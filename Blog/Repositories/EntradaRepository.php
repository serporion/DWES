<?php

namespace Repositories;

use Lib\BaseDatos;
use Models\Entrada;
use PDO;

class EntradaRepository
{
    function __construct()
    {
        $this->conexion = new BaseDatos();
    }

    //Anteriormetodo pero no nos da objetos, solo un array
    public function findAll(): ?array
    {
        $this->conexion->consulta("SELECT * from entradas ORDER BY fecha DESC");
        return $this->conexion->extraer_todos();

    }


    public function extractAll(): ?array
    {

        $this->conexion->consulta("SELECT * FROM entradas ORDER BY fecha DESC");

        $EntradasData = $this->conexion->extraer_todos();

        if (!$EntradasData) {
            return null; // Si no hay resultados, devuelve null
        }

        $entradas = [];

        foreach ($EntradasData as $entrada) {
            $entradas[] = Entrada::fromArray($entrada);
        }

        return $entradas;
    }

    


    public function extraer_Entrada(int $id): ? Entrada
    {

        $this->conexion->consulta("SELECT * from entradas where id=$id");

        $EntradaUnico = $this->conexion->extraer_registro();

        if (!$EntradaUnico) {
            return null; // Si no hay resultados, devuelve null
        }

        return Entrada::fromArray($EntradaUnico);

    }


    public function save(Entrada $entrada): bool {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if ($entrada->getId()) {

                $sql = "UPDATE entradas SET usuario_id = :usuario_id, categoria_id = :categoria_id, titulo = :titulo, descripcion = :descripcion, fecha = :fecha WHERE id = :id";
            } else {

                $sql = "INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES (:usuario_id, :categoria_id, :titulo, :descripcion, :fecha)";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);

            $stmt->bindValue(':usuario_id', $_SESSION['usuario']['id']);
            $stmt->bindValue(':categoria_id', $entrada->getCategoriaId(), PDO::PARAM_STR);
            $stmt->bindValue(':titulo', $entrada->getTitulo(), PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $entrada->getDescripcion(), PDO::PARAM_STR);
            $stmt->bindValue(':fecha', date("Y-m-d"), PDO::PARAM_STR);


            if ($entrada->getId()) {
                $stmt->bindValue(':id', $entrada->getId(), PDO::PARAM_INT);
            }

            $result = $stmt->execute();

            $stmt->closeCursor();

            return $result;

        } catch (\PDOException $e) {

            return false;
        }
    }

    public function buscarEntradas(string $buscar): ?array
    {
        $sql = "
        SELECT 
            id AS entrada_id,
            titulo,
            descripcion,
            fecha
        FROM 
            entradas
        WHERE 
            titulo LIKE :buscar OR descripcion LIKE :buscar
        ORDER BY fecha DESC
    ";

        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
        $stmt->execute();

        $EntradasData = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!$EntradasData) {
            return null; // Si no hay resultados, devuelve null
        }

        $entradas = [];
        foreach ($EntradasData as $entrada) {
            $entradas[] = Entrada::fromArray((array)$entrada);
        }

        return $entradas;
    }


    public function delete(Entrada $entrada ,int $id): bool
    {

        try {

            if ($entrada->getId()) {

                $sql = "DELETE from entradas WHERE id = $id";
            }

            $stmt = $this->conexion->getConexion()->prepare($sql);


            $result = $stmt->execute();

            $stmt->closeCursor();

            return $result;

        } catch (\PDOException $e) {

            return false;
        }
    }


}