<?php
class Admin extends Controller{
    public function __construct() {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        date_default_timezone_set('America/Mexico_City');
        $data['usuarios'] = $this->model->getData('usuarios');
        $data['clientes'] = $this->model->getData('clientes');
        $data['productos'] = $this->model->getData('productos');
        $data['proveedor'] = $this->model->getData('proveedor');
        $data['ventas'] = $this->model->ventas_compra('ventas');
        $data['compras'] = $this->model->ventas_compra('compras');
        $data['campanas'] = $this->model->getData('campanas');
        $this->views->getView('usuarios', 'home', $data);
    }
    public function datos()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "configuracion");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $data = $this->model->getEmpresa();
        $this->views->getView('usuarios', 'admin', $data);
    }
    public function cambiarEmpresa()
    {
        $identidad = strClean($_POST['identidad']);
        $nombre = strClean($_POST['nombre']);
        $telefono = strClean($_POST['telefono']);
        $direccion = strClean($_POST['direccion']);
        $mensaje = strClean($_POST['mensaje']);
        $id = strClean($_POST['id']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $imgNombre = 'logo.png';
        $destino = "Assets/img/" . $imgNombre;
        $data = $this->model->modificar($identidad, $nombre, $telefono, $direccion, $mensaje, $id);
        if ($data == 'ok') {
            if (!empty($name)) {
                move_uploaded_file($tmpname, $destino);
            }
            $msg = array('msg' => 'Datos actualizado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al actualizar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function stock()
    {
        $data['stock'] = $this->model->getStock();
        echo json_encode($data);
        die();
    }
    public function stock_cortos()
    {
        $data['stock'] = $this->model->selectStockM();
        echo json_encode($data);
        die();
    }
    public function stock_minimo()
    {
        $data = $this->model->selectStockM();
        echo json_encode($data);
    }
    public function productos()
    {
        $data = $this->model->selectProductos();
        echo json_encode($data);
    }
}
