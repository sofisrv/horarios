<?php
require('Libraries/fpdf/pdf_js.php');
class Compras extends Controller{
    public function __construct() {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "nueva_compra");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('compras', "index");
    }
    public function buscarCodigo()
    {
        $data = $this->model->getProCod($_GET['pro']);
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['codigo'] . ' - ' . $row['descripcion'];
            $data['value'] = $row['codigo'];
            $data['precio'] = $row['precio_compra'];
            $data['descripcion'] = $row['descripcion'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar()
    {
        $data = $this->model->getProCod($_GET['pro']);
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['codigo'] . ' - ' . $row['descripcion'];
            $data['value'] = $row['codigo'];
            $data['precio'] = $row['precio_venta'];
            $data['descripcion'] = $row['descripcion'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar_cli()
    {
        $data = $this->model->getCli('clientes', $_GET['pro']);
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['nombre'] . ' - ' . $row['direccion'];
            $data['value'] = $row['nombre'];
            $data['direccion'] = $row['direccion'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar_pr()
    {
        $data = $this->model->getCli('proveedor', $_GET['pro']);
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['ruc'] . ' - ' . $row['nombre'];
            $data['value'] = $row['ruc'];
            $data['nombre'] = $row['nombre'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresar()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'] ;
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->model->getComprobar($id_producto, $id_usuario, 'detalle');
        if (empty($comprobar)) {
            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetalle($id_producto, $id_usuario, $precio,$cantidad,$sub_total);
            if ($data == "ok") {
                $msg = array('msg' => 'Producto ingresado', 'icono' => 'success');
            }else{
                $msg = array('msg' => 'Error al ingresar el producto', 'icono' => 'error');
            }
        }else{
            $total_cant = $comprobar['cantidad'] + $cantidad;
            $total = $precio * $total_cant;
            $data = $this->model->actualizarDetalle('detalle', $id_producto, $id_usuario, $precio, $total_cant, $total, $comprobar['id']);
            if ($data == "ok") {
                $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al actualizar el producto', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresarV()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_venta'];
        $cantidad = $_POST['cantidad'];
        $comprobar = $this->model->getComprobar($id_producto, $id_usuario, 'detalle_temp');
        $cantidad_dis = $datos['cantidad'];
        if ($cantidad_dis < $cantidad) {
            $msg = array('msg' => 'No hay Stock, te quedan ' . $cantidad_dis, 'icono' => 'warning');
        } else {
            if (empty($comprobar)) {
                $sub_total = $precio * $cantidad;
                $data = $this->model->registrarDetalleV($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
                if ($data == "ok") {
                    $msg = array('msg' => 'Producto ingresado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al ingresar el producto', 'icono' => 'error');
                }
            } else {
                $total_cant = $comprobar['cantidad'] + $cantidad;
                $total = $precio * $total_cant;
                $stock_disponible = $cantidad_dis - $comprobar['cantidad'];
                if ($cantidad_dis < $total_cant) {
                    $msg = array('msg' => 'No hay Stock, te quedan ' . $stock_disponible, 'icono' => 'warning');
                } else {
                    $data = $this->model->actualizarDetalle('detalle_temp', $id_producto, $id_usuario, $precio, $total_cant, $total, $comprobar['id']);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al actualizar el producto', 'icono' => 'error');
                    }
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar($table)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle($id_usuario, $table);
        $data['total_pagar'] = $this->model->calcularCompra($id_usuario, $table);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delete($id)
    {
        $data = $this->model->deleteDetalle($id, 'detalle');
        if ($data == 'ok') {
            $msg = array('msg' => 'Producto Eliminado', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el producto', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function delete_venta($id)
    {
        $data = $this->model->deleteDetalle($id, 'detalle_temp');
        if ($data == 'ok') {
            $msg = array('msg' => 'Producto Eliminado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el producto', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }
    public function historial()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "compras");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('compras', "historial_compras");
    }
    public function historial_ventas()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "ventas");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('compras', "historial_ventas");
    }
    public function listar_historial()
    {
        $data = $this->model->getCompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Pagada</span>';
                $data[$i]['acciones'] = '<div>
                <a href="'.base_url. "compras/generarPdf/" . $data[$i]['id'] . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <button class="btn btn-warning" type="button" onclick="btnAnularC(' . $data[$i]['id'] . ');"><i class="fas fa-ban"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a href="' . base_url . "compras/generarPdf/" . $data[$i]['id'] . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function listar_ventas()
    {
        $data = $this->model->getHistorial();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Pagada</span>';
                $data[$i]['acciones'] = '<div>
                <a href="' . base_url . "compras/generarVentaPdf/" . $data[$i]['id'] . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <button class="btn btn-warning" type="button" onclick="btnAnularV(' . $data[$i]['id'] . ');"><i class="fas fa-ban"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div>
                <a href="' . base_url . "compras/generarPdf/" . $data[$i]['id'] . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ventas()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "nueva_venta");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('compras', "ventas");
    }
    public function generar($id_pr)
    {
        $id_pr = strClean($id_pr);
        $id_usuario = $_SESSION['id_usuario'];
        if (empty($id_pr)) {
            $id_pr = 1;
        }
        $data = $this->model->getDetalle($id_usuario, 'detalle');
        $pagar = $this->model->calcularCompra($id_usuario, 'detalle');
        $fecha = date('Y-m-d');
        $compra = $this->model->insertarCompra($id_usuario, $pagar['total'], $id_pr, $fecha);
        if ($compra == 'ok') {
            $folio = $this->model->maximo_id('compras');
            foreach ($data as $row) {
                $id_pro = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $sub_total = $row['sub_total'];
                $this->model->registrarDetalles('detalle_compra',$folio['id'], $id_pro, $cantidad, $precio, $sub_total);
                $stock = $this->model->getProductos($row['id_producto']);
                $cantidad = $stock['cantidad'] + $row['cantidad'];
                $this->model->actualizarStock($cantidad, $stock['id']);
            }
            $eliminar = $this->model->eliminarTemp($id_usuario, 'detalle');
            if ($eliminar == 'ok') {
                $msg = array('msg' => 'Compra Generada', 'folio' => $folio['id'], 'icono' => 'success');
            }
        }else{
            $msg = array('msg' => 'Error al generar la compra', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarVenta($id_cli)
    {
        $id_cli = strClean($id_cli);
        $id_usuario = $_SESSION['id_usuario'];
        $data = $this->model->getDetalle($id_usuario, 'detalle_temp');
        $pagar = $this->model->calcularCompra($id_usuario, 'detalle_temp');
        $fecha = date('Y-m-d');
        $venta = $this->model->insertarVenta($id_usuario, $pagar['total'], $id_cli, $fecha);
        if ($venta == 'ok') {
            $folio = $this->model->maximo_id('ventas');
            foreach ($data as $row) {
                $id_pro = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $descuento = $row['descuento'];
                $precio = $row['precio'];
                $sub_total = $row['sub_total'] - $row['descuento'];
                $this->model->registrarVentas('detalle_ventas', $folio['id'], $id_pro, $cantidad, $descuento, $precio, $sub_total);
                $stock = $this->model->getProductos($row['id_producto']);
                $cantidad = $stock['cantidad'] - $row['cantidad'];
                $this->model->actualizarStock($cantidad, $stock['id']);
            }
            $eliminar = $this->model->eliminarTemp($id_usuario, 'detalle_temp');
            if ($eliminar == 'ok') {
                $msg = array('msg' => 'Venta Generada', 'folio' => $folio['id'], 'icono' => 'success');
            }
        } else {
            $msg = array('msg' => 'Error al generar la venta', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPdf($folio)
    {
        $folio = strClean($folio);
        $empresa = $this->model->getEmpresa();
        $detalle = $this->model->detalleCompras($folio, 'compras', 'detalle_compra');
        $proveedor = $this->model->getProveedor($folio);
        $pdf = new PDF_AutoPrint('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetTitle('Reporte Venta');
        $pdf->SetMargins(2, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(65, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image('Assets/img/logo.png', 50, 16, 25, 25);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['identidad'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $folio, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, 'Fecha: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $proveedor['fecha'], 0, 1, 'L');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Datos del Proveedor', 0, 1, 'C');
        $pdf->Cell(75, 5, '-------------------------------------------------------------', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Nombre: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($proveedor['nombre']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Teléfono'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($proveedor['telefono']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Dirección'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($proveedor['direccion']), 0, 1, 'L');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Detalle de Productos', 0, 1, 'C');
        $pdf->Cell(75, 5, '-------------------------------------------------------------', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'Cant', 0, 0, 'L');
        $pdf->Cell(18, 5, 'Precio', 0, 0, 'L');
        $pdf->Cell(49, 5, utf8_decode('Descripción'), 0, 1, 'L');

        $pdf->SetFont('Arial', '', 10);
        $total = 0.00;
        foreach ($detalle as $row) {
            $total = $total + $row['sub_total'];
            $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(18, 5, $row['precio'], 0, 0, 'L');
            $pdf->MultiCell(49, 5, utf8_decode($row['descripcion']) . ' = ' . $row['sub_total'], 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(75, 5, number_format($total, 2, '.', ','), 0, 1, 'R');
        $pdf->Ln();
        $pdf->MultiCell(75, 5, $empresa['mensaje'], 0, 'C');
        $pdf->AutoPrint();
        $pdf->Output();
        
    }
    public function generarVentaPdf($folio)
    {
        $folio = strClean($folio);
        $empresa = $this->model->getEmpresa();
        $detalle = $this->model->detalleCompras($folio, 'ventas', 'detalle_ventas');
        $cliente = $this->model->getCliente($folio);

        $pdf = new PDF_AutoPrint('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(2, 0, 0);
        $pdf->SetTitle('Reporte Venta');
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Image('Assets/img/logo.png', 50, 16, 25, 25);
        $pdf->Cell(75, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(18, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['identidad'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $folio, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, 'Fecha: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $cliente['fecha'], 0, 1, 'L');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Datos del cliente', 0, 1, 'C');
        $pdf->Cell(75, 5, '-------------------------------------------------------------', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Nombre: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($cliente['nombre']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Teléfono'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($cliente['telefono']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Dirección'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 5, utf8_decode($cliente['direccion']), 0, 1, 'L');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Detalle de Productos', 0, 1, 'C');
        $pdf->Cell(75, 5, '-------------------------------------------------------------', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, 'Cant', 0, 0, 'L');
        $pdf->Cell(18, 5, 'Precio', 0, 0, 'L');
        $pdf->Cell(49, 5, utf8_decode('Descripción'), 0, 1, 'L');
        $total = 0.00;
        $descuento = 0.00;
        $pdf->SetFont('Arial', '', 10);
        foreach ($detalle as $row) {
            $descuento = $descuento + $row['descuento'];
            $total = $total + $row['sub_total'];
            $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(18, 5, $row['precio'], 0, 0, 'L');
            $pdf->MultiCell(49, 5, utf8_decode($row['descripcion']) . ' = ' . $row['sub_total'], 0, 'L');
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Descuento', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(75, 5, number_format($descuento, 2, '.', ','), 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(75, 5, number_format($total, 2, '.', ','), 0, 1, 'R');
        $pdf->Ln();
        $pdf->MultiCell(75, 5, $empresa['mensaje'], 0, 'C');
        $pdf->AutoPrint();
        $pdf->Output();
    }
    public function anularC($id)
    {
        if (isset($_GET)) {
            $existe = $this->model->getDetalleCompra('detalle_compra', $id);
            if (!empty($existe)) {
                foreach ($existe as $row) {
                    $stock = $this->model->getProductos($row['id_producto']);
                    $cantidad = $stock['cantidad'] - $row['cantidad'];
                    $this->model->actualizarStock($cantidad, $stock['id']);
                }
                $data = $this->model->anular('compras', $id);
                if ($data == 'ok') {
                    $msg = array('msg' => 'Compra anulada', 'icono' => 'success');
                }else{
                    $msg = array('msg' => 'Error al anular la compra', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Error al anular la compra', 'icono' => 'error');
            }
            echo json_encode($msg);
            die();
        }
    }
    public function anularV($id)
    {
        if (isset($_GET)) {
            $existe = $this->model->getDetalleCompra('detalle_ventas', $id);
            if (!empty($existe)) {
                foreach ($existe as $row) {
                    $stock = $this->model->getProductos($row['id_producto']);
                    $cantidad = $stock['cantidad'] + $row['cantidad'];
                    $this->model->actualizarStock($cantidad, $stock['id']);
                }
                $data = $this->model->anular('ventas', $id);
                if ($data == 'ok') {
                    $msg = array('msg' => 'Venta anulada', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al anular la venta', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Error al anular la venta', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function descuentoVenta($datos)
    {
        $array = explode(",", $datos);
        $id = strClean($array[0]);
        $desc = strClean($array[1]);
        if (is_numeric($id) && is_numeric($desc)) {
            $data = $this->model->actualizarDescuento($desc, $id);
            if ($data == 'ok') {
                $mensaje = array('msg' => 'Descuento Agregado', 'icono' => 'success');
            } else {
                $mensaje = array('msg' => 'Error al agregar el descuento', 'icono' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'Ingrese un número valido', 'icono' => 'warning');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}
class PDF_AutoPrint extends PDF_JavaScript
{
    function AutoPrint($printer = '')
    {
        // Open the print dialog
        if ($printer) {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        } else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
    
}

