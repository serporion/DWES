<?php

namespace Models;
use Lib\BaseDatos;
use PDOException;

    class Entrada{
        private BaseDatos $conexion;
        private mixed $stmt;

        function __construct(
            private string | null $id = null,
            private string $usuario_id='',
            private string $categoria_id='',
            private string $titulo='',
            private string $descripcion='',
            private string $fecha='',
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

        public function getUsuarioId(): string
        {
            return $this->usuario_id;
        }

        public function setUsuarioId(string $usuario_id): void
        {
            $this->usuario_id = $usuario_id;
        }

        public function getCategoriaId(): string
        {
            return $this->categoria_id;
        }

        public function setCategoriaId(string $categoria_id): void
        {
            $this->categoria_id = $categoria_id;
        }

        public function getTitulo(): string
        {
            return $this->titulo;
        }

        public function setTitulo(string $titulo): void
        {
            $this->titulo = $titulo;
        }

        public function getDescripcion(): string
        {
            return $this->descripcion;
        }

        public function setDescripcion(string $descripcion): void
        {
            $this->descripcion = $descripcion;
        }

        public function getFecha(): string
        {
            return $this->fecha;
        }

        public function setFecha(string $fecha): void
        {
            $this->fecha = $fecha;
        }



        public static function fromArray(array $data): Entrada
        {
            return new Entrada(
                $data['id'] ?? '',
                $data['usuario_id'] ?? '',
                $data['categoria_id'] ?? '',
                $data['titulo'] ?? '',
                $data['descripcion'] ?? '',
                $data['fecha'] ?? '',
            );
        }

        public function getAll(): array
        {
            try {

                $this->stmt = $this->conexion->consulta("SELECT * FROM entradas");
                $resultados = $this->conexion->extraer_todos();

                return $resultados;

            } catch (PDOException $e) {
                echo "Error al obtener las entradas: " . $e->getMessage();
                return [];
            }
        }

    }
