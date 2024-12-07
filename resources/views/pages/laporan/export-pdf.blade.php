<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Reimbursement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
            /* background-color: #f4f4f4; */
            font-size: 10px
        }

        h4 {
            margin-bottom: 20px;
            color: #333;
        }

        /* .filter-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        } */

        .table-container {
            overflow-x: auto;
            background-color: white;
            border-radius: 8px;
            width: 100%;
            /* padding: 20px; */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h4>Laporan Reimbursement</h4>

    <!-- Keterangan Filter -->
    <div class="filter-info">
        <p><strong>Tanggal Awal:</strong> {{ $tanggal_awal }}</p>
        <p><strong>Tanggal Akhir:</strong> {{ $tanggal_akhir }}</p>
        <p><strong>Status:</strong>
            @if ($status == 'all')
                Semua Status
            @elseif($status == 0)
                Menunggu Persetujuan
            @elseif($status == 1)
                Disetujui
            @else
                Ditolak
            @endif
        </p>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Nominal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->translatedFormat('d-m-Y H:i') }}</td>
                        <td>{{ $item->user->nip }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ formatRupiah($item->nominal) }}</td>
                        <td>{{ $item->kategori->nama }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            @if ($item->status_pengajuan == 0)
                                Menunggu Persetujuan
                            @elseif($item->status_pengajuan == 1)
                                Disetujui
                            @else
                                Ditolak
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
