<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Pembahasanmodel;
class Pembahasan extends BaseController
{
    protected $soalmodel;
    protected $pembahasanmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
        $this->pembahasanmodel = new Pembahasanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult()
            ];
            return view('front/pembahasan/pembahasan',$data);
        }
        
    }

    public function pilihanMateri() {
        $request = \Config\Services::request();
        $data = [
            'materi_id' => $request->uri->getSegment(3),
            'group' => $this->soalmodel->getGroupByid($request->uri->getSegment(4))->getResult(),
        ];

        return view('front/pembahasan/pembahasan_pilihanmateri',$data);
    }

    public function ujian() {
        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(3);
        $group_id = $request->uri->getSegment(4);
        $data['group'] = $this->pembahasanmodel->getGroup()->getResult();
        $data['soal'] = $this->pembahasanmodel->getSoal(1,2,$materi_id,0)->getResult();
        $data['jawaban'] = $this->pembahasanmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->pembahasanmodel->getTotalSoal(1,$request->uri->getSegment(3))->getResult();

        $data['used'] = $this->pembahasanmodel->getUsed($this->session->user_id,$materi_id)->getResult();
        
        if (count($data['used'])>0) {
            if ($group_id == 3) {
                $data['used'] = $data['used'][0]->used;
            } else {
                $data['used'] = $data['used'][0]->used + 1;
            }
        } else {
            $data['used'] = 1;
        }
        return view('front/pembahasan/tryout',$data);
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
        $used = $this->request->getPost("used");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";

        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                $getResponByid = $this->pembahasanmodel->getResponByPrev($soal_id,$group_id,$materi,$this->session->user_id,$used)->getResult();
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
                        "kolom_id" => $kolom_id,
                        "used" => $used
                    ];
        
                    $updaterespon = $this->pembahasanmodel->updateResponPrev($soal_id,$jawaban_id,$group_id,$materi,$this->session->user_id,$data,$used);
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
                            "used" => $used
                        ];
            
                        $respon_id = $this->pembahasanmodel->simpanRespon($data);
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
                    $res = $this->pembahasanmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $group_id = $res[0]->group_id;   
                        $kolom_id = $res[0]->kolom_id;
                        $res_ttlsoal = $this->pembahasanmodel->getTotalSoal($group_id,$materi)->getResult();
                    }
                    $pilihan_nmx = "";
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->pembahasanmodel->getResponBox($boxsoal->soal_id,$group_id,$materi,$this->session->user_id,$used)->getResult();
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
                        <img style='max-height:100%; max-width:100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."' class='img-fluid'>
                        </a>
                    </div>";
                    }
                    
                    $getjawaban = $this->pembahasanmodel->getjawaban($res[0]->soal_id)->getResult();
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
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' class='btn col-md-12 jawaban_dv' style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;white-space: normal;'> <label for='pilihan_nm'>".$key->pilihan_nm.". </label> <span>".$key->jawaban_nm."</span>
                        <div>$img_jwb</div>
                            </div>";
                    }

                    // PEMBAHASAN

                $pembahasan = "<div class='col-md-12'>
                <button onclick='if(document.getElementById(\"spoiler\") .style.display==\"none\") {document.getElementById(\"spoiler\") .style.display=\"\"}else{document.getElementById(\"spoiler\") .style.display=\"none\"}' style='margin-bottom:10px;float: right;' type='button' class='btn bg-gradient-secondary'>pembahasan</button><br>
                <div id='spoiler' style='display:none;border: 1px solid black;background-color: #8fbc8f;border-radius:5px;'>";
                // if ($group_id == 2) {
                if ($res[0]->pembahasan_img != "") {
                     $pembahasan .= "<img style='padding:10px;max-height:100%; max-width:100%;' src='".base_url()."/images/pembahasan/".$res[0]->materi."/".$res[0]->pembahasan_img."'>";
                }
                   
                    $pembahasan .= "<div style='margin: 20px;background-color: white;padding: 10px;'><span>".$res[0]->pembahasan."</span></div>";
                // } else if ($group_id == 3) {
                    $resjawaban_nm = $this->pembahasanmodel->getJawabannm($res[0]->kunci,$res[0]->soal_id)->getResult();
                    $pembahasan .= "<div style='margin: 20px;background-color: white;padding: 10px;'><span>".$resjawaban_nm[0]->pilihan_nm.". ".$resjawaban_nm[0]->jawaban_nm."</span></div>";
                // }
                
        $pembahasan .= "</div>
             </div>";
                    
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
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "group_id"=>$group_id,"kolom_id"=>$kolom_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"pembahasan"=>$pembahasan));
                }
        }
        
    }

    public function hasil() {
        $request = \Config\Services::request();
        $user_id = $this->session->user_id;
        $materi_id = $request->uri->getSegment(3);
        $used = $request->uri->getSegment(4);
        $benar_kec = 0;
            $salah_kec = 0;
            $benar_keb = 0;
            $salah_keb = 0;
            $persen_kec  = 0;
            $persen_kep  = 0;
            
            $kecerdasanskor = $this->pembahasanmodel->getKecerdasanSkor($user_id,$materi_id,$used)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }
            $data['persen_kec'] = ($benar_kec * 0.0025) * 100;

            $kepskor = $this->pembahasanmodel->getKepribadianSkor($user_id,$materi_id,$used)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            
            $data['persen_kep'] = ($benar_keb * 0.005) * 100;
            $data['total_skor'] = $data['persen_kep'] + $data['persen_kec'];
            $data['materi_id'] = $materi_id;
            // if ($materi_id == 10) {
            //     $ressession = $this->pembahasanmodel->getSessionSkor($this->session->user_id)->getResult();
            //     foreach ($ressession as $sesskr) {
            //         $persen_kec  = $sesskr->skor_kec; 
            //         $persen_kep  = $sesskr->skor_kep;
            //         $data['total_skor'] = $persen_kep + $persen_kec;
            //     }
            // }
        return view('front/pembahasan/hasilpembahasan',$data);
    }
}