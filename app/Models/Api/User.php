<?php

namespace App\Models\Api;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{
    use HasFactory;

    public $table = 'user-api';

    protected $guarded = [];

    // Jika perlu, tentukan base URL untuk API pengguna
    protected $baseUrl = 'https://api.qrm15.com/user/list_karyawan';

    // Implementasi metode untuk mendapatkan pengguna berdasarkan kredensial
    public static function attempt(array $credentials)
    {
        $response = Http::post(static::resolveUrl('login'), $credentials);

        if ($response->successful()) {
            return new static($response->json());
        }

        return null;
    }

    // Implementasi metode untuk mendapatkan pengguna berdasarkan token
    public static function findByToken($token)
    {
        $response = Http::withToken($token)->get(static::resolveUrl('user'));

        if ($response->successful()) {
            return new static($response->json());
        }

        return null;
    }

    // Resolve URL untuk request API
    protected static function resolveUrl($endpoint)
    {
        return rtrim(static::$baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }


    // private $_client;

    // public function __construct()
    // {
    //     $this->_client = new Client([
    //         'base_uri' => 'https://api.qrm15.com/user/list_karyawan',
    //         'http_errors' => false,
    //         'protocols'       => ['http', 'https']
    //     ]);
    // }

    // protected function getAPI()
    // {
    //     $response = $this->_client->request('GET', 'users',[
    //         'query' => [
    //             'q-tech-KEY'    => 'Qrm!5@Bali123'
    //         ]
    //     ]);

    //     $result = json_encode($response->getBody()->getContents(), true);
    //     return $result;
    // }
}
