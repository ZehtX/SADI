<?php

require_once "../DB/db_connection.php";
require_once "Inputs.php";

class Cliente
{

    protected $CI;
    protected $Nombre;
    protected $Telefono;
    protected $Direccion;

    public function __construct($CI, $Nombre, $Telefono, $Direccion)
    {
        $this->CI = clearIn($CI);
        $this->Nombre = clearIn($Nombre);
        $this->Telefono = clearIn($Telefono);
        $this->Direccion = clearIn($Direccion);
    }

    public function getCI()
    {
        return $this->CI;
    }

    public function setCI($CI)
    {
        $this->CI = $CI;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function getTelefono()
    {
        return $this->Telefono;
    }

    public function setTelefono($Telefono)
    {
        $this->Telefono = $Telefono;
    }

    public function getDireccion()
    {
        return $this->Direccion;
    }

    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;
    }

    public static function getAllClients()
    {
        global $conn;

        $query = "SELECT * FROM `cliente` WHERE is_delete = 0;";

        $result = $conn->query($query);

        $clients = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
        }

        return $clients;
    }
    public static function countClients()
    {
        global $conn;

        $query = "SELECT COUNT(*) as suma FROM `cliente` WHERE is_delete = 0;";

        $result = $conn->query($query);

        $clients = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
        }

        return $clients;
    }

    public function register()
    {
        global $conn;

        $query = "INSERT INTO `cliente`(CI, Nombre_Apellido, Telefono, Direccion, is_delete) 
        VALUES ('$this->CI', '$this->Nombre', '$this->Telefono', '$this->Direccion', '0');";

        $result = $conn->query($query);

        return $result;
    }

    public static function searchClient(string $CI)
    {
        global $conn;

        $query = "SELECT * FROM cliente WHERE CI = $CI and is_delete = 0;";

        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $client[] = $row;
            }

            return $client;
        } else {
            return false;
        }
    }

    public static function viewDataClients($clients)
    {
        if ($clients == false) {
            echo "<tr>";
            echo '<td colspan="3">Cliente No Registrado</td>';
            echo "</tr>";
        } else {
            $i = 0;
            foreach ($clients as $client) {
                echo "<tr>";
                echo '<td class="text-nowrap" id="ced' . $i . '">V-' . $client['CI'] . "</td>";
                echo '<td class="text-nowrap" id="nom' . $i . '">' . $client['Nombre_Apellido'] . "</td>";
                echo '<td class="text-nowrap" id="tel' . $i . '">' . $client['Telefono'] . "</td>";
                echo '<td hidden id="dir' . $i . '">' . $client['Direccion'] . "</td>";

                echo '<td class="text-nowrap">
                <button type="button" class="btn btn-outline-success btn-icon" data-bs-toggle="modal" data-bs-html="true" data-bs-target="#viewClient" data-bs-original-title="<em>Detalles</em>" onclick="imprimirValor(' . intval($i) . ')">
                    <i class="bi bi-eye-fill"></i>
                </button>';
                echo '<a href="modify_client.php?CI=' . $client['CI'] . '">
                        <button type="button" class="btn btn-outline-info btn-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-original-title="<em>Modificar</em>">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </a>';
                echo '<a href="delete_client.php?CI=' . $client['CI'] . '">
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

    public function updateClient()
    {
        global $conn;

        $query = "UPDATE cliente SET Nombre_Apellido = ?, Telefono = ?, Direccion = ? WHERE CI = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $this->Nombre, $this->Telefono, $this->Direccion, $this->CI);
        $result = $stmt->execute();
        $stmt->close();


        return $result;
    }

    public static function viewDataClientsNotEyes($clients)
    {
        if ($clients == false) {
            echo "<tr>";
            echo '<td colspan="3">Cliente No Registrado</td>';
            echo "</tr>";
        } else {
            foreach ($clients as $client) {
                echo "<tr>";
                echo '<td class="text-nowrap">V-' . $client['CI'] . "</td>";
                echo '<td class="text-nowrap">' . $client['Nombre_Apellido'] . "</td>";
                echo '<td class="text-nowrap">' . $client['Telefono'] . "</td>";
                echo '<td>' . $client['Direccion'] . "</td>";


                echo "</tr>";
            }
        }
    }

    public static function deleteClient($CI)
    {

        global $conn;

        $query = "UPDATE `cliente` SET `is_delete` = '1' WHERE `cliente`.`CI` = '$CI';";

        $result = $conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
