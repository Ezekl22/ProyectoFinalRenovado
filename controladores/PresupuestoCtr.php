<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'controladores/ClienteCtr.php';
require_once 'controladores/ProductoCtr.php';

class PresupuestoCtr {
    private $presupuestoDAO;
    private $clienteCtr;
    private $productoCtr;

    public function __construct() {
        $this->presupuestoDAO = new PresupuestoDAO();
        $this->clienteCtr = new ClienteCtr();
        $this->productoCtr = new ProductoCtr();
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $presupuestos = $this->presupuestoDAO->getAllPresupuestos();

        // Cargar la vista con los datos
        require_once 'vistas/presupuestos/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/presupuestos/create.php';
    }

    public function create() {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo = $_POST['tipo'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];
    
            // Crea un nuevo objeto User con los datos del formulario
            $user = new User($nombre, $apellido, $tipo, $mail, $contrasena);
    
            // Llama a la función para crear el usuario en la base de datos
            $this->userDAO->createUser($user);
        }
    }

    public function getPantallaEdit() {
        $this->index();
        require_once 'vistas/presupuestos/edit.php';
    }

    public function getNombreClienteById($id){
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente['nombre'].' '.$cliente['apellido'];
    }

    public function getClienteById($id){
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente;
    }

    public function getProductoById($id){
        $cliente = $this->productoCtr->getProductoById($id);
        return $cliente;
    }

    public function getProductosPresupuestoById($id) {
        return $this->presupuestoDAO->getProductosPresupuestoById($id);
    }

    public function update($id) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["idcliente"])){
                $presupuesto = new PresupuestoMdl($_POST["idcliente"], $_POST["nrocomprobante"], $_POST['tipo'], $_POST["estado"], $_POST["fecha"], $_POST["puntoventa"], $_POST["total"]);
                $presupuesto->setIdPresupuesto($id);
                $this->presupuestoDAO->updatePresupuesto($presupuesto);
            }
        }
    }

    public function getProductosPresupuesto($id) {

    }

    public function getPresupuestoById($id){
        return $this->presupuestoDAO->getPresupuestoById($id);
    }

    // public function getPantallaDelete(){
    //     require_once 'vistas/usuario/delete.php';
    //     $this->index();
    // }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->presupuestoDAO->deletePresupuesto($id);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }

    public function getAllClientes(){
        return $this->clienteCtr->getAllClientes();
    }

    public function getAllProductos(){
        return $this->productoCtr->getAllProductos();
    }
}
