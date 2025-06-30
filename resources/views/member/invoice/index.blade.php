<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Peminjaman Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            margin: 40px;
            background-color: #ffffff;
            color: #1f2937;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #e5e7eb;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }

        .logo-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-title img {
            width: 80px;
        }

        .contact {
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .contact p {
            margin: 2px 0;
        }

        .section-title {
            text-align: center;
            margin: 20px 0;
        }

        .section-title h2 {
            margin: 0;
            color: #2563eb;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .info div {
            width: 48%;
        }

        .info b {
            display: inline-block;
            width: 120px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }

        th {
            background-color: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="logo-title">
            <img src="{{ public_path('images/logo-umi.jpg') }}" alt="Logo">
            <div class="contact">
                <p>pinjamFIKOM</p>
                <p>Jl. Hang Tuah No. 8 Medan</p>
                <p>www.pinjamFikom.com</p>
                <p>info@methodist.ac.id</p>
                <p>(061)-4536735</p>
            </div>
        </div>

        <div class="section-title">
            <h2>P E M I N J A M A N  B A R A N G</h2>
            <p><strong>Invoice</strong></p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 25px;">
    <div>
        <p><b>Dipinjam Oleh:</b> {{ $peminjaman->user->nama }}</p>
        <p><b>Email:</b> {{ $peminjaman->user->email }}</p>
        <p><b>No. Invoice:</b> #{{ str_pad($peminjaman->id, 8, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div style="text-align: right;">
        <p><b>Tanggal Pinjam:</b> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</p>
        <p><b>Waktu Pinjam:</b> {{ $peminjaman->time_pinjam }}</p>
        <p><b>Status:</b> {{ ucfirst($peminjaman->status) }}</p>
    </div>
</div>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $peminjaman->barang->merk }}</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total Barang: 1
        </div>

        <div class="footer">
            Dicetak otomatis oleh sistem pinjamFIKOM - {{ date('d/m/Y H:i') }} WIB
        </div>
    </div>
</body>
</html>
