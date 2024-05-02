<?php
require_once 'models/GestionPantallasMdl.php';
require_once 'models/GestionPantallasDAO.php';
require_once 'models/PopUpMdl.php';
require_once 'controladores/SesionCtr.php';

class GestionPantallasControlador
{
    //private $GestionPantallasDAO;

    public function __construct()
    {
    }

    public function cargarPantalla()
    {

        $tipoUsuario = "";
        //verifico si hay un parametro get de module, si lo hay, traigo el tipo de usuario
        if ($this->getModule() && !empty($this->getModule())) {
            session_start();
            $sesionCtr = $_SESSION['session'];
            session_write_close();
            $tipoUsuario = $sesionCtr->getUsuarioSesionado()->getTipo();
        }
        switch ($this->getModule()) {
            case 'presupuestos':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) != "REPARADOR") {
                    include_once ('./controladores/PresupuestoCtr.php');
                    $indexPage = new PresupuestoCtr();
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'reparacion':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) != "VENDEDOR") {
                    include_once ('controladores/ReparacionControlador.php');
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'clientes':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) != "REPARADOR") {
                    include_once ('controladores/ClienteCtr.php');
                    $indexPage = new ClienteCtr();
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'proveedores':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) == "ADMINISTRADOR" || strtoupper($tipoUsuario) == "ADMINISTRADOR BASE") {
                    include_once ('controladores/ProveedorCtr.php');
                    $indexPage = new ProveedorCtr();
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'pedidos':
                // verifico que el tipo de usuario tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) != "REPARADOR") {
                    include_once ('controladores/PedidoCompraControlador.php');
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'usuarios':
                // verifico que el tipo de usuario tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if (strtoupper($tipoUsuario) == "ADMINISTRADOR" || strtoupper($tipoUsuario) == "ADMINISTRADOR BASE") {
                    include_once './controladores/UsuarioCtr.php';
                    $indexPage = new UsuarioCtr();
                } else {
                    $this->redireccionar('menu');
                }
                break;
            case 'productos':
                include_once './controladores/ProductoCtr.php';
                $indexPage = new ProductoCtr();
                break;
            case 'menu':
                include_once './controladores/MenuCtr.php';
                $indexPage = new MenuCtr();
                break;
            default:
                include_once './vistas/inicio/index.php';
                break;
        }

        if ($this->getModule()) {
            switch ($this->getAction()) {
                case 'edit':
                    $indexPage->getPantallaEdit();
                    break;
                case 'delete':
                    $indexPage->getPantallaDelete();
                    break;
                case 'create':
                    $indexPage->getPantallaCreate();
                    break;
                case 'annul':
                    $indexPage->getPantallaAnnul();
                    break;
                default:
                    $indexPage->index();
                    break;
            }
        } else {
            if ($this->getAction()) {
                if ($this->getAction() == 'login') {
                    $sesionCtr = new SesionCtr();
                    $sesionCtr->verificarInicioSesion($this);
                } else if ($this->getAction() == 'logout') {
                    session_start();
                    $sesionCtr = $_SESSION['session'];
                    session_write_close();
                    $sesionCtr->cerrarSesion($this);
                }
            }

        }
    }

    public function redireccionar($modulo)
    {
        ob_start();
        header("Location: index.php?" . ($modulo && $modulo != "" ? "module=$modulo" : ""));
        ob_end_flush();
    }

    public function crearPopUp(PopUpMdl $popUpMdl)
    {
        $popUpM = $popUpMdl;
        include 'vistas/otros/popUp.php';
    }

    public function getModule()
    {
        return isset($_GET['module']) ? $_GET['module'] : '';
    }

    public function getAction()
    {
        return isset($_GET['action']) ? $_GET['action'] : '';
    }
}