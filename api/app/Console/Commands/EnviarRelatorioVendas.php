<?php

namespace App\Console\Commands;

use App\Mail\RelatorioDiarioVendas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Domain\Venda\VendaServiceInterface;

class EnviarRelatorioVendas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-relatorio-vendas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um e-mail com a soma das vendas do dia';

    /**
     * Execute the console command.
     */
    public function handle(VendaServiceInterface $vendaService)
    {
        $vendas = $vendaService->buscarVendasNoDia(now());
        Mail::send(new RelatorioDiarioVendas($vendas, now()->format('d/m/Y')));
    }
}
