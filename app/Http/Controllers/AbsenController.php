<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Izin;
use App\Models\JumlahIzin;
use App\Models\Lokasi;
use App\Models\Regional;
use App\Models\Shift;
use App\Models\User;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function index()
    {
        Cache::flush();
        $countKehadiranPerBulan = count(Absen::where('user_id', auth()->user()->id)->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countJumlahIzin = JumlahIzin::select('jumlah_izin')->where('tahun', Carbon::now()->format('Y'))->where('user_id', auth()->user()->id)->first();
        $regional = Regional::select('timezone')->where('id', auth()->user()->regional_id)->first();
        $timezone = Carbon::now($regional->timezone);
        date_default_timezone_set($regional->timezone);

        $this->cekAlfa();
        return view('absen.index', compact('countKehadiranPerBulan', 'countJumlahIzin', 'regional', 'timezone'));
    }

    public function create()
    {
        Cache::flush();
        $this->cekAlfa();

        // Ambil lokasi user berdasarkan id user, join tabel lokasi
        $lokasiUser = User::select('users.lokasi_id as lokasi_id', 'lokasi.lokasi_proyek', 'lokasi.latitude', 'lokasi.longitude', 'lokasi.radius')
            ->join('lokasi', 'users.lokasi_id', '=', 'lokasi.id')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Fungsi cek absen dibawah, mengecek apakah sudah absen masuk atau pulang
        $cekAbsen = $this->cekAbsenHariIni();

        // Ambil shift
        $shift = Shift::where('regional_id', auth()->user()->regional_id)->get();

        return view('absen.create', compact('cekAbsen', 'shift', 'lokasiUser'));
    }

    public function detail()
    {
        $namaBulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        $countKehadiran = count(Absen::where('user_id', auth()->user()->id)->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countTerlambat = count(Absen::where('user_id', auth()->user()->id)->where('status', 'Terlambat')->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countAlfa = count(Absen::where('user_id', auth()->user()->id)->where('status', 'Alfa')->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countCuti = count(Absen::where('user_id', auth()->user()->id)->where('status', 'Cuti')->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countSakit = count(Absen::where('user_id', auth()->user()->id)->where('status', 'Sakit')->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());
        $countIzin = count(Absen::where('user_id', auth()->user()->id)->where('status', 'Izin')->whereMonth('tgl_masuk', Carbon::now()->format('m'))->get());

        $countPemotongan = $this->pemotonganKeterlambatan();

        return view('absen.detail', compact('countKehadiran', 'countTerlambat', 'countAlfa', 'countCuti', 'countSakit', 'countIzin', 'countPemotongan', 'namaBulan'));
    }

    public function allDetail()
    {
        $namaBulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
        $users = User::select('id', 'name')->get();
        return view('absen.all-detail', compact('users', 'namaBulan'));
    }

    /*
    |--------------------------------------------
    | Simpan Absen
    |--------------------------------------------
    | Syarat :
    | - Absen harus sesuai dengan radius lokasi
    | - Absen memiliki absen masuk dan absen keluar
    | - Absen harus menyimpan shift pagi, shift sore, dan shift malam
    | - Absen malam berbeda kondisi dari absen yang lainnya
    */
    public function store(Request $request)
    {
        // Jika tidak terdapat request foto
        if ($request->image == null) {
            toast('Oppss, terjadi kesalahan!', 'error');
            return Redirect::back();
        }

        // Panggil fungsi dibawah
        // Kondisi jika didalam radius
        if ($this->radiusLokasi($request->latitude, $request->longitude)) {
            // Jika request absen masuk
            if ($request->kategori == "absenMasuk") {

                // Pilih shift yang di checked pada form
                $shiftYangDipilih = Shift::where('regional_id', auth()->user()->regional_id)->where('id', $request->shiftChecked)->first();
                // $regional = Regional::select('timezone')->where('id', auth()->user()->regional_id)->first();

                // $jamTimezoneUser = $regional->timezone;

                // dd($jamTimezoneUser);

                // Ambil nama foto dari fungsi absenImageStore dibawah
                $pathFoto = $this->absenImageStore($request->image);

                // Jika shift yang dipilih adalah shift malam
                if ($shiftYangDipilih->is_diff_day == 1) {
                    /*
                    |--------------------------------------------
                    | Shift malam mulai dari jam 23:00 - 07:00
                    |--------------------------------------------
                    | Syarat :
                    | - User absen dihari pertama sebelum jam 23:00 (Tidak Telat)       | Tanggal : 2024-01-01
                    | - User absen dihari pertama setelah jam 23:00 (Telat)             | Tanggal : 2024-01-01
                    | - User absen dihari kedua setelah jam 00:00 (Telat)               | Tanggal : 2024-01-02
                    | - User bisa absen dihari kedua dengan memilih shift yang lain,    | Tanggal : 2024-01-02
                    |   setelah memilih shift different day
                    */

                    /*
                    | Fungsi setting range dibawah ini untuk menentukan, apakah dia absen sudah pergantian hari atau masih di hari yang sama.
                    | Ukur range pertama dari jam masuk shift sampai jam sebelum tengah malam (pergantian hari)
                    | Ukur range kedua dari setelah tengah malam (hari kedua) sampai jam pulang shift
                    */

                    // Setting range hari pada hari pertama
                    $startHariPertama = Carbon::parse($shiftYangDipilih->jam_masuk)->subHours(2)->format('H:i');
                    $endHariPertama = Carbon::createFromTimeString('23:59');

                    // Setting range hari pada hari kedua
                    $startHariKedua = Carbon::createFromTimeString('00:00');
                    $endHariKedua = Carbon::parse($shiftYangDipilih->jam_pulang)->addHours(2)->format('H:i');

                    // Jika waktu user saat absen didalam range hari pertama, input data seperti biasa, dengan fungsi keterlambatan dan keterangannya
                    if (Carbon::now()->between($startHariPertama, $endHariPertama)) {
                        // Cek apakah user sudah absen masuk pada hari itu dengan shiftnya
                        $cekAbsenMasukHariPertama = Absen::where('user_id', auth()->user()->id)
                            ->where('shift_id', $shiftYangDipilih->id)
                            ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                            ->latest('created_at')
                            ->first();

                        if ($cekAbsenMasukHariPertama == null) {
                            // Fungsi cek timezone, pengecekan jika ada perbedaan waktu timezone dan waktu pada device user
                            $this->cekTimezone(Carbon::now(), $shiftYangDipilih->timezone);

                            // Fungsi cek terlambat, return ['waktu terlambat', 'potongan keterlambatan', 'status']
                            $keterlambatan = $this->cekTerlambat(Carbon::now()->format('H:i:s'), $shiftYangDipilih->jam_masuk);

                            // Keterangan absen
                            $keterangan =
                                $keterlambatan['status'] != "Normal"
                                ? "Terlambat masuk " . Carbon::parse(Carbon::now()->format('H:i:s'))->diffForHumans($shiftYangDipilih->jam_masuk, CarbonInterface::DIFF_ABSOLUTE)
                                : "Masuk Tepat Waktu, Shift " . $shiftYangDipilih->nama;

                            // Masukkan ke array data
                            $data = [
                                'user_id' => auth()->user()->id,
                                'lokasi_id' => $request->lokasi_id,
                                'shift_id' => $shiftYangDipilih->id,
                                'tgl_masuk' => Carbon::now()->format('Y-m-d'),
                                'jam_masuk' => Carbon::now()->format('H:i:s'),
                                'foto_masuk' => $pathFoto,
                                'lokasi_masuk' => $request->lokasi_proyek,
                                'tgl_pulang' => '',
                                'jam_pulang' => '',
                                'foto_pulang' => 'Belum Dilakukan',
                                'lokasi_pulang' => 'Belum Dilakukan',
                                'terlambat' => $keterlambatan['time'],
                                'keterangan' => $keterangan,
                                'potongan' => $keterlambatan['potongan'],
                                'status' => $keterlambatan['status'],
                            ];
                            Absen::create($data);

                            toast('Absen masuk berhasil', 'success');
                            return Redirect::route('absen.index');
                        }

                        toast('Anda sudah melakukan absen masuk', 'warning');
                        return Redirect::route('absen.index');
                    }

                    // Jika waktu user saat absen didalam range hari kedua, input data seperti biasa
                    // User sudah pasti telat karena melewati batas shift yaitu 23:00
                    if (Carbon::now()->between($startHariKedua, $endHariKedua)) {

                        // Cek apakah user sudah absen masuk pada hari itu dengan shiftnya
                        $cekAbsenMasukHariKedua = Absen::where('user_id', auth()->user()->id)
                            ->where('shift_id', $shiftYangDipilih->id)
                            ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                            ->latest('created_at')
                            ->first();

                        if ($cekAbsenMasukHariKedua == null) {
                            // Fungsi cek timezone, pengecekan jika ada perbedaan waktu timezone dan waktu pada device user
                            $this->cekTimezone(Carbon::now(), $shiftYangDipilih->timezone);

                            // Fungsi cek terlambat, return ['waktu terlambat', 'potongan keterlambatan', 'status']
                            $keterlambatan = $this->cekTerlambat(Carbon::now(), $shiftYangDipilih->jam_masuk, true);

                            // Keterangan absen
                            $keterangan = "Terlambat masuk " . $keterlambatan['diffHuman'];

                            // Masukkan ke array daya
                            $data = [
                                'user_id' => auth()->user()->id,
                                'lokasi_id' => $request->lokasi_id,
                                'shift_id' => $shiftYangDipilih->id,
                                'tgl_masuk' => Carbon::now()->format('Y-m-d'),
                                'jam_masuk' => Carbon::now()->format('H:i:s'),
                                'foto_masuk' => $pathFoto,
                                'lokasi_masuk' => $request->lokasi_proyek,
                                'tgl_pulang' => '',
                                'jam_pulang' => '',
                                'foto_pulang' => 'Belum Dilakukan',
                                'lokasi_pulang' => 'Belum Dilakukan',
                                'terlambat' => $keterlambatan['time'],
                                'keterangan' => $keterangan,
                                'potongan' => $keterlambatan['potongan'],
                                'status' => 'Terlambat',
                            ];
                            Absen::create($data);

                            toast('Absen masuk berhasil', 'success');
                            return Redirect::route('absen.index');
                        }
                        toast('Anda sudah melakukan absen masuk', 'warning');
                        return Redirect::route('absen.index');
                    }

                    toast('Anda belum bisa melakukan shift malam.', 'warning');
                    return Redirect::route('absen.index');
                } else {

                    // Cek apakah user sudah absen masuk pada hari itu sesuai dengan shiftnya
                    $cekAbsenMasuk = Absen::where('user_id', auth()->user()->id)
                        ->where('shift_id', $shiftYangDipilih->id)
                        ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                        ->latest('created_at')
                        ->first();

                    // Jika belum absen masuk pada hari itu (Jika row data = 0 atau berarti tidak ada)
                    if ($cekAbsenMasuk == null) {

                        if (Carbon::now()->between(Carbon::parse($shiftYangDipilih->jam_masuk)->subHours(2)->format('H:i:s'), Carbon::parse($shiftYangDipilih->jam_pulang)->format('H:i:s'))) {
                            # code...
                            // Fungsi cek timezone, pengecekan jika ada perbedaan waktu timezone dan waktu pada device user
                            $this->cekTimezone(Carbon::now(), $shiftYangDipilih->timezone);

                            // Fungsi cek terlambat, return ['waktu terlambat', 'potongan keterlambatan', 'status']
                            $keterlambatan = $this->cekTerlambat(Carbon::now()->format('H:i:s'), $shiftYangDipilih->jam_masuk);

                            // Keterangan absen
                            $keterangan =
                                $keterlambatan['status'] != "Normal"
                                ? "Terlambat masuk " . Carbon::parse(Carbon::now()->format('H:i:s'))->diffForHumans($shiftYangDipilih->jam_masuk, CarbonInterface::DIFF_ABSOLUTE)
                                : "Masuk Tepat Waktu, Shift " . $shiftYangDipilih->nama;

                            // Masukkan ke array data
                            $data = [
                                'user_id' => auth()->user()->id,
                                'lokasi_id' => $request->lokasi_id,
                                'shift_id' => $shiftYangDipilih->id,
                                'tgl_masuk' => Carbon::now()->format('Y-m-d'),
                                'jam_masuk' => Carbon::now()->format('H:i:s'),
                                'foto_masuk' => $pathFoto,
                                'lokasi_masuk' => $request->lokasi_proyek,
                                'tgl_pulang' => '',
                                'jam_pulang' => '',
                                'foto_pulang' => 'Belum Dilakukan',
                                'lokasi_pulang' => 'Belum Dilakukan',
                                'terlambat' => $keterlambatan['time'],
                                'keterangan' => $keterangan,
                                'potongan' => $keterlambatan['potongan'],
                                'status' => $keterlambatan['status'],
                            ];
                            Absen::create($data);

                            toast('Absen masuk berhasil', 'success');
                            return Redirect::route('absen.index');
                        }
                        toast('Anda belum bisa melakukan shift ' . strtolower($shiftYangDipilih->nama) . '.', 'warning');
                        return Redirect::route('absen.index');
                    }

                    toast('Anda sudah melakukan absen masuk', 'warning');
                    return Redirect::route('absen.index');
                }
            }

            // Jika request absen pulang
            if ($request->kategori == "absenPulang") {
                /*
                |-------------------------------------
                | Syarat Absen Pulang Shift Malam :
                |-------------------------------------
                | - Absen pulang mengikuti hari pertama user absen
                | - Absen pulang mengikuti hari kedua user absen
                */

                // Cari absen yang paling terakhir dari user berdasarkan id user
                $absenHariIni = Absen::select('absen.*', 'absen.jam_masuk as absenMasuk', 'shift.nama', 'shift.jam_pulang as shiftPulang', 'shift.is_diff_day')
                    ->join('shift', 'absen.shift_id', '=', 'shift.id')
                    ->where('user_id', auth()->user()->id)
                    ->latest('absen.created_at')
                    ->first();

                // Ambil nama foto dari fungsi absenImageStore dibawah
                $pathFoto = $this->absenImageStore($request->image);

                // Jika shift yang dipilih adalah shift malam
                if ($absenHariIni->is_diff_day == 1) {

                    // Cek apakah user sudah absen masuk pada hari itu dengan shiftnya
                    $absenHariIni = Absen::where('user_id', auth()->user()->id)
                        ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                        ->orWhere('tgl_masuk', Carbon::yesterday()->format('Y-m-d'))
                        ->whereNot('status', 'Alfa')
                        ->latest('created_at')
                        ->first();

                    // Pilih shift sesuai absen hari ini, dan user yg melakukan absen
                    $shiftYangDipilih = Shift::find($absenHariIni->shift_id);

                    // Jika belum absen pulang pada hari itu (Jika row data = 0 atau berarti tidak ada)
                    if ($absenHariIni != null) {
                        $this->cekTimezone(Carbon::now(), $shiftYangDipilih->timezone);

                        // Return jika belum saatnya pulang tetapi user sudah tekan tombol pulang
                        if (Carbon::now()->format('H:i:s') <= Carbon::parse($shiftYangDipilih->jam_pulang)->addHours(5)->format('H:i:s')) {
                            if (Carbon::now()->diffInHours($absenHariIni->jam_masuk) <= 4) {
                                toast('Belum saatnya pulang', 'warning');
                                return Redirect::route('absen.index');
                            }
                        }

                        $data = [
                            'tgl_pulang' => Carbon::now()->format('Y-m-d'),
                            'jam_pulang' => Carbon::now()->format('H:i:s'),
                            'foto_pulang' => $pathFoto,
                            'lokasi_pulang' => $request->lokasi_proyek,
                            'keterangan' => $absenHariIni->keterangan . ', Sudah Absen Pulang, Lama Bekerja ' . Carbon::parse($absenHariIni->absenMasuk)->diffForHumans(Carbon::now(), CarbonInterface::DIFF_ABSOLUTE),
                        ];
                        $absenHariIni->update($data);

                        toast('Absen pulang berhasil', 'success');
                        return Redirect::route('absen.index');
                    }

                    toast('Anda sudah melakukan absen masuk', 'warning');
                    return Redirect::route('absen.index');
                } else {
                    // Cek apakah user sudah absen masuk pada hari itu dengan shiftnya
                    $absenHariIni = Absen::where('user_id', auth()->user()->id)
                        ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                        ->latest('created_at')
                        ->first();

                    // Pilih shift sesuai absen hari ini, dan user yg melakukan absen
                    $shiftYangDipilih = Shift::find($absenHariIni->shift_id);

                    // Jika belum absen pulang pada hari itu (Jika row data = 0 atau berarti tidak ada)
                    if ($absenHariIni != null) {

                        // Fungsi cek timezone, pengecekan jika ada perbedaan waktu timezone dan waktu pada device user
                        $this->cekTimezone(Carbon::now(), $shiftYangDipilih->timezone);

                        // Return jika belum saatnya pulang tetapi user sudah tekan tombol pulang
                        if (Carbon::now()->format('H:i:s') <= Carbon::parse($shiftYangDipilih->jam_pulang)->addHours(5)->format('H:i:s')) {
                            if (Carbon::now()->diffInHours($absenHariIni->jam_masuk) <= 4) {
                                toast('Belum saatnya pulang', 'warning');
                                return Redirect::route('absen.index');
                            }
                        }

                        $data = [
                            'tgl_pulang' => Carbon::now()->format('Y-m-d'),
                            'jam_pulang' => Carbon::now()->format('H:i:s'),
                            'foto_pulang' => $pathFoto,
                            'lokasi_pulang' => $request->lokasi_proyek,
                            'keterangan' => $absenHariIni->keterangan . ', Sudah Absen Pulang, Lama Bekerja ' . Carbon::parse($absenHariIni->jam_masuk)->diffForHumans(Carbon::now(), CarbonInterface::DIFF_ABSOLUTE),
                        ];
                        $absenHariIni->update($data);

                        toast('Absen pulang berhasil', 'success');
                        return Redirect::route('absen.index');
                    }

                    toast('Anda sudah melakukan absen masuk', 'warning');
                    return Redirect::route('absen.index');
                }

                toast('Absen pulang berhasil', 'success');
                return Redirect::route('absen.index');
            }

            toast('Mohon ulangi proses absen', 'warning');
            return Redirect::route('absen.index');
        } else {
            toast('Anda diluar radius!', 'warning');
            return Redirect::route('absen.index');
        }
    }

    // Fungsi simpan data ke folder
    private function absenImageStore($imageRequest)
    {
        $img = $imageRequest;
        $folderPath = "user-absen/" . Carbon::now()->format('Y-m-d') . "/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file, $image_base64);
        return $file;
    }

    // Fungsi cek lebih waktu keterlambatan
    private function cekTerlambat($jamUser, $jamShift, bool $diffDay = null)
    {
        $data = array();

        // Parse waktu user dengan waktu shift

        // Cek apakah absen ini termasuk diff day
        if ($diffDay != true) {
            // Setting range hari pada hari pertama
            $startHariPertama = Carbon::parse($jamShift)->subHours(2)->format('H:i');
            $endHariPertama = Carbon::createFromTimeString('23:59');

            // Setting range hari pada hari kedua
            $startHariKedua = Carbon::createFromTimeString('00:00');
            $endHariKedua = Carbon::parse($jamShift)->format('H:i');

            if (Carbon::now()->between($startHariPertama, $endHariPertama)) {
                $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamShift);
            }

            if (Carbon::now()->between($startHariKedua, $endHariKedua)) {
                $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::yesterday()->format('Y-m-d') . " " . Carbon::parse($jamShift)->format('H:i:s'));
            }

            $data['diffHuman'] = Carbon::parse($jamUser)->diffForHumans(Carbon::parse($jamShift), CarbonInterface::DIFF_ABSOLUTE);
        } else {
            $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamShift);
        }

        $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamUser);

        // Jika waktu masuk kurang dari waktu yang ditentukan dalam shift, artinya user tidak terlambat
        if ($waktuMasuk->format('H:i:s') <= $waktuShift->format('H:i:s')) {
            // Return time ke 00:00:00 untuk input di kolom terlambat, dan normal untuk status
            $data['time'] = "00:00:00";
            $data['potongan'] = 0;
            $data['status'] = "Normal";
        } else {
            $data['potongan'] = 0;

            if ($waktuMasuk->diffInMinutes($waktuShift) >= 20) {
                $data['potongan'] = 1;
            }

            if ($waktuMasuk->diffInMinutes($waktuShift) >= 40) {
                $data['potongan'] = 2;
            }

            if ($waktuMasuk->diffInMinutes($waktuShift) >= 60) {
                $data['potongan'] = 3;
            }

            // Return time dari perbedaan waktu antara waktu masuk dan shift, dan terlambat untuk status
            $data['time'] = $waktuMasuk->diff($waktuShift)->format('%H:%I:%S');
            $data['status'] = "Terlambat";
        }

        return $data;
    }

    // Fungsi cek timezone
    private function cekTimezone($jamUser, $shiftTimezone)
    {
        $waktuSesuaiTimezone = Carbon::now($shiftTimezone);
        if ($waktuSesuaiTimezone->diffInMinutes($jamUser) >= 2) {
            toast('Sistem mendeteksi anomali pada waktu server dan device!', 'warning');
            return Redirect::route('absen.index');
        }
        return;
    }

    // Fungsi radius lokasi, apakah didalam atau diluar radius || Output true false
    private function radiusLokasi($latitudeRequest, $longitudeRequest)
    {
        // Ambil lokasi user berdasarkan id user, join tabel lokasi
        $lokasiUser = User::select('lokasi.latitude', 'lokasi.longitude', 'lokasi.radius')
            ->join('lokasi', 'users.lokasi_id', '=', 'lokasi.id')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Koordinat user saat ini
        $latitudeFrom = $latitudeRequest;
        $longitudeFrom = $longitudeRequest;

        // Koordinat user ditempatkan
        $latitudeTo = $lokasiUser->latitude;
        $longitudeTo = $lokasiUser->longitude;

        // Radius planet bumi pada tatasurya ini
        $earthRadius = 6371000;

        // Konversi dari degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        // Kurangin dulu
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Rumus yang tidak dimengerti
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $radius = $angle * $earthRadius;

        // Kondisi jika radius lebih kecil daripada perhitungan diatas
        if ($radius <= $lokasiUser->radius) {
            return true;
        }

        // Sebaliknya
        return false;
    }

    // Fungsi cek apakah sudah absen hari ini?
    private function cekAbsenHariIni()
    {
        /*
        | Return 1, jika belum absen masuk di hari ini
        | Return 2, jika belum absen pulang di hari ini
        | Return 3, jika belum saatnya jam pulang di hari ini
        */

        // Sudah absen masuk kah di table absen dengan user yang absen
        $cekAbsenMasukHariIni = Absen::where('user_id', auth()->user()->id)->latest()->first();

        if ($cekAbsenMasukHariIni == null) {
            return 1;
        } else {
            if ($cekAbsenMasukHariIni->status == "Cuti" || $cekAbsenMasukHariIni->status == "Izin" || $cekAbsenMasukHariIni->status == "Sakit") {
                return 0;
            }

            $shiftDipilih = Shift::find($cekAbsenMasukHariIni->shift_id);

            if ($shiftDipilih->is_diff_day == 1) {
                $cekAbsenMasukHariIni = Absen::where('user_id', auth()->user()->id)
                    ->where('shift_id', $shiftDipilih->id)
                    ->latest('created_at')
                    ->first();

                // Jika belum absen masuk
                if ($cekAbsenMasukHariIni == null) {
                    return 1;
                }

                $startHariPertama = Carbon::parse($shiftDipilih->jam_masuk)->subHours(2)->format('H:i');
                $endHariPertama = Carbon::createFromTimeString('23:59');

                // Jika waktu user saat absen didalam range hari pertama, input data seperti biasa, dengan fungsi keterlambatan dan keterangannya
                if (Carbon::now()->between($startHariPertama, $endHariPertama)) {
                    $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::tomorrow()->format('Y-m-d') . " " . $shiftDipilih->jam_pulang)->subHours(2)->format('Y-m-d H:i:s');
                    $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . Carbon::now()->format('H:i:s'))->format('Y-m-d H:i:s');
                    // Pilih shift sesuai absen hari ini, dan user yg melakukan absen, Menentukan absen pada sebelum jam pulang

                    if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && $waktuMasuk < $waktuShift) {
                        return 3;
                    }

                    // Jika absen pulang melebihi jam 9 dan user belum absen, reset absen tersebut
                    if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) > 12) {
                        // if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::now()->format('Y-m-d H:i:s') > Carbon::createFromFormat('Y-m-d H:i:s', Carbon::tomorrow()->format('Y-m-d') . " 12:00:00")->format('Y-m-d H:i:s')) {
                        return 1;
                    }

                    // Jika absen pulang melebihi jam 9 dan user sudah melakukan absen, reset absen tersebut
                    if ($cekAbsenMasukHariIni->tgl_pulang != null && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) > 12) {
                        return 1;
                    }

                    // Jika belum absen pulang
                    if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) < 12) {
                        return 2;
                    }
                }

                $startHariKedua = Carbon::createFromTimeString('00:00');
                $endHariKedua = Carbon::parse($shiftDipilih->jam_pulang)->addHours(5)->format('H:i');

                if (Carbon::now()->between($startHariKedua, $endHariKedua)) {
                    $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $shiftDipilih->jam_pulang)->format('H:i:s');
                    $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . Carbon::now()->format('H:i:s'))->format('H:i:s');

                    // Pilih shift sesuai absen hari ini, dan user yg melakukan absen, Menentukan absen pada sebelum jam pulang
                    if (($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && $waktuMasuk < $waktuShift)) {
                        if (Carbon::now()->diffInHours($waktuMasuk) <= 4) {
                            return 3;
                        }
                        return 2;
                    }

                    // Jika absen pulang melebihi 2 jam dan user belum absen, reset absen tersebut
                    if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) > 12) {
                        return 1;
                    }

                    // Jika absen pulang melebihi jam 9 dan user sudah melakukan absen, reset absen tersebut
                    if ($cekAbsenMasukHariIni->tgl_pulang != null && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) > 12) {
                        return 1;
                    }

                    // Jika belum absen pulang
                    if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::parse($cekAbsenMasukHariIni->created_at)->diffInHours(Carbon::now()) < 12) {
                        return 2;
                    }
                }
                return 1;
            } else {
                $cekAbsenMasukHariIni = Absen::where('user_id', auth()->user()->id)
                    ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                    ->first();

                // Jika belum absen masuk
                if ($cekAbsenMasukHariIni == null) {
                    return 1;
                }

                // Pilih shift sesuai absen hari ini, dan user yg melakukan absen, Menentukan absen pada sebelum jam pulang
                $shiftYangDipilih = Shift::find($cekAbsenMasukHariIni->shift_id);
                if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00" && Carbon::now()->format('H:i:s') <= Carbon::parse($shiftYangDipilih->jam_pulang)->format('H:i:s')) {
                    return 3;
                }

                // Jika belum absen pulang
                if ($cekAbsenMasukHariIni->tgl_pulang == "0000-00-00") {
                    return 2;
                }
            }

            return 0;
        }

        return 0;
    }

    private function cekAlfa()
    {
        $absen = Absen::where('jam_pulang', "00:00:00")->whereNot('status', 'Cuti')->whereNot('status', 'Ijin')->get();
        foreach ($absen as $item) {
            if (Carbon::parse($item->created_at)->diffInHours(Carbon::now()) > 12) {
                $item->update([
                    'status' => "Alfa",
                    'keterangan' => $item->keterangan . ", Belum Melakukan Absen Pulang"
                ]);
            }
        }
    }

    public function printModel1(Request $request)
    {
        $absen = Absen::select('absen.tgl_masuk', 'absen.status', 'shift.nama as shift_nama', 'shift.jam_masuk as shiftMasuk', 'shift.jam_pulang as shiftPulang', 'users.name')
            ->join('shift', 'absen.shift_id', '=', 'shift.id')
            ->join('users', 'absen.user_id', '=', 'users.id')
            ->orderBy('tgl_masuk', 'DESC');

        $absen->whereYear('tgl_masuk', '=', $request->tahun);
        $absen->where('user_id', $request->user_id);
        $user = User::select('users.name', 'users.email', 'users.telp', 'users.alamat_ktp', 'users.alamat_dom', 'lokasi.nama_bandara', 'lokasi.lokasi_proyek', 'regional.nama')
            ->join('lokasi', 'users.lokasi_id', '=', 'lokasi.id')
            ->join('regional', 'lokasi.regional_id', '=', 'regional.id')
            ->find($request->user_id);

        if (count($absen->get()) == null) {
            toast('Belum ada absen pada tahun tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        $data = json_encode($absen->get(), true);

        $pdf = PDF::loadView('components.print-layouts.absen.model1', ['absen' => $data, 'user' => $user, 'tahun' => $request->tahun])->setPaper('a4', 'landscape');
        return $pdf->stream('absensi_' . $user->name . '_' . $request->tahun . '.pdf');
    }

    public function printModel2(Request $request)
    {
        $data['Alfa'] = Absen::groupBy('user_id')->where('status', 'Alfa')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status',  DB::raw('count("") as total'))->get();
        $data['Cuti'] = Absen::groupBy('user_id')->where('status', 'Cuti')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status',  DB::raw('count("") as total'))->get();
        $data['Izin'] = Absen::groupBy('user_id')->where('status', 'Izin')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status',  DB::raw('count("") as total'))->get();
        $data['Sakit'] = Absen::groupBy('user_id')->where('status', 'Sakit')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status',  DB::raw('count("") as total'))->get();
        $data['Normal'] = Absen::groupBy('user_id')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status', DB::raw('count("") as total'))->get();
        $data['Terlambat'] = Absen::groupBy('user_id')->where('status', 'Terlambat')->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])->select('user_id', 'status', DB::raw('count("") as total'))->get();

        $absen = Absen::whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])
            ->select('status', 'potongan', 'shift.terlambat_1', 'shift.terlambat_2', 'shift.terlambat_3', 'shift.potongan_1', 'shift.potongan_2', 'shift.potongan_3')
            ->join('shift', 'absen.shift_id', '=', 'shift.id')
            ->where('status', 'Terlambat')
            ->get();

        $users = new User();
        $result = array();

        foreach ($data['Normal'] as $value) {
            $user = $users->select('name')->find($value->user_id);
            $result[$user->name]['Normal'] = $value->total;
        }

        foreach ($data['Terlambat'] as $value) {
            $user = $users->select('id', 'name')->find($value->user_id);
            $result[$user->name]['Terlambat'] = $value->total;
            $result[$user->name]['Potongan'] = $this->pemotonganKeterlambatan($user->id, [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')]);
        }

        foreach ($data['Alfa'] as $value) {
            $user = $users->select('name')->find($value->user_id);
            $result[$user->name]['Alfa'] = $value->total;
        }

        foreach ($data['Cuti'] as $value) {
            $user = $users->select('name')->find($value->user_id);
            $result[$user->name]['Cuti'] = $value->total;
        }

        foreach ($data['Izin'] as $value) {
            $user = $users->select('name')->find($value->user_id);
            $result[$user->name]['Izin'] = $value->total;
        }

        foreach ($data['Sakit'] as $value) {
            $user = $users->select('name')->find($value->user_id);
            $result[$user->name]['Sakit'] = $value->total;
        }

        if (count($result) == null) {
            toast('Belum ada absen pada tahun tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        // dd($result);

        $pdf = PDF::loadView('components.print-layouts.absen.model2', ['user' => $result, 'start' => Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y'), 'end' => Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y')])->setPaper('a4', 'landscape');
        return $pdf->stream('rekap_absensi_karyawan_(' . Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y') . ' - ' . Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y') . ').pdf');
    }

    // Fungsi pengecekan pemotongan sesuai keterlambatan absen
    private function pemotonganKeterlambatan($userId = null, $rangeDate = null)
    {
        $absen = Absen::select('status', 'potongan', 'shift.terlambat_1', 'shift.terlambat_2', 'shift.terlambat_3', 'shift.potongan_1', 'shift.potongan_2', 'shift.potongan_3')
            ->join('shift', 'absen.shift_id', '=', 'shift.id')
            ->where('user_id', $userId == null ? auth()->user()->id : $userId)
            ->where('status', 'Terlambat');

        if ($rangeDate != null) {
            $absen->whereBetween('tgl_masuk', $rangeDate);
        } else {
            $absen->whereMonth('tgl_masuk', Carbon::now()->format('m'));
        }

        $result = $this->perhitunganPemotongan($absen->get());

        $result['total'] = $result['potongan_1'] + $result['potongan_2'] + $result['potongan_3'];

        return $result;
    }

    private function perhitunganPemotongan($absen)
    {
        $data['terlambat_1'] = 0;
        $data['waktu_1'] = 0;
        $data['potongan_1'] = 0;

        $data['terlambat_2'] = 0;
        $data['waktu_2'] = 0;
        $data['potongan_2'] = 0;

        $data['terlambat_3'] = 0;
        $data['waktu_3'] = 0;
        $data['potongan_3'] = 0;

        foreach ($absen as $value) {
            $data['waktu_1'] = $value->terlambat_1;
            $data['waktu_2'] = $value->terlambat_2;
            $data['waktu_3'] = $value->terlambat_3;

            if ($value->potongan == 1) {
                $data['terlambat_1'] += 1;
                $data['potongan_1'] += $value->potongan_1;
            }
            if ($value->potongan == 2) {
                $data['terlambat_2'] += 1;
                $data['potongan_2'] += $value->potongan_2;
            }
            if ($value->potongan == 3) {
                $data['terlambat_3'] += 1;
                $data['potongan_3'] += $value->potongan_3;
            }

            if ($value->potongan == 0) {
                continue;
            }
        }

        return $data;
    }
}
