<?php

namespace App\Domain\Vendedor;

use App\Domain\Vendedor\Vendedor;

interface VendedorRepositoryInterface
{
    public function gravarNovoVendedor(Vendedor $vendedor): int;
}
