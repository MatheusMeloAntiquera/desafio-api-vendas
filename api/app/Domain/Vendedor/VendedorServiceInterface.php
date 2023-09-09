<?php

namespace App\Domain\Vendedor;

use App\Domain\Vendedor\Vendedor;
use App\Domain\Vendedor\DtoCriarVendedor;

interface VendedorServiceInterface
{
    public function criarVendedor(DtoCriarVendedor $dtoCriarVendedor): Vendedor;

    /**
     * @return Vendedor[]|null
     */
    public function retornarTodosVendedores();
}
