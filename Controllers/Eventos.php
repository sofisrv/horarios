<?php
class Eventos extends Controller
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
        $data = $this->model->getEventos();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "eventos");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('eventos', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getEventos();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-danger" type="button" onclick="btnEliminarEvento(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarEvento(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
            if ($data[$i]['fecha'] == 1) {
                $data[$i]['fecha'] = '<span>PROCESO</span>';
            }else{
                $data[$i]['fecha'] = '<span >LIMPIEZA</span>';
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
                $data = $this->model->registrareventos($id_producto, $id_maquinaria, $orden, $tiempo);
                if ($data == "ok") {
                    $msg = array('msg' => 'Evento registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Evento ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificareventos($id_producto, $id_maquinaria, $orden, $tiempo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Evento modificado con éxito', 'icono' => 'success');
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
        $data = $this->model->editarEvento($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionEvento(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Evento dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionEvento(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Evento reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
