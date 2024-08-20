<?php
class LimpiezasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLimpiezas()
    {
        $sql = "SELECT p.id, p.hora_ini, p.hora_fin, p.fecha, pr.nombre as id_maquinaria, p.estado FROM eventos p INNER JOIN maquinaria pr on p.id_maquinaria = pr.id where tipo = '2';";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarLimpieza(string $idp, string $idm, string $orden, string $tiempo)
    {
        $sql = "INSERT INTO procesos(id_producto, id_maquinaria, orden, tiempo) VALUES (?,?, ?, ?)";
        $datos = array($idp, $idm, $orden, $tiempo);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function modificarLimpieza(string $idp, string $idm, string $orden, string $tiempo, int $id)
    {
        $sql = "UPDATE eventos SET id_producto=?, id_maquinaria = ?, orden=?, tiempo = ? WHERE id = ?";
        $datos = array($idp, $idm, $orden, $tiempo, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarLimpieza(int $id)
    {
        $sql = "SELECT * FROM eventos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionLimpieza(int $estado, int $id)
    {
        $sql = "UPDATE eventos SET estado = ? WHERE id = ?";
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
