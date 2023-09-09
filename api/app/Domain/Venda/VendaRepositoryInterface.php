<?php

namespace App\Domain\Venda;

use App\Domain\Venda\Venda;

interface VendaRepositoryInterface
{
    public function gravarNovaVenda(Venda $venda): int;

    public function buscarVendaPorId(int $id): Venda|null;

    /**
     *
     * @param integer $vendedorId
     * @return Venda[]|null
     */
    public function buscarVendasPorVendedor(int $vendedorId);
}
