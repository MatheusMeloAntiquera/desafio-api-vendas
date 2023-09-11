<?php

namespace App\Domain\Venda;

use App\Domain\Vendedor\Vendedor;

class Venda
{
    public int $id;
    public float $comissao;
    public float $valor;
    public string $data;
    public Vendedor $vendedor;
}
