<?php

namespace Services;

use Repositories\UsuarioRepository;
use Models\Usuario;

class UsuarioService{

    private UsuarioRepository $repository;

    function __construct()
    {
        $this->repository = new UsuarioRepository();
    }

    public function findAll(): ?array
    {
        return $this->repository->extractAll(); //Conversión en array de Objetos.
    }

    public function save(array $usuarioData): bool {

        try {

            $usuario = Usuario::fromArray($usuarioData);


            return $this->repository->save($usuario);

        } catch (\Exception $e) {

            echo "Error en el servicio al guardar el usuario: " . $e->getMessage();
            return false;

        }
    }

    public function read(int $id){

        return $this->repository->extraer_Usuario($id);

    }

    public function delete(int $id):bool {

        $usu = $this->repository->extraer_Usuario($id);
        return $this->repository->delete($usu, $id);

    }

    public function emailExiste($email): bool {
        return $this->repository->buscarEmail($email) !== null;
    }
    public function filasAfectadas(): int {
            return $this->repository->filasAfectadas();
    }
}