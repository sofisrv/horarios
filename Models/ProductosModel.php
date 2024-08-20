<?php
class ProductosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductos()
    {
        $sql = "SELECT p.*, c.id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id_cat = p.id_cat";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $minimo,string $img, int $cat)
    {
        $verificar = "SELECT * FROM productos WHERE codigo = '$codigo'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO productos(codigo, descripcion, precio_compra, precio_venta,stock_minimo,foto,id_cat) VALUES (?,?,?,?,?,?,?)";
            $datos = array($codigo, $nombre, $precio_compra, $precio_venta,$minimo, $img, $cat);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }
        return $res;
    }
    public function modificarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $minimo, string $img, int $cat, int $id)
    {
        $verificar = "SELECT * FROM productos WHERE codigo = '$codigo' AND id != $id";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "UPDATE productos SET codigo=?, descripcion=?, precio_compra=?, precio_venta=?, stock_minimo=?, foto=?, id_cat=? WHERE id = ?";
            $datos = array($codigo, $nombre, $precio_compra, $precio_venta, $minimo, $img,$cat, $id);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "modificado";
            } else {
                $res = "error";
            }
        }else{
            $res = "existe";
        }
        return $res;
    }
    public function editarPro(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionPro(int $estado, int $id)
    {
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
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
