<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Domain\Vendedor\Vendedor;
use App\Domain\Venda\DtoNovaVenda;
use Illuminate\Support\Facades\App;
use App\Domain\Venda\VendaServiceInterface;
use App\Domain\Venda\VendaRepositoryInterface;

class VendaServiceTest extends TestCase
{
    private VendaServiceInterface $vendaService;
    /**
     * @test
     * @return void
     */
    public function devera_lancar_uma_nova_venda_com_sucesso(): void
    {
        $mockVendaRepository = $this->partialMock(
            VendaRepositoryInterface::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('gravarNovaVenda')->once()->andReturn(1);
            }
        );

        $vendedor = new Vendedor();
        $vendedor->id = 1;
        $vendedor->nome = "Maria";
        $vendedor->email = "maria@teste.com.br";

        $mockVendedorRepository = $this->partialMock(
            VendaRepositoryInterface::class,
            function (MockInterface $mock) use ($vendedor) {
                $mock->shouldReceive('buscarVendedorPorId')->once()->andReturn($vendedor);
            }
        );

        /**
         * @var \Mockery\MockInterface $mockVendedorService
         */
        $mockVendaService = Mockery::mock(VendaService::class, [$mockVendaRepository, $mockVendedorRepository]);

        $this->instance(
            VendaServiceInterface::class,
            $mockVendaService->makePartial()
        );

        $this->vendaService = App::make(VendaServiceInterface::class);

        $dtoNovaVenda = new DtoNovaVenda();
        $dtoNovaVenda->vendedorId = 1;
        $dtoNovaVenda->valor = 100.0;

        $venda = $this->vendaService->lancarNovaVenda($dtoNovaVenda);
        $this->assertEquals($venda->id, 1);
        $this->assertEquals($venda->vendedor->nome, $vendedor->nome);
        $this->assertEquals($venda->vendedor->email, $vendedor->email);
        $this->assertEquals($venda->comissao, 8.5);
        $this->assertEquals($venda->valor, 100);
        $this->assertNotEmpty($venda->data);
    }
}
