<?php
class Pedidos extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
    }
    public function index()
    {
        $data = $this->model->getProductos();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "pedidos");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('pedidos', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getPedido();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarPedido(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarPedido(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarPedido(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $codigo = strClean($_POST['codigo']);
        $id_producto = strClean($_POST['id_producto']);
        $fecha_creacion = strClean($_POST['fecha_creacion']);
        $fecha_entrega = strClean($_POST['fecha_entrega']);
        $id = strClean($_POST['id']);
        if (empty($codigo) || empty($id_producto) || empty($fecha_creacion)|| empty($fecha_entrega)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        } else {
            if ($id == "") {
                $data = $this->model->registrarPedido($codigo, $id_producto, $fecha_creacion, $fecha_entrega);
                if ($data == "ok") {
                    $msg = array('msg' => 'Pedido registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Pedido ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarPedido($codigo, $id_producto, $fecha_creacion, $fecha_entrega, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Pedido modificado con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarPedido($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionPedidos(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Pedido dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionPedidos(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Pedido reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
