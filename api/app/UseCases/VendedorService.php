<?php

namespace App\UseCases;

use App\Domain\Vendedor\Vendedor;
use App\Domain\Vendedor\DtoCriarVendedor;
use App\Domain\Vendedor\VendedorRepositoryInterface;
use App\Domain\Vendedor\VendedorServiceInterface;

class VendedorService implements VendedorServiceInterface
{
    private VendedorRepositoryInterface $vendedorRepository;

    public function __construct(VendedorRepositoryInterface $vendedorRepository)
    {
        $this->vendedorRepository = $vendedorRepository;
    }
    public function criarVendedor(DtoCriarVendedor $dtoCriarVendedor): Vendedor
    {
        $vendedor = new Vendedor();
        $vendedor->nome = $dtoCriarVendedor->nome;
        $vendedor->email = $dtoCriarVendedor->email;

        $vendedor->id = $this->vendedorRepository->gravarNovoVendedor($vendedor);

        return $vendedor;
    }
}
