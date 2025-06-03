<?php

require_once "../DB/db_connection.php";
require_once "Producto.php";

class Detalle
{
    protected $Codigo_Factura;
    protected $Codigo_Producto;
    protected $Descripcion;
    protected $Cantidad;
    protected $Subtotal;

    public function __construct($Codigo_Factura, $Codigo_Producto, $Descripcion, $Cantidad, $Subtotal)
    {
        $this->Codigo_Factura = $Codigo_Factura;
        $this->Codigo_Producto = $Codigo_Producto;
        $this->Descripcion = $Descripcion;
        $this->Cantidad = $Cantidad;
        $this->Subtotal = $Subtotal;
    }

    public function getCodigoFactura()
    {
        return $this->Codigo_Factura;
    }

    public function setCodigoFactura($Codigo_Factura)
    {
        $this->Codigo_Factura = $Codigo_Factura;
    }

    public function getCodigoProducto()
    {
        return $this->Codigo_Producto;
    }

    public function setCodigoProducto($Codigo_Producto)
    {
        $this->Codigo_Producto = $Codigo_Producto;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getCantidad()
    {
        return $this->Cantidad;
    }

    public function setCantidad($Cantidad)
    {
        $this->Cantidad = $Cantidad;
    }

    public function getSubtotal()
    {
        return $this->Subtotal;
    }

    public function setSubtotal($Subtotal)
    {
        $this->Subtotal = $Subtotal;
    }

    public function registerDetail()
    {
        global $conn;

        $query = "INSERT INTO `detalle` (`Codigo_Factura`, `Codigo_Producto`, `Cantidad`, `Subtotal`) VALUES (?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $query);

        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "ssid", $this->Codigo_Factura, $this->Codigo_Producto, $this->Cantidad, $this->Subtotal);

        // Ejecutar la consulta
        if(mysqli_stmt_execute($stmt)){
            $b = true;
        }else{
            $b = false;
        }

        // Manejo de errores
        if (mysqli_stmt_errno($stmt)) {
            // Manejar el error aquí
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);

        return $b;
    }

    public static function registerDetailsGroup(int $CodigoFactura, $cookie){
        if (isset($cookie)) {

            $array = explode("|", $cookie);
    
            $count = count($array) - 1;
        
            for ($i = 0; $i < $count; $i++) {
                $product = explode(",", $array[$i]);
        
                $productDetail = new Detalle($CodigoFactura,$product[0], $product[1], $product[2],$product[3]);
    
               $b = $productDetail->registerDetail();

                $product = Producto::searchProduct($productDetail->getCodigoProducto());
                //$Cantidad = intval(valArray($product,"Cantidad")) - $productDetail->getCantidad();

                //Producto::updateStock($productDetail->getCodigoProducto(),$Cantidad);
            }
            }
            if ($b) {
                return true;
            }else{
                return false;
            }
    }


    public function addDetail()
    {      
        $string = $this->Codigo_Producto.','.$this->Descripcion.','.$this->Cantidad.','.$this->Subtotal.'|';

        return $string;
    }

    public static function getListProducts($Codigo_Factura)
    {
        global $conn;

        $query = "SELECT detalle.Codigo_Factura, detalle.Codigo_Producto, producto.Descripcion, detalle.Cantidad, detalle.Subtotal
        FROM detalle
        INNER JOIN producto ON detalle.Codigo_Producto = producto.Codigo WHERE detalle.Codigo_Factura = '$Codigo_Factura';";

        $result = $conn->query($query);

        $detalle = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detalle[] = $row;
            }
            return $detalle;
        } else {
            return false;
        }
    }

    public static function viewCookieDetails(string $cookie){
        if (isset($cookie)) {

        $array = explode("|", $cookie);

        // echo count($array);

        $count = count($array) - 1;

        // echo $count;
    
        for ($i = 0; $i < $count; $i++) {
            $product = explode(",", $array[$i]);
    
            $productDetail = new Detalle(null,$product[0], $product[1], $product[2],$product[3]);
            
            $subtotal = $productDetail->getSubtotal();

            echo "<tr>";
            echo  "<td>".$productDetail->getCodigoProducto()."</td>";
            echo  "<td>".$productDetail->getDescripcion()."</td>";
            echo  "<td>".$productDetail->getCantidad()."</td>";
            echo  "<td>".$subtotal."$</td>";
            echo '<td>';
                echo '<a href="delete_product_detail.php?idDetail=' . $i . '&Precio='.$subtotal.'">
                            <button type="button" class="btn btn-outline-danger  btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Eliminar</em>">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                     </a>';
                echo '</td>';
            echo "</tr>";
           
        }
        }
    }

    public static function deleteListProducts($Codigo_Factura)
    {
        global $conn;

        $query = "DELETE FROM `Detalle` WHERE Codigo_Factura = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $Codigo_Factura);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteProduct(int $id)
    {
        global $conn;

        $query = "DELETE FROM `detalle` WHERE ID = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function viewSubtotal($CodigoFactura)
    {
        $array = Detalle::getListProducts($CodigoFactura);

        $subtotal = 0.00;

        foreach ($array as $item) {
            $subtotal += $item['Subtotal'];
        }

        return $subtotal;
    }

    public static function viewDetails(array|bool $detalle)
    {
        if ($detalle) {
            foreach ($detalle as $detail) {
                echo "<tr>";
                echo '<td class="text-nowrap">' . $detail['Codigo_Producto'] . "</td>";
                echo '<td class="text-nowrap">' . $detail['Descripcion'] . "</td>";
                echo '<td class="text-nowrap">' . $detail['Cantidad'] . "</td>";
                echo '<td class="text-nowrap">' . $detail['Subtotal'] . "$</td>";
                echo '<td hidden> </td>';

                echo "</tr>";
            }
        }
    }
}
?>