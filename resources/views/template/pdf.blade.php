<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }
        table th {
            font-weight: bold;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture #{{ $sale->id }}</h1>
    </div>

    <div class="invoice-info">
        <p><strong>Date :</strong> {{ $sale->created_at->format('d/m/Y') }}</p>
        <p><strong>Référence :</strong> {{ $sale->reference ?? 'N/A' }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Client :</strong> {{ $sale->customer->name ?? 'Client non spécifié' }}</p>
        <!-- Autres informations client si disponibles -->
    </div>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sale->article->name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ number_format($sale->article->sale_price, 2) }} €</td>
                <td>{{ number_format($sale->total_price, 2) }} €</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <h3>Total : {{ number_format($sale->total_price, 2) }} €</h3>
    </div>
</body>
</html>
