<?php
require_once 'models/PedidoCompraMdl.php';
require_once 'models/PedidoCompraDAO.php';
require_once 'controladores/ProveedorCtr.php';
require_once 'controladores/ProductoCtr.php';

class PedidoCompraCtr {
    private $pedidoCompraDAO;
    private $proveedorCtr;
    private $productoCtr;
    public $idPedidoSeleccionado;
    public $action;
    private $module;
    public $pedidoSeleccionado;

    public function __construct() {
        $this->pedidoCompraDAO = new PedidoCompraDAO();
        $this->proveedorCtr = new ProveedorCtr();
        $this->productoCtr = new ProductoCtr();
        $this->idPedidoSeleccionado = isset($_GET['id']) ? $_GET['id'] : '';
        $this->action = isset($_GET['action']) ? $_GET['action'] : '';
        $this->module = isset($_GET['module']) ? $_GET['module'] : '';
        // hago este codigo para que solo se utilice en pedidos de compra para la pantalla de editar
        $this->pedidoSeleccionado = ($this->idPedidoSeleccionado && $this->module == "pedidos")? $this->pedidoCompraDAO->getPedidoCompraById($this->idPedidoSeleccionado) : "";
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $pedidosCompras = $this->getAllPedidosCompras();

        // Cargar la vista con los datos
        require_once 'vistas/pedidos-compra/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/pedidos-compra/create.php';
    }

    public function getAllPedidosCompras(){
        return $this->pedidoCompraDAO->getAllPedidosCompras();
    }

    // public function create() {
    //     // Mostrar el formulario de creación de usuario
    //     require_once 'views/usuario/create.php';
    // }

    // public function store($data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Crear un nuevo usuario en la base de datos
    //     $usuario = new Usuario($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
    //     $this->pedidoCompraDAO->createUsuario($usuario);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }
    public function getProveedorById($id) {
        return $this->proveedorCtr->getProveedorById($id);
    }

    public function getPantallaEdit() {
        //$pedidoCompra = $this->getPedidoCompraById($id);

        require_once 'vistas/pedidos-compra/edit.php';
        $this->index();
    }

    public function getAllProveedores(){
        return $this->proveedorCtr->getAllProveedores();
    }

    public function getAllProductos(){
        return $this->productoCtr->getAllProductos();
    }

    public function getProductosPedidoCompraById($id) {
        return $this->pedidoCompraDAO->getProductosPedidoCompraById($id);
    }

    // public function update($id, $data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Actualizar el usuario en la base de datos
    //     $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
    //     $user->setId($id);
    //     $this->pedidoCompraDAO->updateUser($user);
    // }

    public function getPedidoCompraById($id){
        return $this->pedidoCompraDAO->getPedidoCompraById($id);
    }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->pedidoCompraDAO->deleteUser($id);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }
}
