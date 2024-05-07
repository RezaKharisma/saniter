<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Regional;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pengaturan.shift.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regional = Regional::select('id', 'nama')->get();
        $timezones = $this->timezones();
        return view('pengaturan.shift.create', compact('regional', 'timezones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regional_id' => 'required',
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'timezone' => 'required',
        ], ['jam_masuk.required' => 'jam masuk wajib diisi.', 'jam_pulang.required' => 'jam pulang wajib diisi.', 'regional_id.required' => 'regional wajib diisi.']);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()->withInput()->withErrors($validator);
        }

        Shift::create([
            'regional_id' => $request->regional_id,
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'terlambat_1' => $request->terlambat_1,
            'terlambat_2' => $request->terlambat_2,
            'terlambat_3' => $request->terlambat_3,
            'potongan_1' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_1)),
            'potongan_2' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_2)),
            'potongan_3' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_3)),
            'is_diff_day' => $request->is_diff_day == "on" ? 1 : 0,
            'timezone' => $request->timezone
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('shift.index'); // Redirect kembali
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->can('shift_update')) {
            $regional = Regional::select('id', 'nama')->get();
            $shift = Shift::find($id);
            $timezones = $this->timezones();
            return view('pengaturan.shift.edit', compact('regional', 'shift', 'timezones'));
        }

        toast('Oops, anda tidak memiliki akses!', 'warning');
        return Redirect::route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'regional_id' => 'required',
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'timezone' => 'required',
        ], ['jam_masuk.required' => 'jam masuk wajib diisi.', 'jam_pulang.required' => 'jam pulang wajib diisi.', 'regional_id.required' => 'regional wajib diisi.']);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $shift = Shift::find($id);
        $data = [
            'regional_id' => $request->regional_id,
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'terlambat_1' => $request->terlambat_1,
            'terlambat_2' => $request->terlambat_2,
            'terlambat_3' => $request->terlambat_3,
            'potongan_1' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_1)),
            'potongan_2' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_2)),
            'potongan_3' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->potongan_3)),
            'is_diff_day' => $request->is_diff_day == "on" ? 1 : 0,
            'timezone' => $request->timezone
        ];
        $shift->update($data);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('shift.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari berdasarkan id pada tabel shift, kemudian delete
        $shift = Shift::find($id);
        $shift->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('shift.index'); // Redirect kembali
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
