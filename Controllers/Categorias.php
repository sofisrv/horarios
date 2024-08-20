<?php
class Categorias extends Controller
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
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "categorias");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('productos', "categorias");
    }
    public function listar()
    {
        $data = $this->model->getCategorias();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCat(' . $data[$i]['id_cat'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarCat(' . $data[$i]['id_cat'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarCat(' . $data[$i]['id_cat'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $codigo = strClean($_POST['codigo']);
        $nombre = strClean($_POST['categoria']);
        $id = strClean($_POST['id']);
        if (empty($codigo) || empty($nombre)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        } else {
            if ($id == "") {
                $data = $this->model->registrarCat($codigo, $nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Categoria registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La categoria ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarCat($codigo, $nombre,$id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Categoria modificado con éxito', 'icono' => 'success');
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
        $data = $this->model->editarCat($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCat(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCat(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
