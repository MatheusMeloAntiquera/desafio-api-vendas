<?php

namespace Tests\Unit;

use Mockery;
use DateTime;
use Tests\TestCase;
use Mockery\MockInterface;
use App\UseCases\VendaService;
use App\Domain\Vendedor\Vendedor;
use App\Domain\Venda\DtoNovaVenda;
use Illuminate\Support\Facades\App;
use App\Domain\Venda\VendaServiceInterface;
use App\Domain\Venda\VendaRepositoryInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;

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
                $mock->shouldReceive('gravarNovaVenda')->once()->andReturn(10);
            }
        );

        $vendedor = new Vendedor();
        $vendedor->id = 1;
        $vendedor->nome = "Maria";
        $vendedor->email = "maria@teste.com.br";

        $mockVendedorRepository = $this->partialMock(
            VendedorRepositoryInterface::class,
            function (MockInterface $mock) use ($vendedor) {
                $mock->shouldReceive('buscarVendedorPorId')->once()->andReturn($vendedor);
            }
        );

        /**
         * @var \Mockery\MockInterface $mockVendaService
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

        $this->assertEquals($venda->id, 10);
        $this->assertEquals($venda->vendedor->nome, $vendedor->nome);
        $this->assertEquals($venda->vendedor->email, $vendedor->email);
        $this->assertEquals($venda->comissao, 8.5);
        $this->assertEquals($venda->valor, 100.0);
        $this->assertNotEmpty($venda->data);
        $this->assertInstanceOf(DateTime::class, DateTime::createFromFormat('Y-m-d H:i:s', $venda->data));
    }
}
