<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Regional;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Role;

class FortifyServiceProvider extends ServiceProvider
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'https://api.qrm15.com/user/list_karyawan',
            'http_errors' => false,
            'protocols'       => ['http', 'https']
            //   'auth'  => ['public', 'qrm15@bali123']
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $response = $this->_client->request('GET', 'users',[
                'query' => [
                    'q-tech-KEY'    => 'Qrm!5@Bali123'
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            $user = $result['data'];

            foreach($user as $item)
            {
                $userApi = $request->email === $item['email'];

                if ($userApi && Hash::check($request->password, $item['password'])) {

                    $role = Role::where('name', $item['role'])->first();
                    if ($role == null) {
                        $role = Role::create(['name' => $item['role']]);
                    }

                    $regional = Regional::where('nama', $item['regional'])->first();
                    if($regional == null){
                        $regional = Regional::create([
                            'nama' => $item['regional'],
                            'latitude' => 0,
                            'longitude' => 0,
                        ]);
                    }

                    $cekUser = User::where('email', $item['email'])->first();
                    if ($cekUser == null) {
                        $user = User::updateOrCreate([
                            'regional_id' => $regional->id,
                            'lokasi_id' => 1,
                            'role_id' => $role->id,
                            'name' => $item['name'],
                            'email' => $item['email'],
                            'nik' => $item['no_ktp'],
                            'alamat_ktp' => $item['alamat_ktp'],
                            'alamat_dom' => $item['alamat_domisili'],
                            'telp' => $item['no_telp'],
                            'foto' => 'user-images/default.jpg',
                            'password' => $item['password'],
                            'ttd' => 'user-ttd/default.jpg',
                            'is_active' => 1,
                            'status' => 'Tetap'
                        ]);
                        $user->assignRole($role->name);
                        return $user;
                    }

                    return $cekUser;
                }
            }

            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->is_active == false) {
                    throw ValidationException::withMessages(['email' => 'Saat ini akun anda tidak aktif. Hubungi administrator situs untuk mengaktifkannya.']);
                }
                return $user;
            }
        });

        $this->configureRoutes();
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group([
            'namespace' => 'Laravel\Fortify\Http\Controllers',
            'domain' => config('fortify.domain', null),
            'prefix' => config('fortify.prefix'),
        ], function () {
            $this->loadRoutesFrom(base_path('routes/fortify.php'));
        });
    }
}
