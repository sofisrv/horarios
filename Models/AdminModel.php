<?php
class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM empresa";
        $data = $this->select($sql);
        return $data;
    }
    public function getData(string $table)
    {
        $sql = "SELECT COUNT(*) as $table FROM $table WHERE estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function modificar(string $identidad, string $nom, string $tel, string $dir, string $msg, int $id)
    {
        $sql = "UPDATE empresa SET identidad=?, nombre=?, telefono=?, direccion=?, mensaje=? WHERE id = ?";
            $datos = array($identidad, $nom, $tel, $dir, $msg, $id);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        return $res;
    }
    public function getStock()
    {
        $sql = "SELECT id, descripcion FROM productos WHERE cantidad = 0 AND estado = 1 ORDER BY id DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function selectStockM()
    {
        $sql = "SELECT descripcion, cantidad FROM productos WHERE stock_minimo > cantidad AND cantidad > 0 AND estado = 1 ORDER BY cantidad ASC LIMIT 10";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function selectProductos()
    {
        $sql = "SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) as total FROM detalle_ventas d INNER JOIN productos p ON p.id = d.id_producto group by d.id_producto ORDER BY d.cantidad DESC LIMIT 10";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function ventas_compra(string $table)
    {
        $sql = "SELECT COUNT(*) as total_dia FROM $table WHERE fecha = CURDATE()";
        $res = $this->selecT($sql);
        return $res;
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
