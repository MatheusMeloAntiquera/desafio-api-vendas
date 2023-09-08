<?php

namespace App\Domain\Vendedor;

use App\Domain\Vendedor\Vendedor;
use App\Domain\Vendedor\DtoCriarVendedor;

interface VendedorServiceInterface
{
    public function __construct(VendedorRepositoryInterface $vendedorRepository);
    public function criarVendedor(DtoCriarVendedor $dtoCriarVendedor): Vendedor;
}
