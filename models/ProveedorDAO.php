<?php

require_once 'includes/DBConnection.php';

class ProveedorDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(ProveedorMdl $proveedor)
    {
        // Código para crear un nuevo proveedor en la base de datos
        $stmt = $this->db->getConnection()->prepare("INSERT INTO proveedores (nombre, categoria_fiscal, direccion, telefono, correo, saldo, fecha) VALUES (:nombre, :cateogria_fiscal, :direccion, :telefono, :correo, :saldo, :fechaCreacion)");

        $nombre = $proveedor->getNombre();
        $categoria_fiscal = $proveedor->getCategoriaFiscal();
        $direccion = $proveedor->getDireccion();
        $telefono = $proveedor->getTelefono();
        $correo = $proveedor->getCorreo();
        $saldo = $proveedor->getSaldo();
        $fechaCreacion = $proveedor->getFechaCreacion();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":categoria_fiscal", $categoria_fiscal, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $telefono, PDO::PARAM_INT);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->bindParam(":saldo", $saldo, PDO::PARAM_STR);
        $stmt->bindParam(":fechaCreacion", $fechaCreacion, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function update(ProveedorMdl $proveedor)
    {
        // Código para actualizar un proveedor existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE proveedores SET nombre=:nombre, categoria_fiscal=:categoria_fiscal, direccion=:direccion, telefono=:telefono, correo=:correo, saldo=:saldo, fechaCreacion=:fechaCreacion WHERE idproveedor= :idproveedor");

        $nombre = $proveedor->getNombre();
        $categoria_fiscal = $proveedor->getCategoriaFiscal();
        $direccion = $proveedor->getDireccion();
        $telefono = $proveedor->getTelefono();
        $correo = $proveedor->getCorreo();
        $saldo = $proveedor->getSaldo();
        $fechaCreacion = $proveedor->getFechaCreacion();
        $idproveedor = $proveedor->getId();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":categoria_fiscal", $categoria_fiscal, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->bindParam(":saldo", $saldo, PDO::PARAM_STR);
        $stmt->bindParam(":fechaCreacion", $fechaCreacion, PDO::PARAM_STR);
        $stmt->bindParam(":idproveedor", $idproveedor, PDO::PARAM_INT);

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
        // Código para eliminar un proveedor de la base de datos
        $stmt = $this->db->getConnection()->prepare("DELETE FROM proveedores WHERE idproveedor = :idproveedor");
        $stmt->bindParam(":idproveedor", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // La eliminación fue exitosa
            return "ok";
        } else {
            // Manejar errores si es necesario
            print_r($this->db->getConnection()->errorInfo());
            return "error";
        }
    }

    public function getProveedorById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM proveedores WHERE idproveedor = " . $id);

        $stmt->execute();
        $valor = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $valor;
    }

    public function getAllProveedores()
    {
        // Código para obtener todos los proveedors desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM proveedores");
        $stmt->execute();
        $valor = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $valor;
    }
}
