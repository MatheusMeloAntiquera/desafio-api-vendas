<?php

namespace App\Domain\Vendedor;

use App\Domain\Venda\Venda;

class Vendedor
{
    public int $id;
    public string $nome;
    public string $email;

    /**
     * @var Venda[]|null
     */
    public $vendas;

    public function comissao(): float
    {
        return array_reduce($this->vendas, fn($total, $venda): float => $total += $venda->comissao, 0);
    }
}
