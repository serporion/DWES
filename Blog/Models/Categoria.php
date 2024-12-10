<?php

namespace Models;
use Lib\BaseDatos;

    class Categoria{
        private BaseDatos $conexion;
        private mixed $stmt;

        function __construct(
            private string | null $id = null,
            private string $nombre='',

        )
        {
            $this->conexion = new BaseDatos();
        }

        public function getId()
        {
            return $this->id;
        }

        public function getNombre()
        {
            return $this->nombre;
        }

        public static function fromArray(array $data): Categoria
        {
            return new Categoria(
                $data['id'] ?? '',
                $data['nombre'] ?? ''
            );
        }

    }
