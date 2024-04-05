<?php

namespace App\Models\Api;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class NamaMaterial extends Model
{
    use HasFactory;

    private $_client;

    private $stokmaterial = array();

    // protected $table = 'nama_material';
    // protected $guarded = ['id'];

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'https://api.qrm15.com/logistik/liststockmaterial',
            'http_errors' => false,
            'protocols'       => ['http', 'https']
        ]);

        $response = $this->_client->request('GET', 'liststockmaterial',[
            'query' => [
                'q-tech-KEY'    => 'Qrm!5@Bali123'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        $this->stokmaterial = $result['stokmaterial'];
    }

    public function getAllMaterial(){
        return $this->stokmaterial;
    }

    public function getNamaMaterialById($id){
        $data = array();
        foreach ($this->stokmaterial as $row) {
            if ($row['id'] == $id) {
                array_push($data, $row);
                break;
            }
        }
        return $data[0];
    }
}
