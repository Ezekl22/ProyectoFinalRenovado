<?php
require_once 'models/ProveedorMdl.php';
require_once 'models/ProveedorDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class ProveedorCtr
{
    private $proveedorDAO;

    public function __construct()
    {
        $this->proveedorDAO = new ProveedorDAO();
        $module = isset ($_GET['module']) ? $_GET['module'] : '';
        $action = isset ($_GET['action']) ? $_GET['action'] : '';
        $id = isset ($_GET['id']) ? $_GET['id'] : '';
        if ($module == 'proveedores') {
            switch ($action) {
                case 'created':
                    $this->create();
                    break;
                case 'deleted':
                    $this->delete($id);
                    break;
                case 'edited':
                    $this->update($id);
                    break;
            }
        }
    }

    public function index()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PROVEEDORES, $this->getAllProveedores(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        $proveedores = $this->proveedorDAO->getAllProveedores();
        require_once 'vistas/proveedor/proveedor.php';
    }

    public function getProveedorById($id)
    {
        return $this->proveedorDAO->getProveedorById($id);
    }

    public function getAllProveedores()
    {
        return $this->proveedorDAO->getAllProveedores();
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/proveedor/create.php';
    }

    public function create()
    {
        // Verifica si se han enviado datos por POST
        if (isset ($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $categoria_fiscal = $_POST['categoria_fiscal'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $saldo = $_POST['saldo'];
            $fechaCreacion = $_POST['fechaCreacion'];

            // Crea un nuevo objeto ProveedorMdl con los datos del formulario
            $proveedor = new ProveedorMdl($nombre, $categoria_fiscal, $direccion, $correo, $telefono, $saldo, $fechaCreacion);
        }

        // Llama a la función para crear el proveedor en la base de datos
        $this->proveedorDAO->create($proveedor);
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/proveedor/edit.php';
    }

    public function update($id)
    {
        if (isset ($_POST["nombre"])) {
            $proveedor = new ProveedorMdl($_POST["nombre"], $_POST["categoria_fiscal"], $_POST["direccion"], $_POST["telefono"], $_POST["correo"], $_POST["saldo"], $_POST["fechaCreacion"]);
            $proveedor->setId($id);
            $this->proveedorDAO->update($proveedor);
        }
    }

    public function getPantallaDelete()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Proveedor', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function delete($id)
    {
        $this->proveedorDAO->delete($id);
    }
}