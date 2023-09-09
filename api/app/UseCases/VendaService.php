<?php

namespace App\UseCases;

use App\Domain\Venda\Venda;
use App\Domain\Venda\DtoNovaVenda;
use App\Domain\Venda\VendaServiceInterface;
use App\Domain\Venda\VendaRepositoryInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendaService implements VendaServiceInterface
{
    private VendedorRepositoryInterface $vendedorRepository;
    private VendaRepositoryInterface $vendaRepository;
    public function __construct(VendaRepositoryInterface $vendaRepository, VendedorRepositoryInterface $vendedorRepository)
    {
        $this->vendedorRepository = $vendedorRepository;
        $this->vendaRepository = $vendaRepository;
    }
    public function lancarNovaVenda(DtoNovaVenda $dtoNovaVenda): Venda
    {
        $venda = new Venda();
        $venda->valor = $dtoNovaVenda->valor;
        $venda->comissao = $dtoNovaVenda->valor * 0.085;
        $venda->vendedor = $this->vendedorRepository->buscarVendedorPorId($dtoNovaVenda->vendedorId);
        $venda->data = now();

        $venda->id = $this->vendaRepository->gravarNovaVenda($venda);
        return $venda;
    }
}
