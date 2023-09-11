<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\RelatorioDiarioVendas;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvioRelatorioTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     * @return void
     */
    public function deveraEnviarUmEmailComRelatorioDeVendasDoDia(): void
    {
        Mail::fake();
        $this->artisan('app:enviar-relatorio-vendas')->assertSuccessful();
        Mail::assertSent(RelatorioDiarioVendas::class);
    }
}
