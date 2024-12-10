<?php

namespace Models;
use Lib\BaseDatos;
use PDOException;

    class Usuario{
        private BaseDatos $conexion;
        private mixed $stmt;

        function __construct(
            private string | null $id = null,
            private string $nombre='',
            private string $apellidos='',
            private string $email='',
            private string $password='',
            private string $fecha='',
            private string $rol='',
        )

        {
            $this->conexion = new BaseDatos();
        }


        public function getId()

        {
            return $this->id;
        }

        public function getNombre() : string

        {
            return $this->nombre;
        }

        public function setNombre($nombre)
        {
            $this->nombre = $nombre;

            return $this;
        }

        public function getApellidos(): string
        {
            return $this->apellidos;
        }


        public function setApellidos($apellidos)
        {
            $this->apellidos = $apellidos;

            return $this;
        }


        public function getEmail(): string
        {
            return $this->email;
        }


        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        public function getFecha(): string
        {
            return $this->fecha;
        }

        public function setFecha(string $fecha): void
        {
            $this->fecha = $fecha;
        }

        public function getRol(): string
        {
            return $this->rol;
        }

        public function setRol(string $rol): void
        {
            $this->rol = $rol;
        }

        public static function fromArray(array $data): Usuario
        {
            return new Usuario(
                $data['id'] ?? '',
                $data['nombre'] ?? '',
                $data['apellidos'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['fecha'] ?? '',
                $data['rol'] ?? ''
            );
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

    }
