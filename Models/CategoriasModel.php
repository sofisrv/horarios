<?php
class CategoriasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarCat(string $codigo, string $nombre)
    {
        $verficar = "SELECT * FROM categorias WHERE codigo = '$codigo'";
        $existe = $this->select($verficar);
        if (empty($existe)) {
            $sql = "INSERT INTO categorias(codigo, categoria) VALUES (?,?)";
            $datos = array($codigo, $nombre);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function modificarCat(string $codigo, string $nombre, int $id)
    {
        $sql = "UPDATE categorias SET codigo=?, categoria = ? WHERE id_cat = ?";
        $datos = array($codigo, $nombre, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarCat(int $id)
    {
        $sql = "SELECT * FROM categorias WHERE id_cat = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCat(int $estado, int $id)
    {
        $sql = "UPDATE categorias SET estado = ? WHERE id_cat = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $sql = "SELECT p.id, p.permiso, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$permiso'";
        $existe = $this->select($sql);
        return $existe;
    }
}
