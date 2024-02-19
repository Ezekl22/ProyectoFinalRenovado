<?php
require_once 'models/UsuarioMdl.php';
require_once 'models/UsuarioDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class UsuarioCtr {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
        $action = isset($_GET['action'])?$_GET['action']:'';
        $id = isset($_GET['id'])?$_GET['id']:'';
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
            case 'searched':
                $this->search();
                break;
        }
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $termino = isset($_POST) ? $_POST : "";
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_USUARIOS, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllUsuarios(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);


        // Cargar la vista con los datos
        require_once 'vistas/usuario/usuario.php';
    }

    public function getAllUsuarios(){
        return $this->usuarioDAO->getAllUsuarios();
    }

    public function search()
    {
        return $this->usuarioDAO->search();
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/usuario/create.php';
    }

    public function create()
    {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo = $_POST['tipo'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];
    
            // Crea un nuevo objeto Usuario con los datos del formulario
            $usuario = new Usuario($nombre, $apellido, $tipo, $mail, $contrasena);
    
            // Llama a la función para crear el usuario en la base de datos
            $this->usuarioDAO->createUsuario($usuario);
        }
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/usuario/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $usuario = new Usuario($_POST["nombre"], $_POST["apellido"], $_POST["tipo"], $_POST["mail"], $_POST["contrasena"]);
            $usuario->setIdUsuario($id);
            $this->usuarioDAO->updateUsuario($usuario);
        }
    }

   public function getPantallaDelete(){
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete','Eliminar Usuario',"",BOTONES_POPUP_ELIMINAR,'index.php?action=delete'));
        $this->index();
    }

    public function delete($id) {
        if(strtoupper($this->getUsuarioById($id)[3]) != "ADMINISTRADOR BASE")
        $this->usuarioDAO->deleteUsuario($id);
    }

    public function getUsuarioById($id){
        $this->usuarioDAO->getUsuarioById($id);
    }

    public function getUsuarioByMailContra($mail,$contrasena){
        $usuarioDB = $this->usuarioDAO->getUsuarioByMailContra($mail,$contrasena);

        $usuario = count($usuarioDB) > 0? new Usuario($usuarioDB['nombre'], $usuarioDB['apellido'],$usuarioDB['tipo'],$usuarioDB['mail']) : $usuarioDB;
        return $usuario;
    }
}
