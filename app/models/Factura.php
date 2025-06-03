<?php

require_once "../DB/db_connection.php";
require_once "Detalle.php";
require_once "Inputs.php";

class Factura
{
    private $Codigo_Factura;
    private $CI_Cliente;
    private $Fecha;
    private $Total;

    public function __construct($Codigo_Factura, $CI_Cliente, $Fecha, $Total)
    {
        $this->Codigo_Factura = $Codigo_Factura;
        $this->CI_Cliente = $CI_Cliente;
        $this->Fecha = $Fecha;
        $this->Total = $Total;
    }

    public function getCodigoFactura()
    {
        return $this->Codigo_Factura;
    }

    public function setCodigoFactura($codigo)
    {
        $this->Codigo_Factura = $codigo;
    }

    public function getCI_Cliente()
    {
        return $this->CI_Cliente;
    }

    public function setCI_Cliente($ci)
    {
        $this->CI_Cliente = $ci;
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha($fecha)
    {
        $this->Fecha = $fecha;
    }

    public function getTotal()
    {
        return $this->Total;
    }

    public function setTotal($total)
    {
        $this->Total = $total;
    }

    public static function setDBTotal($codigoFactura, $conn)
    {
        // Aquí iría el código para actualizar el total en la base de datos según el código de factura
        // Recuerda incluir la variable de conexión $conn como global dentro de la función
    }

    public function createFactura()
    {
        global $conn;

        $query = "INSERT INTO factura(Codigo_Factura, CI_Cliente, Fecha, Total, is_delete) 
        VALUES (?, ?, CURRENT_TIMESTAMP, ?,0);";

        $stmt = $conn->prepare($query);

        $this->Codigo_Factura = (self::newCode());

        $stmt->bind_param("isd", $this->Codigo_Factura, $this->CI_Cliente, $this->Total);

        $result = $stmt->execute();

        // $stmt->close();

        self::updateCode($this->Codigo_Factura);

        return $result;
    }

    public static function newCode()
    {
        global $conn;

        $query = "SELECT Numero FROM ultima_operacion;";

        $result = $conn->query($query);
        // $conn->close();
        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $Code[] = $row;
            }
        }

        foreach($Code as $code){
            $codigo = $code['Numero'];
        }

        $codigo++;

