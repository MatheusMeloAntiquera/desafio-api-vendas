<?php

namespace App\Domain\Venda;

class DtoNovaVenda
{
    public int $vendedorId;
    public float $valor;

    public static function novoDtoPorArray(array $dados): DtoNovaVenda
    {
        $dto = new self();
        $dto->valor = $dados['valor'];
        $dto->vendedorId = $dados['vendedor_id'];

        return $dto;
    }
}
