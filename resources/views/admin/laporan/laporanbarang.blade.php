
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            margin: 40px auto;
            background-color: #f9fafb;
            color: #1f2937;
            max-width: 900px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .title {
            flex-grow: 1;
            text-align: center;
        }

        .title h2 {
            font-size: 22px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .date {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border: 2px solid #3b82f6; /* border biru terang */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        th {
            background-color: #2563eb; /* biru tua */
            color: #ffffff;
            text-align: center;
            padding: 12px;
            font-weight: 600;
            border-bottom: 2px solid #1d4ed8;
        }

        td {
            padding: 10px;
            border-top: 1px solid #bfdbfe; /* garis biru muda antar baris */
            border-left: 1px solid #bfdbfe;
            border-right: 1px solid #bfdbfe;
            text-align: center;
            color: #1f2937;
        }

        tbody tr:nth-child(even) {
            background-color: #eff6ff; /* biru muda */
        }

        tbody tr:hover {
            background-color: #dbeafe; /* biru hover */
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
            color: #9ca3af;
            border-top: 1px solid #d1d5db;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/logo-umi.jpg') }}" class="logo" alt="Logo">
        </div>
        <div class="title">
            <h2>Laporan Data Barang</h2>
        </div>
        <div class="tanggal">Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</div>
        <table>
            <thead>
                <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Merk</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $i => $barang)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="text-left">{{ $barang->kategori->nama ?? '-' }}</td>
                <td class="text-left">{{ $barang->merk }}</td>
                <td class="text-left">{{ \Illuminate\Support\Str::limit($barang->deskripsi, 50) }}</td>
                <td>{{ $barang->jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        &copy; {{ date('Y') }} pinjamFIKOM | Fakultas Ilmu Komputer Universitas Methodist Indonesia
    </div>
</body>
</html>