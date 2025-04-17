<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; }
        .summary { margin-top: 30px; }
        .header { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Period: {{ date('d/m/Y', strtotime($dateFrom)) }} to {{ date('d/m/Y', strtotime($dateTo)) }}</p>
        <p>Academic Level: {{ $academicLevel }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Invoice #</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                    <td>
                        {{ $payment->invoice->student->full_name }}
                        <small>({{ $payment->invoice->student->registration_number }})</small>
                    </td>
                    <td>{{ $payment->invoice->invoice_number }}</td>
                    <td>TSh {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <p>Total Amount: TSh {{ number_format($totalAmount, 2) }}</p>
        <p>Approved: TSh {{ number_format($summary['approved'], 2) }}</p>
        <p>Pending: TSh {{ number_format($summary['pending'], 2) }}</p>
        <p>Rejected: TSh {{ number_format($summary['rejected'], 2) }}</p>
    </div>
</body>
</html>