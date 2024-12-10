<?php
    namespace Lib;
    use PDO;
    use PDOException;

    class BaseDatos{
        private PDO $conexion;
        private mixed $resultado;

        public function __construct(
            private $tipo_de_base = 'mysql',
            private string $servidor = SERVERNAME,  
            private string $usuario = USERNAME,
            private string $pass = PASSWORD,
            private string $base_datos = DATABASE) {
                $this->conexion = $this->conectar();
            }

        //Función que conecta con la base de datos.
        private function conectar(): PDO
        {
            try {
                $opciones = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                );

                $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
                return $conexion;
            } catch (PDOException $e) {
                echo "Ha surgido un error y no se puede conectar a la base de datos. Detalle: " . $e->getMessage();
                exit;
            }
        }

        //Función reducida de PDO para hacer una búsqueda en los campos $param titulo y $param descripción el valor
        //$value de lo ingresado en el input.
        public function bind($param, $value, $type = PDO::PARAM_STR) {
            $this->stmt->bindValue($param, $value, $type);
        }
        public function getConexion(): PDO {
            return $this->conexion;
        }

        //Función que realiza una consulta según el envío de
        public function consulta(string $consultaSQL): void {
            try {
                $this->resultado = $this->conexion->query($consultaSQL);
            } catch (PDOException $e) {
                echo "Error en la consulta SQL: " . $e->getMessage();
                $this->resultado = null;
            }
        }


        public function extraer_registro(): mixed {
                return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC))? $fila:false;
        }

        public function extraer_todos(): array{
                return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
        }


    }
