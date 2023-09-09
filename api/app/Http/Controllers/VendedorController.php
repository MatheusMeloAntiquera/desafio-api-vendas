<?php

namespace App\Http\Controllers;

use App\Domain\Vendedor\DtoCriarVendedor;
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

        return response()->json($vendedores, 200);
    }
}
