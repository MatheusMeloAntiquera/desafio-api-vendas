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
}
