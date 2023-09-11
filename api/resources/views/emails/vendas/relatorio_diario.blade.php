<html>

<head>
    <style>
        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Relatório de Vendas - {{ $data }}</h1>
    <table>
        <thead>
            <th>Vendedor</th>
            <th>E-mail</th>
            <th>Valor</th>
            <th>Comissão</th>
            <th>Data Da Venda</th>
        </thead>
        <tbody>
            @foreach ($vendas as $venda)
            <tr>
                <td>{{ $venda->vendedor->nome }}</td>
                <td>{{ $venda->vendedor->email }}</td>
                <td>R$ {{ number_format($venda->valor, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($venda->comissao, 2, ',', '.') }}</td>
                <td>{{ (new DateTimeImmutable($venda->data))->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2"><b>Total</b></td>
                <td colspan="3"><b>R$ {{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
