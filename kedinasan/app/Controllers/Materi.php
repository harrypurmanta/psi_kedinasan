<?php

namespace App\Controllers;
use App\Models\Soalmodel;
class Materi extends BaseController
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
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'materiSK' => $this->soalmodel->getMateriSK()->getResult(),
            ];
            return view('front/materi',$data);
        }
    }

    public function pilihanMateri() {
        $request = \Config\Services::request();
        $data = [
            'materi_id' => $request->uri->getSegment(3),
            'group' => $this->soalmodel->getGroupByid($request->uri->getSegment(4))->getResult(),
        ];
        

        return view('front/pilihanmateri',$data);
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

            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,$this->session->session,$materi_id)->getResult();
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
