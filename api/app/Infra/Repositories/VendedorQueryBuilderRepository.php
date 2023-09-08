<?php

namespace App\Infra\Repositories;

use stdClass;
use App\Domain\Vendedor\Vendedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Concerns\BuildsQueries;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorQueryBuilderRepository implements VendedorRepositoryInterface
{
    private $tabela = "vendedores";

    public function gravarNovoVendedor(Vendedor $vendedor): int
    {
        return DB::table($this->tabela)->insertGetId([
            "nome" => $vendedor->nome,
            "email" => $vendedor->email,
            "created_at" => now(),
        ]);

    }

    public function buscarVendedorPorId(int $id): Vendedor|null
    {
        $resultado = DB::table($this->tabela)->where("id", $id)->first();

        if (empty($resultado)) {
            return null;
        }

        return $this->criarNovaInstanciaVendedor($resultado);
    }

    private function criarNovaInstanciaVendedor(stdClass $resultado): Vendedor
    {
        $vendedor = new Vendedor();
        $vendedor->id = $resultado->id;
        $vendedor->nome = $resultado->nome;
        $vendedor->email = $resultado->email;

        return $vendedor;
    }
}
