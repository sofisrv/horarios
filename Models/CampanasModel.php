<?php
class CampanasModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCampanas()
    {
        
        $sql = "SELECT c.id, p1.codigo as id1, p2.codigo as id2, c.tiempo_campana, c.estado FROM campanas c INNER JOIN productos p1 ON c.id1 = p1.id INNER JOIN productos p2 ON c.id2 = p2.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos()
    {
        $sql = "SELECT p.*, c.id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id_cat = p.id_cat";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarCam(string $id1, string $id2, string $tiempo_campana, string $tiempo)
    {
        
            # code...
            $sql = "INSERT INTO campanas(id1, id2, tiempo_campana, tiempo) VALUES (?,?,?,?)";
            $datos = array($id1, $id2, $tiempo_campana, $tiempo);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        return $res;
    }
    public function modificarCampana(string $id1, string $id2, string $tiempo_campana, string $tiempo, int $id)
    {
        $sql = "UPDATE campanas SET id1 = ?, id2 = ? ,tiempo_campana = ?, campana = ? WHERE id = ?";
        $datos = array($id1, $id2, $tiempo_campana, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarCam(int $id)
    {
        $sql = "SELECT * FROM campanas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCam(int $estado, int $id)
    {
        $sql = "UPDATE campanas SET estado = ? WHERE id = ?";
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
