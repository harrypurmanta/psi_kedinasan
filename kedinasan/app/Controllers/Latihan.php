<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Latihanmodel;
class Latihan extends BaseController
{
    protected $soalmodel;
    protected $latihanmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
        $this->latihanmodel = new Latihanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'group' => $this->latihanmodel->getGroupLatihan()->getResult(),
            ];
            return view('front/latihan/index',$data);
        }
        
    }

    public function jenis()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $group_id = $request->uri->getSegment(3);
            $data = [
                'jenis' => $this->latihanmodel->getJenisByGroupId($group_id)->getResult(),
            ];
            return view('front/latihan/jenis',$data);
        }
    }
    
    public function petunjuk()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $group_id = $request->uri->getSegment(3);
            $jenis_id = $request->uri->getSegment(4);

            $data = [
                'group_id' => $group_id,
                'jenis_id' => $jenis_id,
                'group' => $this->soalmodel->getGroupByid($group_id)->getResult(),
                'jenis' => $this->latihanmodel->getJenisById($jenis_id)
        ];

            if ($group_id == 1) {
                return view('front/latihan/petunjukpasshand', $data);
            } else if ($group_id == 2) {
                return view('front/latihan/petunjukkecerdasan', $data);
            } else if ($group_id == 3) {
                return view('front/latihan/petunjukkepribadian', $data);
            } else {
                return view('front/latihan/petunjukpasshand', $data);
            }
        }
    }

    public function tryout()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            $group_id = $request->uri->getSegment(3);
            $jenis_id = $request->uri->getSegment(4);

            $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
            return view('front/latihan/tryout', ['group_id' => $group_id, 'jenis_nm' => $jenis_nm]);
        }
    }


    public function startujian() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $group_id = $this->request->getPost("group_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $used = $this->request->getPost("used");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
       
            if ($proc == "start") {
                $notes = $this->latihanmodel->getLastUsed($this->session->user_id, $jenis_id, $group_id, $materi);
                if ($notes) {
                    $respon = $this->latihanmodel->getResponByUser($this->session->user_id,$jenis_id, $group_id, $materi, $notes->used)->getResult();
                
                    if (count($respon)>0) {
                        $used = $notes->used + 1;
                        $dataexam = [
                            "jenis_id" => $jenis_id,
                            "group_id" => $group_id,
                            "materi_id" => $materi,
                            "user_id" => $this->session->user_id,
                            "used" => $used,
                        ];
                        $insertexam = $this->latihanmodel->insertexam($dataexam);
                        
                    } else {
                        $used = $notes->used;
                    }
                } else {
                    $used = 1;
                    $dataexam = [
                        "jenis_id" => $jenis_id,
                        "group_id" => $group_id,
                        "materi_id" => $materi,
                        "user_id" => $this->session->user_id,
                        "used" => $used,
                    ];
                    $insertexam = $this->latihanmodel->insertexam($dataexam);
                }
               
                
            }
            
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                $getResponByid = $this->latihanmodel->getResponByPrev($soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                if (count($getResponByid)>0) {
                    $data = [
                        "jawaban_id" => $jawaban_id,
                        "pilihan_nm" => $pilihan_nm,
                        "soal_id" => $soal_id,
                        "no_soal" => $no_soal,
                        "jenis_id" => $jenis_id,
                        "materi" => $materi,
                        "created_user_id" => $this->session->user_id,
                        "created_dttm" => $date,
                        "used" => $used,
                        "group_id" => $group_id,
                    ];
        
                    $updaterespon = $this->latihanmodel->updateResponPrev($soal_id,$jawaban_id,$jenis_id,$materi,$this->session->user_id,$used,$data);
                } else {
                    if ($jawaban_id !== "null" && isset($soal_id)) {
                        $data = [
                            "jawaban_id" => $jawaban_id,
                            "pilihan_nm" => $pilihan_nm,
                            "soal_id" => $soal_id,
                            "no_soal" => $no_soal,
                            "jenis_id" => $jenis_id,
                            "materi" => $materi,
                            "used" => $used,
                            "group_id" => $group_id,
                            "created_user_id" => $this->session->user_id,
                            "created_dttm" => $date,
                            // "session" => $this->session->session
                        ];
            
                        $respon_id = $this->latihanmodel->simpanRespon($data);
                    }
                }
            }
                $getjumlahjawab = $this->latihanmodel->getResponCountByLatihan($jenis_id, $group_id,$this->session->user_id,$used)->getResult();
                
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }

                $res_ttlsoal = $this->latihanmodel->getTotalSoalLatihan($jenis_id, $group_id)->getResult();
                
                if ($jumlahjawab == count($res_ttlsoal)) {
                    $proc = "selesai";
                }
                
                
                if ($proc == "selesai") {
                    // $data = [
                    //     "remaining_time" => $waktu,
                    //     "date" => $date,
                    //     "status_cd" => "normal",
                    //     "isFinish" => "finish"
                    // ];
                    // $this->latihanmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                    
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $jenis_id = $res[0]->jenis_id;   
                        $group_id = $res[0]->group_id;
                    } 

                    
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->latihanmodel->getResponBox($boxsoal->soal_id,$jenis_id,$materi,$this->session->user_id, $used, $group_id)->getResult();
                        if ($jenis_id == 99) {
                            $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                            $boxcursor = "cursor:pointer;";
                        } else {
                            $boxclick = "";
                            $boxcursor = "";
                        }

                        // if ($no_soal == count($res_ttlsoal)+1) {
                        //     $no_soal_belum[] = $boxsoal->no_soal;
                        //     if (count($no_soal_belum)>0 && $proc == "next" && $res_ttlsoal) {
                        //         $no_soal = $no_soal_belum[0];
                        //     } 
                        //     $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                        // } 

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
    
                    $getjawaban = $this->latihanmodel->getjawaban($res[0]->soal_id)->getResult();
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
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' class='p-10 col-md-12 jawaban_dv' style='display: flex; padding: 5px; margin-top: 10px; margin-bottom: 10px; background-color: #aeaebb;border-radius: 5px; text-align: left; cursor: pointer;'> <label for='pilihan_nm' style='margin-left:10px;'>".$key->pilihan_nm.". </label> <span style='margin-left: 5px;'>".$key->jawaban_nm."</span>
                        <div>$img_jwb</div>
                            </div>";
                    }
                    $button = "";
                    
                    
                    $button .= "<div class='col-md-9'>";
                    if ($jenis_id == 99) {
                        $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                    }
                     $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                     $button .= "</div>";
                    //  if (count($res_ttlsoal) != $no_soal) {
                    //         $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    // }
                    
                    if ($jumlahjawab == count($res_ttlsoal) - 1 || $jumlahjawab == count($res_ttlsoal)) {
                        $button .= "<div class='col-md-3'>";
                        $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                         $button .= "</div>";
                    }
                    
                    // $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-warning'>Selesai</button>";
                   
                   

                    // if (count($res_ttlsoal) == $no_soal) {
                    //     $group_id = $group_id + 1;
                    //     $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    // } else {
                        
                    // }
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "jenis_id"=>$jenis_id,"group_id"=>$group_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab, "used" => $used));
                }
        }
        
    }

    public function updateFinishRespon() {
        $materi_id = $this->request->getPost("materi_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $user_id = $this->session->user_id;

        $data = [
            "status_cd" => "finish"
        ];
        $reset = $this->latihanmodel->updateFinishRespon($materi_id,$jenis_id,$user_id,$used,$data);

        echo json_encode($reset);
    }

    public function hasillatihan() {
        $request = \Config\Services::request();
        // $jenis_id = $this->request->getPost('jenis_id');
        $materi = $request->uri->getSegment(3);
        $jenis_id = $request->uri->getSegment(4);
        $used = $request->uri->getSegment(5);
        $group_id = $request->uri->getSegment(6);
        // echo json_encode($jenis_id);exit;
        $benar  = 0;
        $salah  = 0;
        $res = $this->latihanmodel->getResponLatihan($jenis_id,$this->session->user_id,$used, $group_id)->getResult();
        // echo var_dump($res);exit;

        if (count($res)>0) {
            foreach ($res as $k) {
                if ($k->kunci == $k->pilihan_respon) {
                    $benar = $benar + 1;
                } else {
                    $salah = $salah + 1;
                }
            }
        }

        $data = [
            "benar" => $benar,
            "salah" => $salah
        ];
        
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            return view('front/latihan/hasillatihan', $data);
        }
    }

    public function pembahasan_latihan() {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            $group_id = $request->uri->getSegment(6);
            $jenis_id = $request->uri->getSegment(4);

            $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
            return view('front/pembahasan_latihan/tryout', ['group_id' => $group_id, 'jenis_nm' => $jenis_nm]);
        }
    }

    
    public function startujianpembahasan() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $group_id = $this->request->getPost("group_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $used = $this->request->getPost("used");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
       
            // if ($proc == "start") {
            //     $notes = $this->latihanmodel->getLastUsed($this->session->user_id,$jenis_id, $group_id, $materi);

            //     $respon = $this->latihanmodel->getResponByUser($this->session->user_id,$jenis_id, $group_id, $materi, $notes->used)->getResult();
                
            //     if (count($respon)>0) {
            //         if ($notes) {
            //             $used = $notes->used + 1;
            //         } else {
            //             $used = 1;
            //         }
            //         $dataexam = [
            //             "jenis_id" => $jenis_id,
            //             "group_id" => $group_id,
            //             "materi_id" => $materi,
            //             "user_id" => $this->session->user_id,
            //             "used" => $used,
            //         ];
            //         $insertexam = $this->latihanmodel->insertexam($dataexam);
            //     } else {
            //          if ($notes) {
            //             $used = $notes->used;
            //         } else {
            //             $used = 1;
            //         }
            //     }
            // }

            
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                // $getResponByid = $this->latihanmodel->getResponByPrev($soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                // if (count($getResponByid)>0) {
                //     $data = [
                //         "jawaban_id" => $jawaban_id,
                //         "pilihan_nm" => $pilihan_nm,
                //         "soal_id" => $soal_id,
                //         "no_soal" => $no_soal,
                //         "jenis_id" => $jenis_id,
                //         "materi" => $materi,
                //         "created_user_id" => $this->session->user_id,
                //         "created_dttm" => $date,
                //         "used" => $used,
                //         "group_id" => $group_id,
                //     ];
        
                //     $updaterespon = $this->latihanmodel->updateResponPrev($soal_id,$jawaban_id,$jenis_id,$materi,$this->session->user_id,$used,$data);
                // } else {
                //     if ($jawaban_id !== "null" && isset($soal_id)) {
                //         $data = [
                //             "jawaban_id" => $jawaban_id,
                //             "pilihan_nm" => $pilihan_nm,
                //             "soal_id" => $soal_id,
                //             "no_soal" => $no_soal,
                //             "jenis_id" => $jenis_id,
                //             "materi" => $materi,
                //             "used" => $used,
                //             "group_id" => $group_id,
                //             "created_user_id" => $this->session->user_id,
                //             "created_dttm" => $date,
                //             // "session" => $this->session->session
                //         ];
            
                //         $respon_id = $this->latihanmodel->simpanRespon($data);
                //     }
                // }
            }
                $getjumlahjawab = $this->latihanmodel->getResponCountByLatihan($jenis_id, $group_id,$this->session->user_id,$used)->getResult();
                
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }

                $res_ttlsoal = $this->latihanmodel->getTotalSoalLatihan($jenis_id, $group_id)->getResult();
                
                if ($proc == "selesai") {
                    // $data = [
                    //     "remaining_time" => $waktu,
                    //     "date" => $date,
                    //     "status_cd" => "normal",
                    //     "isFinish" => "finish"
                    // ];
                    // $this->latihanmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                    
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $jenis_id = $res[0]->jenis_id;   
                        $group_id = $res[0]->group_id;
                    } 

                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->latihanmodel->getResponBoxPembahasan($boxsoal->soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                        $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                        $boxcursor = "cursor:pointer;";

                        // if ($no_soal == count($res_ttlsoal)+1) {
                        //     $no_soal_belum[] = $boxsoal->no_soal;
                        //     if (count($no_soal_belum)>0 && $proc == "next" && $res_ttlsoal) {
                        //         $no_soal = $no_soal_belum[0];
                        //     } 
                        //     $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                        // } 

                        if (count($getResponBox)>0) {
                            $pilihan_nm = " ".$getResponBox[0]->pilihan_nm;

                            if ($getResponBox[0]->pilihan_nm == $getResponBox[0]->kunci) {
                                $style="border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;cursor:pointer;";
                            } else {
                                $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;cursor:pointer;";
                            }
                            
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
    
                    $getjawaban = $this->latihanmodel->getjawaban($res[0]->soal_id)->getResult();
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
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' class='p-10 col-md-12 jawaban_dv' style='display: flex; padding: 5px; margin-top: 10px; margin-bottom: 10px; background-color: #aeaebb;border-radius: 5px; text-align: left;'> <label for='pilihan_nm' style='margin-left:10px;'>".$key->pilihan_nm.". </label> <span style='margin-left: 5px;'>".$key->jawaban_nm."</span>
                        <div>$img_jwb</div>
                            </div>";
                    }

                    // PEMBAHASAN
                    

                    $button = "<div class='row'>";
                    $button .= "<div class='col-md-6'>";
                    $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                    $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    $button .= "</div>";

                    $button .= "<div class='col-md-6 text-right'>
                            <button onclick='if(document.getElementById(\"spoiler\") .style.display==\"none\") {document.getElementById(\"spoiler\") .style.display=\"\"}else{document.getElementById(\"spoiler\") .style.display=\"none\"}' style='margin-bottom:10px;' type='button' class='btn bg-gradient-secondary'>pembahasan</button><br>
                            <div id='spoiler' style='display:none;border: 1px solid black;background-color: #8fbc8f;border-radius:5px;'>";
                            if ($res[0]->pembahasan_img != "") {
                                $button .= "<img style='padding:10px;max-height:100%; max-width:100%;' src='/images/pembahasan_latihan/$group_id/$jenis_id/".$res[0]->pembahasan_img."'>";
                            } else {
                                $resjawaban_nm = $this->latihanmodel->getJawabannmPembahasan($res[0]->kunci,$res[0]->soal_id)->getResult();
                                $button .= "<div class='text-left' style='margin: 5px;background-color: white; padding: 10px;'><span>".$resjawaban_nm[0]->pilihan_nm.". ".$resjawaban_nm[0]->jawaban_nm."</span>
                                <br><p>".$res[0]->pembahasan."</p>
                                </div>";
                            }
                            
                    $button .= "</div></div>";
                    $button .= "</div>";

                    //  if (count($res_ttlsoal) != $no_soal) {
                    //         $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    // }
                    
                    // if ($jumlahjawab == count($res_ttlsoal) - 1 || $jumlahjawab == count($res_ttlsoal)) {
                    //     $button .= "<div class='col-md-3'>";
                    //     $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    //      $button .= "</div>";
                    // }
                    
                    // $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-warning'>Selesai</button>";
                   
                   

                    // if (count($res_ttlsoal) == $no_soal) {
                    //     $group_id = $group_id + 1;
                    //     $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    // } else {
                        
                    // }
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "jenis_id"=>$jenis_id,"group_id"=>$group_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab, "used" => $used));
                }
        }
        
    }

}