<?php

namespace Tests\Unit;

use Tests\TestCase;

class VendedorTest extends TestCase
{
    protected function setUp(): void
    {
        $this->createApplication();
        $this->vendedorService = App::make(VendedorServiceInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function devera_criar_um_vendedor_com_sucesso(): void
    {
        $dtoCriarVendedor = new DtoCriarVendedor();
        $dtoCriarVendedor->nome = "João";
        $dtoCriarVendedor->email = "joao@teste.com.br";

        $vendedor = $this->vendedorService->criarVendedor($dtoCriarVendedor);
        $this->assertNotEmpty($vendedor->id);
        $this->assertEquals($vendedor->nome, $dtoCriarVendedor->nome);
        $this->assertEquals($vendedor->email, $dtoCriarVendedor->email);
    }
}
