<?php

namespace App\Infra;

use App\Domain\Vendedor\Vendedor;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorQueryBuilderRepository implements VendedorRepositoryInterface
{
    public function gravarNovoVendedor(Vendedor $vendedor): int
    {
        return 2;
    }
}
