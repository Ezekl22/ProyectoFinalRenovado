<?php

require_once 'includes/DBConnection.php';

class ClienteDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function createCliente(Cliente $cliente)
    {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO clientes (nombre, apellido, email, cuit, categoriafiscal) VALUES (:nombre, :apellido, :email, :cuit, :categoriaFiscal)");

        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $email = $cliente->getEmail();
        $cuit = $cliente->getCuit();
        $categoriaFiscal = $cliente->getCategoriaFiscal();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
        $stmt->bindParam(":categoriaFiscal", $categoriaFiscal, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {
            $error = $stmt->errorInfo();

        }

        $stmt->closeCursor();
        $stmt = null;

        return $error;
    }

    public function update(Cliente $cliente)
    {
        // Código para actualizar un cliente existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE clientes SET nombre=:nombre, apellido=:apellido, email=:email, cuit=:cuit, categoriafiscal=:categoriafiscal WHERE idcliente= :idcliente");

        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $email = $cliente->getEmail();
        $cuit = $cliente->getCuit();
        $categoriaFiscal = $cliente->getCategoriaFiscal();
        $id = $cliente->getId();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
        $stmt->bindParam(":categoriafiscal", $categoriaFiscal, PDO::PARAM_STR);
        $stmt->bindParam(":idcliente", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function delete($id)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM clientes WHERE idcliente = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // La eliminación fue exitosa
            return "ok";
        } else {
            // Manejar errores si es necesario
            print_r($this->db->getConnection()->errorInfo());
            return "error";
        }
    }

    public function getClienteById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes WHERE idcliente = " . $id);

        $stmt->execute();
        $retorno = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getAllClientes()
    {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes");

        $stmt->execute();
        $retorno = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT * FROM clientes WHERE nombre LIKE '$termino' OR apellido LIKE '$termino' OR email LIKE '$termino' OR cuit LIKE '$termino' OR categoriafiscal LIKE '$termino' ";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }

    }
}
