<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Tryout extends BaseController
{
    protected $soalmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
	}

    public function index()
    {
        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(2);
        $data['group'] = $this->soalmodel->getGroup()->getResult();
        $data['soal'] = $this->soalmodel->getSoal(1,1,$materi_id,0)->getResult();
        $data['jawaban'] = $this->soalmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->soalmodel->getTotalSoal(1,$request->uri->getSegment(2))->getResult();
        return view('front/tryout',$data);
    }

    public function ujian() {
        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(3);
        $data['group'] = $this->soalmodel->getGroup()->getResult();
        if ($request->uri->getSegment(4) == 10) {
            $kolom_id = 1;
        } else {
            $kolom_id = 0;
        }
        
        $data['soal'] = $this->soalmodel->getSoal(1,$request->uri->getSegment(4),$materi_id,$kolom_id)->getResult();
        $data['jawaban'] = $this->soalmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->soalmodel->getTotalSoal(1,$request->uri->getSegment(3))->getResult();
        return view('front/tryout',$data);
    }
    
    public function startujian() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $group_id = $this->request->getPost("group_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $kolom_id = $this->request->getPost("kolom_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                $getResponByid = $this->soalmodel->getResponByPrev($soal_id,$group_id,$materi,$this->session->user_id)->getResult();
                if (count($getResponByid)>0) {
                    $data = [
                        "jawaban_id" => $jawaban_id,
                        "pilihan_nm" => $pilihan_nm,
                        "soal_id" => $soal_id,
                        "no_soal" => $no_soal,
                        "group_id" => $group_id,
                        "materi" => $materi,
                        "created_user_id" => $this->session->user_id,
                        "created_dttm" => $date,
                        "used" => 0,
                        "kolom_id" => $kolom_id,
                        // "session" => $this->session->session
                    ];
        
                    $updaterespon = $this->soalmodel->updateResponPrev($soal_id,$jawaban_id,$group_id,$materi,$this->session->user_id,$data);
                } else {
                    if ($jawaban_id !== "null" && isset($soal_id)) {
                        $data = [
                            "jawaban_id" => $jawaban_id,
                            "pilihan_nm" => $pilihan_nm,
                            "soal_id" => $soal_id,
                            "no_soal" => $no_soal,
                            "group_id" => $group_id,
                            "materi" => $materi,
                            "used" => 0,
                            "kolom_id" => $kolom_id,
                            "created_user_id" => $this->session->user_id,
                            "created_dttm" => $date,
                            // "session" => $this->session->session
                        ];
            
                        $respon_id = $this->soalmodel->simpanRespon($data);
                    }
                }
            }
                if ($proc == "selesai") {
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    // echo json_encode($no_soal);exit;
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $group_id = $res[0]->group_id;   
                        $kolom_id = $res[0]->kolom_id;
                        $res_ttlsoal = $this->soalmodel->getTotalSoal($group_id,$materi)->getResult();
                    } 
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->soalmodel->getResponBox($boxsoal->soal_id,$group_id,$materi,$this->session->user_id)->getResult();
                        $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                        $boxcursor = "cursor:pointer;";

                        if (count($getResponBox)>0) {
                            $pilihan_nm = " ".$getResponBox[0]->pilihan_nm;
                            $style="border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $getResponBox[0]->pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        } else {
                            $pilihan_nm = "";
                            $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        }
                        $boxnomorsoal .= "<div class='col-md-2' style='$style font-size:12px;' $boxclick>".$boxsoal->no_soal."$pilihan_nm</div>";
                    }
                    

                    if ($res[0]->soal_img == "") {
                        $img_soal = "";
                    } else {
                        $img_soal = "<div class='col-sm-10'>
                        <a href='".base_url()."/images/soal/materi/".$res[0]->materi."/besar/".$res[0]->soal_img."' data-toggle='lightbox'>
                        <img style='max-width: 350px;max-height: 100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."' class='img-fluid'>
                        </a>
                    </div>";
                    }
    
                    $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                    $jawaban_idx = "";
                    $pilihan_nms = "";
                    foreach ($getjawaban as $key) {
                        if ($pilihan_nmx == $key->pilihan_nm) {
                            $jawaban_idx = $key->jawaban_id;
                            $pilihan_nms = $key->pilihan_nm;
                            $border = "margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;border: thick solid rgb(0, 166, 90);";
                        } else {
                            $border = "";
                        }
                        
                        if ($key->jawaban_img == "") {
                            $img_jwb = "";
                        } else {
                            $img_jwb = "<img style='max-width:350px;height:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/".$key->jawaban_img.".jpg'>";
                        }
                        
                        $jawaban .= "
                            <div id='dv_jawaban_".$key->jawaban_id."' 
                                onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' 
                                class='btn col-md-12 jawaban_dv' 
                                style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align:left;
                                        word-break: break-all; overflow-wrap: break-word; white-space: normal;'>
                                
                                <label for='pilihan_nm'>".$key->pilihan_nm.". </label> 

                                <span>
                                    ".$key->jawaban_nm."
                                </span>

                                <div>$img_jwb</div>
                            </div>";
                    }
                    $button = "";
                    $getjumlahjawab = $this->soalmodel->getResponCountByMateriUser($group_id,$materi,$this->session->user_id)->getResult();
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }
                    
                    if ($no_soal == 1) {
                        
                    } else {
                        $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                    }

                    $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    
                    if ($jumlahjawab == count($res_ttlsoal) - 1) {
                        $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    } 

                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "group_id"=>$group_id,"kolom_id"=>$kolom_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab));
                }
        }
        
    }

    public function ujianPauli() {
        $request = \Config\Services::request();
        $data["materi_id"]  = $request->uri->getSegment(3);
        $data["group_id"]   = $request->uri->getSegment(4);
        $kolom_id = 0;
        
        return view('front/pauli/ujian',$data);
    }

    public function pauliujian() {
        $req = $this->request;

        $proc        = $req->getPost("proc");
        $soal_id     = $req->getPost("soal_id");
        $jawaban_id  = $req->getPost("jawaban_id");
        $group_id    = $req->getPost("group_id");
        $no_soal     = (int)$req->getPost("no_soal");
        $pilihan_nm  = $req->getPost("pilihan_nm");
        $kolom_id    = (int)$req->getPost("kolom_id");
        $materi      = $req->getPost("materi");
        $sk_group_id = (int)$req->getPost("sk_group_id");
        
        $user_id = $this->session->user_id;
        
        $date = date("Y-m-d H:i:s");

        if (!$this->session->has('used')) {
            $this->session->set('used', 1);
        }

        if ($jawaban_id != "") {
            $data = [
                "jawaban_id"      => $jawaban_id,
                "pilihan_nm"      => $pilihan_nm,
                "soal_id"         => $soal_id,
                "no_soal"         => $no_soal,
                "group_id"        => $group_id,
                "materi"          => $materi,
                "used"            => $this->session->used,
                "kolom_id"        => $kolom_id,
                "created_user_id" => $user_id,
                "created_dttm"    => $date,
                "session"         => $this->session->session
            ];
            
            $exists = $this->soalmodel->getResponPauli($soal_id, $group_id, $materi, $user_id, $sk_group_id)->getResult();
            
            if (count($exists) > 0) {
                $updaterespon = $this->soalmodel->updateResponPauli($soal_id,$group_id,$materi,$user_id,$sk_group_id,$data);
            } else {
                $this->soalmodel->simpanResponSK($data);
            }
        }
        
        $no_soal++;

        if ($proc === "persiapan" || $no_soal == 51 && $group_id == 9 && $kolom_id <= 20 && $sk_group_id <= 4) {
            return $this->response->setJSON([
                "ret" => "persiapan",
                "kolom_id" => $kolom_id,
                "sk_group_id" => $sk_group_id
            ]);
        }

        if ($proc === "selesai") {
            return $this->response->setJSON(["ret" => "selesai"]);
        }
        
        $soal = $this->soalmodel->getSoalPauliFast($no_soal, $group_id, $materi, $kolom_id, $sk_group_id);

        if (!$soal) {
            return $this->response->setJSON(["ret" => "soal_tidak_ada"]);
        }

        $jawaban = $this->soalmodel->getjawabanPauli($soal->soal_id)->getResult();

        return $this->response->setJSON([
            "ret" => "ok",
            "no_soal" => $no_soal,
            "kolom_id" => $kolom_id,
            "group_id" => $group_id,
            "sk_group_id" => $sk_group_id,
            "data_soal" => [
                "soal_id" => $soal->soal_id,
                "soal_nm" => $soal->soal_nm,
                "jawaban" => $jawaban
            ]
        ]);
    }

    public function updateFinishRespon() {
        $materi_id = $this->request->getPost("materi_id");
        $group_id = $this->request->getPost("group_id");
        $user_id = $this->session->user_id;
        $data = [
            "status_cd" => "finish"
        ];
        $reset = $this->soalmodel->updateFinishRespon($materi_id,$group_id,$user_id,$data);

        echo json_encode($reset);exit;
    }

    public function hasiltryout() {
        $request = \Config\Services::request();
        $user_id = $this->session->user_id;
        $materi_id = $request->uri->getSegment(3);
        $benar_kec = 0;
            $salah_kec = 0;
            $benar_keb = 0;
            $salah_keb = 0;
            $benar_sk  = 0;
            $salah_sk  = 0;
            $total_skor  = 0;
            $persen_kec  = 0;
            $persen_kep  = 0;
            $persen_sk = 0;
            $ttl_benar_sk = 0;
            
            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($user_id,$this->session->session,$materi_id)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }
            
            $data['persen_kec'] = ($benar_kec * 0.0025) * 100;
            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,"",$materi_id)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $data['persen_kep'] = ($benar_keb * 0.005) * 100;

            $klm = $this->soalmodel->getKolomSoal()->getResult();
            foreach ($klm as $key) {
                $benar = 0;
                $salah = 0;
                $soal_terjawab = 0;
                $res_responSK = $this->soalmodel->getResponSikapKerja($user_id,$this->session->session,$key->kolom_id,$materi_id)->getResult();
                if (count($res_responSK)>0) {
                    $soal_terjawab = count($res_responSK);
                    foreach ($res_responSK as $rSK) {
                        // $soal_terjawab = $soal_terjawab + 1;
                        if ($rSK->pilihan_respon == $rSK->kunci) {
                            $benar = $benar + 1;
                        } else {
                            $salah = $salah + 1;
                        }
                    }
                } else {
                    $soal_terjawab = $soal_terjawab;
                }
                $ttl_benar_sk = $ttl_benar_sk + $benar;
            }
            $data['persen_sk'] = ($ttl_benar_sk * 0.0005) * 100;

                $data['total_skor'] = $data['persen_sk'] + $data['persen_kep'] + $data['persen_kec'];
            if ($materi_id == 10) {
                $ressession = $this->soalmodel->getSessionSkor($this->session->user_id)->getResult();
                foreach ($ressession as $sesskr) {
                    $persen_kec  = $sesskr->skor_kec; 
                    $persen_kep  = $sesskr->skor_kep;
                    $persen_sk   = $sesskr->skor_sk;
                    $data['total_skor'] = $persen_sk + $persen_kep + $persen_kec;
                }
            }
        return view('front/hasiltryout',$data);
    }

}