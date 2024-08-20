<?php
class ProcesosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProcesos()
    {
        $sql = "SELECT p.id, pr.descripcion as id_producto, m.nombre as id_maquinaria, p.orden, p.tiempo, p.estado FROM procesos p INNER JOIN productos pr on p.id_producto = pr.id INNER JOIN maquinaria m on p.id_maquinaria = m.id;";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos()
    {
        $sql = "SELECT p.*, c.id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id_cat = p.id_cat";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getMaquinaria()
    {
        $sql = "SELECT * FROM maquinaria";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarProcesos(string $idp, string $idm, string $orden, string $tiempo)
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
    public function modificarProcesos(string $idp, string $idm, string $orden, string $tiempo, int $id)
    {
        $sql = "UPDATE procesos SET id_producto=?, id_maquinaria = ?, orden=?, tiempo = ? WHERE id = ?";
        $datos = array($idp, $idm, $orden, $tiempo, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarProceso(int $id)
    {
        $sql = "SELECT * FROM procesos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionProcesos(int $estado, int $id)
    {
        $sql = "UPDATE procesos SET estado = ? WHERE id = ?";
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
