<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regional = Regional::Select('*')->get();

        return view('pengaturan.regional.index', compact('regional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timezones = $this->timezones();
        return view('pengaturan.regional.create', compact('timezones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $regional = Regional::find($id);
        $timezones = $this->timezones();
        return view('pengaturan.regional.edit', compact('regional','timezones'));


    }

    /**
     * Store a newly created resource in storage.
     */
    // Untuk menambahkan data regional kedalam database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:regional,nama',
            'latitude' => 'required',
            'longitude' => 'required',
            'timezone' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        Regional::create([
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timezone' => $request->timezone
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('regional.index'); // Redirect kembali
    }

    // Untuk menghapus data regional
    public function delete($id)
    {
        $regional = Regional::findOrFail($id);
        $regional->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('regional.index'); // Redirect kembali
    }

    // Untuk proses update data Regional
    public function update(Request $request, $id)
    {
        // Mengambil request dari submit form
        $validator = Validator::make($request->all(),[
                // Validasi & ambil semua request
                'nama' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'timezone' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $regional = Regional::find($id); // Where user = $id
        $data = [
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timezone' => $request->timezone
        ];
        // dd($regional);
        $regional->update($data); // Update data

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('regional.index'); // Redirect kembali
    }

    public function timezones()
    {
        return $timeZone = [
            ["America/New_York", "GMT-4"],
            ["America/Los_Angeles", "GMT-7"],
            ["Europe/London", "GMT+1"],
            ["Europe/Paris", "GMT+2"],
            ["Asia/Tokyo", "GMT+9"],
            ["Asia/Shanghai", "GMT+8"],
            ["Asia/Dubai", "GMT+4"],
            ["Australia/Sydney", "GMT+10"],
            ["Australia/Melbourne", "GMT+10"],
            ["Asia/Singapore", "GMT+8"],
            ["America/Chicago", "GMT-5"],
            ["America/Toronto", "GMT-4"],
            ["Europe/Berlin", "GMT+2"],
            ["Europe/Madrid", "GMT+2"],
            ["America/Mexico_City", "GMT-5"],
            ["America/Buenos_Aires", "GMT-3"],
            ["Asia/Hong_Kong", "GMT+8"],
            ["Asia/Seoul", "GMT+9"],
            ["Asia/Jakarta", "GMT+7"],
            ["Africa/Johannesburg", "GMT+2"],
        ];
    }
}
