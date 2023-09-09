<?php

namespace Tests\Unit;

use App\Domain\Venda\Venda;
use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Domain\Vendedor\Vendedor;
use App\UseCases\VendedorService;
use Illuminate\Support\Facades\App;
use App\Domain\Vendedor\DtoCriarVendedor;
use App\Domain\Venda\VendaRepositoryInterface;
use App\Domain\Vendedor\VendedorServiceInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorServiceTest extends TestCase
{
    private VendedorServiceInterface $vendedorService;
    protected function setUp(): void
    {
        $this->createApplication();
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function deveraCriarUmVendedorComSucesso(): void
    {
        $mockVendedorRepository = $this->partialMock(
            VendedorRepositoryInterface::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('gravarNovoVendedor')->once()->andReturn(1);
            }
        );

        /**
         * @var \Mockery\MockInterface $mockVendedorService
         */
        $mockVendedorService = Mockery::mock(VendedorService::class, [$mockVendedorRepository, Mockery::mock(VendaRepositoryInterface::class)]);

        $this->instance(
            VendedorServiceInterface::class,
            $mockVendedorService->makePartial()
        );

        $this->vendedorService = App::make(VendedorServiceInterface::class);

        $dtoCriarVendedor = new DtoCriarVendedor();
        $dtoCriarVendedor->nome = "João";
        $dtoCriarVendedor->email = "joao@teste.com.br";

        $vendedor = $this->vendedorService->criarVendedor($dtoCriarVendedor);
        $this->assertEquals($vendedor->id, 1);
        $this->assertEquals($vendedor->nome, $dtoCriarVendedor->nome);
        $this->assertEquals($vendedor->email, $dtoCriarVendedor->email);
    }

    /**
     * @test
     * @return void
     */
    public function deveraRetornarTodosOsVendedores(): void
    {
        $vendedor1 = new Vendedor();
        $vendedor1->id = 1;
        $vendedor1->nome = "João";
        $vendedor1->email = "joao@teste.com.br";

        $vendedor2 = new Vendedor();
        $vendedor2->id = 2;
        $vendedor2->nome = "Paulo";
        $vendedor2->email = "paulo@teste.com";

        $mockVendedorRepository = $this->partialMock(
            VendedorRepositoryInterface::class,
            function (MockInterface $mock) use ($vendedor1, $vendedor2) {
                $mock->shouldReceive('retornarTodosVendedores')->once()->andReturn([$vendedor1, $vendedor2]);
            }
        );

        $mockVendaRepository = $this->partialMock(
            VendaRepositoryInterface::class,
            function (MockInterface $mock) use ($vendedor1, $vendedor2) {
                $venda1 = new Venda();
                $venda1->comissao = 8.5;
                $venda1->valor = 100;
                $venda1->data = "2023-09-09 09:00:00";
                $venda1->id = 1;

                $venda2 = new Venda();
                $venda2->comissao = 85;
                $venda2->valor = 1000;
                $venda2->data = "2023-09-09 15:45:00";
                $venda2->id = 2;

                $mock->shouldReceive('buscarVendasPorVendedor')->once()->withArgs([$vendedor1->id])->andReturn([$venda1, $venda2]);
                $mock->shouldReceive('buscarVendasPorVendedor')->once()->withArgs([$vendedor2->id])->andReturn([]);
            }
        );

        /**
         * @var \Mockery\MockInterface $mockVendedorService
         */
        $mockVendedorService = Mockery::mock(VendedorService::class, [$mockVendedorRepository, $mockVendaRepository]);

        $this->instance(
            VendedorServiceInterface::class,
            $mockVendedorService->makePartial()
        );

        /**
         * @var VendedorServiceInterface $vendedorService
         */
        $this->vendedorService = App::make(VendedorServiceInterface::class);

        $vendedores = $this->vendedorService->retornarTodosVendedores();
        $this->assertCount(2, $vendedores);
        $this->assertCount(2, $vendedores[0]->vendas);
        $this->assertCount(0, $vendedores[1]->vendas);
    }

    /**
     * @test
     * @return void
     */
    public function deveraCalcularAComissaoCorretaDoVendedor(): void
    {
        $this->vendedorService = App::make(VendedorServiceInterface::class);

        $vendedor1 = new Vendedor();
        $vendedor1->nome = "João";
        $vendedor1->email = "joao@teste.com.br";

        $vendedor2 = new Vendedor();
        $vendedor2->nome = "Paulo";
        $vendedor2->email = "paulo@teste.com";

        $venda1 = new Venda();
        $venda1->comissao = 8.5;
        $venda1->valor = 100;
        $venda1->data = "2023-09-09 09:00:00";
        $venda1->id = 1;

        $venda2 = new Venda();
        $venda2->comissao = 85;
        $venda2->valor = 1000;
        $venda2->data = "2023-09-09 15:45:00";
        $venda2->id = 2;

        $vendedor1->vendas = [$venda1, $venda2];

        $comissaoVendedor1 = $this->vendedorService->calculaComissaoVendedor($vendedor1);
        $comissaoVendedor2 = $this->vendedorService->calculaComissaoVendedor($vendedor2);

        $this->assertEquals(93.5, $comissaoVendedor1);
        $this->assertEquals(0, $comissaoVendedor2);
    }

}
