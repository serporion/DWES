<?php

namespace Controllers;

use Lib\Pages;
use Services\EntradaService;

class DashboardController {
    private Pages $pages;

    private EntradaService $entradaService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->entradaService = new EntradaService();
    }

    //Dependiendo de si existe o no una sesión y de quien esté logado se redirige a una página u otra.
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $todas_las_entradas = $this->entradaService->findAll();

        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['usuario']['rol'] == 1) {
                $this->pages->render('Usuario/bienvenidoUsuario', ['todas_las_entradas' => $todas_las_entradas]);
            } elseif ($_SESSION['usuario']['rol'] == 7) {
                $this->pages->render("Usuario/bienvenidoAdmin"); //, ['todas_las_entradas' => $todas_las_entradas]);
            } else {
                $this->pages->render('Entrada/mostrar_todos', ['todas_las_entradas' => $todas_las_entradas]);
            }
        } else {

            $this->pages->render('Entrada/mostrar_todos', ['todas_las_entradas' => $todas_las_entradas]);
        }
    }


}