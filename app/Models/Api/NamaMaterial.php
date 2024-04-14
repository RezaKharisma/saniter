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

        $result = json_decode($response->getBody()->getContents(),true);
        $this->stokmaterial = $result['stokmaterial'];
    }

    public function getAllMaterial(){
        return $this->stokmaterial;
    }

    public function getNamaMaterialById($id){
        $data = array();
        foreach ($this->stokmaterial as $row) {
            if ($row['id'] == $id) {
                $dataRow['id'] = $row['id'];
                $dataRow['brand'] = $row['brand'];
                $dataRow['harga_beli'] = $row['harga_beli'];
                $dataRow['harga_modal'] = $row['harga_modal'];
                $dataRow['jenis_material'] = $row['jenis_material'];
                $dataRow['jenis_pekerjaan'] = $row['jenis_pekerjaan'];
                $dataRow['kode_material'] = $row['kode_material'];
                $dataRow['nama_material'] = $row['nama_material'];
                $dataRow['nama_perusahaan'] = $row['nama_perusahaan'];
                $dataRow['qty'] = $row['qty'];
                array_push($data, $dataRow);
                break;
            }
        }
        return $data[0];
    }
}
