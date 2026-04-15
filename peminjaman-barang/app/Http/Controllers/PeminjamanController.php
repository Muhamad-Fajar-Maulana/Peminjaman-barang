<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    //
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'barang_id'     => 'required',
            'jumlah_pinjam' => 'required|numeric|min:1',
            'tenggat_waktu' => 'required|date|after:today',
        ]);

        // Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // 2. Cek Stok Barang
            $barang = Barang::findOrFail($request->barang_id);
            
            if ($barang->stok < $request->jumlah_pinjam) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            // 3. Simpan ke Tabel Peminjamans
            $peminjaman = Peminjaman::create([
                'user_id'        => Auth::id() ?? 1, // Pakai ID 1 jika belum ada sistem login
                'tanggal_pinjam' => now(),
                'tenggat_waktu'  => $request->tenggat_waktu,
                'status'         => 'dipinjam',
            ]);

            // 4. Simpan ke Tabel DetailPeminjamans
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'barang_id'     => $barang->id,
                'jumlah_pinjam' => $request->jumlah_pinjam,
            ]);

            // 5. KURANGI STOK BARANG (Logika Inti)
            $barang->decrement('stok', $request->jumlah_pinjam);

            // Jika semua lancar, simpan permanen
            DB::commit();

            return redirect()->back()->with('success', 'Peminjaman berhasil diproses!');

        } catch (\Exception $e) {
            // Jika ada satu saja yang error, batalkan semua perubahan database
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}