<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Mail\SendMail;
use App\Models\Anggaran;
use App\Models\Kategori;
use App\Models\NotifM;
use App\Models\Reimbursment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReimbursmentController extends Controller
{
    public function index()
    {
        $items = Reimbursment::getByUser()->orderBy('id', 'DESC')->get();
        return view('pages.reimbursment.index', [
            'title' => 'Data Reimbursment',
            'items' => $items
        ]);
    }

    public function pengajuan()
    {
        return view('pages.reimbursment.pengajuan', [
            'title' => 'Pengajuan Reimbursment',
            'categories' => Kategori::orderBy('nama', 'ASC')->get()
        ]);
    }

    public function proses_pengajuan()
    {
        request()->validate([
            'kategori_id' => ['required'],
            'nominal' => ['required', 'numeric'],
            'bukti' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'surat_jalan' => ['nullable', 'mimes:pdf'],
            'tanggal' => ['required']
        ]);

        $tanggal_conv = Carbon::parse(request('tanggal'));
        $tahun = $tanggal_conv->format('Y');
        $bulan = $tanggal_conv->format('m');
        // cek anggaran
        $cekAnggaran = Anggaran::where('department_id', auth()->user()->department_id)->where('tahun', $tahun)->where('bulan', $bulan);

        if (!$cekAnggaran->count() > 0) {
            return redirect()->back()->with('error', 'Anggaran belum tersedia.');
        }
        if ($cekAnggaran->first()->sisa() < request('nominal')) {
            return redirect()->back()->with('error', 'Sisa Anggaran tidak cukup.');
        }

        DB::beginTransaction();
        try {
            $data = request()->only(['kategori_id', 'nominal', 'deskripsi', 'tanggal']);
            $data['bukti'] = request()->file('bukti')->store('reimbursment/bukti', 'public');
            if(request()->only('surat_jalan')){

                $data['surat_jalan'] = request()->file('surat_jalan')->store('reimbursment/surat-jalan', 'public');
            }
            $data['kode'] = Reimbursment::getNewCode();
            $data['user_id'] = auth()->id();
            $data = Reimbursment::create($data);
            $body = [
                'subject' => 'Pengajuan Reimbursment',
                'to' => 'staff keuangan',
                'data' => $data
            ];
            $send_to = User::where('role', 'staff keuangan')->pluck('email');
            foreach ($send_to as $email) {
                Mail::to($email)->send(new \App\Mail\SendMail($body));
            }

            $notif = new NotifM();
            $notif->title = "Pengajuan Reimbursment";
            $notif->value = "Pengajuan Remibursment telah terkonfirmasi, silahkan periksa";
            $notif->pengirim = Auth::user()->id;
            $notif->reimbursments_id = $data->id;
            $notif->status = 0;
            $notif->save();
            broadcast(new NewNotification($notif));
            DB::commit();
            return redirect()->route('reimbursment.index')
                    ->with('success', 'Reimbursment berhasil diajukan. Tunggu Verifikasi dari Keuangan.')
                    ->with('notif', 'Ada pengajuan reimbursement baru!');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('reimbursment.index')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Reimbursment::getByUser()->findOrFail($id);
        if ($item->status_pengajuan == 1) {
            return redirect()->route('reimbursment.index');
        }
        return view('pages.reimbursment.edit', [
            'title' => 'Edit Reimbursment',
            'item' => $item,
            'categories' => Kategori::orderBy('nama', 'ASC')->get()
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'kategori_id' => ['required'],
            'nominal' => ['required', 'numeric'],
            'bukti' => ['image', 'mimes:png,jpg,jpeg'],
            'surat_jalan' => ['mimes:pdf'],
            'tanggal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = Reimbursment::getByUser()->findOrFail($id);
            $data = request()->only(['kategori_id', 'nominal', 'deskripsi', 'tanggal']);
            if (request()->file('bukti')) {
                if ($item->bukti) {
                    Storage::disk('public')->delete($item->bukti);
                }
                $data['bukti'] = request()->file('bukti')->store('reimbursment/bukti', 'public');
            }
            if (request()->file('surat_jalan')) {
                if ($item->surat_jalan) {
                    Storage::disk('public')->delete($item->surat_jalan);
                }
                $data['surat_jalan'] = request()->file('surat_jalan')->store('reimbursment/surat-jalan', 'public');
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('reimbursment.index')->with('success', 'Reimbursment berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('reimbursment.index')->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $item = Reimbursment::with(['user.department'])->getByUser()->findOrFail($id);
        $anggaran = Anggaran::where('department_id', $item->user->department_id)->where('tahun', $item->created_at->format('Y'))->where('bulan', $item->created_at->format('m'))->first();
        return view('pages.reimbursment.show', [
            'title' => 'Detail Reimbursment',
            'item' => $item,
            'anggaran' => $anggaran
        ]);
    }

    public function set_tolak($id)
    {
        try {
            $item = Reimbursment::with(['user.department'])->findOrFail($id);
            $item->update([
                'status_pengajuan' => 2,
                'catatan' => request('catatan')
            ]);

            $body = [
                'subject' => 'Pengajuan Ditolak',
                'data' => $item,
                'to' => 'staff umum'
            ];
            Mail::to($item->user->email)->send(new SendMail($body));

            return redirect()->back()->with('success', 'Reimbursment berhasil ditolak.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function set_setujui($id)
    {
        try {
            $item = Reimbursment::with(['user.department'])->findOrFail($id);
            $tanggal_conv = Carbon::parse($item->tanggal);
            $tahun = $tanggal_conv->format('Y');
            $bulan = $tanggal_conv->format('m');
            $cekAnggaran = Anggaran::where('department_id', $item->user->department_id)->where('tahun', $tahun)->where('bulan', $bulan);

            if ($cekAnggaran->count() < 1) {
                return redirect()->back()->with('error', 'Anggaran belum tersedia.');
            }
            if ($cekAnggaran->first()->sisa() < request('nominal')) {
                return redirect()->back()->with('error', 'Sisa Anggaran tidak cukup.');
            }
            $item->update([
                'status_pengajuan' => 1,
                'tanggal_persetujuan' => Carbon::now(),
                'keuangan_user_id' => auth()->id()
            ]);
            $body = [
                'subject' => 'Pengajuan Disetujui',
                'data' => $item,
                'to' => 'staff umum'
            ];
            Mail::to($item->user->email)->send(new SendMail($body));

            return redirect()->back()->with('success', 'Reimbursment berhasil disetujui.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function pembayaran($id)
    {
        $item = Reimbursment::with(['user.department'])->getByUser()->findOrFail($id);
        return view('pages.reimbursment.pembayaran', [
            'title' => 'Pembayaran Reimbursment',
            'item' => $item
        ]);
    }

public function proses_pembayaran($id)
{
    // dd(request()->all());

    Log::info('Memulai proses pembayaran untuk reimbursement ID: ' . $id);

    request()->validate([
        'metode_pembayaran' => ['required'],
        'nama_rekening'     => ['required_if:metode_pembayaran,Transfer'],
        'nomor_rekening'    => ['required_if:metode_pembayaran,Transfer'],
        'pemilik'           => ['required_if:metode_pembayaran,Transfer'],
    ]);


    $item = Reimbursment::with(['user.department'])->getByUser()->findOrFail($id);
    Log::info('Data reimbursement ditemukan', ['item' => $item]);

    $data = request()->only(['metode_pembayaran', 'nomor_rekening', 'pemilik','nama_rekening']);
    $data['jumlah_dibayarkan'] = $item->nominal;

    if (request()->filled('tanggal_pembayaran')) {
        $data['tanggal_pembayaran'] = request('tanggal_pembayaran');
    }

    if (request()->filled('status_pembayaran')) {
        $data['status_pembayaran'] = request('status_pembayaran');
    }

    if (request()->hasFile('bukti_pembayaran')) {
        $file = request()->file('bukti_pembayaran');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti'), $filename);
        $data['bukti_pembayaran'] = 'bukti/' . $filename;

        Log::info('Bukti pembayaran berhasil diupload', ['file' => $data['bukti_pembayaran']]);
    }

    Log::info('Data pembayaran yang akan disimpan:', $data);

    // Update jika sudah ada, kalau tidak buat baru
    if ($item->pembayaran) {
        $item->pembayaran()->update($data);
        Log::info('Data pembayaran berhasil diperbarui untuk ID: ' . $item->id);
    } else {
        $item->pembayaran()->create($data);
        Log::info('Data pembayaran baru berhasil dibuat untuk ID: ' . $item->id);
    }

    return redirect()->back()->with('status', 'Pembayaran berhasil disubmit.');
}

}
