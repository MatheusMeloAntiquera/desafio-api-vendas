<?php

namespace App\Domain\Venda;

use DateTime;
use App\Domain\Venda\Venda;
use App\Domain\Venda\DtoNovaVenda;

interface VendaServiceInterface
{
    public function lancarNovaVenda(DtoNovaVenda $dtoNovaVenda): Venda;

    /**
     * @return Venda[]
     */
    public function buscarVendasNoDia(DateTime $data);
}
