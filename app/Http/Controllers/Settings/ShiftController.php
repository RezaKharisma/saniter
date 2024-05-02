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
        $regional = Regional::select('id','nama')->get();
        $timezones = $this->timezones();
        return view('pengaturan.shift.create', compact('regional','timezones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'regional_id' => 'required',
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'timezone' => 'required',
        ], ['jam_masuk.required' => 'jam masuk wajib diisi.','jam_pulang.required' => 'jam pulang wajib diisi.','regional_id.required' => 'regional wajib diisi.']);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!','error');
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
            $regional = Regional::select('id','nama')->get();
            $shift = Shift::find($id);
            $timezones = $this->timezones();
            return view('pengaturan.shift.edit', compact('regional','shift','timezones'));
        }

        toast('Oops, anda tidak memiliki akses!', 'warning');
        return Redirect::route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'regional_id' => 'required',
            'nama' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'timezone' => 'required',
        ], ['jam_masuk.required' => 'jam masuk wajib diisi.','jam_pulang.required' => 'jam pulang wajib diisi.','regional_id.required' => 'regional wajib diisi.']);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!','error');
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
            ["GMT-12:00", "International Date Line West"],
            ["GMT-11:00", "Coordinated Universal Time-11"],
            ["GMT-10:00", "Hawaii"],
            ["GMT-09:00", "Alaska"],
            ["GMT-08:00", "Baja California"],
            ["GMT-08:00", "Pacific Time (US and Canada)"],
            ["GMT-07:00", "Chihuahua, La Paz, Mazatlan"],
            ["GMT-07:00", "Arizona"],
            ["GMT-07:00", "Mountain Time (US and Canada)"],
            ["GMT-06:00", "Central America"],
            ["GMT-06:00", "Central Time (US and Canada)"],
            ["GMT-06:00", "Saskatchewan"],
            ["GMT-06:00", "Guadalajara, Mexico City, Monterey"],
            ["GMT-05:00", "Bogota, Lima, Quito"],
            ["GMT-05:00", "Indiana (East)"],
            ["GMT-05:00", "Eastern Time (US and Canada)"],
            ["GMT-04:30", "Caracas"],
            ["GMT-04:00", "Atlantic Time (Canada)"],
            ["GMT-04:00", "Asuncion"],
            ["GMT-04:00", "Georgetown, La Paz, Manaus, San Juan"],
            ["GMT-04:00", "Cuiaba"],
            ["GMT-04:00", "Santiago"],
            ["GMT-03:30", "Newfoundland"],
            ["GMT-03:00", "Brasilia"],
            ["GMT-03:00", "Greenland"],
            ["GMT-03:00", "Cayenne, Fortaleza"],
            ["GMT-03:00", "Buenos Aires"],
            ["GMT-03:00", "Montevideo"],
            ["GMT-02:00", "Coordinated Universal Time-2"],
            ["GMT-01:00", "Cape Verde"],
            ["GMT-01:00", "Azores"],
            ["GMT+00:00", "Casablanca"],
            ["GMT+00:00", "Monrovia, Reykjavik"],
            ["GMT+00:00", "Dublin, Edinburgh, Lisbon, London"],
            ["GMT+00:00", "Coordinated Universal Time"],
            ["GMT+01:00", "Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna"],
            ["GMT+01:00", "Brussels, Copenhagen, Madrid, Paris"],
            ["GMT+01:00", "West Central Africa"],
            ["GMT+01:00", "Belgrade, Bratislava, Budapest, Ljubljana, Prague"],
            ["GMT+01:00", "Sarajevo, Skopje, Warsaw, Zagreb"],
            ["GMT+01:00", "Windhoek"],
            ["GMT+02:00", "Athens, Bucharest, Istanbul"],
            ["GMT+02:00", "Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius"],
            ["GMT+02:00", "Cairo"],
            ["GMT+02:00", "Damascus"],
            ["GMT+02:00", "Amman"],
            ["GMT+02:00", "Harare, Pretoria"],
            ["GMT+02:00", "Jerusalem"],
            ["GMT+02:00", "Beirut"],
            ["GMT+03:00", "Baghdad"],
            ["GMT+03:00", "Minsk"],
            ["GMT+03:00", "Kuwait, Riyadh"],
            ["GMT+03:00", "Nairobi"],
            ["GMT+03:30", "Tehran"],
            ["GMT+04:00", "Moscow, St. Petersburg, Volgograd"],
            ["GMT+04:00", "Tbilisi"],
            ["GMT+04:00", "Yerevan"],
            ["GMT+04:00", "Abu Dhabi, Muscat"],
            ["GMT+04:00", "Baku"],
            ["GMT+04:00", "Port Louis"],
            ["GMT+04:30", "Kabul"],
            ["GMT+05:00", "Tashkent"],
            ["GMT+05:00", "Islamabad, Karachi"],
            ["GMT+05:30", "Sri Jayewardenepura Kotte"],
            ["GMT+05:30", "Chennai, Kolkata, Mumbai, New Delhi"],
            ["GMT+05:45", "Kathmandu"],
            ["GMT+06:00", "Astana"],
            ["GMT+06:00", "Dhaka"],
            ["GMT+06:00", "Yekaterinburg"],
            ["GMT+06:30", "Yangon"],
            ["GMT+07:00", "Bangkok, Hanoi, Jakarta"],
            ["GMT+07:00", "Novosibirsk"],
            ["GMT+08:00", "Krasnoyarsk"],
            ["GMT+08:00", "Ulaanbaatar"],
            ["GMT+08:00", "Beijing, Chongqing, Hong Kong, Urumqi"],
            ["GMT+08:00", "Perth"],
            ["GMT+08:00", "Kuala Lumpur, Singapore"],
            ["GMT+08:00", "Taipei"],
            ["GMT+09:00", "Irkutsk"],
            ["GMT+09:00", "Seoul"],
            ["GMT+09:00", "Osaka, Sapporo, Tokyo"],
            ["GMT+09:30", "Darwin"],
            ["GMT+09:30", "Adelaide"],
            ["GMT+10:00", "Hobart"],
            ["GMT+10:00", "Yakutsk"],
            ["GMT+10:00", "Brisbane"],
            ["GMT+10:00", "Guam, Port Moresby"],
            ["GMT+10:00", "Canberra, Melbourne, Sydney"],
            ["GMT+11:00", "Vladivostok"],
            ["GMT+11:00", "Solomon Islands, New Caledonia"],
            ["GMT+12:00", "Coordinated Universal Time+12"],
            ["GMT+12:00", "Fiji, Marshall Islands"],
            ["GMT+12:00", "Magadan"],
            ["GMT+12:00", "Auckland, Wellington"],
            ["GMT+13:00", "Nuku'alofa"],
            ["GMT+13:00", "Samoa"]
        ];
    }
}
