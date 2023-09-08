<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use App\UseCases\VendedorService;
use Illuminate\Support\Facades\App;
use App\Domain\Vendedor\DtoCriarVendedor;
use App\Domain\Vendedor\VendedorServiceInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->createApplication();
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function devera_criar_um_vendedor_com_sucesso(): void
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
        $mockVendedorService = Mockery::mock(VendedorService::class, [$mockVendedorRepository]);

        $this->instance(
            VendedorServiceInterface::class,
            $mockVendedorService->makePartial()
        );

        $vendedorService = App::make(VendedorServiceInterface::class);

        $dtoCriarVendedor = new DtoCriarVendedor();
        $dtoCriarVendedor->nome = "João";
        $dtoCriarVendedor->email = "joao@teste.com.br";

        $vendedor = $vendedorService->criarVendedor($dtoCriarVendedor);
        $this->assertEquals($vendedor->id, 1);
        $this->assertEquals($vendedor->nome, $dtoCriarVendedor->nome);
        $this->assertEquals($vendedor->email, $dtoCriarVendedor->email);
    }
}
