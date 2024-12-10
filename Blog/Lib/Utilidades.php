<?php

namespace Lib;

class Utilidades {

    public static function filtrado($datos) {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
        return $datos;
    }

    public static function validarNombre($nombre) {

        $nombre = self::filtrado($nombre);

        if (empty($nombre)) {
            return ["error" => "El nombre está vacío", "valor" => null];
        }
        if (strlen($nombre) < 4) {
            return ["error" => "El nombre debe tener al menos 4 caracteres", "valor" => null];
        }
        return ["error" => null, "valor" => $nombre];
    }

    public static function validarApellidos($apellidos) {

        $apellidos = self::filtrado($apellidos);

        if (empty($apellidos)) {
            return ["error" => "Los apellidos están vacíos", "valor" => null];
        }
        return ["error" => null, "valor" => $apellidos];
    }

    public static function validarEmail($email) {

        $email = self::filtrado($email);

        if (empty($email)) {
            return ["error" => "El correo electrónico está vacío", "valor" => null];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["error" => "El correo electrónico no es válido", "valor" => null];
        }
        return ["error" => null, "valor" => $email];
    }


    public static function validarFechaNacimiento($fecha) {

        $fecha = self::filtrado($fecha);

        if (empty($fecha)) {
            return ["error" => "La fecha de nacimiento está vacía", "valor" => null];
        }
        return ["error" => null, "valor" => $fecha];
    }


    public static function validarPassword($password) {

        if (empty($password)) {
            return ["error" => "La contraseña está vacía", "valor" => null];
        }

        if (strlen($password) < 8) {
            return ["error" => "La contraseña debe tener al menos 8 caracteres", "valor" => null];
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return ["error" => "La contraseña debe contener al menos una letra mayúscula", "valor" => null];
        }

        if (!preg_match('/[a-z]/', $password)) {
            return ["error" => "La contraseña debe contener al menos una letra minúscula", "valor" => null];
        }

        return ["error" => null, "valor" => $password];
    }

    public static function validarPasswordRepetida($password, $passwordRepetida) {

        if ($password !== $passwordRepetida) {
            return ["error" => "Las contraseñas no coinciden", "valor" => null];
        }

        return self::validarPassword($password);
    }


    public static function validarTitulo($titulo) {

        $titulo = self::filtrado($titulo);

        if (empty($titulo)) {
            return ["error" => "El título está vacío", "valor" => null];
        }
        if (strlen($titulo) < 4) {
            return ["error" => "El titulo debe tener al menos 4 caracteres", "valor" => null];
        }
        return ["error" => null, "valor" => $titulo];
    }

    public static function validarDescripcion($descripcion) {

        $descripcion = self::filtrado($descripcion);

        if (empty($descripcion)) {
            return ["error" => "La descripción está vacía", "valor" => null];
        }
        if (strlen($descripcion) < 5) {
            return ["error" => "La descripcion debe tener al menos 10 caracteres, explayesé!!", "valor" => null];
        }
        return ["error" => null, "valor" => $descripcion];
    }

}

