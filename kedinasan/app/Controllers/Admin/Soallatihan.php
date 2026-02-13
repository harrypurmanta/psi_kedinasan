<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
use App\Models\Jawabanmodel;
use App\Models\Latihanmodel;
class Soallatihan extends BaseController
{
    protected $soalmodel;
    protected $jawabanmodel;
    protected $latihanmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->jawabanmodel = new Jawabanmodel();
        $this->latihanmodel = new Latihanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult(),
                'soal' => $this->showsoal()
            ];
            return view('admin/soallatihan/soal',$data);
        }
        
    }

    public function setSessionJenis()
    {
        $group_id = $this->request->getPost('group_id');
        $this->session->set('group_id', $group_id);

        $jenis_id = $this->request->getPost('jenis_id');
        $this->session->set('jenis_id', $jenis_id);
    }
    public function getJenis() {
        $group_id       = $this->request->getPost('group_id');
        $this->session->set('group_id', $group_id);
        $res = $this->latihanmodel->getJenisByGroupId($group_id)->getResult();
        echo json_encode($res);
    }

    public function viewTambahsoal() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            if ($this->session->jenis_id == "" || $this->session->jenis_id == null ) {
                $jenis_id = 1;
            } else {
                $jenis_id = $this->session->jenis_id;
            }
    
            if ($this->session->group_id == "" || $this->session->group_id == null ) {
                $group_id = 1;
            } else {
                $group_id = $this->session->group_id;
            }

            $data = [
                'no_soal' => $this->latihanmodel->getNoSoal($jenis_id, $group_id)->getResult(),
                'jenis_soal' => $this->latihanmodel->getJenisByGroupId($group_id)->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult(),
                'soal' => $this->showsoal()
            ];
            // echo '<pre>';
            // var_dump($group_id);
            // echo '</pre>';
            // exit;
            return view('admin/soallatihan/tambahsoal',$data);
        }
    }

    public function viewEditsoal() {
        $soal_id = $this->request->getUri()->getSegment(4);
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            if ($this->session->jenis_id == "") {
                $jenis_id = 1;
            } else {
                $jenis_id = $this->session->jenis_id;
            }
    
            if ($this->session->group_id == "") {
                $group_id = 1;
            } else {
                $group_id = $this->session->group_id;
            }

            $data = [
                'no_soal' => $this->latihanmodel->getNoSoal($jenis_id,$group_id)->getResult(),
                'jenis_soal' => $this->latihanmodel->getJenisByGroupId($group_id)->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult(),
                'soal' => $this->latihanmodel->getSoalByid($soal_id)->getResult(),
                'jawaban' => $this->latihanmodel->getJawabanBySoalId($soal_id)->getResult(),
                'soal_id' => $this->request->getUri()->getSegment(4)
            ];
            // echo json_encode($data);exit;
            return view('admin/soallatihan/editsoal',$data);
        }
    }

    public function getNoSoal() {
        $group_id       = $this->request->getPost('group_id');
        $jenis_id      = $this->request->getPost('jenis_id');
        $no_soal = 1;
        if (isset($group_id) && isset($jenis_id)) {
            $res_soal = $this->latihanmodel->getNoSoal($jenis_id, $group_id)->getResult();
            if ($res_soal[0]->no_soal == null) {
                $no_soal = 1;
            } else {
                $no_soal = $res_soal[0]->no_soal + 1;
            }
        } 
        echo json_encode($no_soal);
    }

    public function showsoal() {
        $group_id   = $this->request->getPost('group_id');
        $jenis_id   = $this->request->getPost('jenis_id');
        $res        = $this->latihanmodel->getSoalBygrJns($group_id, $jenis_id)->getResult();
        echo json_encode($res);
    }

    public function hapusgambar() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $jawaban = $this->latihanmodel->getJawabanById($jawaban_id)->getResult();
        $data = [
            "jawaban_img" => NULL
        ];

        $update = $this->latihanmodel->hapusgambar($jawaban_id);
        if ($update) {
            unlink("../public/images/jawaban_latihan/jenis/".$jawaban[0]->jenis_id."/".$jawaban[0]->jawaban_img);
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal = $this->latihanmodel->getSoalByid($soal_id)->getResult();
        $data = [
            "soal_img" => NULL
        ];

        $update = $this->latihanmodel->hapusgambarsoal($soal_id);

        if ($update) {
            unlink("../public/images/soal_latihan/jenis/".$soal[0]->jenis_id."/".$soal[0]->soal_img);
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarpembsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            "pembahasan_img" => NULL
        ];
        $update = $this->soalmodel->hapusgambarpembsoal($soal_id);
        if ($update) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function simpansoal() {
        $soal_nm = $this->request->getPost('soal_nm');
        $jenis_id = $this->request->getPost('jenis_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $this->session->set("group_id",$group_id);
        $this->session->set("jenis_id",$jenis_id);
        $imagefile = $this->request->getFiles();

        $newName = "";
        $pembahasan_img = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $newName = $img->getClientName();
                    $img->move("../public/images/soal_latihan/jenis/$jenis_id", $newName);
                    copy("../public/images/soal_latihan/jenis/$jenis_id/$newName","../public/images/soal_latihan/jenis/$jenis_id/besar/$newName");
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     $pembahasan_img = $imgs->getClientName();
                     $targetPath = "../public/images/pembahasan_latihan/$group_id/$jenis_id";

                    // cek jika folder belum ada, buat otomatis
                    if (!is_dir($targetPath)) {
                        mkdir($targetPath, 0777, true); // recursive = true supaya bisa buat berlapis
                    }
                    
                     $imgs->move("../public/images/pembahasan_latihan/$group_id/$jenis_id", $pembahasan_img);
                    //  $imgs->move("../public/images/pembahasan/materi/$materi_id/besar/level/$level_nm", $pembahasan_img);
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }

      
        $soal_id = $this->latihanmodel->simpansoallatihan($data);
        if ($soal_id) {
            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getClientName();
                     $imgA->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            $simpanA = $this->latihanmodel->simpanjawaban($dataA);

            if ($simpanA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getClientName();
                         $imgB->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $simpanB = $this->latihanmodel->simpanjawaban($dataB);
                if ($simpanB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getClientName();
                             $imgC->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }

                    $simpanC = $this->latihanmodel->simpanjawaban($dataC);
                    if ($simpanC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getClientName();
                                 $imgD->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        

                        $simpanD = $this->latihanmodel->simpanjawaban($dataD);
                        if ($simpanD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getClientName();
                                     $imgE->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->latihanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->latihanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }

                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }

        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
        // echo json_encode($group[0]->group_nm);
    }

    public function updatesoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal_nm = $this->request->getPost('soal_nm');
        $jenis_id = $this->request->getPost('jenis_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');
        // $resLevel = $this->levelmodel->getlevelById($level_id)->getResult();
        $imagefile = $this->request->getFiles();

        // $level_nm = $resLevel[0]->level_nm;
        $this->session->set("group_id",$group_id);
        $this->session->set("jenis_id",$jenis_id);

        $jawaban_id_A = $this->request->getPost('jawaban_id_A');
        $jawaban_id_B = $this->request->getPost('jawaban_id_B');
        $jawaban_id_C = $this->request->getPost('jawaban_id_C');
        $jawaban_id_D = $this->request->getPost('jawaban_id_D');
        $jawaban_id_E = $this->request->getPost('jawaban_id_E');

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $newName = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $newName = $img->getClientName();
                    $img->move("../public/images/soal_latihan/jenis/$jenis_id", $newName);
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     $pembahasan_img = $imgs->getClientName();
                     $imgs->move("../public/images/pembahasan_latihan/$group_id/$jenis_id", $pembahasan_img);
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }
        
        $update = $this->latihanmodel->updatesoal($soal_id,$data);
        
        if ($update) {
            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getRandomName();
                     $imgA->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            
            $updateA = $this->latihanmodel->updatejawaban($jawaban_id_A, $dataA);
            
            if ($updateA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getRandomName();
                         $imgB->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $updateB = $this->latihanmodel->updatejawaban($jawaban_id_B,$dataB);
                if ($updateB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getRandomName();
                             $imgC->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }
                    
                    $updateC = $this->latihanmodel->updatejawaban($jawaban_id_C,$dataC);
                    if ($updateC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getRandomName();
                                 $imgD->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        $updateD = $this->latihanmodel->updatejawaban($jawaban_id_D,$dataD);
                        if ($updateD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getRandomName();
                                     $imgE->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->latihanmodel->updatejawaban($jawaban_id_E, $dataE);
                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->latihanmodel->updatejawaban($jawaban_id_E, $dataE);

                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }
                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }
        } else {
            $ret = "gagal";
        }
        
        echo json_encode($ret);
    }

    public function hapussoal() {
        $soal_id = $this->request->getPost('soal_id');
        
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->latihanmodel->hapussoal($soal_id, $data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function updatestatus() {
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $kolom_id = $this->request->getPost('kolom_id');
        $status_cd = $this->request->getPost('status_cd');
        $old_status = $this->request->getPost('old_status');

        $update = $this->latihanmodel->updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status);
        log_message("debug",$status_cd);
    }

}