<?php
class Campanas extends Controller{
    public function __construct() {
        session_start();
        parent::__construct();
        if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
    }
    public function index()
    {
        $data = $this->model->getProductos();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "campanas");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('campanas', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getCampanas();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-danger" type="button" onclick="btnEliminarCam(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarCam(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $id1 = strClean($_POST['id1']);
        $id2 = strClean($_POST['id2']);
        $tiempo_campana = strClean($_POST['tiempo_campana']);
        $id = strClean($_POST['id']);
        if (empty($id1) || empty($id2) || empty($tiempo_campana)|| empty($tiempo)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        }else{
            if ($id == "") {
                    $data = $this->model->registrarCam($id1, $id2, $tiempo_campana, $tiempo);
                    if ($data == "ok") {
                    $msg = array('msg' => 'Campana registrado', 'icono' => 'success');
                    }else if($data == "existe"){
                    $msg = array('msg' => 'El Campana ya existe', 'icono' => 'warning');
                    }else{
                    $msg = array('msg' => 'Error al registrar el Campana', 'icono' => 'error');
                    }
            }else{
                $data = $this->model->modificarCampana($id1, $id2, $tiempo_campana, $tiempo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Campana modificado con éxito', 'icono' => 'success');
                }else {
                    $msg = array('msg' => 'Error al modificar el Campana', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarCam($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCam(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Campana dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el Campana', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCam(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Campana reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el Campana', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
