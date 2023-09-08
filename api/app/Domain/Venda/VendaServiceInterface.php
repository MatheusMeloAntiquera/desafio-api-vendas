<?php

namespace App\Domain\Venda;

use App\Domain\Venda\Venda;
use App\Domain\Venda\DtoNovaVenda;

interface VendaServiceInterface
{
    public function lancarNovaVenda(DtoNovaVenda $venda): Venda;
}
