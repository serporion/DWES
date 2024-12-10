<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\Usuario;
use PDO;
use PDOException;

class UsuarioRepository
{
    function __construct()
    {
        $this->conexion = new BaseDatos();
    }


    public function findAll(): ?array
    {
        $this->conexion->consulta("SELECT * from usuarios");
        return $this->conexion->extraer_todos();

    }


    public function extractAll(): ?array
    {


        $this->conexion->consulta("SELECT * FROM usuarios");

        $UsuariosData = $this->conexion->extraer_todos();

        if (!$UsuariosData) {
            return null; // Si no hay resultados, devuelve null
        }

        $usuarios = [];
        foreach ($UsuariosData as $usuario) {
            $usuarios[] = Usuario::fromArray($usuario);
        }

        return $usuarios;
    }


    public function extraer_Usuario(int $id): ?Usuario
    {

        $this->conexion->consulta("SELECT * from usuarios where id=$id");

        $UsuarioUnico = $this->conexion->extraer_registro();

        if (!$UsuarioUnico) {
            return null; // Si no hay resultados, devuelve null
        }

        return Usuario::fromArray($UsuarioUnico);

    }


    public function save(Usuario $usuario): bool {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if ($usuario->getId()) {

                //if ($_SESSION['usuario']['rol'] == 7 ){
                    $rol = 1;
                //}

                $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, fecha = :fecha, rol = :rol WHERE id = :id";
            } else {

                $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, fecha, rol) VALUES (:nombre, :apellidos, :email, :password, :fecha, 1)";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);

            $stmt->bindValue(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':password', $usuario->getPassword(), PDO::PARAM_STR);
            $stmt->bindValue(':fecha', $usuario->getFecha('Y-m-d'), PDO::PARAM_STR);
            //$stmt->bindValue(':rol', $rol, PDO::PARAM_STR);



            if ($usuario->getId()) {
                $stmt->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            }


            $result = $stmt->execute();

            $stmt->closeCursor();

            return $result;

        } catch (\PDOException $e) {

            return false;
        }
    }

    public function delete(Usuario $usuario ,int $id): bool
    {

        try {
            if ($usuario->getId()) {

                $sql = "DELETE from usuarios WHERE id = $id";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);


            $result = $stmt->execute();

            $stmt->closeCursor();

            return $result;

        } catch (\PDOException $e) {

            if ($e->getCode() == '23000') { //Corresponde al error de violacion de integridad. Elimino el mensaje comun en UsuarioController.
                $_SESSION['error'] = "No se puede eliminar el usuario porque tiene registros asociados en otras tablas.";
            } else {
                $_SESSION['error'] = "Error al eliminar el usuario: " . $e->getMessage();
            }
            return false;
        }
    }

    public function buscarEmail($email) {

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $params = [':email' => $email];

        try {

            $stmt = $this->conexion->getConexion()->prepare($sql);
            $stmt->execute($params);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {

                return Usuario::fromArray($resultado);
            } else {

                return null;
            }

        } catch (PDOException $e) {

            error_log("Error al buscar email: " . $e->getMessage());
            return null;
        }
    }

}