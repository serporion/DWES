<?php 
    namespace Controllers;

    use Lib\Pages;
    use Lib\Utilidades;
    use Services\EntradaService;
    use Services\CategoriaService;

    class EntradaController{

        private EntradaService $servicio;
        private Pages $pages;

        function __construct() {
            $this->pages = new Pages();
            $this->servicio = new EntradaService();

        }

        //Extrae todos los registros para ser mostrados en una vista tras su conversión en array de objetos.
        public function extraer_todos(){

            $todas_las_entradas = $this->servicio->findAll();
            $this->pages->render('Entrada/mostrar_todos', ['todas_las_entradas'=>$todas_las_entradas]);
        }

        //Edita el registro correspondiente al id recogido, enviándolo a un formulario para ser modificado y grabado posteriormente.
        public function editarEntrada(): void {

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }

            $mi_entrada = $this->servicio->read($id);

            if (!$mi_entrada) {
                echo "Entrada no encontrado.";
                return;
            }

            $this->pages->render('Entrada/modificarEntrada', ['mi_entrada'=>$mi_entrada]);

        }

        //Borra el registro correspondiente al id recogido.
        public function borrarEntrada()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }

            $mi_entrada = $this->servicio->delete($id);


            if ($mi_entrada) {

                $_SESSION['correcto'] = 'Se ha borrado la entrada correctamente.';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;

            } else {

                $_SESSION['error'] = 'Error en el borrado de la entrada';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            }

        }

        //Consulta las categorias y las envía a la vista del formulario de registro de entradas poder selecciona la
        //correspondiente a la entrada.
        public function registroEntradas(): void
        {
            $categoriaService = new CategoriaService();
            $categorias = $categoriaService->todasLasCategorias();
            $this->pages->render('Entrada/registroForm', ['categorias' => $categorias]);
        }

        //Guarda el registro correspondiente después del filtrado y validaciones. Es transformado en objeto.
        public function guardarEntrada(): void {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $errores = [];

            $id = $_POST['id'] ?? null;
            $usuario_id = $_SESSION['usuario']['id'] ?? '';
            $categoria_id = $_POST['categoria_id'] ?? '';


            //Validacioens

            $resultadoTitulo = Utilidades::validarTitulo($_POST['titulo'] ?? '');
            if ($resultadoTitulo['error']) {

                $errores['titulo'] = $resultadoTitulo['error'];
            } else {
                $titulo = $resultadoTitulo['valor'];
            }

            $resultadoDescripcion = Utilidades::validarDescripcion($_POST['descripcion'] ?? '');
            if ($resultadoDescripcion['error']) {

                $errores['descripcion'] = $resultadoDescripcion['error'];
            } else {
                $descripcion = $resultadoDescripcion['valor'];
            }


            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                $_SESSION['valores'] = $_POST; // Almacena todos los valores del POST. Sirve de auxiliar.
                header("Location: " . BASE_URL . "Entrada/registroEntradas");
                exit;
            }

            $entradaData = [
                'id' => $id,
                'usuario_id' => $usuario_id,
                'categoria_id' => $categoria_id,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
            ];

            $resultado = $this->servicio->save($entradaData);

            if ($resultado) {
                $_SESSION['correcto'] = 'Se ha grabado la entrada correctamente.';

                header("Location: " . BASE_URL . "Dashboard/index");
                exit;

            } else {
                $_SESSION['error'] = 'Error en la grabación de la entrada';

                header("Location: " . BASE_URL . "Dashboard/index");
                exit;
            }
        }

        //Busca las entradas según el criterio establecido en el input en el header del furmulario para la búsqueda.
        public function buscarEntradas(): void
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $buscar = $_GET['buscar'] ?? '';

            $todas_las_entradas = $this->servicio->buscarEntradas($buscar);

            $this->pages->render('Entrada/mostrar_todos', ['todas_las_entradas' => $todas_las_entradas]);
        }

    }
