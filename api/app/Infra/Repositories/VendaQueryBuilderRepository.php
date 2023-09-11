<?php

namespace App\Infra\Repositories;

use DateTime;
use stdClass;
use App\Domain\Venda\Venda;
use App\Domain\Vendedor\Vendedor;
use Illuminate\Support\Facades\DB;
use App\Domain\Venda\VendaRepositoryInterface;

class VendaQueryBuilderRepository implements VendaRepositoryInterface
{
    private $tabela = "vendas";

    public function gravarNovaVenda(Venda $venda): int
    {
        return DB::table($this->tabela)->insertGetId([
            "comissao" => $venda->comissao,
            "valor" => $venda->valor,
            "vendedor_id" => $venda->vendedor->id,
            "created_at" => $venda->data,
        ]);

    }

    public function buscarVendaPorId(int $id): Venda|null
    {
        $resultado = DB::table($this->tabela)
            ->select($this->tabela . ".*", 'vendedores.id as vendedor_id', 'vendedores.nome', 'vendedores.email')
            ->join('vendedores', 'vendedores.id', '=', $this->tabela . '.vendedor_id')
            ->where($this->tabela . ".id", $id)
            ->first();

        if (empty($resultado)) {
            return null;
        }

        return $this->criarNovaInstanciaVenda($resultado);
    }

    public function buscarVendasPorVendedor($vendedorId)
    {
        $resultado = DB::table($this->tabela)
            ->where('vendedor_id', $vendedorId)
            ->get();

        if (empty($resultado)) {
            return null;
        }

        $retorno = [];
        foreach ($resultado as $dados) {
            $venda = new Venda();
            $venda->id = $dados->id;
            $venda->valor = $dados->valor;
            $venda->comissao = $dados->comissao;
            $venda->data = $dados->created_at;
            $retorno[] = $venda;
        }

        return $retorno;
    }

    public function buscarVendasNoIntervalo(DateTime $dataInicio, DateTime $dataFinal)
    {
        $resultado = DB::table($this->tabela)
            ->select($this->tabela . ".*", 'vendedores.id as vendedor_id', 'vendedores.nome', 'vendedores.email')
            ->join('vendedores', 'vendedores.id', '=', $this->tabela . '.vendedor_id')
            ->where($this->tabela . '.created_at', '>', $dataInicio)->where($this->tabela . '.created_at', '<', $dataFinal)
            ->get();
        $retorno = [];
        foreach ($resultado as $dados) {
            $retorno[] = $this->criarNovaInstanciaVenda($dados);
        }

        return $retorno;
    }

    private function criarNovaInstanciaVenda(stdClass $resultado): Venda
    {
        $vendedor = new Vendedor();
        $vendedor->id = $resultado->vendedor_id;
        $vendedor->nome = $resultado->nome;
        $vendedor->email = $resultado->email;

        $venda = new Venda();
        $venda->id = $resultado->id;
        $venda->valor = $resultado->valor;
        $venda->comissao = $resultado->comissao;
        $venda->data = $resultado->created_at;

        $venda->vendedor = $vendedor;

        return $venda;
    }
}
