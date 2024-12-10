<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\Categoria;
use PDO;

class CategoriaRepository
{
    function __construct()
    {
        $this->conexion = new BaseDatos();
    }


    public function findAll(): ?array
    {
        $this->conexion->consulta("SELECT * from categorias");
        return $this->conexion->extraer_todos();

    }

    public function extractAll(): ?array
    {

        $this->conexion->consulta("SELECT * FROM categorias");

        $CategoriasData = $this->conexion->extraer_todos();

        if (!$CategoriasData) {
            return null; // Si no hay resultados, devuelve null
        }

        $categorias = [];
        foreach ($CategoriasData as $categoria) {
            $categorias [] = Categoria::fromArray($categoria);
        }

        return $categorias;
    }

    public function extraer_Categoria(int $id): ?Categoria
    {

        $this->conexion->consulta("SELECT * from categorias where id=$id");

        $CategoriaUnico = $this->conexion->extraer_registro();

        if (!$CategoriaUnico) {
            return null; // Si no hay resultados, devuelve null
        }

        return Categoria::fromArray($CategoriaUnico);

    }

    public function save(Categoria $categoria): bool {

        if (session_status() == PHP_SESSION_NONE) {

            session_start();
        }

        try {
            if ($categoria->getId()) {

                $sql = "UPDATE categorias SET nombre = :nombre WHERE id = :id";

            } else {

                $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);

            $stmt->bindValue(':nombre', $categoria->getNombre(), PDO::PARAM_STR);

            if ($categoria->getId()) {
                $stmt->bindValue(':id', $categoria->getId(), PDO::PARAM_INT);
            }

            $result = $stmt->execute();

            $stmt->closeCursor();

            return $result;

        } catch (\PDOException $e) {

            if ($e->getCode() == '23000') { //Corresponde al error de violacion de integridad. Elimino el mensaje común en UsuarioController.
                $_SESSION['error'] = 'Esta categoría ya existe.';
            } else {
                $_SESSION['error'] = "Error en la creación de categoria: ";
            }

            return false;
        }

    }

    public function delete(Categoria $categoria ,int $id): bool
    {

        try {

            if ($categoria->getId()) {

                $sql = "DELETE from categorias WHERE id = $id";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);


            return $stmt->execute();

        } catch (\PDOException $e) {

            if ($e->getCode() == '23000') { //Corresponde al error de violacion de integridad. Elimino el mensaje comun en UsuarioController.
                $_SESSION['error'] = "No se puede eliminar la categoria porque tiene registros asociados en otras tablas.";
            } else {
                $_SESSION['error'] = "Error al eliminar la categoria: " . $e->getMessage();
            }
            return false;

        }
    }

}