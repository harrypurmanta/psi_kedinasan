<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
class Hasil extends BaseController
{
    protected $session;
    protected $usermodel;
    protected $soalmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usermodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
           
            $user_id = $this->request->getUri()->getSegment(3);
            $data = [           
                "materi" => $this->usermodel->getjawAllJMateri()->getResult(),
                "user" => $this->usermodel->getbyUserId($user_id)->getResult(),
                "user_id" => $user_id
            ];
            return view('admin/hasil',$data);
        }
        
    }

    public function listmaterilatihan() {
        $user_id = $this->request->getPost('user_id');
        $materi = $this->usermodel->getjawAllJMateri()->getResult();
        $ret = "";
        foreach ($materi as $key) {
            $ret .= "<div><a target='_blank' href='".base_url() ."/admin/hasil/latihanmateri/$user_id/".$key->materi_id."'>Latihan ".$key->materi_nm."</a></div>";
        }
        return $ret;
    }

    public function listsubmaterilatihan() {
        $user_id = $this->request->getPost('user_id');
        $jenis = $this->usermodel->getJenisSoal()->getResult();
        $ret = "";
        foreach ($jenis as $key) {
            $ret .= "<div><a target='_blank' href='".base_url() ."/admin/hasil/latihansubmateri/$user_id/".$key->jenis_id."'>".$key->jenis_nm."</a></div>";
        }
        return $ret;
    }

    public function latihanmateri() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi_id = $this->request->getUri()->getSegment(5);

            $resuser = $this->usermodel->getbyUserId($user_id)->getResult();
            $responlatihan = $this->usermodel->getResponLatihanmateri($user_id,$materi_id)->getResult();
            $skused = "";
            if (count($responlatihan)>0) {
                foreach ($responlatihan as $lat) {
                    $used = $lat->used;
                    $skused .= "<div style='display:inline-block;border:1px solid black;margin:10px;width: 90px;text-align: center;border-radius:10px;background-color: deepskyblue;cursor:pointer;.'><a target='_blank' href='".base_url()."/admin/hasil/hasillatihanmateri/$user_id/$materi_id/$used' id='dv_used_${used}' style='width: 100%;height:100%;cursor:pointer;color:#000000;'><label for='dv_used_${used}' style='font-size:50px;cursor:pointer;'>".$lat->used."</label></a></div>";
                }
            } else {
                $skused = "";
            }
            
            $ret = "<div>
                        <div style=\"width:100%;height: 100%;text-align:center;color:#000000;\">
                            <h1>".$resuser[0]->person_nm."</h1>
                        </div>
                        <div>

                        </div>";
            $ret .= $skused;
            // $date_tes = date('d F Y', strtotime($date_tes));
            
            $ret .= "</div>";
          

            $data = [
                'ret' => $ret
            ];
            return view('admin/latihanmateri',$data);
    }

    public function hasillatihanmateri() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi_id = $this->request->getUri()->getSegment(5);
        $used = $this->request->getUri()->getSegment(6);

        $benar_kec = 0;
        $salah_kec = 0;
        $benar_keb = 0;
        $salah_keb = 0;
        $total_skor  = 0;
        $persen_kec  = 0;
        $persen_kep  = 0;
        

        $kecerdasanskor = $this->usermodel->getlatihanKecerdasanSkor($user_id,$used,$materi_id)->getResult();
        foreach ($kecerdasanskor as $kec) {
            if ($kec->kunci == $kec->pilihan_nm) {
                $benar_kec = $benar_kec + 1;
            } else {
                $salah_kec = $salah_kec + 1;
            }
        }

        $persen_kec = ($benar_kec * 0.0025) * 100;

        $kepskor = $this->usermodel->getlatihanKepribadianSkor($user_id,$used,$materi_id)->getResult();
        foreach ($kepskor as $kep) {
            if ($kep->kunci == $kep->pilihan_nm) {
                $benar_keb = $benar_keb + 1;
            } else {
                $salah_keb = $salah_keb + 1;
            }
        }

        $persen_kep = ($benar_keb * 0.005) * 100;

        

        $total_skor = $persen_kep + $persen_kec;
        // if ($materi == 8) {
        //     $persen_kec = (rand(21,23));
        //     $persen_kep = (rand(21,23));
        //     $persen_sk = (rand(21,23));
        //     $total_skor = $persen_sk + $persen_kep + $persen_kec;

        //     $data = [
        //         "session_soal_nm" => "materi4",
        //         "skor_kec" => $persen_kec,
        //         "skor_kep" => $persen_kep,
        //         "skor_sk" => $persen_sk,
        //     ];

        //     $this->soalmodel->insertsessionskor($data);
        // }

        
        $ret = "<div class='col-lg-12'>
            <div style='width:100%;text-align:center;color:#000000;'>
                <h1 style='margin:10px;color:#ffffff;'>SELAMAT !</h1>
                <h1 style='margin:10px;color:#ffffff;'><span>SKOR ANDA</span> <span>$total_skor</span></h1>
            </div>
            <div style='margin:20px;text-align:center;'>
            <table style='table-layout:fixed;width: 50%;margin: 0 auto;'>
            <tbody>
            <tr style='font-size:35px;border-bottom:1px solid black;height: 100px;'><td width='150' style='text-align:center;'>Kecerdasan</td><td width='50' style='text-align:center;'>:</td><td width='80' style='text-align:center;'><label>".ceil($persen_kec)."</label></td></tr>
            <tr style='font-size:35px;border-bottom:1px solid black;height: 100px;'><td style='text-align:center;'>Kepribadian</td><td style='text-align:center;'>:</td><td style='text-align:center;'><label>".ceil($persen_kep)."</label></td></tr>
            </tbody>
            </table>
            </div>";

        $ret .= "</div>";

        return $ret;
    }

    
}
