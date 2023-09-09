<?php

namespace App\UseCases;

use App\Domain\Vendedor\DtoResponseVendedor;
use App\Domain\Vendedor\Vendedor;
use App\Domain\Vendedor\DtoCriarVendedor;
use App\Domain\Venda\VendaRepositoryInterface;
use App\Domain\Vendedor\VendedorServiceInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorService implements VendedorServiceInterface
{
    private VendedorRepositoryInterface $vendedorRepository;
    private VendaRepositoryInterface $vendaRepository;

    public function __construct(VendedorRepositoryInterface $vendedorRepository, VendaRepositoryInterface $vendaRepository)
    {
        $this->vendedorRepository = $vendedorRepository;
        $this->vendaRepository = $vendaRepository;
    }
    public function criarVendedor(DtoCriarVendedor $dtoCriarVendedor): Vendedor
    {
        $vendedor = new Vendedor();
        $vendedor->nome = $dtoCriarVendedor->nome;
        $vendedor->email = $dtoCriarVendedor->email;

        $vendedor->id = $this->vendedorRepository->gravarNovoVendedor($vendedor);

        return $vendedor;
    }

    public function retornarTodosVendedores(): array
    {
        $vendedores = $this->vendedorRepository->retornarTodosVendedores();

        if (empty($vendedores)) {
            return [];
        }

        $retorno = [];
        foreach ($vendedores as $vendedor) {
            $vendedor->vendas = $this->vendaRepository->buscarVendasPorVendedor($vendedor->id);
            $retorno[] = new DtoResponseVendedor($vendedor);
        }

        return $retorno;
    }
}
