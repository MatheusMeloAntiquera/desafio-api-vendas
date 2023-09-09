<?php

namespace Tests\Feature;

use App\Domain\Venda\DtoNovaVenda;
use Tests\TestCase;
use App\Domain\Vendedor\Vendedor;
use Illuminate\Support\Facades\App;
use App\Domain\Venda\VendaServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorTest extends TestCase
{
    use RefreshDatabase;
    private VendedorRepositoryInterface $vendedorRepository;
    private VendaServiceInterface $vendaService;
    protected function setUp(): void
    {
        $this->createApplication();
        $this->vendedorRepository = App::make(VendedorRepositoryInterface::class);
        $this->vendaService = App::make(VendaServiceInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function deveraCriarUmVendedorComSucessoViaApi(): void
    {
        $response = $this->postJson('/api/vendedor', [
            "nome" => "João",
            "email" => "joao@teste.com.br"
        ]);

        $vendedorGravado = $this->vendedorRepository->buscarVendedorPorId($response['id']);

        $response->assertStatus(201);
        $this->assertEquals($vendedorGravado->id, $response['id']);
        $this->assertEquals($vendedorGravado->nome, $response['nome']);
        $this->assertEquals($vendedorGravado->email, $response['email']);
    }

    /**
     * @test
     * @return void
     */
    public function deveraRetornarTodosVendedoresViaApi()
    {
        $vendedor1 = new Vendedor();
        $vendedor1->nome = "João";
        $vendedor1->email = "joao@teste.com.br";
        $vendedor1->id = $this->vendedorRepository->gravarNovoVendedor($vendedor1);

        $vendedor2 = new Vendedor();
        $vendedor2->nome = "Maria";
        $vendedor2->email = "maria@teste.com.br";
        $vendedor2->id = $this->vendedorRepository->gravarNovoVendedor($vendedor2);

        $vendedor3 = new Vendedor();
        $vendedor3->nome = "José";
        $vendedor3->email = "jose@teste.com.br";
        $vendedor3->id = $this->vendedorRepository->gravarNovoVendedor($vendedor3);


        $this->vendaService->lancarNovaVenda(DtoNovaVenda::novoDtoPorArray(["valor" => 100.00, "vendedor_id" => $vendedor1->id]));
        $this->vendaService->lancarNovaVenda(DtoNovaVenda::novoDtoPorArray(["valor" => 100.00, "vendedor_id" => $vendedor1->id]));

        $this->vendaService->lancarNovaVenda(DtoNovaVenda::novoDtoPorArray(["valor" => 100.00, "vendedor_id" => $vendedor3->id]));
        $this->vendaService->lancarNovaVenda(DtoNovaVenda::novoDtoPorArray(["valor" => 1000.00, "vendedor_id" => $vendedor3->id]));

        $response = $this->getJson('/api/vendedor');

        $response->assertStatus(200);
        $this->assertCount(3, (array) $response);
        $this->assertEquals(17, $response[0]['comissao']);
        $this->assertEquals(0, $response[1]['comissao']);
        $this->assertEquals(93.5, $response[2]['comissao']);
    }
}
