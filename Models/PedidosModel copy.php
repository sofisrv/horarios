<?php
class PedidosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPedido()
    {
        $sql = "SELECT  p.id, pr.codigo as codigo, pr.descripcion as id_producto, p.fecha_creacion, p.fecha_entrega, p.estado FROM pedidos p INNER join productos pr on pr.id = p.id_producto";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos()
    {
        $sql = "SELECT p.*, c.id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id_cat = p.id_cat";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarPedido(string $codigo, string $id_producto, string $fecha_creacion, string $fecha_entrega)
    {
        $sql = "INSERT INTO pedidos(codigo, id_producto, fecha_creacion, fecha_entrega) VALUES (?,?, ?, ?)";
        $datos = array($codigo, $id_producto, $fecha_creacion, $fecha_entrega);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function modificarPedido(string $idp, string $idm, string $orden, string $tiempo, int $id)
    {
        $sql = "UPDATE pedidos SET codigo=?, id_producto = ?, fecha_creacion=?, fecha_entrega = ? WHERE id = ?";
        $datos = array($codigo, $id_producto, $fecha_creacion, $fecha_entrega, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarPedido(int $id)
    {
        $sql = "SELECT * FROM pedidos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionPedidos(int $estado, int $id)
    {
        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
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
