<?php
// INSERT INTO `categoria` (`ID`, `Nombre`) VALUES (NULL, 'Pantalon'), (NULL, 'Sueter'), (NULL, 'Franela');

require_once "../DB/db_connection.php";
require_once "Inputs.php";

class Producto
{
    protected $Codigo;
    protected $Descripcion;
    protected $Cantidad;
    protected $Precio;
    protected $idCategoria;

    public function __construct($Codigo, $Descripcion, $Cantidad, $Precio, $idCategoria)
    {
        $this->Codigo = clearIn($Codigo);
        $this->Descripcion = clearIn($Descripcion);
        $this->Cantidad = clearIn($Cantidad);
        $this->Precio = clearIn($Precio);
        $this->idCategoria = clearIn($idCategoria);
    }

    public function getCodigo()
    {
        return $this->Codigo;
    }

    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
    }

    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;
    }

    public function getPrecio()
    {
        return $this->Precio;
    }

    public function setPrecio($Subtotal)
    {
        $this->Precio = $Subtotal;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    public function register()
    {
        global $conn;

        $query = "INSERT INTO producto(Codigo, Descripcion, Cantidad, Precio, ID_Categoria, is_delete) 
    VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        $isDelete = 0;

        $stmt->bind_param("sssssi", $this->Codigo, $this->Descripcion, $this->Cantidad, $this->Precio, $this->idCategoria, $isDelete);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }



    public static function searchProduct(string $Codigo)
    {
        global $conn;

        $Codigo = clearIn($Codigo);

        $query = "SELECT producto.Codigo, producto.Descripcion, producto.Precio, categoria.Nombre, producto.Cantidad
        FROM producto 
        INNER JOIN categoria ON producto.id_categoria = categoria.ID WHERE producto.Codigo = ? and producto.is_delete = 0";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $Codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return $products;
        } else {
            return false;
        }
    }

    public static function searchProductNotBool(string $Codigo)
    {
        global $conn;

        $Codigo = clearIn($Codigo);

        $query = "SELECT producto.Codigo, producto.Descripcion, producto.Precio, categoria.Nombre, producto.Cantidad
        FROM producto 
        INNER JOIN categoria ON producto.id_categoria = categoria.ID WHERE producto.Codigo = ?;";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $Codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();


        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return $products;
        } else {
            return false;
        }
    }

    public static function getAllProducts()
    {
        global $conn;

        $query = "SELECT producto.Codigo, producto.Descripcion, producto.Cantidad, producto.Precio, categoria.Nombre
        FROM producto
        INNER JOIN categoria ON producto.id_categoria = categoria.ID WHERE is_delete = 0;";

        $result = $conn->query($query);
        $conn->close();
        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        return $products;
    }
    public static function contarProductos()
    {
        global $conn;

        $query = "SELECT COUNT(*) as suma FROM producto WHERE is_delete = 0;";

        $result = $conn->query($query);

        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        return $products;
    }

    public static function viewDataProducts(array|string $products)
    {

        if (!$products) {
            echo "<tr>";
            echo '<td colspan="5">Producto no Registrado / Disponible</td>';
            echo "</tr>";
        } else {
            $i = 0;
            foreach ($products as $product) {
                echo "<tr>";
                echo '<td class="text-rowrap" id="codigo' . $i . '">' . $product['Codigo'] . "</td>";
                echo '<td class="text-rowrap" id="descripcion' . $i . '">' . $product['Descripcion'] . "</td>";
                echo '<td class="text-rowrap" id="precio' . $i . '">' . $product['Precio'] . " $</td>";
                echo '<td class="text-rowrap" id="categoria' . $i . '">' . $product['Nombre'] . "</td>";
                echo '<td class="text-rowrap" id="stock' . $i . '">' . $product['Cantidad'] . "</td>";

                echo '<td class="text-nowrap">
                        <button type="button" onclick="imprimirValor(' . intval($i) . ')" class="btn btn-outline-success btn-icon" data-bs-toggle="modal" data-bs-html="true" data-bs-target="#viewProduct" data-bs-original-title="<em>Detalles</em>">
                            <i class="bi bi-eye-fill"></i>
                        </button>';
                echo '<a href="modify_product.php?Codigo=' . $product['Codigo'] . '">
                        <button type="button" class="btn btn-outline-info btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Modificar</em>">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </a>';
                echo '<a href="delete_product.php?Codigo=' . $product['Codigo'] . '">
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

    public function updateProduct()
    {
        global $conn;

        $query = "UPDATE producto SET Descripcion = ?, Cantidad = ?, Precio = ?, ID_Categoria = ? WHERE Codigo = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssis", $this->Descripcion, $this->Cantidad, $this->Precio, $this->idCategoria, $this->Codigo);
        $result = $stmt->execute();
        $stmt->close();


        return $result;
    }

    public static function updateCantidad(string $Codigo, int $Cantidad)
    {
        global $conn;

        $query = "UPDATE producto SET Cantidad = ? WHERE Codigo = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $Cantidad, $Codigo);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public static function updateStock(string $Codigo, int $Cantidad)
    {
        $product = self::searchProduct($Codigo);

        $stock = valArray($product, "Cantidad");

        $stock += $Cantidad;

        self::updateCantidad($Codigo, $stock);
    }

    public static function RestoreStock(string $Cookie)
    {
        $array = explode("|", $Cookie);

        $count = count($array) - 2;

        for ($i = 0; $i <= $count; $i++) {
            $product = explode(",", $array[$i]);

            $codigo = $product[0];
            $cantidad = $product[2];
            self::updateStock($codigo, $cantidad);
        }
    }


    public static function deleteProduct($Codigo)
    {

        global $conn;

        $query = "UPDATE `producto` SET `is_delete` = '1' WHERE `producto`.`Codigo` = '$Codigo';";

        $result = $conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllCategory()
    {
        global $conn;

        $query = "SELECT * FROM categoria";
        $result = $conn->query($query);

        $Categorias = array();

        while ($Categoria = $result->fetch_assoc()) {
            $Categorias[] = $Categoria;
        }

        return $Categorias;
    }
}
