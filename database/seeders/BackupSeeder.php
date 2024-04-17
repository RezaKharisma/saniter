<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\AreaList;
use App\Models\KategoriMenu;
use App\Models\Lokasi;
use App\Models\Menu;
use App\Models\Regional;
use App\Models\Shift;
use App\Models\StokMaterial;
use App\Models\SubMenu;
use App\Models\TglKerja;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BackupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* `db_saniter`.`absen` */
        $absen = array(
        );

        /* `db_saniter`.`area` */
        $area = array(
            array('id' => '2','regional_id' => '3','nama' => 'Domestik','created_at' => '2024-04-09 06:49:59','updated_at' => '2024-04-09 07:19:23'),
            array('id' => '3','regional_id' => '3','nama' => 'International','created_at' => '2024-04-09 06:55:44','updated_at' => '2024-04-09 06:55:44'),
            array('id' => '4','regional_id' => '1','nama' => 'Domestik','created_at' => '2024-04-09 08:32:57','updated_at' => '2024-04-09 08:32:57')
        );

        /* `db_saniter`.`detail_jenis_kerusakan` */
        $detail_jenis_kerusakan = array(
        );

        /* `db_saniter`.`detail_tgl_kerja` */
        $detail_tgl_kerja = array(
        );

        /* `db_saniter`.`failed_jobs` */
        $failed_jobs = array(
        );

        /* `db_saniter`.`foto_kerusakan` */
        $foto_kerusakan = array(
        );

        /* `db_saniter`.`izin` */
        $izin = array(
        );

        /* `db_saniter`.`jenis_kerusakan` */
        $jenis_kerusakan = array(
        );

        /* `db_saniter`.`jumlah_izin` */
        $jumlah_izin = array(
        );

        /* `db_saniter`.`list_area` */
        $list_area = array(
        array('id' => '1','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 01 Pria','denah' => 'denah/cuyFKkLzVdKV5i3KrzpVWxfKttCF1url83vjSobR.jpg','created_at' => '2022-06-23 11:42:49','updated_at' => '2022-12-07 09:56:56'),
        array('id' => '2','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 01 Wanita','denah' => 'denah/BoyfMDmXt7AoCbeOSG0KFfrxchgD48fxjju1pN1U.jpg','created_at' => '2022-06-23 11:43:09','updated_at' => '2022-12-07 09:57:03'),
        array('id' => '3','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 02 Pria','denah' => 'denah/i3wXWTfbKomnEw1VEgpvKk3AFzCUnl1e1bS9y7Dq.jpg','created_at' => '2022-06-23 11:43:28','updated_at' => '2022-12-07 09:57:12'),
        array('id' => '4','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 02 Wanita','denah' => 'denah/hV150vw0wOWRbYlG0W55bdkuP7c53t3W27DDssRQ.jpg','created_at' => '2022-06-23 11:43:45','updated_at' => '2022-12-07 09:58:49'),
        array('id' => '5','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 03 Pria','denah' => 'denah/SyhieU4I4RHJyHAkZkzFSA76ce2kvIdyZX3L3IH5.jpg','created_at' => '2022-06-23 11:43:59','updated_at' => '2022-11-19 11:47:41'),
        array('id' => '6','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 03 Wanita','denah' => 'denah/prkynMA1itH9tIXv5Hfq1WzeqSehHAVD3JIhou3u.jpg','created_at' => '2022-06-23 11:44:08','updated_at' => '2022-11-19 11:47:56'),
        array('id' => '7','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 04 Pria','denah' => 'denah/ALIPox4OWCxrPgKGDSivYXv6DXeNHq8LrKx5kdTJ.jpg','created_at' => '2022-06-23 11:44:21','updated_at' => '2022-11-19 11:49:34'),
        array('id' => '8','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 AD 04 Wanita','denah' => 'denah/m8KGKvir2AB7btkBlWipq1YT6HTnNllP8aqT0IH3.jpg','created_at' => '2022-06-23 11:44:32','updated_at' => '2022-11-19 11:50:02'),
        array('id' => '9','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 Check In Barat Pria','denah' => 'denah/RzSTRr2yMPxHpbu0XLzPNwnDUPv9GDCXA3TEfMgv.jpg','created_at' => '2022-06-23 11:45:42','updated_at' => '2022-11-19 11:50:22'),
        array('id' => '10','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 Check In Barat Wanita','denah' => 'denah/ErVUyMNQsaMlswLiPIaMx0koCr0AH1XQjKHqVQ9g.jpg','created_at' => '2022-06-23 11:46:07','updated_at' => '2022-11-19 11:50:38'),
        array('id' => '11','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 Check In Timur Pria','denah' => 'denah/5KypWRZWftVIhQfsbxeP04GUj00H8Ft50h7tiLKS.jpg','created_at' => '2022-06-23 11:46:16','updated_at' => '2022-11-19 11:50:54'),
        array('id' => '12','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 Check In Timur Wanita','denah' => 'denah/JWOmyOT2Blq18OgllNA2uNVV0wgYzuuAFmPJZTZR.jpg','created_at' => '2022-06-23 11:46:33','updated_at' => '2022-11-19 11:51:12'),
        array('id' => '13','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DD 03 Pria','denah' => 'denah/A7ajNTDi9uMEtzhlwAb5Xfq8ek0u0l6kQr4HwTTh.png','created_at' => '2022-06-23 11:46:44','updated_at' => '2022-11-19 14:48:13'),
        array('id' => '14','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DD 03 Wanita','denah' => 'denah/ClZAOieyKu0PDar7gbjZMd98CMz2GNWfoL6mf7WV.png','created_at' => '2022-06-23 11:47:04','updated_at' => '2022-11-19 14:48:30'),
        array('id' => '15','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DD 02 Pria','denah' => 'denah/uDVwnDy5eOgM1Z27I2wqIjmZAdIjcYW6wMo7grsB.jpg','created_at' => '2022-06-23 11:47:30','updated_at' => '2022-11-19 11:54:17'),
        array('id' => '16','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DD 02 Wanita','denah' => 'denah/iL3o5iWL7p7sLI1nVp1GxbyHcGE9K8svDsK5CatI.jpg','created_at' => '2022-06-23 11:47:41','updated_at' => '2022-11-19 11:54:34'),
        array('id' => '17','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DS 01 Pria','denah' => 'denah/pjC9mt0S4EsMVUfZe5XisGIby5cVyLHWUipKebsj.jpg','created_at' => '2022-06-23 11:47:57','updated_at' => '2022-11-19 11:55:03'),
        array('id' => '18','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DS 01 Wanita','denah' => 'denah/l8kqyl9Faikj3A8N5gC2ncBO2hcR7VYgpn0rTogM.jpg','created_at' => '2022-06-23 11:48:06','updated_at' => '2022-11-19 11:55:19'),
        array('id' => '19','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DS 02 Pria','denah' => 'denah/FWpe90gzIdHRmJuIgalBfJqBuTYtpdqcCyeotdZ7.jpg','created_at' => '2022-06-23 11:48:18','updated_at' => '2022-11-21 09:42:56'),
        array('id' => '20','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 DS 02 Wanita','denah' => 'denah/SlrnHXfYLVMb2jOtl2FM6FlYpRxjroWTNCFOs5Np.jpg','created_at' => '2022-06-23 11:48:33','updated_at' => '2022-11-21 09:43:54'),
        array('id' => '21','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 01 Pria','denah' => 'denah/bixea5tw6f0HEInsqYxoeb4CT6ZmMrNVruhZ0hA8.jpg','created_at' => '2022-06-23 11:48:41','updated_at' => '2022-11-19 11:56:30'),
        array('id' => '22','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 01 Wanita','denah' => 'denah/02xr4zH4RqoDqwfxQY0lyyqW3kzDBQBhPZU8WQCX.jpg','created_at' => '2022-06-23 11:48:51','updated_at' => '2022-11-19 11:56:55'),
        array('id' => '23','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 02 Pria','denah' => 'denah/sHGvTMmYRfereLs61WfUNzZ9KgoDDywE0GNPdyz8.jpg','created_at' => '2022-06-23 11:49:00','updated_at' => '2022-11-19 11:57:17'),
        array('id' => '24','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 02 Wanita','denah' => 'denah/qiXq8f9e9MLS1UQaHpFJ3EbLmHHjeAjzS6fp7cOj.jpg','created_at' => '2022-06-23 11:49:07','updated_at' => '2022-11-19 11:57:35'),
        array('id' => '25','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 03 Pria','denah' => 'denah/CvqtODSc5Vn2e2WOjaogBCinjSVVpS4QNNvG863O.jpg','created_at' => '2022-06-23 11:49:17','updated_at' => '2022-11-19 14:48:57'),
        array('id' => '26','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 03 Wanita','denah' => 'denah/EdOWUXltNhn2o0wJ1cv4r3qKl0owzzoOJIO8eoPV.jpg','created_at' => '2022-06-23 11:49:33','updated_at' => '2022-11-21 09:44:26'),
        array('id' => '27','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 04 Pria','denah' => 'denah/qdE36H1fp0VGWibg5fDQAo5W4bRkdE1SVTM8wseC.jpg','created_at' => '2022-06-23 11:49:43','updated_at' => '2022-11-21 09:44:58'),
        array('id' => '28','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 GHD 04 Wanita','denah' => 'denah/NStdSu0ryrg4xZrPLzk67U34Cl6buV3cn9d4IxhD.jpg','created_at' => '2022-06-23 11:49:54','updated_at' => '2022-11-21 09:45:16'),
        array('id' => '29','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 TD 01 Pria','denah' => 'denah/Ib816786Uv0dE4GOQFs8xZ6BGndRrmoqWHpnsNSU.jpg','created_at' => '2022-06-23 11:50:23','updated_at' => '2022-11-19 11:58:41'),
        array('id' => '30','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet 1 TD 01 Wanita','denah' => 'denah/2FqZ9k6erKzASfWUukv3xTgoB1jcdZMx3KpqM87S.jpg','created_at' => '2022-06-23 12:17:27','updated_at' => '2022-11-19 11:58:56'),
        array('id' => '31','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 04 Pria','denah' => 'denah/YhNyC9wpp7zohV7k88tR1aYM8tB1LkwNTfsiJvSq.jpg','created_at' => '2022-06-23 12:17:40','updated_at' => '2022-11-19 12:01:29'),
        array('id' => '32','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 04 Wanita','denah' => 'denah/pB19f3FP9LO6HwB4dXlqKc8s2Ya0V6DRRFxxib5U.jpg','created_at' => '2022-06-23 12:17:49','updated_at' => '2022-11-19 12:01:51'),
        array('id' => '33','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 05 Pria','denah' => 'denah/4kdwEwJJp09emdpoZNfGzuGbTyKv9BGMj92vDFoF.jpg','created_at' => '2022-06-23 12:18:33','updated_at' => '2022-11-19 13:01:46'),
        array('id' => '34','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 05 Wanita','denah' => 'denah/GZCO2zHuYQPa2BCEIamg47uCKemrlLlfG18jVdDP.jpg','created_at' => '2022-06-23 12:18:42','updated_at' => '2022-11-19 13:02:08'),
        array('id' => '35','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 06 Pria','denah' => 'denah/GLBhcH3Hzfr1DN9apmfMfmf74eCx7oxQIqK6v5OP.jpg','created_at' => '2022-06-23 12:18:53','updated_at' => '2022-11-19 13:03:19'),
        array('id' => '36','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 06 Wanita','denah' => 'denah/Q3kQY2PHZD61ccgqCNabOsElJX2yh4j6z82z6YT8.jpg','created_at' => '2022-06-23 12:19:14','updated_at' => '2022-11-19 13:03:41'),
        array('id' => '37','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 07 Pria','denah' => 'denah/6zabdmfCTxzQsz0DReAgEiuVmgqDxbEaZWHDJBmm.jpg','created_at' => '2022-06-23 12:19:26','updated_at' => '2022-11-19 13:04:12'),
        array('id' => '38','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD 07 Wanita','denah' => 'denah/OxmWT6Ol7PXkoI25bCDaal1aSfOgx0rDkWAqsUKx.jpg','created_at' => '2022-06-23 12:19:39','updated_at' => '2022-11-19 13:04:35'),
        array('id' => '39','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DS 02 Pria','denah' => 'denah/sQRnUxoKi6kPo3tGYwDABUrekuexEFJdsHwJJ5v3.jpg','created_at' => '2022-06-23 12:19:47','updated_at' => '2022-11-21 09:45:45'),
        array('id' => '40','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 DS 02 Wanita','denah' => 'denah/95ecOYQNKsUUrGeyxA0RxM4dL7FLwGv60gNMXXeQ.jpg','created_at' => '2022-06-23 12:19:55','updated_at' => '2022-11-21 09:46:01'),
        array('id' => '41','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 Toilet Gate 1 A Pria','denah' => 'denah/6oKJeIZZ9IJW1vlEmaihPrainNUuD6M3t3s2XQb4.jpg','created_at' => '2022-06-23 12:20:05','updated_at' => '2022-11-19 13:05:21'),
        array('id' => '42','area_id' => '1','lantai' => 'Lantai 2','nama' => 'Toilet 2 Toilet Gate 1 A Wanita','denah' => 'denah/j0l8sV1ATPzOOWB2nXs5Z179j0Aij3QWoFZuqfbS.jpg','created_at' => '2022-06-23 12:20:12','updated_at' => '2022-11-19 13:05:40'),
        array('id' => '43','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 01 Pria','denah' => 'denah/hpuFRUX58jlXllavF6SL23biPCVlqyUVX8X9fBuW.jpg','created_at' => '2022-06-23 12:20:22','updated_at' => '2022-11-21 09:46:24'),
        array('id' => '44','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 01 Wanita','denah' => 'denah/Aqa0Uxpd8NrkeoNmZNCUQiPfJVci0lV0nKOmH6MT.jpg','created_at' => '2022-06-23 12:20:31','updated_at' => '2022-11-21 09:46:39'),
        array('id' => '45','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 02 Pria','denah' => 'denah/B2lUe9WS4ujrnqCvoLnsRdwBivKO4ndaBt2lOP2Q.jpg','created_at' => '2022-06-23 12:20:39','updated_at' => '2022-11-21 09:48:13'),
        array('id' => '46','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 02 Wanita','denah' => 'denah/uBxXP8gZdvDCc0We3A8tcowYnIdYBjAXJDfKKkij.jpg','created_at' => '2022-06-23 12:20:58','updated_at' => '2022-11-21 09:48:39'),
        array('id' => '47','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 04 Pria','denah' => 'denah/54InW6wz3TjUIE6qPYut7HMfAeUiOrQKMUoklAPH.jpg','created_at' => '2022-06-23 12:21:07','updated_at' => '2022-11-21 09:48:59'),
        array('id' => '48','area_id' => '1','lantai' => 'Lantai 3','nama' => 'Toilet 3 DS 04 Wanita','denah' => 'denah/IIS90OLUULsGubfkrm8OginljpUzGFwKda8EqH7b.jpg','created_at' => '2022-06-23 12:21:14','updated_at' => '2022-11-21 09:49:34'),
        array('id' => '49','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 A Pria','denah' => 'denah/B7oB4L2IcmQyR3bs6EXWzB62hzaWYnd4stDuCCa0.jpg','created_at' => '2022-06-23 12:21:38','updated_at' => '2022-12-07 09:59:03'),
        array('id' => '50','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 A Wanita','denah' => 'denah/nqbXXhdwgmm14ryWrMSbP4P72RFmp0riSWL31hxH.jpg','created_at' => '2022-06-23 12:21:51','updated_at' => '2022-12-07 09:59:12'),
        array('id' => '51','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 B Pria','denah' => 'denah/1AXbE1JPYCJuwOdT5i7pehsZV4w08WrzbUcBGPW3.jpg','created_at' => '2022-06-23 12:22:00','updated_at' => '2022-12-07 09:59:26'),
        array('id' => '52','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 B Wanita','denah' => 'denah/vH5zqatzPerDPDxqsCUC3mYhEwEv8xHun8QZcCul.jpg','created_at' => '2022-06-23 12:22:08','updated_at' => '2022-12-07 09:59:33'),
        array('id' => '53','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 C Pria','denah' => 'denah/dG8vPlvsLB6O9CEOKpMznyxo4GKAW65NtsgUmDfB.jpg','created_at' => '2022-06-23 12:22:26','updated_at' => '2022-11-19 13:20:16'),
        array('id' => '54','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 C Wanita','denah' => 'denah/z5Y5EQ4jSd9diF9rRJ3AIudujBshnq8EfAfraaxl.jpg','created_at' => '2022-06-23 12:22:35','updated_at' => '2022-11-19 13:20:41'),
        array('id' => '55','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 D Pria','denah' => 'denah/Zq8pcasodHG2k613o6cjmajpUVvJuAUdQT33gIWM.jpg','created_at' => '2022-06-23 12:22:44','updated_at' => '2022-11-19 13:38:04'),
        array('id' => '56','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 D Wanita','denah' => 'denah/46XYoc366MKglqT4b9GlfFUbFfqms7JUMcqtT6ef.jpg','created_at' => '2022-06-23 12:22:51','updated_at' => '2022-11-19 13:38:22'),
        array('id' => '57','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 E Pria','denah' => 'denah/wj5Fdn2yVgUS4UBvTDCuoaRtd93cnQhODWdNcpsQ.jpg','created_at' => '2022-06-23 12:22:58','updated_at' => '2022-11-19 13:38:39'),
        array('id' => '58','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 E Wanita','denah' => 'denah/8BJzwlV2zzhRcfmRX6soV8tETNf9luOkSnr00fX2.jpg','created_at' => '2022-06-23 12:23:07','updated_at' => '2022-11-19 13:39:16'),
        array('id' => '59','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 F Pria','denah' => 'denah/G0yTQyGQKAuRgaYRf2FkJ8w2PY60M17L1MlVZzdH.jpg','created_at' => '2022-06-23 12:23:13','updated_at' => '2022-11-19 13:39:55'),
        array('id' => '60','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 F Wanita','denah' => 'denah/LC8lFhxIUCG6NDCCCMMtJI6Bgj5CQ22cRqQJorh7.jpg','created_at' => '2022-06-23 12:23:21','updated_at' => '2022-11-19 13:40:12'),
        array('id' => '61','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 G Pria','denah' => 'denah/FY9wgPngtR9sNNFZKX0bc3WMZy4CdxanA9iRvweV.jpg','created_at' => '2022-06-23 12:23:28','updated_at' => '2022-11-19 13:40:29'),
        array('id' => '62','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 G Wanita','denah' => 'denah/s4wbdDEArNQXk5iHns3Bb521rr3whTyVCcmLRDHm.jpg','created_at' => '2022-06-23 12:23:37','updated_at' => '2022-11-19 13:40:51'),
        array('id' => '63','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 H Pria','denah' => 'denah/hUFXesed3SZX3w7i2EEcT5D0zQYBpH6Yww84KHCj.jpg','created_at' => '2022-06-23 12:23:50','updated_at' => '2022-11-19 13:41:10'),
        array('id' => '64','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 H Wanita','denah' => 'denah/qaHgp4Cc9gkrkQBGnExMjQmvBe2m3DOBhplGDNGr.jpg','created_at' => '2022-06-23 12:23:58','updated_at' => '2022-11-19 13:41:53'),
        array('id' => '65','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 I Pria','denah' => 'denah/j8aRKZ8Fddt9slktbQNCG1r4kTOifgUpRl6ef4UH.jpg','created_at' => '2022-06-23 12:24:08','updated_at' => '2022-11-19 13:42:12'),
        array('id' => '66','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 I Wanita','denah' => 'denah/TThp7F69n2f0WW1UcHPRnyK5TGVVS5p3IeDrDSDI.jpg','created_at' => '2022-06-23 12:24:16','updated_at' => '2022-11-19 13:42:50'),
        array('id' => '67','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 J Pria','denah' => 'denah/dCLczT6kUFI5epAClsEI0uwtlSZRru4RReGRM2Nw.jpg','created_at' => '2022-06-23 12:24:30','updated_at' => '2022-11-19 13:42:31'),
        array('id' => '68','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 J Wanita','denah' => 'denah/at4JNAeYhcMn93zz8BnAunQP5LMkawSXjgoYFUSz.jpg','created_at' => '2022-06-23 12:24:41','updated_at' => '2022-11-19 13:43:08'),
        array('id' => '69','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 K Pria','denah' => 'denah/HCAlXPRmBf6UOcJvleJSDzOvO0z3XmbqwOWcwvs9.jpg','created_at' => '2022-06-23 12:24:51','updated_at' => '2022-11-19 13:43:29'),
        array('id' => '70','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 K Wanita','denah' => 'denah/vHDJLU2ws8KcfZKK37HlvsFXxNxMLmDmEjPGjpUo.jpg','created_at' => '2022-06-23 12:27:14','updated_at' => '2022-11-19 13:43:52'),
        array('id' => '71','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 L Pria','denah' => 'denah/UhvQ3AD6qDdiH7c0NNWiV2iAhe5YuKJC6PrNLMzH.jpg','created_at' => '2022-06-23 12:30:54','updated_at' => '2022-11-19 13:44:17'),
        array('id' => '72','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 L Wanita','denah' => 'denah/qjTd9Qub5FYPyn97CeryDlfntCvqA1xLvIrEmRr6.jpg','created_at' => '2022-06-23 12:31:06','updated_at' => '2022-11-19 13:44:40'),
        array('id' => '73','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 M Pria','denah' => 'denah/QEswuGMnIsbqnogs3QE0NnXCccMvN5KCPvGIxzvG.jpg','created_at' => '2022-06-23 12:31:17','updated_at' => '2022-11-19 13:44:59'),
        array('id' => '74','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 M Wanita','denah' => 'denah/YyZrot3j6ARypWuVJt50UDfUfF5ZzpmeClzgFUSe.jpg','created_at' => '2022-06-23 12:31:25','updated_at' => '2022-11-19 13:45:18'),
        array('id' => '75','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 N Pria','denah' => 'denah/1IdA1lmmNzBNSHGYiTFFo61EelrIVIJBevYp8OqJ.jpg','created_at' => '2022-06-23 12:31:37','updated_at' => '2022-11-19 13:45:41'),
        array('id' => '76','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 N Wanita','denah' => 'denah/Ou6intYxihYfbA6M7lwnkQFHpvR6uudfUpaxnHqG.jpg','created_at' => '2022-06-23 12:32:41','updated_at' => '2022-11-19 13:46:05'),
        array('id' => '77','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 O Pria','denah' => 'denah/7qyVJwFaW2ldfrgljUboNR6kOSYo7LISvRzK89OE.jpg','created_at' => '2022-06-23 12:32:49','updated_at' => '2022-11-19 13:46:30'),
        array('id' => '78','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 O Wanita','denah' => 'denah/G0Jj3j6lP34HLI4aKgkyeEc9aYUZsaiFJjH8I4Nq.jpg','created_at' => '2022-06-23 12:32:57','updated_at' => '2022-11-19 13:47:05'),
        array('id' => '79','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 P Pria','denah' => 'denah/q27GgOT9AP1cfj9K5bjWJUk3LPPiFY52RGDCp6tU.jpg','created_at' => '2022-06-23 12:33:05','updated_at' => '2022-11-19 13:47:33'),
        array('id' => '80','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet 1 P Wanita','denah' => 'denah/RmnBkV3XHJJ61PtUjffSDFJ5o7bVPZWGx84QOohk.jpg','created_at' => '2022-06-23 12:33:12','updated_at' => '2022-11-19 13:47:54'),
        array('id' => '81','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 A Pria','denah' => 'denah/2ouwZZeuIyJtKZlukb3FNlwjBzZhhodpZErY0SJX.jpg','created_at' => '2022-06-23 12:33:25','updated_at' => '2022-11-19 13:48:17'),
        array('id' => '82','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 A Wanita','denah' => 'denah/pus6IrsE9P2Jq2yXbKh0rQ3Rw4TA7cfaoHwPgaT2.jpg','created_at' => '2022-06-23 12:33:32','updated_at' => '2022-11-19 13:48:39'),
        array('id' => '83','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 B Pria','denah' => 'denah/k3lcNwAuXjnNcy55lYv21afklj5EXUT6MwWEj26o.jpg','created_at' => '2022-06-23 12:33:40','updated_at' => '2022-11-19 13:49:01'),
        array('id' => '84','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 B Wanita','denah' => 'denah/FF3UJsRrZdYXCI3ZuT5mAm11N5x7DRPloNnpJg6f.jpg','created_at' => '2022-06-23 12:33:48','updated_at' => '2022-11-19 13:49:41'),
        array('id' => '85','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 C Pria','denah' => 'denah/1OI5MToZ6GK9LFhT2p39WePSLRfdMfLqvkpDkIKD.jpg','created_at' => '2022-06-23 12:33:55','updated_at' => '2022-11-19 13:50:08'),
        array('id' => '86','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 C Wanita','denah' => 'denah/KiQiGQ22QcLAx6lnaGNhsGUVZ6IgcbVwue9vck28.jpg','created_at' => '2022-06-23 12:34:02','updated_at' => '2022-11-19 13:50:38'),
        array('id' => '87','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 D Pria','denah' => 'denah/4IeOKjXn8xWBmmlXCXz1K7UIfyQFMDiDpwbameJc.jpg','created_at' => '2022-06-23 12:34:14','updated_at' => '2022-11-19 13:51:08'),
        array('id' => '88','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 D Wanita','denah' => 'denah/XRs1Puc5byVEX1icJlAEWKvI4a6RRc75bXISKj9s.jpg','created_at' => '2022-06-23 12:34:32','updated_at' => '2022-11-19 13:51:29'),
        array('id' => '89','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 D1 Pria','denah' => 'denah/FobBedGRYGIApLgYivNAtV9daTvXSXtzVWyDVZIN.jpg','created_at' => '2022-06-23 12:34:40','updated_at' => '2022-11-19 13:51:51'),
        array('id' => '90','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 D1 Wanita','denah' => 'denah/uhJTOi0NKmVL3DHSJVD90y6LfLNdHyyvFSt253c7.jpg','created_at' => '2022-06-23 12:34:49','updated_at' => '2022-11-19 13:52:11'),
        array('id' => '91','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 E Pria','denah' => 'denah/g1lMv8qqBntL5UEgl058Spi9CddK1Mn4VrVXMMhC.jpg','created_at' => '2022-06-23 12:34:57','updated_at' => '2022-11-19 13:52:39'),
        array('id' => '92','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 E Wanita','denah' => 'denah/CSfAXTlAhvEK7FJnCEf5FlWjynukCNEvKyQh62P2.jpg','created_at' => '2022-06-23 12:35:05','updated_at' => '2022-12-07 10:08:51'),
        array('id' => '93','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 F Pria','denah' => 'denah/b0SLJEuGScHxBbn8FyShGRc9IJriTvBtZM9TdqYM.jpg','created_at' => '2022-06-23 12:35:11','updated_at' => '2022-12-07 10:08:27'),
        array('id' => '94','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 F Wanita','denah' => 'denah/cMU2ifiz0Y5IporvNugxl5pcgmXlWIXZTNuIdOAX.jpg','created_at' => '2022-06-23 12:35:19','updated_at' => '2022-12-07 10:08:17'),
        array('id' => '95','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 G Pria','denah' => 'denah/3FN3SyVnbpvFgTMuQ0kXxHNaOUoZ3KKcTL0iXcBY.jpg','created_at' => '2022-06-23 12:35:29','updated_at' => '2022-12-07 10:08:01'),
        array('id' => '96','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 G Wanita','denah' => 'denah/6z5gmZPgqxdaB2NBq1ZSYUIsD8dtZ3iGFyHdARNo.jpg','created_at' => '2022-06-23 12:35:36','updated_at' => '2022-12-07 10:07:49'),
        array('id' => '97','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 H Pria','denah' => 'denah/x60ePcJEMjfaRFZxqwMbPsbvOlQWUTmNf16J28te.jpg','created_at' => '2022-06-23 12:35:46','updated_at' => '2022-12-07 10:07:40'),
        array('id' => '98','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 H Wanita','denah' => 'denah/jumsEgZsMIilpLbUrOMj1r6t2f2TrhhEvRoHYDu6.jpg','created_at' => '2022-06-23 12:35:53','updated_at' => '2022-12-07 10:07:31'),
        array('id' => '99','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD08 Pria','denah' => 'denah/eNLEnUOz8tcjvhZ6CoKxOmvBxZkMQHl6kjWhNtAq.jpg','created_at' => '2022-06-23 12:36:00','updated_at' => '2022-12-07 10:07:23'),
        array('id' => '100','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet 2 DD08 Wanita','denah' => 'denah/mr9KWv7bQyW6c70clxTg1ZyocYZUhk5ttTQ1o0If.jpg','created_at' => '2022-06-23 12:36:10','updated_at' => '2022-12-07 10:07:13'),
        array('id' => '101','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 A Pria','denah' => 'denah/bGFzTOjBfuuzMPy3Qp1KDj7liY8Z9mJkGaoDmcaG.jpg','created_at' => '2022-06-23 12:36:31','updated_at' => '2022-12-07 10:07:04'),
        array('id' => '102','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 A Wanita','denah' => 'denah/EFjpmVLQuA41DEIeeJA3PLWz706pZEgha3L3aGur.jpg','created_at' => '2022-06-23 12:36:38','updated_at' => '2022-12-07 10:06:50'),
        array('id' => '103','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 B Pria','denah' => 'denah/FRuARv197omUQ6cIglcZQmkoW0i7Xeuj4pb3b7J2.jpg','created_at' => '2022-06-23 12:36:48','updated_at' => '2022-12-07 10:06:32'),
        array('id' => '104','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 B Wanita','denah' => 'denah/iA2lc8AGkIxlD1AROvI4R9yEYnTuaKMjiYppT2ge.jpg','created_at' => '2022-06-23 12:36:58','updated_at' => '2022-12-07 10:06:20'),
        array('id' => '105','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 C Pria','denah' => 'denah/YA2v1x2QMaVaj0DA8P11BdZi8wpHTXnfEJ7dRzqA.jpg','created_at' => '2022-06-23 12:37:05','updated_at' => '2022-12-07 10:06:09'),
        array('id' => '106','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 C Wanita','denah' => 'denah/UajBGm2BBw21i33vsIpQNGY3qVfp1pwxyzuVyEfF.jpg','created_at' => '2022-06-23 12:37:13','updated_at' => '2022-12-07 10:05:58'),
        array('id' => '107','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 D Pria','denah' => 'denah/PJHbQviRMzNldU8UrnXTsKOQm7IzaTxTcC3KAYB0.jpg','created_at' => '2022-06-23 12:37:21','updated_at' => '2022-12-07 10:05:45'),
        array('id' => '108','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 D Wanita','denah' => 'denah/bgwhuXGVRk9mD3ma8fFxIhijdNZnTT1M1Aa1qVaK.jpg','created_at' => '2022-06-23 12:37:31','updated_at' => '2022-12-07 10:05:32'),
        array('id' => '109','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 E Pria','denah' => 'denah/DhGvvHULDuETdWvBlCl6CBhHTwjCzJLmlnBBp0Ud.jpg','created_at' => '2022-06-23 12:37:37','updated_at' => '2022-12-07 10:05:19'),
        array('id' => '110','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 E Wanita','denah' => 'denah/N9XG38qTG8WWzIhciVkJnchwnlCXM0VTbESiSfkS.jpg','created_at' => '2022-06-23 12:37:46','updated_at' => '2022-12-07 10:05:06'),
        array('id' => '111','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 F Pria','denah' => 'denah/uFfPzj4S7n8osCmICDN7TLfQsSfllzuzBhumrXEs.jpg','created_at' => '2022-06-23 12:37:52','updated_at' => '2022-12-07 10:04:57'),
        array('id' => '112','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 F Wanita','denah' => 'denah/LaHRZf6mZZDw2Ekher9WHEMQYUQSPk1SfYCNuTjb.jpg','created_at' => '2022-06-23 12:37:59','updated_at' => '2022-12-07 10:04:48'),
        array('id' => '113','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 G Pria','denah' => 'denah/N7rdm3RSBlaFM25SVSxvP9D8nKqU0IRKVHRsfQms.jpg','created_at' => '2022-06-23 12:38:05','updated_at' => '2022-12-07 10:04:35'),
        array('id' => '114','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 G Wanita','denah' => 'denah/IiCzhCEb6NYWduVGQihem7tmThSC6QzjzROw5HfO.jpg','created_at' => '2022-06-23 12:38:14','updated_at' => '2022-12-07 10:04:15'),
        array('id' => '115','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 H Pria','denah' => 'denah/OFoUBfbdx3VaFnhgtqPHM3U2otgHCxWMMRu8hrYv.jpg','created_at' => '2022-06-23 12:38:33','updated_at' => '2022-12-07 10:04:03'),
        array('id' => '116','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 H Wanita','denah' => 'denah/IUSuxSL7eJ2VUJIyiEDxfcoNWhc4Q4P0bnXaHK7M.jpg','created_at' => '2022-06-23 12:38:42','updated_at' => '2022-12-07 10:03:44'),
        array('id' => '117','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 I Pria','denah' => 'denah/Uh4lnvdHPDnUivg4DmKwPAd5v8kkrOJE1kOvkgWA.jpg','created_at' => '2022-06-23 12:38:54','updated_at' => '2022-12-07 10:03:31'),
        array('id' => '118','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 I Wanita','denah' => 'denah/TPR1KJZZTypXhEsvNVhPAz47dg7MilGiNqMTfKYI.jpg','created_at' => '2022-06-23 12:39:02','updated_at' => '2022-12-07 10:03:17'),
        array('id' => '119','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 J Pria','denah' => 'denah/LJVN1K9qZs9aVjtFumRgtbgSdzJOHXaxekKFbldC.jpg','created_at' => '2022-06-23 12:39:10','updated_at' => '2022-12-07 10:03:03'),
        array('id' => '120','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 J Wanita','denah' => 'denah/1u4A14RchrMSnqplUn4oxwEzHUs1SJlWa4GxZCJ8.jpg','created_at' => '2022-06-23 12:39:19','updated_at' => '2022-12-07 10:02:50'),
        array('id' => '121','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 K Pria','denah' => 'denah/V26I1oQcHvL6kqOd3LNM5BEfNUX4cDHfhMqr6utx.jpg','created_at' => '2022-06-23 12:39:29','updated_at' => '2022-12-07 10:02:20'),
        array('id' => '122','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 K Wanita','denah' => 'denah/4qgtZ9lsiLELGdB3Hilzvw87FnOefGPtMIA4XIQW.jpg','created_at' => '2022-06-23 12:39:40','updated_at' => '2022-12-07 10:02:07'),
        array('id' => '123','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 L Pria','denah' => 'denah/WJttNBchc0G5PPsddUhe2RTEuSzf2cRFvCRgdeGo.jpg','created_at' => '2022-06-23 12:39:49','updated_at' => '2022-12-07 10:01:50'),
        array('id' => '124','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 L Wanita','denah' => 'denah/NnT612knt8ExC3jpboIqvcHWnb5AB5u1AF6Bjh7Q.jpg','created_at' => '2022-06-23 12:39:57','updated_at' => '2022-12-07 10:01:36'),
        array('id' => '125','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 M Pria','denah' => 'denah/k100L0z3kgM8KFYdYMQ0UXY4B8AWOqcBKuppnIw9.jpg','created_at' => '2022-06-23 12:40:04','updated_at' => '2022-12-07 10:01:20'),
        array('id' => '126','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 M Wanita','denah' => 'denah/FumKW0vmHNweFB8C6lCPIENrg2wgTImTZxkzKOYG.jpg','created_at' => '2022-06-23 12:40:12','updated_at' => '2022-12-07 10:01:05'),
        array('id' => '127','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 N Pria','denah' => 'denah/xeyA43vzxJ3IjTIidV0xoBTMOjoMiWD0bUFZbi7X.jpg','created_at' => '2022-06-23 12:40:19','updated_at' => '2022-12-07 10:00:49'),
        array('id' => '128','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet 3 N Wanita','denah' => 'denah/QpiOpPNDSfp8UdCx0DIXzhT3J9Cd5JRTQskY5J8x.jpg','created_at' => '2022-06-23 12:40:28','updated_at' => '2022-12-07 10:00:27'),
        array('id' => '129','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet Esland E Timur Pria','denah' => 'denah/Zp1nRHKNuafJbUIUxm69PdbrHFamCFuNFOu6p2OE.jpg','created_at' => '2022-12-05 10:32:06','updated_at' => '2022-12-05 11:29:01'),
        array('id' => '130','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet Esland E Timur Wanita','denah' => 'denah/4heCpczoSz08kBRYreAjedadcnoIPbfNgKGrVHeV.jpg','created_at' => '2022-12-05 10:32:17','updated_at' => '2022-12-05 11:29:16'),
        array('id' => '131','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet Esland E Barat Pria','denah' => 'denah/ogaAlQkOBH2QuzixtPrleTAjOavkyvUZeD2Q3chO.jpg','created_at' => '2022-12-05 10:32:29','updated_at' => '2022-12-05 11:29:40'),
        array('id' => '132','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet Esland E Barat Wanita','denah' => 'denah/fguEixWB0HsQy6OKrdhpSVK9bLIUgL4ZE8xV6KUv.jpg','created_at' => '2022-12-05 10:32:45','updated_at' => '2022-12-07 10:00:04'),
        array('id' => '133','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet Transit Pria','denah' => 'denah/Y92fhtraFMJ3LXcxXlMaje2cnOUSNB9GeVgajUbw.jpg','created_at' => '2023-01-27 20:39:41','updated_at' => '2023-01-27 20:39:41'),
        array('id' => '134','area_id' => '1','lantai' => 'Lantai 1','nama' => 'Toilet Transit Wanita','denah' => 'denah/k6QIcgfsxurBtm32XtZJ8smMPbEcNtPd1C4fa3DI.jpg','created_at' => '2023-01-27 20:39:50','updated_at' => '2023-01-27 20:39:50'),
        array('id' => '135','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet MLCP Pria','denah' => 'denah/erIN1FGVN84N8nSBczrKt3WPKxggPPXQuKmmHDTN.jpg','created_at' => '2023-05-19 11:15:52','updated_at' => '2023-05-19 11:15:52'),
        array('id' => '136','area_id' => '2','lantai' => 'Lantai 1','nama' => 'Toilet MLCP Wanita','denah' => 'denah/MAQZUbnLmuGagkLjwAoObe92JZmEBl3UKaBXpRtQ.jpg','created_at' => '2023-05-19 11:16:08','updated_at' => '2023-05-19 11:16:08'),
        array('id' => '137','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet MLCP Pria','denah' => 'denah/JM4cVLUolPbbUxtyzbAzmgCDVQoiJ0SPNeKN9GA4.jpg','created_at' => '2023-05-19 11:16:24','updated_at' => '2023-05-19 11:16:24'),
        array('id' => '138','area_id' => '2','lantai' => 'Lantai 2','nama' => 'Toilet MLCP Wanita','denah' => 'denah/Aj1a5GMb1zZgP0fmAqadFlbOYpdUQjQSfVQEhJlI.jpg','created_at' => '2023-05-19 11:20:43','updated_at' => '2023-05-19 11:20:43'),
        array('id' => '139','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet MLCP Pria','denah' => 'denah/1yFradQWyzgauoIA1kCstJVDtbxlbqlZw30hJ3sL.jpg','created_at' => '2023-05-19 11:21:03','updated_at' => '2023-05-19 11:21:03'),
        array('id' => '140','area_id' => '2','lantai' => 'Lantai 3','nama' => 'Toilet MLCP Wanita','denah' => 'denah/AJlYd1syxNxEpA5fIUfWMRg1kAjPBnvYYpJUNxZy.jpg','created_at' => '2023-05-19 11:21:16','updated_at' => '2023-05-19 11:21:16')
        );

        /* `db_saniter`.`lokasi` */
        $lokasi = array(
        array('id' => '1','regional_id' => '3','nama_bandara' => 'Kantor Pusat','lokasi_proyek' => 'Kantor Pusat','latitude' => '-8.661063','longitude' => '115.214712','radius' => '150','created_at' => '2024-04-03 13:33:21','updated_at' => '2024-04-03 13:33:21','deleted_at' => NULL),
        array('id' => '2','regional_id' => '3','nama_bandara' => 'Bandara I Gusti Ngurah Rai','lokasi_proyek' => 'Terminal 1','latitude' => '-8.743818514032556','longitude' => '115.16517094178465','radius' => '100','created_at' => '2024-04-03 13:34:33','updated_at' => '2024-04-03 13:34:33','deleted_at' => NULL),
        array('id' => '3','regional_id' => '3','nama_bandara' => 'Pemogan','lokasi_proyek' => 'Kubu Dukuh','latitude' => '-8.70431439338925','longitude' => '115.19760441686176','radius' => '150','created_at' => '2024-04-03 13:52:00','updated_at' => '2024-04-03 13:52:00','deleted_at' => NULL)
        );

        /* `db_saniter`.`menu` */
        $menu = array(
        array('id' => '1','id_kategori' => '1','judul' => 'Manajemen Menu','order' => '1','url' => 'pengaturan/manajemen-menu','icon' => 'menu','show' => '0','created_at' => '2024-04-03 12:09:06','updated_at' => '2024-04-03 13:11:54'),
        array('id' => '4','id_kategori' => '2','judul' => 'User','order' => '1','url' => 'administrasi/user','icon' => 'user','show' => '1','created_at' => '2024-04-03 12:43:28','updated_at' => '2024-04-03 12:43:28'),
        array('id' => '5','id_kategori' => '2','judul' => 'Absen','order' => '2','url' => 'administrasi/absen','icon' => 'book-content','show' => '1','created_at' => '2024-04-03 12:52:45','updated_at' => '2024-04-03 12:52:45'),
        array('id' => '6','id_kategori' => '2','judul' => 'Izin','order' => '3','url' => 'administrasi/izin','icon' => 'task-x','show' => '1','created_at' => '2024-04-03 12:53:12','updated_at' => '2024-04-03 13:12:25'),
        array('id' => '7','id_kategori' => '1','judul' => 'Regional','order' => '1','url' => 'pengaturan/regional','icon' => 'map-pin','show' => '1','created_at' => '2024-04-03 13:12:48','updated_at' => '2024-04-03 13:12:48'),
        array('id' => '8','id_kategori' => '1','judul' => 'Lokasi','order' => '2','url' => 'pengaturan/lokasi','icon' => 'map','show' => '1','created_at' => '2024-04-03 13:32:35','updated_at' => '2024-04-03 13:32:35'),
        array('id' => '9','id_kategori' => '1','judul' => 'Jumlah Izin','order' => '3','url' => 'pengaturan/jumlah-izin','icon' => 'cog','show' => '1','created_at' => '2024-04-03 14:42:24','updated_at' => '2024-04-03 14:42:24'),
        array('id' => '10','id_kategori' => '3','judul' => 'Nama Material','order' => '1','url' => 'material/nama-material','icon' => 'detail','show' => '1','created_at' => '2024-04-03 23:32:27','updated_at' => '2024-04-03 23:33:53'),
        array('id' => '11','id_kategori' => '3','judul' => 'Stok Material','order' => '2','url' => 'material/stok-material','icon' => 'layer-plus','show' => '1','created_at' => '2024-04-04 00:03:43','updated_at' => '2024-04-04 00:03:43'),
        array('id' => '12','id_kategori' => '4','judul' => 'Data Proyek','order' => '1','url' => 'proyek/data-proyek','icon' => 'briefcase-alt-2','show' => '1','created_at' => '2024-04-09 05:49:02','updated_at' => '2024-04-09 05:49:02'),
        array('id' => '13','id_kategori' => '1','judul' => 'Area','order' => '4','url' => 'pengaturan/area','icon' => 'map-alt','show' => '1','created_at' => '2024-04-09 06:02:04','updated_at' => '2024-04-09 06:02:04'),
        array('id' => '14','id_kategori' => '1','judul' => 'Area List','order' => '5','url' => 'pengaturan/list-area','icon' => 'sitemap','show' => '1','created_at' => '2024-04-09 07:22:21','updated_at' => '2024-04-09 08:07:49'),
        array('id' => '15','id_kategori' => '1','judul' => 'Shift','order' => '6','url' => 'pengaturan/shift','icon' => 'time','show' => '1','created_at' => '2024-04-14 17:27:11','updated_at' => '2024-04-14 17:27:19')
        );

        /* `db_saniter`.`menu_kategori` */
        $menu_kategori = array(
        array('id' => '1','nama_kategori' => 'Pengaturan','order' => '3','show' => '1','created_at' => '2024-04-03 12:08:44','updated_at' => '2024-04-03 23:28:49'),
        array('id' => '2','nama_kategori' => 'Administrasi','order' => '1','show' => '1','created_at' => '2024-04-03 12:42:39','updated_at' => '2024-04-03 12:42:39'),
        array('id' => '3','nama_kategori' => 'Material','order' => '2','show' => '1','created_at' => '2024-04-03 23:28:36','updated_at' => '2024-04-03 23:28:36'),
        array('id' => '4','nama_kategori' => 'Proyek','order' => '2','show' => '1','created_at' => '2024-04-09 05:27:03','updated_at' => '2024-04-09 05:27:03')
        );

        /* `db_saniter`.`migrations` */
        $migrations = array(
        array('id' => '1','migration' => '2014_10_12_000000_create_users_table','batch' => '1'),
        array('id' => '2','migration' => '2014_10_12_100000_create_password_reset_tokens_table','batch' => '1'),
        array('id' => '3','migration' => '2014_10_12_200000_add_two_factor_columns_to_users_table','batch' => '1'),
        array('id' => '4','migration' => '2019_08_19_000000_create_failed_jobs_table','batch' => '1'),
        array('id' => '5','migration' => '2019_12_14_000001_create_personal_access_tokens_table','batch' => '1'),
        array('id' => '6','migration' => '2024_03_09_152731_create_regional_table','batch' => '1'),
        array('id' => '7','migration' => '2024_03_10_043154_create_permission_tables','batch' => '1'),
        array('id' => '8','migration' => '2024_03_10_101436_create_menu_table','batch' => '1'),
        array('id' => '9','migration' => '2024_03_10_105328_create_menu_kategori_table','batch' => '1'),
        array('id' => '10','migration' => '2024_03_10_105336_create_sub_menu_table','batch' => '1'),
        array('id' => '11','migration' => '2024_03_21_020208_create_absen_table','batch' => '1'),
        array('id' => '12','migration' => '2024_03_21_020645_create_shift_table','batch' => '1'),
        array('id' => '13','migration' => '2024_03_25_055300_create_lokasi_table','batch' => '1'),
        array('id' => '14','migration' => '2024_03_27_025822_create_izin_table','batch' => '1'),
        array('id' => '15','migration' => '2024_03_27_031834_create_jumlah_izin_table','batch' => '1'),
        array('id' => '16','migration' => '2024_04_04_092133_create_stok_material_table','batch' => '1'),
        array('id' => '17','migration' => '2024_04_05_110651_create_nama_material_table','batch' => '1'),
        array('id' => '18','migration' => '2024_04_06_115437_create_retur_material_table','batch' => '1'),
        array('id' => '19','migration' => '2024_04_09_140518_create_area_table','batch' => '1'),
        array('id' => '20','migration' => '2024_04_09_151539_create_list_area_table','batch' => '1'),
        array('id' => '21','migration' => '2024_04_12_104022_create_tgl_kerja_table','batch' => '1'),
        array('id' => '22','migration' => '2024_04_12_113426_create_detail_tgl_kerja_table','batch' => '1'),
        array('id' => '23','migration' => '2024_04_12_205953_create_jenis_kerusakan_table','batch' => '1'),
        array('id' => '24','migration' => '2024_04_13_182918_create_foto_kerusakan_table','batch' => '1'),
        array('id' => '25','migration' => '2024_04_13_183353_create_detail_jenis_kerusakan_table','batch' => '1')
        );

        /* `db_saniter`.`model_has_permissions` */
        $model_has_permissions = array(
        );

        /* `db_saniter`.`model_has_roles` */
        $model_has_roles = array(
        array('role_id' => '1','model_type' => 'App\\Models\\User','model_id' => '1'),
        array('role_id' => '26','model_type' => 'App\\Models\\User','model_id' => '3')
        );

        /* `db_saniter`.`nama_material` */
        $nama_material = array(
        );

        /* `db_saniter`.`password_reset_tokens` */
        $password_reset_tokens = array(
        );

        /* `db_saniter`.`permissions` */
        $permissions = array(
        array('id' => '1','id_menu' => '1','name' => 'menu_create','guard_name' => 'web','created_at' => '2024-04-03 12:09:25','updated_at' => '2024-04-03 12:09:25'),
        array('id' => '2','id_menu' => '1','name' => 'menu_read','guard_name' => 'web','created_at' => '2024-04-03 12:09:25','updated_at' => '2024-04-03 12:09:25'),
        array('id' => '3','id_menu' => '1','name' => 'menu_update','guard_name' => 'web','created_at' => '2024-04-03 12:09:25','updated_at' => '2024-04-03 12:09:25'),
        array('id' => '4','id_menu' => '1','name' => 'menu_delete','guard_name' => 'web','created_at' => '2024-04-03 12:09:25','updated_at' => '2024-04-03 12:09:25'),
        array('id' => '5','id_menu' => '1','name' => 'ketegori_create','guard_name' => 'web','created_at' => '2024-04-03 12:10:52','updated_at' => '2024-04-03 12:10:52'),
        array('id' => '6','id_menu' => '1','name' => 'ketegori_read','guard_name' => 'web','created_at' => '2024-04-03 12:10:52','updated_at' => '2024-04-03 12:10:52'),
        array('id' => '7','id_menu' => '1','name' => 'ketegori_update','guard_name' => 'web','created_at' => '2024-04-03 12:10:52','updated_at' => '2024-04-03 12:10:52'),
        array('id' => '8','id_menu' => '1','name' => 'ketegori_delete','guard_name' => 'web','created_at' => '2024-04-03 12:10:52','updated_at' => '2024-04-03 12:10:52'),
        array('id' => '9','id_menu' => '1','name' => 'sub_menu_create','guard_name' => 'web','created_at' => '2024-04-03 12:11:06','updated_at' => '2024-04-03 12:11:31'),
        array('id' => '10','id_menu' => '1','name' => 'sub_menu_read','guard_name' => 'web','created_at' => '2024-04-03 12:11:06','updated_at' => '2024-04-03 12:11:26'),
        array('id' => '11','id_menu' => '1','name' => 'sub_menu_update','guard_name' => 'web','created_at' => '2024-04-03 12:11:06','updated_at' => '2024-04-03 12:11:21'),
        array('id' => '12','id_menu' => '1','name' => 'sub_menu_delete','guard_name' => 'web','created_at' => '2024-04-03 12:11:06','updated_at' => '2024-04-03 12:11:15'),
        array('id' => '13','id_menu' => '4','name' => 'user_create','guard_name' => 'web','created_at' => '2024-04-03 12:43:39','updated_at' => '2024-04-03 12:43:39'),
        array('id' => '14','id_menu' => '4','name' => 'user_read','guard_name' => 'web','created_at' => '2024-04-03 12:43:39','updated_at' => '2024-04-03 12:43:39'),
        array('id' => '15','id_menu' => '4','name' => 'user_update','guard_name' => 'web','created_at' => '2024-04-03 12:43:39','updated_at' => '2024-04-03 12:43:39'),
        array('id' => '16','id_menu' => '4','name' => 'user_delete','guard_name' => 'web','created_at' => '2024-04-03 12:43:39','updated_at' => '2024-04-03 12:43:39'),
        array('id' => '17','id_menu' => '5','name' => 'absen_create','guard_name' => 'web','created_at' => '2024-04-03 12:54:45','updated_at' => '2024-04-03 12:54:45'),
        array('id' => '18','id_menu' => '5','name' => 'absen_read','guard_name' => 'web','created_at' => '2024-04-03 12:54:45','updated_at' => '2024-04-03 12:54:45'),
        array('id' => '19','id_menu' => '5','name' => 'absen_update','guard_name' => 'web','created_at' => '2024-04-03 12:54:46','updated_at' => '2024-04-03 12:54:46'),
        array('id' => '20','id_menu' => '5','name' => 'absen_delete','guard_name' => 'web','created_at' => '2024-04-03 12:54:46','updated_at' => '2024-04-03 12:54:46'),
        array('id' => '21','id_menu' => '6','name' => 'izin_create','guard_name' => 'web','created_at' => '2024-04-03 12:54:56','updated_at' => '2024-04-03 12:54:56'),
        array('id' => '22','id_menu' => '6','name' => 'izin_read','guard_name' => 'web','created_at' => '2024-04-03 12:54:56','updated_at' => '2024-04-03 12:54:56'),
        array('id' => '23','id_menu' => '6','name' => 'izin_update','guard_name' => 'web','created_at' => '2024-04-03 12:54:56','updated_at' => '2024-04-03 12:54:56'),
        array('id' => '24','id_menu' => '6','name' => 'izin_delete','guard_name' => 'web','created_at' => '2024-04-03 12:54:56','updated_at' => '2024-04-03 12:54:56'),
        array('id' => '25','id_menu' => '6','name' => 'pengaturan_izin_create','guard_name' => 'web','created_at' => '2024-04-03 13:06:31','updated_at' => '2024-04-03 13:06:31'),
        array('id' => '26','id_menu' => '6','name' => 'pengaturan_izin_read','guard_name' => 'web','created_at' => '2024-04-03 13:06:31','updated_at' => '2024-04-03 13:06:31'),
        array('id' => '27','id_menu' => '6','name' => 'pengaturan_izin_update','guard_name' => 'web','created_at' => '2024-04-03 13:06:31','updated_at' => '2024-04-03 13:06:31'),
        array('id' => '28','id_menu' => '6','name' => 'pengaturan_izin_delete','guard_name' => 'web','created_at' => '2024-04-03 13:06:31','updated_at' => '2024-04-03 13:06:31'),
        array('id' => '29','id_menu' => '7','name' => 'regional_create','guard_name' => 'web','created_at' => '2024-04-03 13:13:09','updated_at' => '2024-04-03 13:13:09'),
        array('id' => '30','id_menu' => '7','name' => 'regional_read','guard_name' => 'web','created_at' => '2024-04-03 13:13:09','updated_at' => '2024-04-03 13:13:09'),
        array('id' => '31','id_menu' => '7','name' => 'regional_update','guard_name' => 'web','created_at' => '2024-04-03 13:13:09','updated_at' => '2024-04-03 13:13:09'),
        array('id' => '32','id_menu' => '7','name' => 'regional_delete','guard_name' => 'web','created_at' => '2024-04-03 13:13:09','updated_at' => '2024-04-03 13:13:09'),
        array('id' => '33','id_menu' => '8','name' => 'lokasi_create','guard_name' => 'web','created_at' => '2024-04-03 13:32:43','updated_at' => '2024-04-03 13:32:43'),
        array('id' => '34','id_menu' => '8','name' => 'lokasi_read','guard_name' => 'web','created_at' => '2024-04-03 13:32:43','updated_at' => '2024-04-03 13:32:43'),
        array('id' => '35','id_menu' => '8','name' => 'lokasi_update','guard_name' => 'web','created_at' => '2024-04-03 13:32:43','updated_at' => '2024-04-03 13:32:43'),
        array('id' => '36','id_menu' => '8','name' => 'lokasi_delete','guard_name' => 'web','created_at' => '2024-04-03 13:32:43','updated_at' => '2024-04-03 13:32:43'),
        array('id' => '37','id_menu' => '9','name' => 'jumlah izin_create','guard_name' => 'web','created_at' => '2024-04-03 14:42:38','updated_at' => '2024-04-03 14:42:38'),
        array('id' => '38','id_menu' => '9','name' => 'jumlah izin_read','guard_name' => 'web','created_at' => '2024-04-03 14:42:38','updated_at' => '2024-04-03 14:42:38'),
        array('id' => '39','id_menu' => '9','name' => 'jumlah izin_update','guard_name' => 'web','created_at' => '2024-04-03 14:42:38','updated_at' => '2024-04-03 14:42:38'),
        array('id' => '40','id_menu' => '9','name' => 'jumlah izin_delete','guard_name' => 'web','created_at' => '2024-04-03 14:42:38','updated_at' => '2024-04-03 14:42:38'),
        array('id' => '41','id_menu' => '6','name' => 'validasi2_izin','guard_name' => 'web','created_at' => '2024-04-03 15:32:31','updated_at' => '2024-04-03 15:32:31'),
        array('id' => '42','id_menu' => '6','name' => 'validasi1_izin','guard_name' => 'web','created_at' => '2024-04-03 15:32:49','updated_at' => '2024-04-03 15:32:49'),
        array('id' => '44','id_menu' => '10','name' => 'nama material_read','guard_name' => 'web','created_at' => '2024-04-03 23:34:14','updated_at' => '2024-04-03 23:34:14'),
        array('id' => '55','id_menu' => '11','name' => 'stok material pengajuan_create','guard_name' => 'web','created_at' => '2024-04-07 00:59:13','updated_at' => '2024-04-07 00:59:13'),
        array('id' => '56','id_menu' => '11','name' => 'stok material pengajuan_read','guard_name' => 'web','created_at' => '2024-04-07 00:59:13','updated_at' => '2024-04-07 00:59:13'),
        array('id' => '57','id_menu' => '11','name' => 'stok material pengajuan_update','guard_name' => 'web','created_at' => '2024-04-07 00:59:13','updated_at' => '2024-04-07 00:59:13'),
        array('id' => '58','id_menu' => '11','name' => 'stok material pengajuan_delete','guard_name' => 'web','created_at' => '2024-04-07 00:59:13','updated_at' => '2024-04-07 00:59:13'),
        array('id' => '59','id_menu' => '11','name' => 'validasi_pm_stok_material','guard_name' => 'web','created_at' => '2024-04-07 01:00:35','updated_at' => '2024-04-07 01:00:35'),
        array('id' => '60','id_menu' => '11','name' => 'validasi_spv_stok_material','guard_name' => 'web','created_at' => '2024-04-07 01:00:46','updated_at' => '2024-04-07 01:00:46'),
        array('id' => '61','id_menu' => '11','name' => 'stok material list_create','guard_name' => 'web','created_at' => '2024-04-07 01:33:49','updated_at' => '2024-04-07 01:33:49'),
        array('id' => '62','id_menu' => '11','name' => 'stok material list_read','guard_name' => 'web','created_at' => '2024-04-07 01:33:49','updated_at' => '2024-04-07 01:33:49'),
        array('id' => '63','id_menu' => '11','name' => 'stok material list_update','guard_name' => 'web','created_at' => '2024-04-07 01:33:49','updated_at' => '2024-04-07 01:33:49'),
        array('id' => '64','id_menu' => '11','name' => 'stok material list_delete','guard_name' => 'web','created_at' => '2024-04-07 01:33:49','updated_at' => '2024-04-07 01:33:49'),
        array('id' => '65','id_menu' => '11','name' => 'stok material retur_create','guard_name' => 'web','created_at' => '2024-04-07 23:50:39','updated_at' => '2024-04-07 23:50:39'),
        array('id' => '66','id_menu' => '11','name' => 'stok material retur_read','guard_name' => 'web','created_at' => '2024-04-07 23:50:39','updated_at' => '2024-04-07 23:50:39'),
        array('id' => '67','id_menu' => '11','name' => 'stok material retur_update','guard_name' => 'web','created_at' => '2024-04-07 23:50:39','updated_at' => '2024-04-07 23:50:39'),
        array('id' => '68','id_menu' => '11','name' => 'stok material retur_delete','guard_name' => 'web','created_at' => '2024-04-07 23:50:39','updated_at' => '2024-04-07 23:50:39'),
        array('id' => '69','id_menu' => '5','name' => 'absen_detail_all','guard_name' => 'web','created_at' => '2024-04-08 07:40:38','updated_at' => '2024-04-08 07:40:38'),
        array('id' => '70','id_menu' => '6','name' => 'all_izin','guard_name' => 'web','created_at' => '2024-04-08 08:07:58','updated_at' => '2024-04-08 08:07:58'),
        array('id' => '71','id_menu' => '12','name' => 'data proyek_create','guard_name' => 'web','created_at' => '2024-04-09 05:49:49','updated_at' => '2024-04-09 05:49:49'),
        array('id' => '72','id_menu' => '12','name' => 'data proyek_read','guard_name' => 'web','created_at' => '2024-04-09 05:49:49','updated_at' => '2024-04-09 05:49:49'),
        array('id' => '73','id_menu' => '12','name' => 'data proyek_update','guard_name' => 'web','created_at' => '2024-04-09 05:49:49','updated_at' => '2024-04-09 05:49:49'),
        array('id' => '74','id_menu' => '12','name' => 'data proyek_delete','guard_name' => 'web','created_at' => '2024-04-09 05:49:49','updated_at' => '2024-04-09 05:49:49'),
        array('id' => '75','id_menu' => '13','name' => 'area_create','guard_name' => 'web','created_at' => '2024-04-09 06:11:17','updated_at' => '2024-04-09 06:11:17'),
        array('id' => '76','id_menu' => '13','name' => 'area_read','guard_name' => 'web','created_at' => '2024-04-09 06:11:17','updated_at' => '2024-04-09 06:11:17'),
        array('id' => '77','id_menu' => '13','name' => 'area_update','guard_name' => 'web','created_at' => '2024-04-09 06:11:17','updated_at' => '2024-04-09 06:11:17'),
        array('id' => '78','id_menu' => '13','name' => 'area_delete','guard_name' => 'web','created_at' => '2024-04-09 06:11:17','updated_at' => '2024-04-09 06:11:17'),
        array('id' => '79','id_menu' => '14','name' => 'area list_create','guard_name' => 'web','created_at' => '2024-04-09 07:24:23','updated_at' => '2024-04-09 07:24:23'),
        array('id' => '80','id_menu' => '14','name' => 'area list_read','guard_name' => 'web','created_at' => '2024-04-09 07:24:23','updated_at' => '2024-04-09 07:24:23'),
        array('id' => '81','id_menu' => '14','name' => 'area list_update','guard_name' => 'web','created_at' => '2024-04-09 07:24:23','updated_at' => '2024-04-09 07:24:23'),
        array('id' => '82','id_menu' => '14','name' => 'area list_delete','guard_name' => 'web','created_at' => '2024-04-09 07:24:23','updated_at' => '2024-04-09 07:24:23'),
        array('id' => '83','id_menu' => '15','name' => 'shift_create','guard_name' => 'web','created_at' => '2024-04-14 17:27:35','updated_at' => '2024-04-14 17:27:35'),
        array('id' => '84','id_menu' => '15','name' => 'shift_read','guard_name' => 'web','created_at' => '2024-04-14 17:27:35','updated_at' => '2024-04-14 17:27:35'),
        array('id' => '85','id_menu' => '15','name' => 'shift_update','guard_name' => 'web','created_at' => '2024-04-14 17:27:35','updated_at' => '2024-04-14 17:27:35'),
        array('id' => '86','id_menu' => '15','name' => 'shift_delete','guard_name' => 'web','created_at' => '2024-04-14 17:27:35','updated_at' => '2024-04-14 17:27:35'),
        array('id' => '87','id_menu' => '4','name' => 'user_ajax','guard_name' => 'web','created_at' => '2024-04-14 17:31:11','updated_at' => '2024-04-14 17:31:28')
        );

        /* `db_saniter`.`personal_access_tokens` */
        $personal_access_tokens = array(
        );

        /* `db_saniter`.`regional` */
        $regional = array(
        array('id' => '1','nama' => 'Barat','latitude' => '-6.299706065145467','longitude' => '106.72254088949181','created_at' => '2024-04-03 12:08:13','updated_at' => '2024-04-03 13:26:58','deleted_at' => NULL),
        array('id' => '2','nama' => 'Tengah','latitude' => '-7.245696806718458','longitude' => '112.73892431229427','created_at' => '2024-04-03 12:08:13','updated_at' => '2024-04-03 13:27:48','deleted_at' => NULL),
        array('id' => '3','nama' => 'Pusat','latitude' => '-8.661063','longitude' => '115.214712','created_at' => '2024-04-03 12:08:13','updated_at' => '2024-04-03 12:08:13','deleted_at' => NULL),
        array('id' => '5','nama' => 'Pusat-BSD','latitude' => '0','longitude' => '0','created_at' => '2024-04-04 07:30:33','updated_at' => '2024-04-04 07:30:33','deleted_at' => NULL),
        array('id' => '6','nama' => 'Pusat-Finance','latitude' => '0','longitude' => '0','created_at' => '2024-04-04 07:30:33','updated_at' => '2024-04-04 07:30:33','deleted_at' => NULL),
        array('id' => '7','nama' => 'Pusat-Teknik','latitude' => '0','longitude' => '0','created_at' => '2024-04-04 07:30:33','updated_at' => '2024-04-04 07:30:33','deleted_at' => NULL),
        array('id' => '8','nama' => 'Jakarta','latitude' => '0','longitude' => '0','created_at' => '2024-04-04 07:30:33','updated_at' => '2024-04-04 07:30:33','deleted_at' => NULL),
        array('id' => '9','nama' => 'Dirtek','latitude' => '0','longitude' => '0','created_at' => '2024-04-04 07:30:33','updated_at' => '2024-04-04 07:30:33','deleted_at' => NULL)
        );

        /* `db_saniter`.`retur_material` */
        $retur_material = array(
        array('id' => '1','stok_material_id' => '1','diterima_id' => '2','kode_material' => 'MBS-MP-2004M-22-SNTR-001','nama_material' => 'Masterpren 2004M','tgl_retur' => NULL,'status' => 'ACC Sebagian','keterangan' => '-','retur_by' => NULL,'validasi_by' => '0','retur_to' => NULL,'validasi_to' => '0','jumlah' => '10','hasil_retur' => 'Menunggu Validasi','created_by' => 'Admin Saniter','created_at' => '2024-04-14 21:18:26','updated_at' => '2024-04-14 21:18:26')
        );

        /* `db_saniter`.`roles` */
        $roles = array(
        array('id' => '1','name' => 'Administrator','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '2','name' => 'Direktur Utama','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '3','name' => 'CO GM Reg.Barat','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '4','name' => 'GM. Reg.Barat','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '5','name' => 'Dir. Keuangan','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '6','name' => 'GM. Reg.Timur','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '7','name' => 'Dir. Teknik','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '8','name' => 'Project Manager (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '9','name' => 'TA Dir. Keuangan','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '10','name' => 'Manajer IT','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '11','name' => 'Site Engineering Manager (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '12','name' => 'TA. Dirtek','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '13','name' => 'Site Oprational Manager (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '14','name' => 'Project Manager (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '15','name' => 'Resign/PHK','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '16','name' => 'Manager Finance (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '17','name' => 'Staff Finance (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '18','name' => 'Manajer Logistik (Pusat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '19','name' => 'Site Engineering Manager (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '20','name' => 'Site Oprational Manager (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '21','name' => 'Driver (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '22','name' => 'Logistik (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '23','name' => 'Dir. Business Development','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '24','name' => 'Konsultan','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '25','name' => 'Staff Logistik (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '26','name' => 'Staff Logistik (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '27','name' => 'Manager Legal','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '28','name' => 'Staff HRD','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '29','name' => 'Staff Akunting (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '30','name' => 'Staff Teknik (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '31','name' => 'Intern Logistik','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '32','name' => 'Intern Finance','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '33','name' => 'Intern Teknik','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '34','name' => 'Cleaning Service','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '35','name' => 'Admin Project (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '36','name' => 'Staff Sales (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '37','name' => 'Admin Project (Reg.Barat)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '38','name' => 'Project Manager (Reg.Tengah)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '39','name' => 'Staff Sales (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '40','name' => 'Staff Finance (Reg.Tengah)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '41','name' => 'Supervisor (Reg.Timur)','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '42','name' => 'Staff IT','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42'),
        array('id' => '43','name' => 'Masa Orientasi Calon Karyawan','guard_name' => 'web','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42')
        );

        /* `db_saniter`.`role_has_permissions` */
        $role_has_permissions = array(
        array('permission_id' => '1','role_id' => '1'),
        array('permission_id' => '2','role_id' => '1'),
        array('permission_id' => '3','role_id' => '1'),
        array('permission_id' => '4','role_id' => '1'),
        array('permission_id' => '5','role_id' => '1'),
        array('permission_id' => '6','role_id' => '1'),
        array('permission_id' => '7','role_id' => '1'),
        array('permission_id' => '8','role_id' => '1'),
        array('permission_id' => '9','role_id' => '1'),
        array('permission_id' => '10','role_id' => '1'),
        array('permission_id' => '11','role_id' => '1'),
        array('permission_id' => '12','role_id' => '1'),
        array('permission_id' => '13','role_id' => '1'),
        array('permission_id' => '14','role_id' => '1'),
        array('permission_id' => '15','role_id' => '1'),
        array('permission_id' => '16','role_id' => '1'),
        array('permission_id' => '17','role_id' => '1'),
        array('permission_id' => '18','role_id' => '1'),
        array('permission_id' => '19','role_id' => '1'),
        array('permission_id' => '20','role_id' => '1'),
        array('permission_id' => '21','role_id' => '1'),
        array('permission_id' => '22','role_id' => '1'),
        array('permission_id' => '23','role_id' => '1'),
        array('permission_id' => '24','role_id' => '1'),
        array('permission_id' => '25','role_id' => '1'),
        array('permission_id' => '26','role_id' => '1'),
        array('permission_id' => '27','role_id' => '1'),
        array('permission_id' => '28','role_id' => '1'),
        array('permission_id' => '29','role_id' => '1'),
        array('permission_id' => '30','role_id' => '1'),
        array('permission_id' => '31','role_id' => '1'),
        array('permission_id' => '32','role_id' => '1'),
        array('permission_id' => '33','role_id' => '1'),
        array('permission_id' => '34','role_id' => '1'),
        array('permission_id' => '35','role_id' => '1'),
        array('permission_id' => '36','role_id' => '1'),
        array('permission_id' => '37','role_id' => '1'),
        array('permission_id' => '38','role_id' => '1'),
        array('permission_id' => '39','role_id' => '1'),
        array('permission_id' => '40','role_id' => '1'),
        array('permission_id' => '41','role_id' => '1'),
        array('permission_id' => '44','role_id' => '1'),
        array('permission_id' => '44','role_id' => '26'),
        array('permission_id' => '55','role_id' => '1'),
        array('permission_id' => '55','role_id' => '26'),
        array('permission_id' => '56','role_id' => '1'),
        array('permission_id' => '56','role_id' => '26'),
        array('permission_id' => '57','role_id' => '1'),
        array('permission_id' => '57','role_id' => '26'),
        array('permission_id' => '58','role_id' => '1'),
        array('permission_id' => '58','role_id' => '26'),
        array('permission_id' => '59','role_id' => '1'),
        array('permission_id' => '60','role_id' => '26'),
        array('permission_id' => '61','role_id' => '1'),
        array('permission_id' => '61','role_id' => '26'),
        array('permission_id' => '62','role_id' => '1'),
        array('permission_id' => '62','role_id' => '26'),
        array('permission_id' => '63','role_id' => '1'),
        array('permission_id' => '63','role_id' => '26'),
        array('permission_id' => '64','role_id' => '1'),
        array('permission_id' => '64','role_id' => '26'),
        array('permission_id' => '65','role_id' => '1'),
        array('permission_id' => '65','role_id' => '26'),
        array('permission_id' => '66','role_id' => '1'),
        array('permission_id' => '66','role_id' => '26'),
        array('permission_id' => '67','role_id' => '1'),
        array('permission_id' => '67','role_id' => '26'),
        array('permission_id' => '68','role_id' => '1'),
        array('permission_id' => '68','role_id' => '26'),
        array('permission_id' => '69','role_id' => '1'),
        array('permission_id' => '70','role_id' => '1'),
        array('permission_id' => '71','role_id' => '1'),
        array('permission_id' => '71','role_id' => '26'),
        array('permission_id' => '72','role_id' => '1'),
        array('permission_id' => '72','role_id' => '26'),
        array('permission_id' => '73','role_id' => '1'),
        array('permission_id' => '73','role_id' => '26'),
        array('permission_id' => '74','role_id' => '1'),
        array('permission_id' => '74','role_id' => '26'),
        array('permission_id' => '75','role_id' => '1'),
        array('permission_id' => '76','role_id' => '1'),
        array('permission_id' => '77','role_id' => '1'),
        array('permission_id' => '78','role_id' => '1'),
        array('permission_id' => '79','role_id' => '1'),
        array('permission_id' => '79','role_id' => '26'),
        array('permission_id' => '80','role_id' => '1'),
        array('permission_id' => '80','role_id' => '26'),
        array('permission_id' => '81','role_id' => '1'),
        array('permission_id' => '81','role_id' => '26'),
        array('permission_id' => '82','role_id' => '1'),
        array('permission_id' => '82','role_id' => '26'),
        array('permission_id' => '83','role_id' => '1'),
        array('permission_id' => '84','role_id' => '1'),
        array('permission_id' => '85','role_id' => '1'),
        array('permission_id' => '86','role_id' => '1'),
        array('permission_id' => '87','role_id' => '1')
        );

        /* `db_saniter`.`shift` */
        $shift = array(
        array('id' => '1','nama' => 'Pagi','server_time' => '00:00:01','jam_masuk' => '09:00:00','jam_pulang' => '17:00:00','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42','deleted_at' => NULL),
        array('id' => '2','nama' => 'Sore','server_time' => '00:00:01','jam_masuk' => '15:00:00','jam_pulang' => '23:00:00','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42','deleted_at' => NULL),
        array('id' => '3','nama' => 'Malam','server_time' => '00:00:01','jam_masuk' => '23:00:00','jam_pulang' => '07:00:00','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 17:03:42','deleted_at' => NULL)
        );

        /* `db_saniter`.`stok_material` */
        $stok_material = array(
        array('id' => '1','material_id' => '10','kode_material' => 'MBS-MP-2004M-22-SNTR-001','nama_material' => 'Masterpren 2004M','harga' => '550550','masuk' => '20','sebagian' => '10','diterima_pm' => '1','diterima_pm_by' => 'Admin Saniter','tanggal_diterima_pm' => '2024-04-14','status_validasi_pm' => 'ACC Sebagian','keterangan' => '-','diterima_spv' => '1','diterima_spv_by' => 'Staff Saniter','tanggal_diterima_spv' => '2024-04-14','stok_update' => '20','created_by' => 'Admin Saniter','history' => '1','history_id' => '2','created_at' => '2024-04-14 20:39:50','updated_at' => '2024-04-14 21:18:26'),
        array('id' => '2','material_id' => '10','kode_material' => 'MBS-MP-2004M-22-SNTR-001','nama_material' => 'Masterpren 2004M','harga' => '550550','masuk' => '10','sebagian' => '0','diterima_pm' => '1','diterima_pm_by' => 'Admin Saniter','tanggal_diterima_pm' => '2024-04-14','status_validasi_pm' => 'ACC','keterangan' => '-','diterima_spv' => '1','diterima_spv_by' => 'Staff Saniter','tanggal_diterima_spv' => '2024-04-14','stok_update' => '0','created_by' => 'System','history' => '0','history_id' => '0','created_at' => '2024-04-14 21:18:26','updated_at' => '2024-04-14 21:18:26')
        );

        /* `db_saniter`.`sub_menu` */
        $sub_menu = array(
        array('id' => '1','id_menu' => '1','judul' => 'Menu','order' => '2','url' => 'menu','created_at' => '2024-04-03 12:10:00','updated_at' => '2024-04-03 12:10:00'),
        array('id' => '2','id_menu' => '1','judul' => 'Kategori','order' => '1','url' => 'kategori','created_at' => '2024-04-03 12:10:11','updated_at' => '2024-04-03 12:10:11'),
        array('id' => '3','id_menu' => '1','judul' => 'Sub Menu','order' => '3','url' => 'sub-menu','created_at' => '2024-04-03 12:10:25','updated_at' => '2024-04-03 12:10:25'),
        array('id' => '4','id_menu' => '11','judul' => 'List','order' => '1','url' => 'list','created_at' => '2024-04-07 00:57:23','updated_at' => '2024-04-07 00:57:23'),
        array('id' => '5','id_menu' => '11','judul' => 'Tambah Stok','order' => '2','url' => 'tambah-stok','created_at' => '2024-04-07 00:57:36','updated_at' => '2024-04-07 00:57:36'),
        array('id' => '6','id_menu' => '11','judul' => 'Retur','order' => '3','url' => 'retur','created_at' => '2024-04-07 00:57:46','updated_at' => '2024-04-07 00:57:46')
        );

        /* `db_saniter`.`tgl_kerja` */
        $tgl_kerja = array(
        array('id' => '1','tanggal' => '2024-04-14','created_at' => '2024-04-14 20:45:17','updated_at' => '2024-04-14 20:45:17')
        );

        /* `db_saniter`.`users` */
        $users = array(
        array('id' => '1','regional_id' => '1','lokasi_id' => '1','role_id' => '1','name' => 'Admin Saniter','email' => 'admin@gmail.com','nik' => '5171012103010002','alamat_ktp' => '','alamat_dom' => '','telp' => '0819034078903','foto' => 'user-images/default.jpg','password' => '$2y$12$Heg5qCjuEY5PMgbGQTlGXesKPjyK5H/Meb2BgbQ46XakoQGco038.','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'ttd' => 'user-ttd/default.jpg','is_active' => '1','status' => 'Kontrak','created_at' => '2024-04-14 17:03:41','updated_at' => '2024-04-14 17:03:41','remember_token' => NULL,'deleted_at' => NULL),
        array('id' => '2','regional_id' => '3','lokasi_id' => '1','role_id' => '3','name' => 'Teknisi Saniter','email' => 'teknisi@gmail.com','nik' => '5171012103010002','alamat_ktp' => '','alamat_dom' => '','telp' => '0819034078901','foto' => 'user-images/default.jpg','password' => '$2y$12$UQ2t2iSkfGwfUwygNkjEg.FiaMFqKdMu58hOM.DKK959bVg90n88a','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'ttd' => 'user-ttd/default.jpg','is_active' => '1','status' => 'Kontrak','created_at' => '2024-04-14 17:03:41','updated_at' => '2024-04-14 17:03:41','remember_token' => NULL,'deleted_at' => NULL),
        array('id' => '3','regional_id' => '3','lokasi_id' => '3','role_id' => '26','name' => 'Staff Saniter','email' => 'staff@gmail.com','nik' => '5171012103010002','alamat_ktp' => 'asd','alamat_dom' => 'asd','telp' => '0819034078902','foto' => 'user-images/default.jpg','password' => '$2y$12$QElv7b9jug8LbJcoi8nzuOz77rfbP.wh6Oc/7iRzS7kt0TvtPDbhi','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'ttd' => 'user-ttd/default.jpg','is_active' => '1','status' => 'Kontrak','created_at' => '2024-04-14 17:03:42','updated_at' => '2024-04-14 21:17:56','remember_token' => NULL,'deleted_at' => NULL)
        );

        foreach($area as $item){
            Area::create($item);
        }
        foreach($list_area as $item){
            AreaList::create($item);
        }
        foreach($lokasi as $item){
            Lokasi::create($item);
        }
        foreach($menu as $item){
            Menu::create($item);
        }
        foreach($menu_kategori as $item){
            KategoriMenu::create($item);
        }
        foreach($permissions as $item){
            Permission::create($item);
        }
        foreach($regional as $item){
            Regional::create($item);
        }
        foreach($roles as $item){
            Role::create($item);
        }
        foreach($role_has_permissions as $item){
            DB::table('role_has_permissions')->insert($item);
        }
        foreach($shift as $item){
            Shift::create($item);
        }
        foreach($stok_material as $item){
            StokMaterial::create($item);
        }
        foreach($sub_menu as $item){
            SubMenu::create($item);
        }
        foreach($tgl_kerja as $item){
            TglKerja::create($item);
        }
        foreach($users as $item){
            User::create($item);
        }
        foreach($model_has_roles as $item){
            DB::table('model_has_roles')->insert($item);
        }
    }
}
