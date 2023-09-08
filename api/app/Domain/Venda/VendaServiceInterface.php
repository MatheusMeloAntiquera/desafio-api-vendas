<?php

namespace App\Domain\Venda;

interface VendaServiceInterface
{
    public function lancarNovaVenda(DtoNovaVenda $venda): Venda;
}
