<?php

namespace Models;

use Lib\BaseDatos;
use PDOException;

class Login
{

    private BaseDatos $conexion;
    private mixed $stmt;

    function __construct(
        private string | null $id = null,

    )
    {
        $this->conexion = new BaseDatos();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getAll(): array
    {
        try {

            $this->stmt = $this->conexion->consulta("SELECT * FROM usuarios");
            $resultados = $this->conexion->extraer_todos();

            return $resultados;

        } catch (PDOException $e) {

            echo "Error al obtener los usuarios: " . $e->getMessage();
            return [];
        }
    }

    public static function fromArray(array $data): Usuario
    {
        return new Usuario(
            $data['id'] ?? '',
            $data['nombre'] ?? '',
            $data['password'] ?? '',
            $data['correo'] ?? '',

        );
    }
}