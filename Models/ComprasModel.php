<?php
class ComprasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProCod(string $cod)
    {
        $sql = "SELECT * FROM productos WHERE codigo LIKE '%" . $cod . "%' AND estado = 1 OR descripcion LIKE '%" . $cod . "%' AND estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getCli(string $table, string $nombre)
    {
        $sql = "SELECT * FROM $table WHERE nombre LIKE '%" . $nombre . "%' AND estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function getCliente(int $id)
    {
        $sql = "SELECT v.*, c.* FROM ventas v INNER JOIN clientes c ON c.id = v.id_cliente WHERE v.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function getProveedor(int $id)
    {
        $sql = "SELECT c.*, p.* FROM compras c INNER JOIN proveedor p ON p.id = c.id_proveedor WHERE c.id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {
        $sql = "INSERT INTO detalle(id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function registrarDetalleV(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {
        $sql = "INSERT INTO detalle_temp (id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function actualizarDetalle(string $table, int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total, int $id)
    {
        $sql = "UPDATE $table SET id_producto = ?, id_usuario = ?, precio = ?, cantidad = ?, sub_total = ? WHERE id = $id";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getDetalle(int $id, string $table)
    {
        $sql = "SELECT d.*, p.id AS id_pro, p.descripcion FROM $table d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getComprobar(int $id, int $usuario, string $table)
    {
        $sql = "SELECT * FROM $table WHERE id_producto = $id AND id_usuario = $usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function calcularCompra(int $id_usuario, string $table)
    {
        $sql = "SELECT sub_total, SUM(sub_total) AS total FROM $table WHERE id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function deleteDetalle(int $id, string $table)
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function insertarCompra(int $id, string $total, int $id_pr, string $fecha)
    {
        $sql = "INSERT INTO compras (id_usuario, total, id_proveedor, fecha) VALUES (?,?,?,?)";
        $datos = array($id, $total, $id_pr, $fecha);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function insertarVenta(int $id, string $total, int $id_cli, string $fecha)
    {
        $sql = "INSERT INTO ventas (id_usuario, total, id_cliente, fecha) VALUES (?,?,?,?)";
        $datos = array($id, $total, $id_cli, $fecha);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function maximo_id(string $table)
    {
        $sql = "SELECT MAX(id) AS id FROM $table";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalles(string $table, int $id, int $id_pro, int $cantidad, string $precio, string $sub_total)
    {
        $sql = "INSERT INTO $table(folio, id_producto, cantidad, precio, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id, $id_pro, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function registrarVentas(string $table, int $id, int $id_pro, int $cantidad, string $descuento,string $precio, string $sub_total)
    {
        $sql = "INSERT INTO $table(folio, id_producto, cantidad, descuento,precio, sub_total) VALUES (?,?,?,?,?,?)";
        $datos = array($id, $id_pro, $cantidad, $descuento, $precio,$sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function eliminarTemp(int $id_usuario, string $table)
    {
        $sql = "DELETE FROM $table WHERE id_usuario = ?";
        $datos = array($id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $msg = 'ok';
        }else{
            $msg = 'error';
        }
        return $msg;
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM empresa";
        $data = $this->select($sql);
        return $data;
    }
    public function getCompras()
    {
        $sql = "SELECT p.id, p.nombre, c.* FROM proveedor p INNER JOIN compras c ON c.id_proveedor = p.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getHistorial()
    {
        $sql = "SELECT c.id, c.nombre, v.* FROM clientes c INNER JOIN ventas v ON v.id_cliente = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function detalleCompras(int $folio, string $table1, string $table2)
    {
        $sql = "SELECT c.*, d.*, p.id, p.descripcion FROM $table1 c INNER JOIN $table2 d ON c.id = d.folio INNER JOIN productos p ON p.id = d.id_producto WHERE c.id = $folio";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getDetalleCompra(string $table, int $id)
    {
        $sql = "SELECT * FROM $table WHERE folio = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function actualizarStock(int $cantidad, int $id)
    {
        $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
        $datos = array($cantidad, $id);
        $this->save($sql, $datos);
    }
    public function anular(string $table, int $id)
    {
        $sql = "UPDATE $table SET estado = ? WHERE id = ?";
        $datos = array(0, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
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
    public function actualizarDescuento(string $desc, int $id)
    {
        $sql = "SELECT * FROM detalle_temp WHERE id = $id";
        $data = $this->select($sql);
        $descuento = $data['descuento'] + $desc;
        $sql = "UPDATE detalle_temp SET descuento = ? WHERE id = ?";
        $datos = array($descuento, $id);
        $verificar = $this->save($sql, $datos);
        if ($verificar == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
}
