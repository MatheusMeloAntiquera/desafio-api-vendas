<?php

namespace App\Http\Controllers;

use App\Domain\Venda\DtoNovaVenda;
use App\Domain\Venda\VendaServiceInterface;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    private VendaServiceInterface $vendaService;

    public function __construct(VendaServiceInterface $vendaService)
    {
        $this->vendaService = $vendaService;
    }
    public function lancarNovaVenda(Request $requisicao)
    {
        $dtoNovaVenda = new DtoNovaVenda();
        $dtoNovaVenda->valor = $requisicao->valor;
        $dtoNovaVenda->vendedorId = $requisicao->vendedor_id;

        $venda = $this->vendaService->lancarNovaVenda($dtoNovaVenda);

        return response()->json([
            "id" => $venda->id,
            "nome" => $venda->vendedor->nome,
            "email" => $venda->vendedor->email,
            "comissao" => $venda->comissao,
            "valor" => $venda->valor,
            "data" => $venda->data,
        ], 201);
    }
}
