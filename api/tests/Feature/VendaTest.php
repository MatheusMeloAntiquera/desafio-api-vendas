<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Vendedor\Vendedor;
use Illuminate\Support\Facades\App;
use App\Domain\Venda\VendaRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendaTest extends TestCase
{
    use RefreshDatabase;
    private VendedorRepositoryInterface $vendedorRepository;
    private VendaRepositoryInterface $vendaRepository;
    protected function setUp(): void
    {
        $this->createApplication();
        $this->vendedorRepository = App::make(VendedorRepositoryInterface::class);
        $this->vendaRepository = App::make(VendaRepositoryInterface::class);

        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function deveraRegistrarUmaVendaComSucessoViaApi(): void
    {
        $vendedor = new Vendedor();
        $vendedor->nome = "Maria";
        $vendedor->email = "maria@teste.com.br";

        $vendedor->id = $this->vendedorRepository->gravarNovoVendedor($vendedor);

        $response = $this->post('/api/venda', [
            "vendedor_id" => $vendedor->id,
            "valor" => 250.00
        ]);

        $vendaRegistrada = $this->vendaRepository->buscarVendaPorId($response['id']);

        $response->assertStatus(201);
        $this->assertEquals($vendaRegistrada->id, $response['id']);
        $this->assertEquals($vendaRegistrada->vendedor->nome, $response['nome']);
        $this->assertEquals($vendaRegistrada->vendedor->email, $response['email']);
        $this->assertEquals($vendaRegistrada->comissao, $response['comissao']);
        $this->assertEquals($response['comissao'], 21.25);
        $this->assertEquals($vendaRegistrada->valor, $response['valor']);
        $this->assertEquals($vendaRegistrada->data, $response['data']);
    }
}
