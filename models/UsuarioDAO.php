<?php

require_once 'includes/DBConnection.php';

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createUsuario(Usuario $usuario) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO usuarios (nombre, apellido, mail, contrasena, tipo) VALUES (:nombre, :apellido, :mail, :contrasena, :tipo)");
        
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $mail = $usuario->getMail();
        $contrasena = $usuario->getContrasena();
        $tipo = $usuario->getTipo();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
		$stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function updateUsuario(Usuario $usuario) {
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $mail = $usuario->getMail();
        $contrasena = $usuario->getContrasena();
        $tipo = $usuario->getTipo();
        $idusuario = $usuario->getIdUsuario();

        $txtPassword = $contrasena != ''?' contrasena=:contrasena,':'';
        $query = "UPDATE usuarios SET nombre=:nombre, apellido=:apellido, mail=:mail,".$txtPassword." tipo=:tipo WHERE idusuario=:idusuario";
        $stmt = $this->db->getConnection()->prepare($query);
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        if($contrasena != ''){
            $stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
        }
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
		$stmt->bindParam(":idusuario",$idusuario , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}

        $stmt->closeCursor();
        $stmt = null;
    }

    public function deleteUsuario($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM usuarios WHERE idusuario = :idusuario");
        $stmt->bindParam(":idusuario", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            // La eliminación fue exitosa
            return "ok";
        } else {
            // Manejar errores si es necesario
            print_r($this->db->getConnection()->errorInfo());
            return "error";
        }
    }

    public function getUsuarioById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM usuarios WHERE idusuario = ".$id);
        $stmt->execute();
        $retorno = $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getAllUsuarios() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $retorno = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getUsuarioByMailContra($mail,$contrasena){
        $query = "SELECT * FROM usuarios WHERE mail = :mail AND contrasena = :contrasena";
        $stmt = $this->db->getConnection()->prepare($query);
        
		$stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
        $stmt->execute();
        $retorno = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return empty($retorno) ? [] : $retorno[0];
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT * FROM usuarios WHERE nombre LIKE '$termino' OR apellido LIKE '$termino' OR tipo LIKE '$termino' OR mail LIKE '$termino' ";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }

    }
}
