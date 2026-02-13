<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
use App\Models\SoalmodelSKLatihan;
use App\Models\Jawabanmodel;

class Soalsikapkerjalatihan extends BaseController
{
    protected $session;
    protected $usermodel;
    protected $soalmodel;
    protected $jawabanmodel;
    protected $soalmodelSkLatihan;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usermodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
        $this->jawabanmodel = new Jawabanmodel();
        $this->soalmodelSkLatihan = new SoalmodelSKLatihan();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                "sk_group" => $this->soalmodelSkLatihan->getSKgroupAll()->getResult(),
            ];
            return view('admin/soalsklatihan/soal', $data);
        }
        
    }

    public function tambahsoalSkLatihan() {
        $kolom_id = $this->request->getUri()->getSegment(4);
        $group_id = $this->request->getUri()->getSegment(5);
        $materi_id = $this->request->getUri()->getSegment(6);
        $sk_group_id = $this->request->getUri()->getSegment(7);

        $kolom_id = $this->request->getUri()->getSegment(4);
        $group_id = $this->request->getUri()->getSegment(5);
        $materi_id = $this->request->getUri()->getSegment(6);
        $sk_group_id = $this->request->getUri()->getSegment(7);

        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            
            $getSoal = $this->soalmodel->getSoalByIdSK($kolom_id, $group_id, $materi_id, $sk_group_id)->getResult();
            if (count($getSoal) > 0) {
                $soal_id_new = $getSoal[0]->soal_id;
            } else {
                $soal_id_new = NULL;
            }

            $total = count($getSoal);
            $size  = ceil($total / 4); // ukuran per bagian

            $bagian1 = array_slice($getSoal, 0, $size);
            $bagian2 = array_slice($getSoal, $size, $size);
            $bagian3 = array_slice($getSoal, $size * 2, $size);
            $bagian4 = array_slice($getSoal, $size * 3);

            $data = [
                'kolom' => $this->soalmodel->getKolomById($kolom_id)->getResult(),
                'bagian1' => $bagian1,
                'bagian2' => $bagian2,
                'bagian3' => $bagian3,
                'bagian4' => $bagian4,
                'jawaban' => $this->jawabanmodel->getJawabanBySoalId($soal_id_new)->getResult(),
                'soal_id' => $soal_id_new,
                "materi_id" => $materi_id,
                "kolom_id" => $kolom_id,
                "sk_group_id" => $sk_group_id
            ];
            
            
            return view('admin/soalsklatihan/tambahsoalsklatihan',$data);
        }
    }

    public function showkolom() {
        $sk_group_id  = $this->request->getPost('sk_group_id');

        $res    = $this->soalmodelSkLatihan->getKolomSkLatihan(4, 98, $sk_group_id)->getResult();
        
        echo json_encode($res);
    }

    public function viewEditsoalSkLatihan() {
        $kolom_id = $this->request->getUri()->getSegment(4);
        $group_id = $this->request->getUri()->getSegment(5);
        $materi_id = $this->request->getUri()->getSegment(6);
        $sk_group_id = $this->request->getUri()->getSegment(7);

        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            
            $getSoal = $this->soalmodel->getSoalByIdSK($kolom_id, $group_id, $materi_id, $sk_group_id)->getResult();
            if (count($getSoal) > 0) {
                $soal_id_new = $getSoal[0]->soal_id;
                $typeSoal = $getSoal[0]->typesoal;
            } else {
                $soal_id_new = NULL;
                $typeSoal = "text";
            }

            $total = count($getSoal);
            $size  = ceil($total / 4); // ukuran per bagian

            $bagian1 = array_slice($getSoal, 0, $size);
            $bagian2 = array_slice($getSoal, $size, $size);
            $bagian3 = array_slice($getSoal, $size * 2, $size);
            $bagian4 = array_slice($getSoal, $size * 3);

            $data = [
                'kolom' => $this->soalmodel->getKolomById($kolom_id)->getResult(),
                'bagian1' => $bagian1,
                'bagian2' => $bagian2,
                'bagian3' => $bagian3,
                'bagian4' => $bagian4,
                'jawaban' => $this->jawabanmodel->getJawabanBySoalId($soal_id_new)->getResult(),
                'soal_id' => $soal_id_new,
                "materi_id" => $materi_id,
                "kolom_id" => $kolom_id,
                "sk_group_id" => $sk_group_id,
                "typeSoal" => $typeSoal
            ];
            
            return view('admin/soalsklatihan/editsoalsklatihan',$data);
        }
    }

    public function insertGambarSk()
    {
        // $number      = $this->request->getPost('number');
        $typeSoal     = $this->request->getPost('typeSoal');
        $kolom_id    = $this->request->getPost('kolom_id');
        $sk_group_id = $this->request->getPost('sk_group_id');
        $jawaban_lama = $this->request->getPost('jawaban_lama');
        $group_id = 4;
        $soal_nm = [];  
        $allowedMime = ['image/png', 'image/jpg', 'image/jpeg'];

        $path = FCPATH . "images/soalsk/kolom/$kolom_id/sk_group/$sk_group_id";

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $uploadedFiles = [];

        // LOOP gambarsk1 s/d gambarsk5
        for ($i = 1; $i <= 5; $i++) {
            $file = $this->request->getFile('gambarsk' . $i);

            // skip jika tidak ada file
            if (!$file || !$file->isValid()) {
                continue;
            }

            // validasi mime
            if (!in_array($file->getMimeType(), $allowedMime)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Hanya gambar diperbolehkan (gambarsk' . $i . ')'
                ]);
            }

            // nama file unik per gambar
            if ($i == 1) {
                $pilihan = 'A';
            } else if ($i == 2) {
                $pilihan = 'B';
            } else if ($i == 3) {
                $pilihan = 'C';
            } else if ($i == 4) {
                $pilihan = 'D';
            } else if ($i == 5) {
                $pilihan = 'E';
            }

            $newName = $i . $pilihan  . '_' . $kolom_id . '_' . $sk_group_id . '.' . $file->getExtension();
            $fullPath = $path . '/' . $newName;

            // replace file lama
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // upload
            if ($file->move($path, $newName)) {
                $uploadedFiles[] = $newName;
                $soal_nm[] = $newName;
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $file->getErrorString()
                ]);
            }
        }
        $soal_nm = implode('|', $soal_nm);
        $res = $this->randomcharGambar($soal_nm,$kolom_id,98,$sk_group_id);
        return $res;
        if (empty($uploadedFiles)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tidak ada file yang diupload'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'files' => $uploadedFiles
        ]);
    }

    public function updateGambarSk()
    {
        // $number      = $this->request->getPost('number');
        $typeSoal     = $this->request->getPost('typeSoal');
        $kolom_id    = $this->request->getPost('kolom_id');
        $sk_group_id = $this->request->getPost('sk_group_id');
        $jawaban_nm_lama = $this->request->getPost('jawaban_nm_lama');
        $group_id = 4;
        $soal_nm = [];  
        $allowedMime = ['image/png', 'image/jpg', 'image/jpeg'];

        $path = FCPATH . "images/soalsk/kolom/$kolom_id/sk_group/$sk_group_id";

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $uploadedFiles = [];

        // LOOP gambarsk1 s/d gambarsk5
        for ($i = 1; $i <= 5; $i++) {
            $file = $this->request->getFile('gambarsk' . $i);

            // skip jika tidak ada file
            if (!$file || !$file->isValid()) {
                continue;
            }

            // validasi mime
            if (!in_array($file->getMimeType(), $allowedMime)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Hanya gambar diperbolehkan (gambarsk' . $i . ')'
                ]);
            }

            // nama file unik per gambar
            if ($i == 1) {
                $pilihan = 'A';
            } else if ($i == 2) {
                $pilihan = 'B';
            } else if ($i == 3) {
                $pilihan = 'C';
            } else if ($i == 4) {
                $pilihan = 'D';
            } else if ($i == 5) {
                $pilihan = 'E';
            }

            $newName = $i . $pilihan  . '_' . $kolom_id . '_' . $sk_group_id . '.' . $file->getExtension();
            $fullPath = $path . '/' . $newName;

            // replace file lama
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // upload
            if ($file->move($path, $newName)) {
                $uploadedFiles[] = $newName;
                $soal_nm[] = $newName;
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $file->getErrorString()
                ]);
            }
        }

        if (empty($uploadedFiles)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tidak ada file yang diupload'
            ]);
        }

        $soal_nm = implode('|', $soal_nm);
        
        $soal_id = $this->soalmodel->getSoalIdByClueSKGambar($jawaban_nm_lama, $group_id, $sk_group_id, $kolom_id, 98)->getResult();
        // echo json_encode($soal_id);exit;
        $res = $this->randomcharGambarUpdate($soal_nm, $kolom_id, 98, $sk_group_id, $group_id, $soal_id, $jawaban_nm_lama);

        echo json_encode($res); // $res = $this->randomcharGambar($soal_nm,$kolom_id,98,$sk_group_id);

        // return $res;
    }

    public function updateclue() {
        if ($this->session->get("user_nm") == "") {
			return view('login');
		} 

        $group_id = 4;
        $sk_group_id = $this->request->getPost('sk_group_id');
        $materi_id = $this->request->getPost('materi_id');
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $jawaban_nm_lama = $this->request->getPost('jawaban_nm_lama');
        $kolom_id = $this->request->getPost('kolom_id');
        
        if ($this->request->getPost('jawaban_nm_lama') == $this->request->getPost('jawaban_nm')) {
            $res = "finish";
        } else {
            $soal_id = $this->soalmodel->getSoalIdByClue($jawaban_nm_lama, $group_id, $sk_group_id, $kolom_id)->getResult();
            $res = $this->randomcharUpdate($jawaban_nm, $kolom_id, $materi_id, $sk_group_id, $group_id, $soal_id, $jawaban_nm_lama);
        }
        
        echo json_encode($res);
    }

    public function randomcharUpdate($char,$kolom,$materi_id,$sk_group_id,$group_id,$soal_id,$jawaban_nm_lama) {
        // echo json_encode($soal_id);exit;
        $characters = $char; 
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        $index = 0;
        for ($i = 0; $i < 50; $i++) {
            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            if ($kunci == "A") {
                $hilang = $characters[0];
            } else if ($kunci == "B") {
                $hilang = $characters[1];
            } else if ($kunci == "C") {
                $hilang = $characters[2];
            } else if ($kunci == "D") {
                $hilang = $characters[3];
            } else if ($kunci == "E") {
                $hilang = $characters[4];
            }
            
            $soal_txt = $this->randsoal($characters,"");
           
            if (strlen($soal_txt) === 5) {
                $soal_nm = str_replace($hilang,"",$soal_txt);
            } else {
                $soal_nm = $soal_txt;
            }

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $characters,
                'sk_group_id' => $sk_group_id,
                'typesoal' => "text"
            ];

            $updatesoal = $this->soalmodel->updatesoalsk($group_id,$sk_group_id,$kolom,$data,$soal_id[$index]->soal_id,$jawaban_nm_lama);

            if ($updatesoal) {
                $dataJawaban = [
                    "pilihan_nm" => $pilihan,
                    "jawaban_nm" => $characters,
                    "status_cd" => "normal"
                ];
    
                $updatejawaban = $this->soalmodel->updatejawabansk($characters,$dataJawaban,$soal_id[$index]->soal_id,$jawaban_nm_lama);
                if ($updatejawaban) {
                    $ret = "finish";
                } else {
                    $ret = "gagaljwb";
                }
                
            } else {
                $ret = "gagalsoal";
            }
            
            $no++;
            $index++;
        }
        return $ret;
    }

    public function randsoal($characters,$randSoal) {
        $randomString = $randSoal;
        for ($s = 0; $s < 5; $s++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        
        $randSoal = count_chars($randomString,3);
        if (strlen($randSoal) == 5) {
            $soal_nm = str_shuffle($randSoal);
        } else {
            $soal_nm = $this->randsoal($characters,$randSoal);
        }

        return $soal_nm;
    }

    public function randsoalGambar(array $characters): string
    {
        // acak urutan
        shuffle($characters);

        // ambil 5 (aman kalau isinya memang 5)
        $selected = array_slice($characters, 0, 5);

        // gabungkan jadi string
        return implode('|', $selected);
    }

    public function randomcharGambarUpdate($char, $kolom, $materi_id, $sk_group_id, $group_id, $soal_id, $jawaban_nm_lama)
    {
        
        $characters = explode('|', $char);
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        $index = 0;
        for ($i = 0; $i < 50; $i++) {

            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            
            $index = ord($kunci) - 65;
            $hilang = $characters[$index] ?? '';
             
            $soal_txt = $this->randsoalGambar($characters);
            $soal_arr = explode('|', $soal_txt);
            $soal_arr = array_values(array_diff($soal_arr, [$hilang]));
            $soal_nm = implode('|', $soal_arr); 

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => 4,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $char,
                'sk_group_id' => $sk_group_id,
                'typesoal' => "gambar"
            ];
            
            $updatesoal = $this->soalmodel->updatesoalsk($group_id,$sk_group_id,$kolom,$data,$soal_id[$i]->soal_id,$jawaban_nm_lama);

            if ($updatesoal) {
                $dataJawaban = [
                    "pilihan_nm" => $pilihan,
                    "jawaban_nm" => $char,
                    "status_cd" => "normal"
                ];
    
                $updatejawaban = $this->soalmodel->updatejawabansk($characters,$dataJawaban,$soal_id[$i]->soal_id,$jawaban_nm_lama);
                if ($updatejawaban) {
                    $ret = "finish";
                } else {
                    $ret = "gagaljwb";
                }
                
            } else {
                $ret = "gagalsoal";
            }

            $no++;
            $index++;
        }

        return $ret;
    }

    public function randomcharGambar($char, $kolom, $materi_id, $sk_group_id)
    {
        $characters = explode('|', $char);
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;

        for ($i = 0; $i < 50; $i++) {

            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            
            $index = ord($kunci) - 65;
            $hilang = $characters[$index] ?? '';
             
            $soal_txt = $this->randsoalGambar($characters);
            $soal_arr = explode('|', $soal_txt);
            $soal_arr = array_values(array_diff($soal_arr, [$hilang]));
            $soal_nm = implode('|', $soal_arr); 

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => 4,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $char, // simpan string aslinya
                'sk_group_id' => $sk_group_id,
                'typesoal' => "gambar"
            ];

            $soal_id = $this->soalmodel->insertsoalSKlatihan($data);

            $datax = [
                "soal_id" => $soal_id,
                "pilihan_nm" => $pilihan,
                "jawaban_nm" => $char,
                "jawaban_img" => "",
                "status_cd" => "normal"
            ];

            $this->soalmodel->insertjawabanSKlatihan($datax);
            $no++;
        }

        return "finish";
    }


    public function randomchar($char,$kolom,$materi_id,$sk_group_id) {
        $characters = $char; 
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        for ($i = 0; $i < 50; $i++) {
            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            
            if ($kunci == "A") {
                $hilang = $characters[0];
            } else if ($kunci == "B") {
                $hilang = $characters[1];
            } else if ($kunci == "C") {
                $hilang = $characters[2];
            } else if ($kunci == "D") {
                $hilang = $characters[3];
            } else if ($kunci == "E") {
                $hilang = $characters[4];
            }
            
            $soal_txt = $this->randsoal($characters,"");
           
            if (strlen($soal_txt) === 5) {
                $soal_nm = str_replace($hilang,"",$soal_txt);
            } else {
                $soal_nm = $soal_txt;
            }

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => 4,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $characters,
                'sk_group_id' => $sk_group_id,
                'typesoal' => "text"
            ];

            $soal_id = $this->soalmodel->insertsoalSKlatihan($data);

            $datax = [
                "soal_id" => $soal_id,
                "pilihan_nm" => $pilihan,
                "jawaban_nm" => $characters,
                "jawaban_img" => "",
                "status_cd" => "normal"
            ];
    
            $this->soalmodel->insertjawabanSKlatihan($datax);
            $no++;
        }

        return "finish";
    }
}