<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Reimbursement Ditolak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #bb0707;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .content {
            margin: 20px 0;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .content td {
            padding: 8px;
        }

        .content td:first-child {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pengajuan Reimbursement Ditolak</h1>
        </div>
        <div class="content">
            <p>Kepada Yth. {{ $data->user->name ?? 'Pemohon' }},</p>
            <p>Dengan ini kami memberitahukan bahwa pengajuan reimbursement Anda <strong>ditolak</strong> oleh staff
                keuangan dengan detail sebagai berikut:</p>
            <table>
                <tr>
                    <td>Nama:</td>
                    <td>{{ $data->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIP:</td>
                    <td>{{ $data->user->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kategori:</td>
                    <td>{{ $data->kategori->nama }}</td>
                </tr>
                <tr>
                    <td>Keterangan:</td>
                    <td>{{ $data->deskripsi }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pengajuan:</td>
                    <td>{{ formatTanggal($data->created_at, 'd F Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Nominal:</td>
                    <td>{{ formatRupiah($data->nominal) }}</td>
                </tr>
                <tr>
                    <td>Alasan:</td>
                    <td>{{ $data->catatan ?? 'Tidak ada alasan yang diberikan.' }}</td>
                </tr>
            </table>
            <p>Kami sarankan untuk memperbaiki pengajuan Anda sesuai dengan alasan penolakan di atas dan mengajukannya
                kembali melalui sistem. Jika ada pertanyaan lebih lanjut, silakan hubungi staff keuangan.</p>
            <br>
            <p>Terima kasih,</p>
            <p>Staff Keuangan</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem. Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>

</html>
