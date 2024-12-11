<?php

namespace Controllers;

use Lib\Pages;
use Models\Login;
use Services\EntradaService;
use Services\UsuarioService;

class LoginController
{
    private Login $login;
    private Pages $pages;

    private UsuarioService $serviceUsu;
    private EntradaService $entradaService;

    function __construct()
    {
        //Hace uso del modelo Usuario y del modelo Entrada
        $this->pages = new Pages();
        $this->usuarioService = new UsuarioService();
        $this->entradaService = new EntradaService();
        //$this->usuario = new Usuario();

    }

    //Función que llama al formulario de inicio de sesión en el blog.
    public function mostrarLoginInicio(): void
    {
        $this->pages->render('Login/loginForm');
    }

    //Funcion que comprueba que existe el mail en la base de datos que le corresponde la password correspondiente.
    public function comprobarUsuarioanti(): void
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuarioInput = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuariosData = $this->usuarioService->findAll();

            //Uso de array que no es de objetos no necesario ya.
            //$usuarios = array_map(fn($data) => Usuario::fromArray($data), $usuariosData);

            foreach ($usuariosData as $usuario) {

                if ($usuario->getEmail() === $usuarioInput) {

                    $usu = $usuario->getEmail();

                    //if (password_verify($password, $usuario->getPassword())) {

                        $this->iniciarSesion($usuario);

                        $this->redirigirSegunRol($usuario->getRol());

                        exit;

                    //} else {
                        //Paso el usuario correcto al formulario para mejor experiencia.
                        $this->pages->render('Login/loginForm', ['error' => 'Compruebe su contraseña.', 'usu' => $usu]);

                    //}
                }else {
                    $this->pages->render('Login/loginForm', ['error' => 'Compruebe su usuario.']);
                }
            }

        } else {
            echo "<p>Acceso no permitido.</p>";
        }
    }
    public function comprobarUsuario(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuarioInput = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuariosData = $this->usuarioService->findAll();

            //$usuarios = array_map(fn($data) => Usuario::fromArray($data), $usuariosData);

            $paso = false;

            $usuarioEncontrado = false;
            $passwordCorrecta = false;

            foreach ($usuariosData as $usuario) {
                if ($usuario->getEmail() === $usuarioInput) {
                    $usuarioEncontrado = true;

                    if (password_verify($password, $usuario->getPassword())) {
                        $passwordCorrecta = true;
                        $this->iniciarSesion($usuario);
                        $this->redirigirSegunRol($usuario->getRol());
                        exit;
                    }

                    break; // Salimos del bucle si encontramos el usuario, aunque la contraseña sea incorrecta
                }
            }

            if (!$usuarioEncontrado || !$passwordCorrecta) {
                $this->pages->render('Login/loginForm', ['error' => 'Comprueba usuario y contraseña.']);
            }

        } else {
            echo "<p>Acceso no permitido.</p>";
        }
    }
    //Función que inicia la sesión y graba diferentes datos en ella, que servirán posteriormente en otras acciones. Los tenemos más
    //rápido disponibles.
    private function iniciarSesion($usuario): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['usuario'] = [
            'rol' => $usuario->getRol(),
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'apellidos' => $usuario->getApellidos(),
            'correo' => $usuario->getEmail(),

        ];
    }

    //Función que destruye la sesión, y redirige a la página de inicio.
    public function logout(): void
    {
        session_start(); //Continuación de la sessión. Necesario para poder ser destruida.
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "Dashboard/index");
        exit;
    }

    //Función que según el rol del usuario en cuestión le lleva a una zona de bienvenida u otra.
    private function redirigirSegunRol(int $rol): void {

        $todas_las_entradas = $this->entradaService->findAll();

        if ($rol == 1) {
            $this->pages->render('Usuario/bienvenidoUsuario', ['todas_las_entradas' => $todas_las_entradas]);

        } elseif ($rol == 7) {
            $this->pages->render('Usuario/bienvenidoAdmin', ['todas_las_entradas' => $todas_las_entradas]);

        } else {

            echo "Rol no reconocido";
        }
    }
}
