<?php
class Procesos extends Controller
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
        $data1 = $this->model->getMaquinaria();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "procesos");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('procesos', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getProcesos();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div><button class="btn btn-danger" type="button" onclick="btnEliminarProceso(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarProceso(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $orden = strClean($_POST['orden']);
        $tiempo = strClean($_POST['tiempo']);
        $id_producto = strClean($_POST['id_producto']);
        $id_maquinaria = strClean($_POST['id_maquinaria']);
        $id = strClean($_POST['id']);
        if (empty($orden) || empty($tiempo) || empty($id_producto)|| empty($id_maquinaria)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        } else {
            if ($id == "") {
                $data = $this->model->registrarProcesos($id_producto, $id_maquinaria, $orden, $tiempo);
                if ($data == "ok") {
                    $msg = array('msg' => 'Proceso registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Proceso ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarProcesos($id_producto, $id_maquinaria, $orden, $tiempo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Proceso modificado con éxito', 'icono' => 'success');
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
        $data = $this->model->editarProceso($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionProcesos(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Proceso dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionProcesos(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Proceso reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
