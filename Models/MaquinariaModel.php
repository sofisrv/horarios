<?php
class maquinariaModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMaquinaria()
    {
        
        $sql = "SELECT c.id, c.codigo, c.nombre, c.tiempo_l, c.estado FROM maquinaria c";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarMaquinaria(string $codigo, string $nombre, string $tiempo_l)
    {
            # code...
            $sql = "INSERT INTO maquinaria(codigo, nombre, tiempo_l) VALUES (?,?,?)";
            $datos = array($codigo, $nombre, $tiempo_l);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        return $res;
    }
    public function modificarMaquinaria(string $codigo, string $nombre, string $tiempo_l, string $id)
    {
        $sql = "UPDATE maquinaria SET codigo = ?, nombre = ? ,tiempo_l = ? WHERE id = ?";
        $datos = array($codigo, $nombre, $tiempo_l, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarMaquinaria(int $id)
    {
        $sql = "SELECT * FROM maquinaria WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionMaquinaria(int $estado, int $id)
    {
        $sql = "UPDATE maquinaria SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.id, p.permiso, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
}
