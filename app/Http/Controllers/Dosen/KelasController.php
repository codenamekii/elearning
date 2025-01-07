<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{Absen, Jadwal, Materi, Mahasiswa};

class KelasController extends Controller
{
    public function masuk($jadwalId)
    {
        try {
            $jadwal = Jadwal::where('id', decrypt($jadwalId))->firstOrFail();

            debugbar()->info([
                'waktu_sekarang' => waktuSekarang(),
                'jam_masuk' => $jadwal->jam_masuk,
                'jam_keluar' => $jadwal->jam_keluar,
                'hari_ini' => hariIndo(),
                'hari_jadwal' => $jadwal->hari,
                'kondisi_waktu' => waktuSekarang() >= $jadwal->jam_masuk && waktuSekarang() <= $jadwal->jam_keluar,
                'kondisi_hari' => $jadwal->hari == hariIndo()
            ]);

            // Validasi waktu dan hari
            if (
                waktuSekarang() >= $jadwal->jam_masuk &&
                waktuSekarang() <= $jadwal->jam_keluar &&
                $jadwal->hari == hariIndo()
            ) {

                // Ambil data mahasiswa dengan absensi hari ini
                $mahasiswa = Mahasiswa::with(['mahasiswaAbsenHariIni' => function ($q) use ($jadwal) {
                    $q->where('jadwal_id', $jadwal->id);
                }])->where('kelas_id', $jadwal->kelas_id)->get();

                $mahasiswaHadir = $mahasiswa->where('mahasiswaAbsenHariIni', '!=', null)->count();
                $mahasiswaTidakHadir = $mahasiswa->where('mahasiswaAbsenHariIni', '==', null)->count();

                // Ambil data absen hari ini
                $absen = Absen::where('dosen_id', Auth::Id())
                    ->where('jadwal_id', $jadwal->id)
                    ->whereDate('created_at', now())
                    ->first();

                return view('frontend.dosen.kelas.masuk', compact(
                    'mahasiswa',
                    'jadwal',
                    'absen',
                    'mahasiswaHadir',
                    'mahasiswaTidakHadir'
                ));
            }

            return back()->with('error', 'Kelas hanya bisa diakses sesuai jadwal!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengakses kelas!');
        }
    }

    public function storeAbsen()
    {
        try {
            $absen = collect(Absen::where('dosen_id', Auth::Id())
                ->where('jadwal_id', request('jadwal'))
                ->whereDate('created_at', date('Y-m-d'))
                ->first());

            if ($absen->isNotEmpty()) {
                for ($i = 0; $i < count(request('mahasiswa')); $i++) {
                    Absen::updateOrCreate(
                        [
                            'mahasiswa_id' => request('mahasiswa')[$i],
                            'parent' => $absen['id']
                        ],
                        [
                            'parent' => request('parent'),
                            'status' => request('status')[$i],
                            'jadwal_id' => request('jadwal'),
                            'pertemuan' => request('pertemuan'),
                        ]
                    );
                }
                return back()->with('success', 'Berhasil menyimpan data absen');
            }

            return back()->with('error', 'Ups!! Sepertinya anda belum membuat absen untuk hari ini');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan absen!');
        }
    }

    public function materi($jadwalId)
    {
        try {
            $jadwal = Jadwal::where('id', decrypt($jadwalId))->firstOrFail();

            $materis = Materi::with(['matkul', 'kelas'])
                ->where('matkul_id', $jadwal->matkul_id)
                ->where('dosen_id', $jadwal->dosen_id)
                ->where('kelas_id', $jadwal->kelas_id)
                ->latest()
                ->get();

            return view('frontend.dosen.kelas.materi', compact('materis', 'jadwal'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengakses materi!');
        }
    }
}
