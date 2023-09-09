<?php

namespace App\Http\Controllers;

use App\Domain\Vendedor\DtoCriarVendedor;
use App\Domain\Vendedor\DtoResponseVendas;
use App\Domain\Vendedor\DtoResponseVendedor;
use App\Domain\Vendedor\VendedorServiceInterface;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    private VendedorServiceInterface $vendedorService;
    public function __construct(VendedorServiceInterface $vendedorService)
    {
        $this->vendedorService = $vendedorService;
    }
    public function criarNovoVendedor(Request $requisicao)
    {
        $dtoCriarVendedor = new DtoCriarVendedor();
        $dtoCriarVendedor->nome = $requisicao->nome;
        $dtoCriarVendedor->email = $requisicao->email;

        $vendedor = $this->vendedorService->criarVendedor($dtoCriarVendedor);

        return response()->json((array) $vendedor, 201);
    }

    public function listarTodosVendedores()
    {
        $vendedores = $this->vendedorService->retornarTodosVendedores();

        $retorno = [];
        foreach ($vendedores as $vendedor) {
            $retorno[] = new DtoResponseVendedor(
                $vendedor,
                $this->vendedorService->calculaComissaoVendedor($vendedor)
            );
        }
        return response()->json($retorno, 200);
    }

    public function listarTodasVendas(int $vendedorId)
    {
        $vendedor = $this->vendedorService->buscarVendedorPorId($vendedorId);
        $vendas = $this->vendedorService->retornaTodasAsVendas($vendedor);

        $retorno = [];
        foreach ($vendas as $venda) {
            $retorno[] = new DtoResponseVendas(
                $vendedor,
                $venda
            );
        }
        return response()->json($retorno, 200);
    }
}
