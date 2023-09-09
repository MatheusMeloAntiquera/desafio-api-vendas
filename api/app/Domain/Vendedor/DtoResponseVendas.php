<?php

namespace App\Domain\Vendedor;

use App\Domain\Venda\Venda;

class DtoResponseVendas
{
    public int $id;
    public string $nome;
    public string $email;
    public float $comissao;
    public float $valor;
    public string $data;

    public function __construct(Vendedor $vendedor, Venda $venda)
    {
        $this->id = $venda->id;
        $this->nome = $vendedor->nome;
        $this->email = $vendedor->email;
        $this->comissao = $venda->comissao;
        $this->valor = $venda->valor;
        $this->data = $venda->data;
    }
}