        return $codigo;
    }

    public static function updateCode(int $Number)
    {
        global $conn;

        $query = "UPDATE ultima_operacion SET Numero = $Number;";

        $result = $conn->query($query);
        // $conn->close();
    }


    public static function viewIVA(float $subtotal)
    {

        $iva = ($subtotal * 0.16);

        $iva = number_format($iva,2,".",",");

        return $iva;
    }

    public static function viewTotal(float $subtotal)
    {

        $iva = self::viewIVA($subtotal);

        $total = ($subtotal + $iva);

        return $total;
    }

    public static function getAllFactura()
    {
        global $conn;

        $query = "SELECT factura.Codigo_Factura, factura.CI_Cliente, cliente.Nombre_Apellido, 
        factura.Total, factura.Fecha FROM factura INNER JOIN cliente ON factura.CI_Cliente = cliente.CI WHERE factura.is_delete ='0';";

        $result = $conn->query($query);

        $facturas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }
        }

        return $facturas;
    }
    public static function ultimasVentas()
    {
        global $conn;

        $query = "SELECT factura.Codigo_Factura, SUM(detalle.Cantidad) AS Cantidad, 
        detalle.Subtotal, factura.CI_Cliente, cliente.Nombre_Apellido, factura.Total, factura.Fecha 
        FROM factura 
        INNER JOIN cliente ON factura.CI_Cliente = cliente.CI 
        INNER JOIN detalle ON detalle.Codigo_Factura = factura.Codigo_Factura 
        WHERE factura.is_delete = '0' 
        GROUP BY factura.Codigo_Factura 
        ORDER BY factura.Codigo_Factura DESC 
        LIMIT 10;";

        $result = $conn->query($query);

        $facturas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }
        }

        return $facturas;
    }
    public static function verUltimasVentas(array|string $uVentas)
{   
        global $conn;
            
            foreach ($uVentas as $uVenta) {
                echo "<tr>";
                echo '<td class="text-nowrap">' . $uVenta['Codigo_Factura'] . "</td>";
                echo '<td class="text-nowrap">' . $uVenta['CI_Cliente'] . "</td>";
                echo '<td class="text-nowrap">' . $uVenta['Cantidad'] . "</td>";
                echo '<td class="text-nowrap">' . $uVenta['Total'] . "$</td>";
                echo '<td class="text-nowrap">' . $uVenta['Fecha'] . "</td>";
                echo '<td> <a href="checkout_view.php?Codigo=' . $uVenta['Codigo_Factura']. '&index=1">
                        <button type="button" class="btn btn-outline-success btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Detalles</em>">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        </a>';    
                echo '</td>';

                echo "</tr>";
           
            
        }
    }

    public static function searchFacturaByCode(string $Codigo_Factura)
    {
        global $conn;

        $query = "SELECT factura.Codigo_Factura, factura.CI_Cliente, cliente.Nombre_Apellido, factura.Total, factura.Fecha FROM factura 
        INNER JOIN cliente ON factura.CI_cliente = cliente.CI 
        WHERE factura.Codigo_Factura=? and factura.is_delete='0';";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $Codigo_Factura);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }

            return $facturas;
        } else {
            return false;
        }
    }

    public static function searchFacturaByCed(string $Codigo_Factura)
    {
        global $conn;

        $query = "SELECT factura.Codigo_Factura, factura.CI_Cliente, cliente.Nombre_Apellido, factura.Total, factura.Fecha FROM factura 
        INNER JOIN cliente ON factura.CI_cliente = cliente.CI 
        WHERE factura.CI_Cliente=? and factura.is_delete='0';";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $Codigo_Factura);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }

            return $facturas;
        } else {
            return false;
        }
    }


    public static function searchFactura2(int $Codigo_Factura)
    {
        global $conn;

        // $query = "SELECT factura.Codigo_Factura, factura.CI_Cliente, cliente.Nombre_Apellido, factura.Total, factura.Fecha FROM factura 
        // INNER JOIN cliente ON factura.CI_cliente = cliente.CI 
        // WHERE factura.Codigo_Factura=? and factura.is_delete='0';";

        $query ="SELECT * FROM `factura` WHERE Codigo_Factura=? and is_delete='0';";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $Codigo_Factura);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }

            return $facturas;
        } else {
            return false;
        }
    }
    public static function searchDetail(string $Codigo_Factura)
    {
        global $conn;

        $query = "SELECT detalle.Descripcion, detalle.Cantidad, detalle.Subtotal
        FROM factura 
        INNER JOIN detalle ON factura.Codigo_Factura = detalle.Codigo_Factura WHERE factura.Codigo_Factura=? and factura.is_delete='0';";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $Codigo_Factura);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detalles[] = $row;
            }

            return $detalles;
        } else {
            return false;
        }
    }
    public static function viewDataFactura(array|string $facturas)
    {
        global $conn;
        if ($facturas == false) {
            echo "<tr>";
            echo '<td colspan="3">Factura No Registrado</td>';
            echo "</tr>";
        } else {
            $i = 0;
            foreach ($facturas as $factura) {
                echo "<tr>";
                echo '<td class="text-nowrap" id="cod' . $i . '">' . $factura['Codigo_Factura'] . "</td>";
                echo '<td class="text-nowrap" id="cedula' . $i . '">V-' . $factura['CI_Cliente'] . "</td>";
                echo '<td class="text-nowrap" id="nom_ape' . $i . '">' . $factura['Nombre_Apellido'] . "</td>";
                echo '<td class="text-nowrap" id="total' . $i . '">' . $factura['Total'] . "$</td>";
                echo '<td class="text-nowrap" id="fecha' . $i . '">' . $factura['Fecha'] . "</td>";

                echo '<td> <a href="checkout_view.php?Codigo=' . $factura['Codigo_Factura']. '">
                        <button type="button" class="btn btn-outline-success btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Detalles</em>">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        </a>';
                    
                echo '<a href="delete_factura.php?Codigo=' . $factura['Codigo_Factura'] . '">
                        <button type="button" class="btn btn-outline-danger  btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Eliminar</em>">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </a>';
                echo '</td>';

                echo "</tr>";

                $i++;
            }
        }
    }
    public static function viewDetailFactura(array|string $detalles)
{   
        global $conn;
            
            foreach ($detalles as $detalle) {
                echo "<tr>";
                echo '<td class="text-nowrap">' . $detalle['Descripcion'] . "</td>";
                echo '<td class="text-nowrap">' . $detalle['Cantidad'] . "</td>";
                echo '<td class="text-nowrap">' . $detalle['Subtotal'] . "</td>";
                    
                echo '</td>';

                echo "</tr>";
           
            
        }
    }


    public static function deleteFactura($Codigo)
    {

        global $conn;

        $query = "UPDATE `factura` SET `is_delete` = '1' WHERE Codigo_Factura = '$Codigo';";

        $result = $conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}