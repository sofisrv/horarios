<?php
class EventosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEventos()
    {
        $sql = "SELECT p.id, p.hora_ini, p.hora_fin, p.tipo as fecha, pr.nombre as id_maquinaria, p.estado FROM eventos p INNER JOIN maquinaria pr on p.id_maquinaria = pr.id ;";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarEvento(string $idp, string $idm, string $orden, string $tiempo)
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
    public function modificarEvento(string $idp, string $idm, string $orden, string $tiempo, int $id)
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
    public function editarEvento(int $id)
    {
        $sql = "SELECT * FROM eventos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionEvento(int $estado, int $id)
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
