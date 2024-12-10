<?php

namespace Services;

use Repositories\CategoriaRepository;
use Models\Categoria;

class CategoriaService{

    private CategoriaRepository $repository;

    function __construct()
    {
        $this->repository = new CategoriaRepository();
    }

    public function todasLasCategorias(): ?array
    {
        return $this->repository->findAll();
    }

    public function findAll(): ?array
    {
        return $this->repository->extractAll(); //Conversión en array de Objetos.
    }

    public function save(array $categoriaData): bool {

        try {

            $categoria = Categoria::fromArray($categoriaData);


            return $this->repository->save($categoria);

        } catch (\Exception $e) {

            echo "Error en el servicio al guardar la categoria: " . $e->getMessage();
            return false;
        }
    }

    public function read(int $id){
        return $this->repository->extraer_Categoria($id);

    }

    public function delete(int $id):bool{

        $cat = $this->repository->extraer_Categoria($id);
        return $this->repository->delete($cat, $id);

    }

    public function filasAfectadas(): int {
            return $this->repository->filasAfectadas();
    }
}