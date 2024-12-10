<?php 
    namespace Controllers;

    use Lib\Pages;
    use Lib\Utilidades;
    use Services\CategoriaService;

    class CategoriaController{

        private CategoriaService $servicio;
        private Pages $pages;

        function __construct() {
            $this->pages = new Pages();
            $this->servicio = new CategoriaService();

        }

        //Extrae todos los registros para ser mostrados en una vista trás su conversión en array de objetos.
        public function extraer_todos(){

            $todas_las_categorias = $this->servicio->findAll();
            $this->pages->render('Categoria/mostrar_todos', ['todas_las_categorias'=>$todas_las_categorias]);
        }

        //Llama al formulario de registro.
        public function registroCategorias(): void
        {
            $this->pages->render('Categoria/registroForm');
        }


        //Edita el registro correspondiente al id recogido, enviándolo a un formulario para ser modificado y grabado posteriormente.
        public function editarCategoria(): void {

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }

            $mi_categoria = $this->servicio->read($id);
            if (!$mi_categoria) {
                echo "Categoria no encontrada.";
                return;
            }

            $this->pages->render('Categoria/modificarCategoria', ['mi_categoria'=>$mi_categoria]);
        }

        //Borra el registro correspondiente al id recogido.
        public function borrarCategoria()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }

            $mi_categoria = $this->servicio->delete($id);
            if ($mi_categoria) {
                $_SESSION['correcto'] = 'Se ha borrado la categoria correctamente.';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;

            } else {
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            }
        }

        //Guarda el registro correspondiente después del filtrado y validaciones. Es transformado en objeto.
        public function guardarCategoria(): void {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $errores = [];

            $resultadoNombre = Utilidades::validarNombre($_POST['nombre'] ?? '');

            if ($resultadoNombre['error']) {
                $errores['nombre'] = $resultadoNombre['error'];
            } else {
                $nombre = ucfirst(strtolower($resultadoNombre['valor']));
            }

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                $_SESSION['valores'] = $_POST; // Almacena todos los valores del POST. Sirve de auxiliar.
                header("Location: " . BASE_URL . "Categoria/registroCategorias");
                exit;
            }

            $categoriaData = [
                'id' => $id ?? null,
                'nombre' => $nombre,
            ];

            $resultado = $this->servicio->save($categoriaData);

            if ($resultado) {
                $_SESSION['correcto'] = 'Se ha grabado la categoria correctamente.';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            } else {
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            }
        }
    }
