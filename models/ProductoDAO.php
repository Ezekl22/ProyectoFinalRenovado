<?php
require_once 'includes/DBConnection.php';

class ProductoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function update(ProductoMdl $producto)
    {
        // Código para actualizar un usuario existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE productos SET nombre=:nombre, marca=:marca, detalle=:detalle, stock=:stock, tipo = :tipo, preciocompra = :preciocompra, precioventa = :precioventa WHERE idproducto= :idproducto");

        $nombre = $producto->getNombre();
        $marca = $producto->getNombre();
        $detalle = $producto->getDetalle();
        $stock = $producto->getStock();
        $tipo = $producto->getTipo();
        $idproducto = $producto->getIdProducto();
        $preciocompra = $producto->getPrecioCompra();
        $precioventa = $producto->getPrecioVenta();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":detalle", $detalle, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":preciocompra", $preciocompra, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":precioventa", $precioventa, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":idproducto", $idproducto, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function create(ProductoMdl $producto)
    {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO productos (nombre, marca, detalle, stock, tipo, preciocompra, precioventa) VALUES (:nombre, :marca, :detalle, :stock, :tipo, :preciocompra, :precioventa)");

        $nombre = $producto->getNombre();
        $marca = $producto->getMarca();
        $detalle = $producto->getDetalle();
        $stock = $producto->getStock();
        $tipo = $producto->getTipo();
        $precioCompra = $producto->getPrecioCompra();
        $precioVenta = $producto->getPrecioVenta();

        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":detalle", $detalle, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":preciocompra", $precioCompra, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":precioventa", $precioVenta, PDO::PARAM_STR_CHAR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getProductoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM productos WHERE idproducto = " . $id);

        if ($stmt->execute()) {
            return $stmt->fetchAll()[0];
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt->closeCursor();
        $stmt = null;
    }

    public function getProductosById($ids)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM productos WHERE idproducto in (" . implode(", ", $ids) . ")");

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt->closeCursor();
        $stmt = null;
    }

    public function getAllProductos()
    {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM productos");

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt->closeCursor();
        $stmt = null;
    }

    public function delete($id)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM productos WHERE idproducto = :id");
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

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT * FROM productos WHERE nombre LIKE '$termino' OR marca LIKE '$termino' OR detalle LIKE '$termino' OR stock LIKE '$termino' OR tipo LIKE '$termino' OR preciocompra LIKE '$termino' OR precioventa LIKE '$termino' ";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }

    }
}
