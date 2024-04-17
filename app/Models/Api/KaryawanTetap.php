<?php

namespace App\Models\Api;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanTetap extends Model
{
    use HasFactory;

    private $_client;

    private $karyawanTetap = array();

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'https://api.qrm15.com/user/list_karyawan',
            'http_errors' => false,
            'protocols'       => ['http', 'https']
        ]);

        $response = $this->_client->request('GET', 'users',[
            'query' => [
                'q-tech-KEY'    => 'Qrm!5@Bali123'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        $this->karyawanTetap = $result['data'];
    }

    public function getAllKaryawanTetap(){
        return $this->karyawanTetap;
    }

    public function getKaryawanTetapById($id){
        try
        {
            $data = array();
            foreach ($this->karyawanTetap as $row) {
                if ($row['id'] == $id) {
                    array_push($data, $row);
                    break;
                }
            }
            return $data[0];
        }
        catch(\Exception $e)
        {
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
}
