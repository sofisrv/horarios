<?php
class Usuarios extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "usuarios");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
        }
        $this->views->getView('usuarios', "index");
    }
    public function listar()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $data = $this->model->getUsuarios();
        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                if ($data[$i]['id'] == 1) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] = '<div>
                    <span class="badge badge-primary">Adminstrador</span>
                    <div/>';
                }else{
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-dark" type="button" onclick="btnPermisos(' . $data[$i]['id'] . ');"><i class="fas fa-key"></i></button>
                    <button class="btn btn-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                    <div/>';
                }
            }else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarUser(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function validar()
    {
        if (empty(strClean($_POST['usuario'])) || empty(strClean($_POST['clave']))) {
            $msg = array('msg' => "El usuario y la contraseña es requerido", 'icono' => 'warning');
        }else{
            $usuario = strClean($_POST['usuario']);
            $clave = strClean($_POST['clave']);
            $data = $this->model->getUsuario($usuario);
            if ($data != null) {
                if (password_verify($clave, $data['clave'])) {
                    $_SESSION['id_usuario'] = $data['id'];
                    $_SESSION['usuario'] = $data['usuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['activo'] = true;
                    $msg = array('msg' => "ok");
                }else{
                    $msg = array('msg' => "Contraseña incorrecta", 'icono' => 'error');
                }
            }else{
                $msg = array('msg' => "El usuario no existe", 'icono' => 'warning');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $usuario = strClean($_POST['usuario']);
        $nombre = strClean($_POST['nombre']);
        $correo = strClean($_POST['correo']);
        $clave = strClean($_POST['clave']);
        $confirmar = strClean($_POST['confirmar']);
        $id = strClean($_POST['id']);
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        if (empty($usuario) || empty($nombre) || empty($correo)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'error');
        }else{
            if ($id == "") {
                if(empty($clave) || empty($confirmar)){
                    $msg = array('msg' => 'Todo los campos son obligatorios','icono' => 'error');
                }else{
                    if ($clave != $confirmar) {
                        $msg = array('msg' => 'Las contraseña no coinciden', 'icono' => 'warning');
                    }else{
                        $data = $this->model->registrarUsuario($usuario, $nombre,$correo, $hash);
                        if ($data == "ok") {
                            $msg = array('msg' => 'Usuario registrado con éxito', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'El usuario ya existe', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'Error al registrar el usuario', 'icono' => 'error');
                        }
                    }
                }
            }else{
                $data = $this->model->modificarUsuario($usuario, $nombre, $correo, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El usuario ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al modificar el usuario', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionUser(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el usuario', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionUser(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el usuario', 'icono' => 'success');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function perfil()
    {
        $id = $_SESSION['id_usuario'];
        $data = $this->model->getPerfil($id);
        $this->views->getView('usuarios', 'perfil', $data);
    }
    public function cambiarPerfil()
    {
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        if (!empty($name)) {
            $imgNombre = $_SESSION['id_usuario'] . ".png";
            $destino = "Assets/img/usuarios/" . $imgNombre;
            if (move_uploaded_file($tmpname, $destino)) {
                $msg = array('msg' => 'Perfil actualizado', 'icono' => 'success');
            }else{
                $msg = array('msg' => 'Error al actualizar perfil', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function eliminarPerfil()
    {
        $ruta = 'Assets/img/usuarios/' . $_SESSION['id_usuario'] . '.png';
        if (file_exists($ruta)) {
            if (unlink($ruta)) {
                $msg = array('msg' => 'Foto de perfil eliminado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al eliminar foto de perfil', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function cambiar_pass()
    {
        $actual = strClean($_POST['actual']);
        $nueva = strClean($_POST['nueva']);
        $confirmar = strClean($_POST['confirmar']);
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($nueva != $confirmar) {
                $msg = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
            }else{
                $id = $_SESSION['id_usuario'];
                $data = $this->model->getPerfil($id);
                if (password_verify($actual, $data['clave'])) {
                    $data = $this->model->ActualizarPass(password_hash($nueva, PASSWORD_DEFAULT), $id);
                    if ($data == 'ok') {
                        $msg = array('msg' => 'Contraseña modificada con exito', 'icono' => 'success');
                    }
                } else {
                    $msg = array('msg' => 'Contraseña actual incorrecta', 'icono' => 'warning');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function permisos($id)
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "roles");
        if (!$perm && $id_user != 1) {
            echo '<div class="card">
                    <div class="card-body text-center">
                        <span class="badge badge-danger">No tienes permisos</span>
                    </div>
                </div>';
            exit;
        }
        $data = $this->model->getPermisos();
        $asignados = $this->model->getDetallePermisos($id);
        $datos = array();
        foreach ($asignados as $asignado) {
            $datos[$asignado['id_permiso']] = true;
        }
        echo '<div class="row">
        <input type="hidden" name="id_usuario" value="' . $id . '">';
        foreach ($data as $row) {
            echo '<div class="d-inline mx-3 text-center">
                    <hr>
                    <label for="" class="font-weight-bold text-capitalize">' . $row['permiso'] . '</label>
                        <div class="center">
                            <input type="checkbox" name="permisos[]" value="' . $row['id'] . '" ';
            if (isset($datos[$row['id']])) {
                echo "checked";
            }
            echo '>
                            <span class="span">On</span>
                            <span class="span">Off</span>
                        </div>
                </div>';
        }
        echo '</div>
        <button class="btn btn-primary mt-3 btn-block" type="button" onclick="registrarPermisos();">Actualizar</button>';
        die();
    }
    public function registrarPermisos()
    {
        $id_user = $_POST['id_usuario'];
        $permisos = $_POST['permisos'];
        $this->model->deletePermisos($id_user);
        if ($permisos != "") {
            foreach ($permisos as $permiso) {
                $this->model->actualizarPermisos($id_user, $permiso);
            }
        }
        $msg = array('msg' => 'Permisos Modificado', 'icono' => 'success');
        echo json_encode($msg);
        die();
    }
    public function salir()
    {
        session_destroy();
        header("location: ".base_url);
    }
}