<?php
require_once 'models/UsuarioMdl.php';
require_once 'controladores/UsuarioCtr.php';

ob_start();

class SesionCtr {
    private $usuarioSesionado;
    private $gestionPantallaCtr;

    public function __construct() {}

    public function verificarInicioSesion($gestionPantallaCtr){
        $mensajeError ="";
        if(isset($_POST['mail']) && isset($_POST['contrasena'])){
            $usuarioCtr = new UsuarioCtr();
            $usuario = $usuarioCtr->getUsuarioByMailContra($_POST['mail'], $_POST['contrasena']);
            if(!empty($usuario)){
                $this->usuarioSesionado = $usuario;
                $this->gestionPantallaCtr = $gestionPantallaCtr;
                $this->iniciarSesion();
            }else{
                $mensajeError ="El mail o contraseña es incorrecto, intentelo nuevamente";
            }
        }
        ob_end_flush();
    }

    private function iniciarSesion(){
        session_start();
        $_SESSION['session'] = $this;
        session_write_close();
        header("Location: index.php?module=menu");
    }

    public function cerrarSesion($gestionPantallasCtr){
        session_unset();
        session_destroy();
        $gestionPantallasCtr->redireccionar("");
    }

    public function getUsuarioSesionado(){
        return $this->usuarioSesionado;
    }

    public function getGestionPantallaCtr(){
        return $this->gestionPantallaCtr;
    }
}
