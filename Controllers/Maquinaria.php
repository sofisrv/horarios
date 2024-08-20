<?php
class maquinaria extends Controller{
    public function __construct() {
        session_start();
        parent::__construct();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "maquinaria");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
    }
    public function index()
    {
        $data = $this->model->getMaquinaria();
        $this->views->getView('maquinaria', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getMaquinaria();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="btnEditarMaquinaria(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarMaquinaria(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarMaquinaria(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
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
        $tiempo_l = strClean($_POST['tiempo_l']);
        $id = strClean($_POST['id']);
        if (empty($codigo) || empty($nombre) || empty($tiempo_l)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        }else{
            if ($id == "") {
                    $data = $this->model->registrarMaquinaria($codigo, $nombre, $tiempo_l);
                    if ($data == "ok") {
                    $msg = array('msg' => 'Maquinaria registrado', 'icono' => 'success');
                    }else if($data == "existe"){
                    $msg = array('msg' => 'El Maquinaria ya existe', 'icono' => 'warning');
                    }else{
                    $msg = array('msg' => 'Error al registrar el Maquinaria', 'icono' => 'error');
                    }
            }else{
                $data = $this->model->modificarMaquinaria($codigo, $nombre, $tiempo_l, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Maquinaria modificado con éxito', 'icono' => 'success');
                }else {
                    $msg = array('msg' => 'Error al modificar el Maquinaria', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarMaquinaria($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionMaquinaria(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Maquinaria dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el Maquinaria', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionMaquinaria(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Maquinaria reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el Maquinaria', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
