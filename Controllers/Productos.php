<?php
class Productos extends Controller{
    public function __construct() {
        session_start();
        parent::__construct();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "productos");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
    }
    public function index()
    {
        $data = $this->model->getCategorias();
        $this->views->getView('productos', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getProductos();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="btnEditarPro(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarPro(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarPro(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $codigo = strClean($_POST['codigo']);
        $nombre = strClean($_POST['nombre']);
        $precio_compra = strClean($_POST['precio_compra']);
        $precio_venta = strClean($_POST['precio_venta']);
        $minimo = strClean($_POST['minimo']);
        $categoria = strClean($_POST['categoria']);
        $id = strClean($_POST['id']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        
        $fecha = date("YmdHis");
        if (empty($codigo) || empty($nombre) || empty($precio_compra) || empty($precio_venta) || empty($categoria)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            if (!empty($name)) {
                $imgNombre = $fecha . ".jpg";
                $destino = "Assets/img/pro/" . $imgNombre;
            }else if(!empty($_POST['foto_actual']) && empty($name)){
                $imgNombre = $_POST['foto_actual'];
            }else{
                $imgNombre = "default.png";
            }
            if ($id == "") {
                    $data = $this->model->registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $minimo,$imgNombre, $categoria);
                    if ($data == "ok") {
                        if (!empty($name)) {
                            move_uploaded_file($tmpname, $destino);
                        }
                    $msg = array('msg' => 'Producto registrado con éxito', 'icono' => 'success');
                    }else if($data == "existe"){
                    $msg = array('msg' => 'El producto ya existe', 'icono' => 'warning');
                    }else{
                    $msg = array('msg' => 'Error al registrar el producto', 'icono' => 'error');
                    }
            }else{
                $imgDelete = $this->model->editarPro($id);
                if ($imgDelete['foto'] != 'default.png') {
                    if (file_exists("Assets/img/pro/" . $imgDelete['foto'])) {
                        unlink("Assets/img/pro/" . $imgDelete['foto']);
                    }
                }
                $data = $this->model->modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $minimo,$imgNombre,$categoria, $id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Producto modificado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El producto ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al modificar el producto', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionPro(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Producto dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionPro(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Producto reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
