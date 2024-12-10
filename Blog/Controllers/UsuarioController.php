<?php 
    namespace Controllers;

    use Lib\Pages;
    use Lib\Utilidades;
    use Services\UsuarioService;

    class UsuarioController{

        private UsuarioService $servicio;
        private Pages $pages;

        function __construct() {
            $this->pages = new Pages();
            $this->servicio = new UsuarioService();

        }

        //Extrae todos los registros para ser mostrados en una vista tras su conversión en array de objetos.
        public function extraer_todos(){

            $todos_los_usuarios = $this->servicio->findAll();
            $this->pages->render('Usuario/mostrar_todos', ['todos_los_usuarios'=>$todos_los_usuarios]);
        }


        //Llama al formulario de registro.
        public function registroUsuarios(): void
        {
            $this->pages->render('Usuario/registroForm');
        }


        //Edita el registro correspondiente al id recogido, enviándolo a un formulario para ser modificado y grabado posteriormente.
        public function editarUsuario(): void {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }else {
                $_SESSION['idusu'] = $id;
            }

            $mi_usuario = $this->servicio->read($id);

            if (!$mi_usuario) {
                echo "Usuario no encontrado.";
                return;
            }

            //Envío los datos del usuario al formulario.
            $this->pages->render('Usuario/modificarUsuario', ['mi_usuario'=>$mi_usuario]);

        }

        //Borra el registro correspondiente al id recogido.
        public function borrarUsuario()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $id = $_GET['id'] ?? null;

            if ($id === null) {
                echo "ID no válido.";
                return;
            }

            $mi_usuario = $this->servicio->delete($id);

            if ($mi_usuario) {
                $_SESSION['correcto'] = 'Se ha borrado el usuario correctamente.';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;

            } else {
                //$_SESSION['error'] = 'Error en el borrado del usuario'; //Se recoge en otro lugar. Puedo hacer uso de throw $e;
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            }
        }

        //Función que guarda el registro correspondiente después del filtrado y validaciones. Es transformado en objeto.
        public function guardarUsuario(): void {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['idusu']))
            {
                $id = $_SESSION['idusu'];
            }

            $errores = [];
            //$esModificacion = isset($_POST['id']) && !empty($_POST['id']); //Errores a doquier
            $esModificacion = isset($_SESSION['usuario']['id']); //Necesito booleana para ver si es modificacion o no.


            //Validacioens

            $resultadoNombre = Utilidades::validarNombre($_POST['nombre'] ?? '');
            if ($resultadoNombre['error']) {

                $errores['nombre'] = $resultadoNombre['error'];
            } else {
                $nombre = $resultadoNombre['valor'];
            }

            $resultadoApellidos = Utilidades::validarApellidos($_POST['apellidos'] ?? '');
            if ($resultadoApellidos['error']) {

                $errores['apellidos'] = $resultadoApellidos['error'];

            } else {
                $apellidos = $resultadoApellidos['valor'];
            }


            $resultadoEmail = Utilidades::validarEmail($_POST['email'] ?? '');
            if ($resultadoEmail['error']) {
                $errores['email'] = $resultadoEmail['error'];

            } else {
                $email = $resultadoEmail['valor'];
                if ($esModificacion) {
                    $emailOriginal = $_SESSION['usuario']['correo'];
                    if ($email !== $emailOriginal && $this->servicio->emailExiste($email) && $_SESSION['usuario']['rol'] != 7) {
                        $errores['email'] = "Este correo electrónico ya está en uso por otro usuario";
                    }

                    if ($email !== $emailOriginal && $this->servicio->emailExiste($email) && $_SESSION['usuario']['rol'] != 7) {
                        $errores['email'] = "Este correo electrónico ya está en uso por otro usuario";
                    }
                } else {
                    if ($this->servicio->emailExiste($email)) {
                        $errores['email'] = "Este correo electrónico ya está registrado";
                    }
                }
            }


            $resultadoFechaNacimiento = Utilidades::validarFechaNacimiento($_POST['fecha'] ?? '');
            if ($resultadoFechaNacimiento['error']) {

                $errores['fecha'] = $resultadoFechaNacimiento['error'];

            } else {
                $fechaNacimiento = $resultadoFechaNacimiento['valor'];
            }


            $resultadoPassword = Utilidades::validarPassword($_POST['password'] ?? '');
            if ($resultadoPassword['error']) {

                $errores['password'] = $resultadoPassword['error'];
            } else {

                $passwordSegura = password_hash($resultadoPassword['valor'], PASSWORD_BCRYPT);
            }


            $resultadoPasswordRepetida = Utilidades::validarPasswordRepetida($_POST['password'] ?? '', $_POST['passwordrepetida'] ?? '');
            if ($resultadoPasswordRepetida['error']) {

                $errores['passwordrepetida'] = $resultadoPasswordRepetida['error'];
            }


            //Grabar los errores

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                $_SESSION['valores'] = $_POST; // Almacena todos los valores del POST. Sirve de auxiliar.
                header("Location: " . BASE_URL . "Usuario/registroUsuarios");
                exit;
            }

            $usuarioData = [
                'id' => $id ?? null,
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'email' => $email,
                'password' => $passwordSegura,
                'fecha' => $fechaNacimiento,

            ];


            $resultado = $this->servicio->save($usuarioData);

            if ($resultado) {

                $_SESSION['correcto'] = 'Se ha grabado el usuario.';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            } else {

                $_SESSION['error'] = 'Error en la grabación del usuario';
                header("Location: " . BASE_URL . "Dashboard/index");

                exit;
            }
        }

    }
