<?php

namespace App\Controllers;
use App\Models\Soalmodel;


class Sikapkerja extends BaseController
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

        $ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;color:#000000;'>
        <h1 style='margin:20px;'><b>Penjelasan</b></h1>
        <h4><b>Sebelum mengerjakan tes, bacalah petunjuk pengerjaan tes ini dengan seksama.</b></h4>
        <p style='text-align:justify;font-size:18px;margin:18px;'>Pada tes sikap kerja ini, anda akan dihadapkan pada lima deret(angka/huruf/simbol) yang di pasangkan dengan huruf A, B, C, D dan E. yang terbagi dalam 10 kolom dimana masing-masing kolom
        memiliki pola deret yang berbeda-beda. Sebagai contoh seperti terlihat pada contoh dibawah ini :</p>
        <div style='text-align:center;'>
        <table align='center' border='2' style='width:50%;'>
        <thead>
        <tr>
        <th colspan='5'>Kolom 1</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td>∑</td>
        <td>4</td>
        <td>7</td>
        <td>V</td>
        <td>X</td>
        </tr>
        <tr>
        <td style='font-weight:bold;'>A</td>
        <td style='font-weight:bold;'>B</td>
        <td style='font-weight:bold;'>C</td>
        <td style='font-weight:bold;'>D</td>
        <td style='font-weight:bold;'>E</td>
        </tr>
        </tbody>
        </table>
        </div>

        <p style='text-align:justify;font-size:18px;margin:18px;'>Pada baris bawah huruf A, B, C, D dan E adalah pilihan jawaban nya dan pada baris atas yang berisi deret (angka/huruf/simbol) adalah pasangannya sebagai berikut.</p>
        <ul style='list-style-type: none;font-size:18px;'>
        <li>Pilihan jawaban <b>A</b> dipasangkan dengan simbol <b>∑</b></li>
        <li>Pilihan jawaban <b>B</b> dipasangkan dengan angka  <b>4</b></li>
        <li>Pilihan jawaban <b>C</b> dipasangkan dengan angka  <b>7</b></li>
        <li>Pilihan jawaban <b>D</b> dipasangkan dengan huruf  <b>V</b></li>
        <li>Pilihan jawaban <b>E</b> dipasangkan dengan huruf  <b>X</b></li>
        </ul>
        
        <p style='text-align:justify;font-size:18px;margin:18px;'>Kemudian pada persoalan, anda akan diberikan 4 deret (angka/huruf/simbol). Tugas anda adalah
        menemukan simbol/huruf/angka yang hilang pada setiap soal tersebut. Kemudian pilihlah <b>satu
        jawaban</b> diantara <b></b>lima pilihan jawaban</b> yang sesuai dengan pasangan yang hilang tersebut.</p>


        <div style='text-align:center;'>
        <h4><b>Contoh :</b></h4>
        <table align='center' border='2' style='width:50%;'>
        <thead>
        <tr>
        <th colspan='5'>Kolom 1</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td>∑</td>
        <td>4</td>
        <td>7</td>
        <td>V</td>
        <td>X</td>
        </tr>
        <tr>
        <td style='font-weight:bold;'>A</td>
        <td style='font-weight:bold;'>B</td>
        <td style='font-weight:bold;'>C</td>
        <td style='font-weight:bold;'>D</td>
        <td style='font-weight:bold;'>E</td>
        </tr>
        </tbody>
        </table>
        </div>


        <div style='text-align:center;margin-top:20px;'>
        <table align='center' border='1' style='width:40%;'>
        <tbody>
        <tr>
        <td>4</td>
        <td>∑</td>
        <td>7</td>
        <td>V</td>
        </tr>
        </tbody>
        </table>
        </div>

        <div style='text-align:center;margin-top:20px;'>
        <table align='center' border='2' style='width:50%;'>
        <tbody>
        <tr>
        <td style='font-weight:bold;'>A</td>
        <td style='font-weight:bold;'>B</td>
        <td style='font-weight:bold;'>C</td>
        <td style='font-weight:bold;'>D</td>
        <td style='font-weight:bold;'>E</td>
        </tr>
        </tbody>
        </table>
        </div>

        <p style='text-align:justify;font-size:18px;margin:18px;'>Dari 4 deret (angka/huruf/simbol) tersebut, huruf X tidak ada pada soal tersebut. Karena huruf X
        berpasangan dengan pilihan jawaban e, maka pilihlah <b>jawaban e</b> pada pilihan jawaban yang disediakan.</p>

        <h4 style='text-align:justify;font-size:18px;margin:18px;'><b>Hal-hal yang perlu anda perhatikan dalam mengerjakan tes sikap kerja ini adalah:</b></h4>

       <div>
            <ul style='list-style-type: number;text-align:justify;font-size:18px;'>
                <li>Setiap kolom memiliki waktu pengerjaan masing-masing dan jika waktu sudah habis maka secara otomatis akan berpindah ke kolom berikutnya.</li>
                <li>Setelah anda menjawab, secara otomatis soal akan berpindah ke kolom berikutnya.</li>
                <li>Tes ini mengharapakan anda bekerja dengan cepat dan cermat.</li>
            </ul>
        </div>
        <div style='margin-top:18px;text-align:cennter;'><h2>Selamat Mengerjakan</h2></div>

        <div style='margin-top:20px;text-align:cennter;'><button style='font-size: 30px;' class='btn btn-primary' onclick='startujiansk(\"$class_soal\",1,1,1,\"null\",\"null\")'>Mulai</button></div>
        
    </div>";
        echo json_encode($ret);

    }

    public function startujian() {
		$soal_id        = $this->request->getPost('soal_id');
		$class_soal     = $this->request->getPost('class_soal');
		$no_soal        = $this->request->getPost('no_soal');
		$jawaban_id     = $this->request->getPost('jawaban_id');
		$pilihan_nm     = $this->request->getPost('pilihan_nm');
		$kolom_id       = $this->request->getPost('kolom_id');
		$used           = $this->request->getPost('used');
        if ($no_soal == "51") {
            $class_soal = "rehatsk";
        }
        $date = date("Y-m-d i:H:s");

        if ($jawaban_id == "null" || $class_soal == "prevsoal") {
        } else {
            if (isset($jawaban_id) && isset($soal_id)) {
                $data = [
                    "jawaban_id" => $jawaban_id,
                    "pilihan_nm" => $pilihan_nm,
                    "soal_id" => $soal_id,
                    "no_soal" => $no_soal,
                    "group_id" => 4,
                    "materi" => 4,
                    "kolom_id" => $kolom_id,
                    "used" => $used,
                    "created_user_id" => $this->session->user_id,
                    "created_dttm" => $date,
                    "session" => $this->session->session
                ];
    
                $respon_id = $this->soalmodel->simpanRespon($data);
            }
        }

        $res = $this->soalmodel->getSoalSK($no_soal,4,4,$kolom_id)->getResult();
        if (count($res)>0) {
            $res_soal = $res;
        } else {
            $no_soal = 1;
            $kolom_id = $kolom_id + 1;
            $res = $this->soalmodel->getSoalSK($no_soal,4,4,$kolom_id)->getResult();
            if (count($res)>0) {
                $res_soal = $res;
            } else {
                $class_soal = "finish";
            }
        }
        if ($class_soal == "finish") {
            
            $ret = "<div class='col-lg-12' style='color:#000000;'>
                        <a href='".base_url()."/home'><button class='btn btn-primary'>Menu Utama</button></a>
                            <div style='width:100%;text-align:center;'>
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
                                    $res_responSK = $this->soalmodel->getResponSK($this->session->user_id,$this->session->session,$key->kolom_id,4)->getResult();
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
                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                    $jawaban_benar_chart[] = $benar;
                                    $ret .= "<li>".$key->kolom_nm." : <label>[$soal_terjawab soal terjawab]</label> - <label>$benar</label> benar | <label>$salah</label> salah</li>";
                                }
                                "</ul>
                            </div>";
                $ret .= "<div class='card'>
                            <div class='card-body'>
                            <div class='chart'>
                                <canvas id='barChart' style='min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;'></canvas>
                            </div>
                            </div>
                        </div>";
                $ret .= "</div>";
        } else if ($class_soal == "rehatsk") {
            $kolom_nm = "";
            $soal_terjawab_chart = "";
            $jawaban_benar_chart = "";
            $$ret = "<div class='col-lg-12' style='text-align:center;min-height: 400px;s'>
                    <h1 style='margin:10px;'>Persiapan . . .</h1>
                    <p style='text-align:justify;font-size:20px;'></p>
                </div>";
        } else {
            $kolom_nm = "";
                $soal_terjawab_chart = "";
                $jawaban_benar_chart = "";
            $ret = "<div class='col-lg-12' style='color:#000000;'>
                    <div style='width:100%;text-align:center;'>
                    <h1 style='margin:10px;float:left;'>Tantangan $no_soal </h1>
                      <h1 style='margin:10px;text-decoration: underline;'>".$res_soal[0]->group_nm."</h1>
                    </div>
                    <div class='row'>
                    <div class='col-lg-12'>
                        <div style='text-align:center;'>
                            <table border='1' style='width: 45%;margin: 0 auto;'>
                            <thead>
                            <th colspan='5' style='font-size:40px;'>
                            Kolom ".$kolom_id."
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
                            <input type='hidden' name='soal_id' id='soal_id' value='".$res_soal[0]->soal_id."' />
                            <td colspan='5'>".$res_soal[0]->soal_nm."</td>";
                    $ret .= "</tr>
                            <tr style='font-size:50px;text-align:center;font-weight:bold;background-color: #ececec;color:#000000'>";
                    foreach ($getjawaban as $k) {
                        $jawaban_id = $k->jawaban_id;
                        $ret .= "<td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujiansk(\"nextsoal\",$no_soal,$kolom_id,$used,$jawaban_id,\"A\")'>A</label></td>
                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujiansk(\"nextsoal\",$no_soal,$kolom_id,$used,$jawaban_id,\"B\")'>B</label></td>
                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujiansk(\"nextsoal\",$no_soal,$kolom_id,$used,$jawaban_id,\"C\")'>C</label></td>
                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujiansk(\"nextsoal\",$no_soal,$kolom_id,$used,$jawaban_id,\"D\")'>D</label></td>
                                <td><label style='cursor:pointer;width:100%;height:100%;' onclick='startujiansk(\"nextsoal\",$no_soal,$kolom_id,$used,$jawaban_id,\"E\")'>E</label></td>";
                    }
                                        
                    $ret .= "</tr>
                            </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>";
        }
        
        echo json_encode(array("html"=>$ret,"class_soal"=>$class_soal,"kolom_nm"=>$kolom_nm,"soal_terjawab_chart"=>$soal_terjawab_chart,"jawaban_benar_chart"=>$jawaban_benar_chart),JSON_UNESCAPED_SLASHES);
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
            $passhandskor = $this->soalmodel->getPasshandSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($passhandskor as $key) {
                if ($key->kunci == $key->pilihan_nm) {
                    $benar_passhand = $benar_passhand + 1;
                } else {
                    $salah_passhand = $salah_passhand + 1;
                }
            }

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }

            $kepskor = $this->soalmodel->getKepribadianSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }

            $sikapkerjaskor = $this->soalmodel->getSikapKerjaSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($sikapkerjaskor as $sk) {
                if ($sk->kunci == $sk->pilihan_nm) {
                    $benar_sk = $benar_sk + 1;
                } else {
                    $salah_sk = $salah_sk + 1;
                }
            }

            $total_skor = $benar_passhand + $benar_kec + $benar_keb + $benar_sk;
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }
            $ret = "<div class='col-lg-12'>
                    <a href='".base_url()."/home'><button class='btn btn-primary'>Menu Utama</button></a>
                        <div style='width:100%;text-align:center;'>
                            <h1 style='margin:10px;'>SELAMAT !</h1>
                            <h1 style='margin:10px;'>SKOR ANDA</h1>
                            <h1 style='margin:10px;$styletotalskor'>$total_skor $syarat</h1>
                        </div>
                        <div>
                            <ul>
                            <li>Passhand skor <label>$benar_passhand</label></li>
                            <li>Kecerdasan skor <label>$benar_kec</label></li>
                            <li>Kepribadian skor <label>$benar_keb</label></li>
                            <li>Sikap Kerja skor <label>$benar_sk</label></li>
                            </ul>
                        </div>";
            $ret .= "</div>";
        echo json_encode($ret);
    }
    
}
