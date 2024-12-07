<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Reimbursement</title>
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
            background-color: #007bff;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pengajuan Reimbursement</h1>
        </div>
        <div class="content">
            <p>Kepada Yth. Staff Keuangan,</p>
            <p>Dengan ini, saya mengajukan reimbursement dengan detail sebagai berikut:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Nama:</td>
                    <td style="padding: 8px;">{{ $data->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">NIP:</td>
                    <td style="padding: 8px;">{{ $data->user->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Kategori:</td>
                    <td style="padding: 8px;">{{ $data->kategori->nama }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Keterangan:</td>
                    <td style="padding: 8px;">{{ $data->deskripsi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Tanggal:</td>
                    <td style="padding: 8px;">{{ formatTanggal($data->created_at, 'd F Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Nominal:</td>
                    <td style="padding: 8px;">{{ formatRupiah($data->nominal) }}</td>
                </tr>
            </table>
            <p>Dokumen pendukung telah dilampirkan untuk proses verifikasi lebih lanjut. Mohon untuk dapat segera
                ditindaklanjuti sesuai dengan prosedur yang berlaku.</p>
            <p>Terima kasih atas perhatian dan kerjasamanya.</p>
            <br>
            <p>Hormat saya,</p>
            <p>{{ $data->user->name ?? '-' }}</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem. Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>

</html>
