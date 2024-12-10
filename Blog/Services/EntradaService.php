<?php

namespace Services;

use Repositories\EntradaRepository;
use Models\Entrada;

class EntradaService{

    private EntradaRepository $repository;

    function __construct()
    {
        $this->repository = new EntradaRepository();
    }

    public function findAll(): ?array
    {
        return $this->repository->extractAll(); //Conversión en array de Objetos.
    }

    public function save(array $entradaData): bool {

        try {

            $entrada = Entrada::fromArray($entradaData);


            return $this->repository->save($entrada);

        } catch (\Exception $e) {

            echo "Error en el servicio al guardar la entrada: " . $e->getMessage();
            return false;
        }
    }

    public function read(int $id){
        return $this->repository->extraer_Entrada($id);

    }

    public function delete(int $id) :bool {

        $ent = $this->repository->extraer_Entrada($id);
        return $this->repository->delete($ent, $id);

    }

    public function buscarEntradas(string $buscar): ?array
    {
        return $this->repository->buscarEntradas($buscar);
    }


    public function filasAfectadas(): int {
            return $this->repository->filasAfectadas();
    }
}