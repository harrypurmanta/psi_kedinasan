<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Tryout extends BaseController
{
    protected $soalmodel;
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
        if ($request->uri->getSegment(4) == 4) {
            $kolom_id = 1;
        } else {
            $kolom_id = 0;
        }
        
        $data['soal'] = $this->soalmodel->getSoal(1,$request->uri->getSegment(4),$materi_id,$kolom_id)->getResult();
        // print_r($data['soal']);exit;
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
            // $sl_rt = $this->soalmodel->selectRemainingTime($this->session->user_id,$materi,"tryout")->getResult();
            // if (count($sl_rt)>0) {
            //     if ($sl_rt[0]->isFinish == "proses" && $proc == "start") {
            //         $cnvrt = str_replace(":","",$sl_rt[0]->remaining_time);
            //         $sisawaktu = $cnvrt / 60;
            //     } else {
            //         $data = [
            //             "remaining_time" => $waktu,
            //             "date" => $date,
            //             "status_cd" => "normal"
            //         ];
            //         $this->soalmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
            //     }
                
            // } else {
            //     $data = [
            //         "remaining_time" => $waktu,
            //         "date" => $date,
            //         "status_cd" => "normal",
            //         "user_id" => $this->session->user_id,
            //         "materi_id" => $materi,
            //         "type" => "tryout",
            //         "isFinish" => "proses"
            //     ];
            //     $this->soalmodel->insertRemainingTime($data);
            // }
            
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
                    // $data = [
                    //     "remaining_time" => $waktu,
                    //     "date" => $date,
                    //     "status_cd" => "normal",
                    //     "isFinish" => "finish"
                    // ];
                    // $this->soalmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $group_id = $res[0]->group_id;   
                        $kolom_id = $res[0]->kolom_id;
                        $res_ttlsoal = $this->soalmodel->getTotalSoal($group_id,$materi)->getResult();
                    }
    
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->soalmodel->getResponBox($boxsoal->soal_id,$group_id,$materi,$this->session->user_id)->getResult();
                        if ($group_id == 2) {
                            $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                            $boxcursor = "cursor:pointer;";
                        } else {
                            $boxclick = "";
                            $boxcursor = "";
                        }
        
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
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' class='p-10 col-md-12 jawaban_dv' style='display:flex;padding: 5px;margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;cursor:pointer;'><label for='pilihan_nm' style='margin-left:10px;'> ".$key->pilihan_nm.".</label> &nbsp;".$key->jawaban_nm."
                            <div>$img_jwb</div>
                                </div>";
                    }
                    $button = "";
                    if (count($res_ttlsoal) == $no_soal) {
                        $group_id = $group_id + 1;
                        $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    } else {
                        if ($group_id == 2) {
                            $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                        }
                        
                        $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    }
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "group_id"=>$group_id,"kolom_id"=>$kolom_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms));
                }
        }
        
    }

    public function sikapkerja() {
        $request = \Config\Services::request();
        $data['group'] = $this->soalmodel->getGroup()->getResult();
        $materi_id = $request->uri->getSegment(3);
        $group_id = $request->uri->getSegment(4);
        return view('front/sikapkerja',$data);
    }

    public function sikapkerjaujian() {
        $request = \Config\Services::request();
        $proc = $this->request->getPost("proc");
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $group_id = $this->request->getPost("group_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $kolom_id = $this->request->getPost("kolom_id");
        $materi = $this->request->getPost("materi");
        $date = date("Y-m-d H:i:s");
        if (isset($jawaban_id)) {
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
                "session" => $this->session->session
            ];
            $respon_id = $this->soalmodel->simpanRespon($data);
        }
        $no_soal = $no_soal + 1;
        // if ($proc == "start") {
        //     $kolom_id = $kolom_id + 1;
        // } 

        if ($proc == "persiapan") {
            echo json_encode(array("ret"=>"persiapan", "kolom"=>$kolom_id));
        } else if ($no_soal == 51 && $group_id == 4 && $kolom_id <= 10) {
            echo json_encode(array("ret"=>"persiapan", "kolom"=>$kolom_id));
        } else if ($group_id == 4 && $kolom_id == 11) {
            echo json_encode(array("ret"=>"selesai"));
        } else {
            $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
            if (count($res)>0) {
                $ret = "<div class='col-md-12'>
                    <table border='0' style='margin: 0 auto;'>
                        <tbody>
                            <tr style='font-size:75px;font-weight:bold;text-align:center;'>";
                            $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                                foreach ($getjawaban as $key) {
                                    $jawaban_nm = str_split($key->jawaban_nm,1);
                                    foreach ($jawaban_nm as $jwb_nm) {
                                        $ret .= "<td width='70'>$jwb_nm</td>";
                                    }
                                }

                        $ret .= "</tr>
                            <tr style='font-size:35px;font-weight:normal;text-align:center;'>
                                <td>A</td>
                                <td>B</td>
                                <td>C</td>
                                <td>D</td>
                                <td>E</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class='col-md-12' style='width:100%;margin-top:30px;'>
                    <label style='font-size:20px;' for='Pertanyaan'>Pertanyaan ".$no_soal."</label>
                    <div style='display:flex;'>";
                        foreach ($res as $keySoal) {
                            $soal_nm = str_split($keySoal->soal_nm,1);
                            foreach ($soal_nm as $jwb_nm) {
                                $ret .= "<div style='background-color:grey;min-width:70px;min-height:70px;font-size:65px;font-weight:bold;text-align:center;margin:10px;'>
                        ".$jwb_nm."</div>";
                            }
                        }
                        
                $ret .= "</div>
                    <div style='display:flex;'>";
                    foreach ($getjawaban as $k) {
                        $jawaban_id = $k->jawaban_id;
                        $ret .= "<button onclick='startujian(\"next\",\"A\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='margin:5px;font-weight:bold;font-size: 20px;'
                        class='btn btn-block btn-outline-success'>A</button>
                    <button onclick='startujian(\"next\",\"B\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='margin:5px;font-weight:bold;font-size: 20px;'
                        class='btn btn-block btn-outline-success'>B</button>
                    <button onclick='startujian(\"next\",\"C\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='margin:5px;font-weight:bold;font-size: 20px;'
                        class='btn btn-block btn-outline-success'>C</button>
                    <button onclick='startujian(\"next\",\"D\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='margin:5px;font-weight:bold;font-size: 20px;'
                        class='btn btn-block btn-outline-success'>D</button>
                    <button onclick='startujian(\"next\",\"E\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='margin:5px;font-weight:bold;font-size: 20px;'
                        class='btn btn-block btn-outline-success'>E</button>";
                    }
                        
                $ret .= "</div>
                </div>";
                echo json_encode(array("ret"=>$ret, "kolom"=>$kolom_id,"group_id"=>$group_id,"no_soal"=>$no_soal));
            } else {
                $ret = "soal_tidak_ada";
                echo json_encode(array("ret"=>$ret));
            }
        }
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
            if ($materi_id == 8) {
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