<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan peran 'guru' dan profil mereka.
     */
    public function index()
    {
        // Ambil semua user dengan peran 'guru' dan eager load profil guru mereka
        // serta mata pelajaran yang diajarkan.
        $userList = User::where('role', 'guru')->with('guru.mataPelajaran')->latest()->get();

        // Data untuk dropdown di modal
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();

        return view('guru.guru.index', compact('userList', 'mapelList'));
    }

    /**
     * Memperbarui atau membuat profil untuk user guru yang sudah ada.
     * Kita menggunakan User model sebagai parameter utama.
     */
    public function update(Request $request, User $user)
    {
        // Pastikan kita hanya mengupdate user dengan peran guru
        if ($user->role !== 'guru') {
            return back()->with('error', 'Aksi tidak diizinkan untuk user ini.');
        }

        $validated = $request->validate([
            // Validasi NIP, unik tapi abaikan untuk profil guru yang sedang diedit.
            'nip' => ['required', 'string', Rule::unique('gurus')->ignore($user->guru->id ?? null)],
            'no_telp' => 'required|string',
            'mapel_ids' => 'nullable|array',
            'mapel_ids.*' => 'exists:mata_pelajarans,id',
        ]);
        
        DB::transaction(function () use ($validated, $user) {
            // Gunakan updateOrCreate untuk membuat profil jika belum ada, atau update jika sudah ada.
            $guru = $user->guru()->updateOrCreate(
                ['user_id' => $user->id], // Kondisi pencarian
                [ // Data untuk diupdate atau dibuat
                    'nip' => $validated['nip'],
                    'no_telp' => $validated['no_telp'],
                ]
            );
            
            // Sync mata pelajaran.
            $guru->mataPelajaran()->sync($validated['mapel_ids'] ?? []);
        });

        return back()->with('success', 'Profil guru berhasil diperbarui.');
    }

    // Method store() dan destroy() bisa dihapus jika tidak lagi digunakan.
    // Untuk saat ini, kita biarkan destroy() di GuruController
    public function destroy(Guru $guru)
    {
        // Menghapus profil guru, bukan user-nya.
        // Jika Anda ingin menghapus user juga, Anda perlu menghapus user-nya secara eksplisit.
        $user = $guru->user;
        $guru->delete();
        // Opsional: hapus juga user-nya
        // $user->delete();
        return back()->with('success', 'Profil guru berhasil dihapus.');
    }
}