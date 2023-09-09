<?php

namespace App\Domain\Vendedor;

class DtoResponseVendedor
{
    public int $id;
    public string $nome;
    public string $email;
    public float $comissao;

    public function __construct(Vendedor $vendedor, float $comissao)
    {
        $this->id = $vendedor->id;
        $this->nome = $vendedor->nome;
        $this->email = $vendedor->email;
        $this->comissao = $comissao;
    }
}
