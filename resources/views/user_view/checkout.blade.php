<!DOCTYPE html>
<html>
<head>
    <title>Checkout Page</title>
</head>
<body>
    <h1>Checkout Page</h1>

    <h2>Loan Funds Bills</h2>
    <ul>
        @foreach($data['LoanFundsBills'] as $bill)
            <li>
                Bill ID: {{ $bill['id'] }},
                Installment: {{ $bill['installment'] }},
                Installment Amount: {{ $bill['installment_amount'] }},
                Status: {{ $bill['status'] }}
                <!-- Tambahkan form untuk memilih data yang akan di-checkout -->
                <form action="{{ route('checkout.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bill_id" value="{{ $bill['id'] }}">
                    <button type="submit">Checkout</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h2>Goods Loan Bills</h2>
    <ul>
        @foreach($data['GoodsLoanBills'] as $bill)
            <li>
                Bill ID: {{ $bill['id'] }},
                Installment: {{ $bill['installment'] }},
                Installment Amount: {{ $bill['installment_amount'] }},
                Status: {{ $bill['status'] }}
                <!-- Tambahkan form untuk memilih data yang akan di-checkout -->
                <form action="{{ route('checkout.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bill_id" value="{{ $bill['id'] }}">
                    <button type="submit">Checkout</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
