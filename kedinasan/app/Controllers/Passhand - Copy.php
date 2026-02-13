<?php

namespace App\Controllers;
use App\Models\Soalmodel;


class Passhand extends BaseController
{

	protected $soalmodel;
	public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
	}

	public function petunjuksoal() {
		$class_soal = $this->request->getPost('class_soal');
		$materi = $this->request->getPost('materi');
        if ($class_soal == "petunjukpasshand") {
            $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                        <h1 style='margin:20px;'>Petunjuk Soal Passhand</h1>
                    <p style='text-align:center;font-size:20px;'>Jawablah Setiap Pertanyaan dengan jujur, sesuai dengan kenyataan yang ada pada diri anda sendiri.</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"$class_soal\",$materi,1,1,\"null\",\"null\",\"0\")'>Mulai</button>
                </div>";
        } else if ($class_soal == "petunjukkecerdasan") {
            $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Kecerdasan</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling  tepat!</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"$class_soal\",$materi,1,2,\"null\",\"null\",0)'>Mulai</button>
                </div>";
        } else if ($class_soal == "petunjukkepribadian") {
            $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Kepribadian</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'>Tugas anda adalah memilih salah satu jawaban yang menurut anda paling sesuai dengan diri anda dari 4 kemungkinan jawaban.</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"$class_soal\",$materi,1,3,\"null\",\"null\",0)'>Mulai</button>
                </div>";
        } else if ($class_soal == "petunjuksikapkerja") {
            $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Sikap Kerja</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'></p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"$class_soal\",$materi,1,4,\"null\",\"null\",1)'>Mulai</button>
                </div>";
        }
        
        echo json_encode($ret);
    }

    public function startujian() {
		$soal_id        = $this->request->getPost('soal_id');
		$kolom_id       = $this->request->getPost('kolom_id');
		$class_soal     = $this->request->getPost('class_soal');
		$materi         = $this->request->getPost('materi');
		$no_soal        = $this->request->getPost('no_soal');
		$group_id       = $this->request->getPost('group_id');
		$jawaban_id     = $this->request->getPost('jawaban_id');
		$pilihan_nm     = $this->request->getPost('pilihan_nm');
		$used           = $this->request->getPost('used');
        $kolom_nm = "";
        $soal_terjawab_chart = "";
        $jawaban_benar_chart = "";
        
        if (isset($kolom_id)) {
            $kolom_id  = $kolom_id;
        } else {
            $kolom_id = 0;
        }
        
        $date = date("Y-m-d H:i:s");

        if (!isset($jawaban_id)) {
            echo json_encode("jawabankosong");
        } else {
            if ($jawaban_id == "null" || $class_soal == "prevsoal") {
            } else {
                $getResponByid = $this->soalmodel->getResponByPrev($soal_id,$group_id,$materi,$this->session->user_id,$this->session->session)->getResult();
    
                if (count($getResponByid)>0) {
                    $data = [
                        "jawaban_id" => $jawaban_id,
                        "pilihan_nm" => $pilihan_nm,
                        "soal_id" => $soal_id,
                        "no_soal" => $no_soal - 1,
                        "group_id" => $group_id,
                        "materi" => $materi,
                        "created_user_id" => $this->session->user_id,
                        "created_dttm" => $date,
                        "used" => 0,
                        "kolom_id" => $kolom_id,
                        "session" => $this->session->session
                    ];
        
                    $updaterespon = $this->soalmodel->updateResponPrev($soal_id,$jawaban_id,$group_id,$materi,$this->session->user_id,$this->session->session,$data);
                } else {
                    if ($jawaban_id !== "null" && isset($soal_id)) {
                        $data = [
                            "jawaban_id" => $jawaban_id,
                            "pilihan_nm" => $pilihan_nm,
                            "soal_id" => $soal_id,
                            "no_soal" => $no_soal - 1,
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
                }
            }

            $max_no_soal = $this->soalmodel->getMaxNoSoal($group_id,$materi)->getResult();
            $max_no_soal = $max_no_soal[0]->max_nosoal + 1;




            if ($no_soal == $max_no_soal && $group_id == 1) {
                $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Kecerdasan</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling  tepat!</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"petunjukkecerdasan\",$materi,1,2,\"null\",\"null\",0)'>Mulai</button>
                </div>";
                $class_soal = "petunjuksoal";
            } else if ($no_soal == $max_no_soal && $group_id == 2) {
                $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Kepribadian</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'>Tugas anda adalah memilih salah satu jawaban yang menurut anda paling sesuai dengan diri anda dari 4 kemungkinan jawaban.</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"petunjukkepribadian\",$materi,1,3,\"null\",\"null\",0)'>Mulai</button>
                </div>";
                $class_soal = "petunjuksoal";
            } else if ($no_soal == $max_no_soal && $group_id == 3) {
                $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
                    <h1 style='margin:20px;'>Petunjuk Soal Sikap Kerja</h1>
                    <p style='text-align:center;font-size:20px;margin:20px;'>Soal terdiri dari 10 kolom, dimana setiap kolom ada batas waktu 1 menit. Pilihlah (angka,huruf,symbol) yang hilang dari soal. Gunakan waktu sebaik mungkin dalam pengerjaannya.</p>
                    <button style='font-size: 30px;' class='btn btn-primary' onclick='startujian(\"petunjuksikapkerja\",$materi,1,4,\"null\",\"null\",1)'>Mulai</button>
                </div>";
                $class_soal = "petunjuksoal";
            } else {
                if ($no_soal == 51 && $group_id == 4) {
                    $class_soal = "rehatsk";
                } else {
                    $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    if (count($res)>0) {
                        $res_ttlsoal = $this->soalmodel->getTotalSoal($group_id,$materi)->getResult();
                    } else {
                        $materix = $materi;
                        $class_soal = "finish";
                    }
                }

                // log_message("debug",$res_ttlsoal);

                if ($class_soal == "Sikap Kerja" || $class_soal == "petunjuksikapkerja") {
                    
                    $ret = "<div class='col-lg-12' style='color:#000000;'> 
                                <div style='width:100%;text-align:center;'>
                                <h1 style='margin:10px;float:left;'>Kolom ".$kolom_id."</h1>
                                <h1 style='margin:10px;'>".$res[0]->group_nm."</h1>
                                </div>
                                <div class='row'>
                                    <div class='col-lg-12'>
                                        <div style='text-align:center;'>
                                            <table border='1' style='width: 45%;margin: 0 auto;'>
                                            <thead>
                                            <th colspan='5' style='font-size:40px;'>
                                                Tantangan $no_soal 
                                            </th>
                                            </thead>
                                            <tbody>
                                            <tr style='font-size:50px;text-align:center;font-weight:bold;'>";
                                            $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                                            foreach ($getjawaban as $key) {
                                                $jawaban_nm = str_split($key->jawaban_nm,1);
                                                foreach ($jawaban_nm as $jwb_nm) {
                                                    $ret .= "<td>".$jwb_nm."</td>";
                                                }
                                            }
                                        $ret .= "</tr>
                                            <tr style='font-size:50px;text-align:center;font-weight:bold;color:red;'> <td>A</td>
                                            <td>B</td>
                                            <td>C</td>
                                            <td>D</td>
                                            <td>E</td>";
                                        $ret .= "</tr>
                                            </tbody>
                                            </table>
                                        </div>
        
                                        <div style='text-align:center;margin-top:30px;'>
                                            <table border='1' style='width: 35%;margin: 0 auto;'>
                                            <tbody>
                                            <tr style='font-size:50px;text-align:center;font-weight:bold;letter-spacing: 20px;'>
                                            <input type='hidden' name='soal_id' id='soal_id' value='".$res[0]->soal_id."' />
                                            <td colspan='5'>".$res[0]->soal_nm."</td>";
                                              
                                        $ret .= "</tr>
                                            <tr style='font-size:50px;text-align:center;font-weight:bold;background-color: #ececec;'>";
                                            foreach ($getjawaban as $k) {
                                                $jawaban_id = $k->jawaban_id;
                                                $ret .= "<td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,$jawaban_id,\"A\",$kolom_id)'>A</label></td>
                                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,$jawaban_id,\"B\",$kolom_id)'>B</label></td>
                                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,$jawaban_id,\"C\",$kolom_id)'>C</label></td>
                                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,$jawaban_id,\"D\",$kolom_id)'>D</label></td>
                                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,$jawaban_id,\"E\",$kolom_id)'>E</label></td>";
                                            }
                                            
                                        $ret .= "</tr>
                                            </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";
                    // echo json_encode(array("html"=>$ret,"materi"=>$materi));
                } else if ($class_soal == "finish") {
                    $benar_passhand = 0;
                    $salah_passhand = 0;
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
                    $passhandjwb = "";
                    $passhandskor = $this->soalmodel->getPasshandSkor($this->session->user_id,$this->session->session,$materi)->getResult();
                    foreach ($passhandskor as $key) {
                        $passhandjwb .= "<li style='display: inline-block;width: 100%;padding: 2px;'>".$key->no_soal.". <label>".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";
                    }
                    
                    $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($this->session->user_id,$this->session->session,$materix)->getResult();
                    foreach ($kecerdasanskor as $kec) {
                        if ($kec->kunci == $kec->pilihan_nm) {
                            $benar_kec = $benar_kec + 1;
                        } else {
                            $salah_kec = $salah_kec + 1;
                        }
                    }

                    $persen_kec = ($benar_kec * 0.0025) * 100;
        
                    $kepskor = $this->soalmodel->getKepribadianSkor($this->session->user_id,$this->session->session,$materix)->getResult();
                    foreach ($kepskor as $kep) {
                        if ($kep->kunci == $kep->pilihan_nm) {
                            $benar_keb = $benar_keb + 1;
                        } else {
                            $salah_keb = $salah_keb + 1;
                        }
                    }

                    $persen_kep = ($benar_keb * 0.005) * 100;
        
                    $skskor = "<div style='width:100%;text-align:center;'>
                                    <p style='margin:10px;font-size:18px;'>Nilai yang tampil merupakan hasil dari jumlah soal yang terjawab, dan bukan merupakan bobot penilaian seperti saat tes sesungguhnya.</p>
                                    <div style='background-color: #007bff;border-radius:10px;'><h2 style='margin:10px;color:white;'>HASIL PENILAIAN</h2></div>
                                </div>
                                <div style='width:100%;text-align:center;'>
                                    <ul style='list-style-type: none;'>";
                                    $kolom_nm = [];
                                    $soal_terjawab_chart = [];
                                    $jawaban_benar_chart = [];
                                    // $persen_sk = 0;
                                    $ttl_benar_sk = 0;
                                    $klm = $this->soalmodel->getKolomSoal()->getResult();
                                    foreach ($klm as $key) {
                                        $kolom_nm[] = $key->kolom_nm;
                                        $benar = 0;
                                        $salah = 0;
                                        $soal_terjawab = 0;
                                        $res_responSK = $this->soalmodel->getResponSikapKerja($this->session->user_id,$this->session->session,$key->kolom_id,$materi)->getResult();
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
                                        $soal_terjawab_chart[] =  $soal_terjawab;
                                        $jawaban_benar_chart[] = $benar;
                                        $skskor .= "<li>".$key->kolom_nm." : <label>[$soal_terjawab soal terjawab]</label> - <label>$benar</label> benar | <label>$salah</label> salah</li>";
                                    }

                                    $persen_sk = ($ttl_benar_sk * 0.0005) * 100;
                            $skskor .= "</ul>
                                </div>";
        
                    $total_skor = $persen_sk + $persen_kep + $persen_kec;
                    if ($materi == 4) {
                        $persen_kec = (rand(21,23));
                        $persen_kep = (rand(21,23));
                        $persen_sk = (rand(21,23));
                        $total_skor = $persen_sk + $persen_kep + $persen_kec;

                        $data = [
                            "session_soal_nm" => "materi4",
                            "skor_kec" => $persen_kec,
                            "skor_kep" => $persen_kep,
                            "skor_sk" => $persen_sk,
                        ];

                        $this->soalmodel->insertsessionskor($data);
                    }
                    
                    if ($total_skor >= 61) {
                        $styletotalskor = "color:green;";
                        $syarat = "(Memenuhi Syarat - MS)";
                    } else {
                        $styletotalskor = "color:red;";
                        $syarat = "(Tidak Memenuhi Syarat - TMS)";
                    }
                    $ret = "<div class='col-lg-12'>
                        <div style='width:100%;text-align:center;color:#000000;'>
                            <h1 style='margin:10px;color:#ffffff;'>SELAMAT !</h1>
                            <h1 style='margin:10px;color:#ffffff;'><span>SKOR ANDA</span> <span style='$styletotalskor'>$total_skor</span></h1>
                            <h1 style='margin:10px;$styletotalskor'>$syarat</h1>
                        </div>
                        <div style='margin:20px;'>
                        <table border='0' style='table-layout:fixed;'>
                        <tbody>
                        <tr style='font-size:25px;border-bottom:1px solid black;'><td width='150'>Passhand</td><td width='50' colspan='2' style='text-align:center;'>:</td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;'><td colspan='3'><div>
                        <ul style='margin-top: 18px;margin-bottom: 18px;font-size: 15px;display: grid;grid-template-columns: auto 1fr;grid-gap: 0 2em;max-width : 100%;z-index: 20;color: rgb(109, 113, 107);box-shadow: rgb(162, 151, 151) 3px 3px 10px;cursor: pointer !important;list-style: none;background: rgb(255, 255, 255);padding: 10px 12px;'>
                      
                        </ul>
                        </div></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Kecerdasan</td><td width='50' style='text-align:center;'>:</td><td width='80' style='text-align:center;'><label>".ceil($persen_kec)."</label></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Kepribadian</td><td style='text-align:center;'>:</td><td style='text-align:center;'><label>".ceil($persen_kep)."</label></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Sikap Kerja</td><td style='text-align:center;'>:</td><td style='text-align:center;'><label>".ceil($persen_sk)."</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
           
            $ret .= "</div>";
        
                    // echo json_encode(array("html"=>$ret,"materi"=>$materi));
                } else if ($class_soal == "rehatsk") {
                    
                    $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;s'>
                        <h1 style='margin:10px;'>Persiapan . . .</h1>
                        <p style='text-align:justify;font-size:20px;'></p>
                    </div>";
                } else {
                    
                    // $ttlsoal = count($res_ttlsoal);
                    $boxnomorsoal = "";
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->soalmodel->getResponBox($boxsoal->no_soal,$group_id,$materi,$this->session->user_id,$this->session->session)->getResult();
                        
                        if ($group_id == 2) {
                            $boxclick = "onclick='startujian(\"prevsoal\",$materi,$boxsoal->no_soal,$group_id,\"radio\")'";
                            $boxcursor = "cursor:pointer;";
                        } else {
                            $boxclick = "";
                            $boxcursor = "";
                        }
    
                        if (count($getResponBox)>0) {
                            $style = "style='border:2px solid #79db79;width:50px;heigth:50px;margin:5px;$boxcursor'";
                        } else {
                            $style = "style='border:2px solid red;width:50px;heigth:50px;margin:5px;$boxcursor'";
                        }
    
                        if ($group_id == 2 && $boxsoal->no_soal == $no_soal) {
                            $style = "style='border:2px solid blue;width:50px;heigth:50px;margin:5px;$boxcursor'";
                        }
                        
                        $boxnomorsoal .= "<label $boxclick $style>".$boxsoal->no_soal."</label>";
                    }
    $ret = "<div class='row'>
    <div class='col-lg-4'>
    <div style='border:1px solid black;text-align:center;'>";
        $ret .= $boxnomorsoal; 
        if ($res[0]->soal_img == "") {
            $img_soal = "";
        } else {
            $img_soal = "<img style='max-width:300px;heigth:100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."'>";
        }
                              
    $ret .= "</div></div>
    <div class='col-lg-7' style='margin-left:20px;padding-left:20px;'>
                                <div style='width:100%;text-align:center;'>
                                <h1 style='margin:10px;text-decoration:underline;'>".$res[0]->group_nm."</h1>
                                </div>
                                <div>
                                <input type='hidden' name='soal_id' id='soal_id' value='".$res[0]->soal_id."' />
                                    <label style='font-size:20px;'>Soal ".$res[0]->no_soal."</label>
                                    <p style='font-size:25px;'>".$res[0]->soal_nm." $img_soal</p>
                                    
                                </div>
                                <div>
                                    <label style='font-size:20px;'>Jawaban</label>";
                                    $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                                    foreach ($getjawaban as $key) {
                                        if ($key->jawaban_img == "") {
                                            $img_jwb = "";
                                        } else {
                                            $img_jwb = "<img style='max-width:150px;heigth:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/".$key->jawaban_img.".jpg'>";
                                        }
                                        
                                        $getResponByJawabanId = $this->soalmodel->getResponByJawabanId($key->jawaban_id,$group_id,$materi,$this->session->user_id,$this->session->session)->getResult();
                                        if (count($getResponByJawabanId)>0) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        $jawaban_idbox = $key->jawaban_id;
                                        $ret .= "<div class='col-md-12 row' style='margin-bottom:10px;'><div class='col-md-1' style='text-align: center;'><input $checked type='radio' name='jawaban' id='jawaban_${jawaban_idbox}' value='".$key->jawaban_id."' data-pilihan='".$key->pilihan_nm."'/> </div><div class='col-md-11' style='padding:0px;'><label style='font-size:20px;' for='jawaban_${jawaban_idbox}'>".$key->pilihan_nm.". ".$key->jawaban_nm."</label> $img_jwb</div></div>";
                                    }
                            if ($group_id == 2) {
                                if ($no_soal == 1) {
                                    $ret .= "<div><div style='text-align:right;'><button style='font-size:25px;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,\"radio\")' class='btn btn-primary'>Next</button></div></div>";
                                } else {
                                    $no_prev = $no_soal - 1;
                                    $ret .= "<div><div style='text-align:right;'><button style='font-size:25px;' onclick='startujian(\"prevsoal\",$materi,$no_prev,$group_id,\"radio\")' class='btn btn-primary'>Previous</button> <button style='font-size:25px;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,\"radio\")' class='btn btn-primary'>Next</button></div></div>";
                                }
        
                                
                            } else {
                                $ret .= "<div><div style='text-align:right;'><button style='font-size:25px;' onclick='startujian(\"nextsoal\",$materi,$no_soal,$group_id,\"radio\")' class='btn btn-primary'>Next</button></div></div>";
                            }
                            $ret .= "</div>
                            </div>";
                }
            }
    
            echo json_encode(array("html"=>$ret,"materi"=>$materi,"group_id"=>$group_id,"no_soal"=>$no_soal,"class_soal"=>$class_soal,"kolom_nm"=>$kolom_nm,"soal_terjawab_chart"=>$soal_terjawab_chart,"jawaban_benar_chart"=>$jawaban_benar_chart),JSON_UNESCAPED_SLASHES);
        }

        
    }

    public function showresult() {
        $materi = $this->request->getPost('materi_id');
        $benar_passhand = 0;
            $salah_passhand = 0;
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
            $passhandjwb = "";
            $passhandskor = $this->soalmodel->getPasshandSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($passhandskor as $key) {
                $passhandjwb .= "<li style='display: inline-block;width: 100%;padding: 2px;'>".$key->no_soal.". <label style='margin-left:15px;'>".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";
            }

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }
            $persen_kec = ($benar_kec * 0.0025) * 100;

            $kepskor = $this->soalmodel->getKepribadianSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $persen_kep = ($benar_keb * 0.005) * 100;

            $skskor = "<div style='width:100%;text-align:center;'>
                                <p style='margin:10px;font-size:18px;'>Nilai yang tampil merupakan hasil dari jumlah soal yang terjawab, dan bukan merupakan bobot penilaian seperti saat tes sesungguhnya.</p>
                                <div style='background-color: #007bff;border-radius:10px;'><h2 style='margin:10px;color:white;'>HASIL PENILAIAN</h2></div>
                            </div>
                            <div style='width:100%;text-align:center;'>
                                <ul style='list-style-type: none;'>";
                                
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                    $kolom_nm[] = $key->kolom_nm;
                                    $benar = 0;
                                    $salah = 0;
                                    $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSikapKerja($this->session->user_id,$this->session->session,$key->kolom_id,$materi)->getResult();
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
                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                    $jawaban_benar_chart[] = $benar;
                                    $skskor .= "<li>".$key->kolom_nm." : <label>[$soal_terjawab soal terjawab]</label> - <label>$benar</label> benar | <label>$salah</label> salah</li>";
                                }
                                $persen_sk = ($ttl_benar_sk * 0.0005) * 100;
                        $skskor .= "</ul>
                            </div>";

            $total_skor = $persen_sk + $persen_kep + $persen_kec;
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }
            $ret = "<div class='col-lg-12'>
                        <div style='width:100%;text-align:center;color:#000000;'>
                            <h1 style='margin:10px;'>SELAMAT !</h1>
                            <h1 style='margin:10px;'><span>SKOR ANDA</span> <span style='$styletotalskor'>$total_skor</span></h1>
                            <h1 style='margin:10px;$styletotalskor'>$syarat</h1>
                        </div>
                        <div style='margin:20px;'>
                        <table border='0' style='table-layout:fixed;color:#000000;'>
                        <tbody>
                        <tr style='font-size:25px;border-bottom:1px solid black;'><td width='150'>Passhand</td><td width='50' colspan='2' style='text-align:center;'>:</td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;'><td colspan='3'><div>
                        <ul style='margin-top: 18px;margin-bottom: 18px;font-size: 15px;display: grid;grid-template-columns: auto 1fr;grid-gap: 0 2em;max-width : 100%;z-index: 20;color: rgb(109, 113, 107);box-shadow: rgb(162, 151, 151) 3px 3px 10px;cursor: pointer !important;list-style: none;background: rgb(255, 255, 255);padding: 10px 12px;'>
                     
                        </ul>
                        </div></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Kecerdasan</td><td width='50' style='text-align:center;'>:</td><td width='80' style='text-align:center;'><label>".ceil($persen_kec)."</label></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Kepribadian</td><td style='text-align:center;'>:</td><td style='text-align:center;'><label>".ceil($persen_kep)."</label></td></tr>
                        <tr style='font-size:25px;border-bottom:1px solid black;height: 100px;'><td>Sikap Kerja</td><td style='text-align:center;'>:</td><td style='text-align:center;'><label>".ceil($persen_sk)."</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
           
            $ret .= "</div>";

        echo json_encode(array("html"=>$ret,"kolom_nm"=>$kolom_nm,"soal_terjawab_chart"=>$soal_terjawab_chart,"jawaban_benar_chart"=>$jawaban_benar_chart));
    }
    
}
