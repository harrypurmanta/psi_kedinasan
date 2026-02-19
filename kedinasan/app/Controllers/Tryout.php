<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Usersmodel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;
class Tryout extends BaseController
{
    protected $soalmodel;
    protected $usersmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
        $this->usersmodel = new Usersmodel();
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
                            $img_jwb = "<img style='max-width:350px;height:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/group/".$group_id."/".$key->jawaban_img."'>";
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
        $group_id = $request->uri->getSegment(4);
        $getRespon = $this->soalmodel->getRespon($group_id,$materi_id,$user_id)->getResult();

        $hasil = [];
        // $lastUsed = $this->soalmodel->getLastUsedPauli($user_id, $group_id, $materi_id)->getRow();
        // $user = $this->usermodel->getbyUserId($user_id)->getResult();
        for ($i = 1; $i <= 4; $i++) {
            $hasil[$i] = $this->soalmodel
                ->getHasilPauliByUserUsed(
                    $user_id,
                    $i, // sk_group_id,
                    $materi_id,
                    1
                )
                ->getResult();
        }
        
        $data = [
            "hasil" => $hasil,
            "getRespon" => $getRespon
        ];
        
        return view('front/hasiltryout',$data);
    }

    public function kirimemail() {
        $mailService = \Config\Services::email();
        $user_id = $this->session->user_id;
        $materi_id = $this->request->getPost("materi");
        $group_id = $this->request->getPost("group_id");
        $mhs = $this->usersmodel->getbyUserId($user_id)->getResult();
        $getRespon = $this->soalmodel->getRespon($group_id,$materi_id,$user_id)->getResult();

        $tabelHasil = '
            <h3 style="text-align:center;">Rekap Nilai per Paket</h3>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <th width="40%" align="center"><b>Paket</b></th>
                    <th width="30%" align="center"><b>Benar</b></th>
                    <th width="30%" align="center"><b>Salah</b></th>
                </tr>';

        foreach ($getRespon as $key) {
            $tabelHasil .= '
            <tr>
                <td align="center">'.$key->group_nm.'</td>
                <td align="center">'.$key->total_benar.'</td>
                <td align="center">'.$key->total_salah.'</td>
            </tr>';
        }

        $tabelHasil .= '</table>';

        $filename = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi_id.".pdf";
   
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Bintang Timur Prestasi');
		$pdf->SetTitle('Hasil Tes');
		$pdf->SetSubject('Hasil Tes');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetImageScale(1.25); // Skala gambar
        $pdf->addPage();

        $pdf->writeHTML($tabelHasil, true, false, true, false, '');

        $filePath = WRITEPATH . 'upload/' . $filename;
        $pdf->Output($filePath, 'F'); // simpan ke file

        
        $mailService->setTo($mhs[0]->email);
            $mailService->setFrom('admin@bintangtimurprestasi.com', 'Hasil');
            $mailService->attach($filePath);
            $mailService->setSubject('Hasil');
            $mailService->setMessage('Terima kasih telah mengikuti tryout Bintang Timur Prestasi. berikut kami kirimkan hasil anda');
            $sendit = $mailService->send();
            echo json_encode($sendit);

    }

}