<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Vendedor\VendedorRepositoryInterface;

class VendedorTest extends TestCase
{
    use RefreshDatabase;
    private VendedorRepositoryInterface $vendedorRepository;
    protected function setUp(): void
    {
        $this->createApplication();
        $this->vendedorRepository = App::make(VendedorRepositoryInterface::class);
        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function deveraCriarUmVendedorComSucessoViaApi(): void
    {
        $response = $this->post('/api/vendedor', [
            "nome" => "João",
            "email" => "joao@teste.com.br"
        ]);

        $vendedorGravado = $this->vendedorRepository->buscarVendedorPorId($response['id']);

        $response->assertStatus(201);
        $this->assertEquals($vendedorGravado->id, $response['id']);
        $this->assertEquals($vendedorGravado->nome, $response['nome']);
        $this->assertEquals($vendedorGravado->email, $response['email']);
    }
}
