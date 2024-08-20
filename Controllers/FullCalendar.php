<?php
class FullCalendar extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
    }
    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "fullcalendar");
        if (!$perm && $id_user != 1) {
            $this->views->getView('templates', "permisos");
            exit;
        }
        $this->views->getView('fullcalendar', "index");
    }
}
