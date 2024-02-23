<?php

class GrillaCtr{
    private $controlador;
    private $grillaMdl;

    public function __construct(GrillaMdl $grillaMdl) {
        $this->grillaMdl = $grillaMdl;
        $this->cargarDatosGrilla($grillaMdl);
        
    }

    private function cargarDatosGrilla(GrillaMdl $grillaMdl){
        $module = isset($_GET['module'])?$_GET['module']:'';
        
        switch ($module) {
            case 'usuarios':
                require_once 'controladores/UsuarioCtr.php';
                $this->controlador = new UsuarioCtr;
                break;
            case 'presupuestos':
                require_once 'controladores/PresupuestoCtr.php';
                $this->controlador = new PresupuestoCtr;
                break;
            case 'productos':
                require_once 'controladores/ProductoCtr.php';
                $this->controlador = new ProductoCtr;
                break;
            default:
                # code...
                break;
        }
    }

    public function mostrarGrilla(){
        $grillaMdl = $this->getGrillaMdl();
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        require_once 'vistas/otros/grilla.php';
    }

    public function getGrillaMdl(){
        return $this->grillaMdl;
    }
}
?>