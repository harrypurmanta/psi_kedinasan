<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends BaseController
{
    protected $session;
    protected $usersmodel;
    protected $soalmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usersmodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
        
	}


    public function index() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'users' => $this->usersmodel->getbynormal()->getResult()
            ];
            return view('admin/users',$data);
        } 
    }

    public function resetmateri() {
        $request = \Config\Services::request();
        $user_id = $request->uri->getSegment(4);
        $data = [
            'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
            'user_id' => $user_id,

            // 'ps' => $this->soalmodel->get()->getResult(),
        ];
        return view('admin/resetmateri',$data);
    }

    public function resetrespon() {
        $materi_id = $this->request->getPost("materi_id");
        $group_id = $this->request->getPost("group_id");
        $user_id = $this->request->getPost("user_id");

        if ($group_id == "semua") {
            $data = [
                "status_cd" => "nullified"
            ];
            $reset = $this->soalmodel->resetsemua($materi_id,$data,$user_id);
        } else {
            $data = [
                "status_cd" => "nullified"
            ];
            $reset = $this->soalmodel->resetbygroup($materi_id,$group_id,$data,$user_id);
        }
        echo json_encode($reset);
    }

    public function tambahuser() {
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div class='form-group row'>
                        <label for='person_nm' class='col-sm-2 col-form-label'>Nama</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='person_nm' name='person_nm'>
                        </div>
                        <label for='satuan' class='col-sm-2 col-form-label'>Satuan</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='satuan' name='satuan'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='birth_place' class='col-sm-2 col-form-label'>Tempat Lahir</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='birth_place' name='birth_place'>
                        </div>
                        <label for='birth_dttm' class='col-sm-2 col-form-label'>Tanggal Lahir</label>
                        <div class='col-4'>
                        <input type='date' class='form-control' id='birth_dttm' name='birth_dttm'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='birth_place' class='col-sm-2 col-form-label'>Jenis Kelamin</label>
                        <div class='col-4'>
                        <select class='form-control' id='gender_cd' name='gender_cd'>
                        <option value='l'>Laki-laki</option>
                        <option value='m'>Perempuan</option>
                        </select>
                        </div>
                        <label for='cellphone' class='col-sm-2 col-form-label'>No. HP</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='cellphone' name='cellphone'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='user_nm' class='col-sm-2 col-form-label'>Username</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='user_nm' name='user_nm'>
                        </div>
                        <label for='addr_txt' class='col-sm-2 col-form-label'>Alamat</label>
                        <div class='col-4'>
                        <textarea class='form-control' id='addr_txt' name='addr_txt'></textarea>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='user_group' class='col-sm-2 col-form-label'>Level User</label>
                        <div class='col-4'>
                        <select class='form-control' id='user_group' name='user_group'>
                        <option value='siswa'>Siswa</option>
                        <option value='admin'>Admin</option>
                        </select>
                        </div>
                    
                    </div>

                    </div>
                    <div class='card-footer'>
                    <button onclick='simpanuser()' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div>";

        return $ret;
    }

    public function simpanuser() {
        $person_nm = $this->request->getPost("person_nm");
        $satuan = $this->request->getPost("satuan");
        $birth_place = $this->request->getPost("birth_place");
        $birth_dttm = $this->request->getPost("birth_dttm");
        $cellphone = $this->request->getPost("cellphone");
        $addr_txt = $this->request->getPost("addr_txt");
        $user_nm = $this->request->getPost("user_nm");
        $gender_cd = $this->request->getPost("gender_cd");
        $user_group = $this->request->getPost("user_group");
        $data = [
            "person_nm" => $person_nm,
            "satuan" => $satuan,
            "birth_place" => $birth_place,
            "birth_dttm" => $birth_dttm,
            "cellphone" => $cellphone,
            "addr_txt" => $addr_txt,
            "gender_cd" => $gender_cd,
            'status_cd' => 'normal'
        ];
        $person_id = $this->usersmodel->simpanperson($data);
        $pwd = md5($cellphone);
        $data = [
            "user_nm" => $user_nm,
            "pwd0" => $pwd,
            "user_group" => $user_group,
            "person_id" => $person_id,
            'status_cd' => 'normal'
        ];
        $user_id = $this->usersmodel->simpanuser($data);
        echo json_encode(array("person_id"=>$person_id,"user_id"=>$user_id));
    }

    public function edituser() {
        $person_id = $this->request->getPost("person_id");
        $res = $this->usersmodel->getbyId($person_id)->getResult();
        $dates = date("Y-m-d",strtotime($res[0]->birth_dttm));
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div class='form-group row'>
                        <label for='person_nm' class='col-sm-2 col-form-label'>Nama</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='person_nm' name='person_nm' value='".$res[0]->person_nm."'>
                        </div>
                        <label for='satuan' class='col-sm-2 col-form-label'>Satuan</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='satuan' name='satuan' value='".$res[0]->satuan."'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='birth_place' class='col-sm-2 col-form-label'>Tempat Lahir</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='birth_place' name='birth_place' value='".$res[0]->birth_place."'>
                        </div>
                        <label for='birth_dttm' class='col-sm-2 col-form-label'>Tanggal Lahir</label>
                        <div class='col-4'>
                        <input type='date' class='form-control' id='birth_dttm' name='birth_dttm' value='".$dates."'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='birth_place' class='col-sm-2 col-form-label'>Jenis Kelamin</label>
                        <div class='col-4'>
                        <select class='form-control' id='gender_cd' name='gender_cd'>
                        <option value='l' ".($res[0]->gender_cd=="l"?"selected":"").">Laki-laki</option>
                        <option value='m' ".($res[0]->gender_cd=="m"?"selected":"").">Perempuan</option>
                        </select>
                        </div>
                        <label for='cellphone' class='col-sm-2 col-form-label'>No. HP</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='cellphone' name='cellphone' value='".$res[0]->cellphone."'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='user_nm' class='col-sm-2 col-form-label'>Username</label>
                        <div class='col-4'>
                        <input type='text' class='form-control' id='user_nm' name='user_nm' value='".$res[0]->user_nm."'>
                        </div>
                        <label for='addr_txt' class='col-sm-2 col-form-label'>Alamat</label>
                        <div class='col-4'>
                        <textarea class='form-control' id='addr_txt' name='addr_txt'>".$res[0]->addr_txt."</textarea>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='user_group' class='col-sm-2 col-form-label'>Level User</label>
                        <div class='col-4'>
                        <select class='form-control' id='user_group' name='user_group'>
                        <option value='siswa' ".($res[0]->user_group=="siswa"?"selected":"").">Siswa</option>
                        <option value='admin' ".($res[0]->user_group=="admin"?"selected":"").">Admin</option>
                        </select>
                        </div>
                    
                    </div>

                    </div>
                    <div class='card-footer'>
                    <button onclick='updateuser(".$res[0]->person_id.")' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div>";

                echo json_encode($ret);
    }

    public function updateuser() {
        $person_id = $this->request->getPost("person_id");
        $person_nm = $this->request->getPost("person_nm");
        $satuan = $this->request->getPost("satuan");
        $birth_place = $this->request->getPost("birth_place");
        $birth_dttm = $this->request->getPost("birth_dttm");
        $cellphone = $this->request->getPost("cellphone");
        $addr_txt = $this->request->getPost("addr_txt");
        $user_nm = $this->request->getPost("user_nm");
        $gender_cd = $this->request->getPost("gender_cd");
        $user_group = $this->request->getPost("user_group");
        $data = [
            "person_nm" => $person_nm,
            "satuan" => $satuan,
            "birth_place" => $birth_place,
            "birth_dttm" => $birth_dttm,
            "cellphone" => $cellphone,
            "addr_txt" => $addr_txt,
            "gender_cd" => $gender_cd,
            'status_cd' => 'normal'
        ];
        $person_id = $this->usersmodel->updateperson($person_id,$data);
        $pwd = md5($cellphone);
        $data = [
            "user_nm" => $user_nm,
            "pwd0" => $pwd,
            "user_group" => $user_group,
            "person_id" => $person_id,
            'status_cd' => 'normal'
        ];
        $user_id = $this->usersmodel->updateuser($person_id,$data);
        echo json_encode(array("person_id"=>$person_id,"user_id"=>$user_id));
    }

    public function hapususer() {
        $person_id = $this->request->getPost('person_id');
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->usersmodel->hapususer($person_id,$data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function hasilexcel() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $res = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
        $reskep = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
        $fileName = $user_id."_laporan_".$materi.".xlsx"; 
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
        $columnPasshand = "A";
        $columnkecerdasan = "7";
        $columnkepribadian = "A";
        $sheet->setCellValue("A" . "1", "PASSHAND");
        foreach ($res as $val) {
			$sheet->setCellValue($columnPasshand . "2", $val->no_soal_respon);
            $sheet->setCellValue($columnPasshand . "3", $val->pilihan_respon);
			$columnPasshand++;
		}

        $resSoalKec = $this->soalmodel->resSoalKec(2,$materi)->getResult();

        $sheet->setCellValue("A" . "5", "KECERDASAN");
        $sheet->setCellValue("A" . "6", "SOAL");
        $sheet->setCellValue("B" . "6", "JAWABAN");
        $sheet->setCellValue("G" . "6", "KUNCI");
        $sheet->setCellValue("H" . "6", "HASIL");
        foreach ($resSoalKec as $sl) {
			$sheet->setCellValue("A" . $columnkecerdasan, $sl->no_soal.". ". $sl->soal_nm);
            $resjawaban = $this->soalmodel->getJawabanBysoalId($sl->soal_id)->getResult();
            $clm = "B";
            foreach ($resjawaban as $jwb) {
                $getResponexcel = $this->soalmodel->getResponexcel($sl->soal_id,$jwb->jawaban_id,$user_id,$materi)->getResult();
                if (count($getResponexcel)>0) {
                    if ($getResponexcel[0]->pilihan_nm == $jwb->pilihan_nm) {
                        $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                        $sheet->getStyle($clm . $columnkecerdasan)->getFont()->setBold(true);
                    } else {
                        $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                    }

                    if ($getResponexcel[0]->pilihan_nm == $sl->kunci) {
                        $hasilx = "BENAR";
                    } else {
                        $hasilx = "SALAH";
                    }
                    
                } else {
                    $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                }
                $clm++;
            }

			
			$sheet->setCellValue("G" . $columnkecerdasan, $sl->kunci);
			$sheet->setCellValue("H" . $columnkecerdasan, $hasilx);
			$columnkecerdasan++;
		}

        $columnkecerdasan = $columnkecerdasan + 2;
        $columnkecerdasanx = $columnkecerdasan + 1;
        $resSoalKecx = $this->soalmodel->resSoalKec(3,$materi)->getResult();

        $sheet->setCellValue("A" . $columnkecerdasan, "KEPRIBADIAN");
        $sheet->setCellValue("A" . $columnkecerdasanx, "SOAL");
        $sheet->setCellValue("B" . $columnkecerdasanx, "JAWABAN");
        $sheet->setCellValue("G" . $columnkecerdasanx, "KUNCI");
        $sheet->setCellValue("H" . $columnkecerdasanx, "HASIL");
        foreach ($resSoalKecx as $slx) {
			$sheet->setCellValue("A" . $columnkecerdasanx, $slx->no_soal.". ". $slx->soal_nm);
            $resjawabanx = $this->soalmodel->getJawabanBysoalId($slx->soal_id)->getResult();
            $clm = "B";
            foreach ($resjawabanx as $jwbx) {
                $getResponexcelx = $this->soalmodel->getResponexcelx($slx->soal_id,$jwbx->jawaban_id,$user_id,$materi)->getResult();
                if (count($getResponexcelx)>0) {
                    if ($getResponexcelx[0]->pilihan_nm == $jwbx->pilihan_nm) {
                        $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                        $sheet->getStyle($clm . $columnkecerdasanx)->getFont()->setBold(true);
                    } else {
                        $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                    }

                    if ($getResponexcelx[0]->pilihan_nm == $slx->kunci) {
                        $hasilxx = "BENAR";
                    } else {
                        $hasilxx = "SALAH";
                    }
                    
                } else {
                    $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                }
                $clm++;
            }

			
			$sheet->setCellValue("G" . $columnkecerdasanx, $slx->kunci);
			$sheet->setCellValue("H" . $columnkecerdasanx, $hasilxx);
			$columnkecerdasanx++;
		}

        
		$writer = new Xlsx($spreadsheet);
		$filepath = $fileName;
		$writer->save($filepath);
 
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		flush();
		readfile($filepath);
		exit;
    }

    public function hasilpdf() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
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

            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();

            $passhandskor = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
            if (count($passhandskor)>0) {
                $passhandjwb .= "<div>
                        <ul style=\"margin-top: 10px;margin-bottom: 18px;font-size: 10px;display: grid;grid-template-columns: auto 1fr;grid-gap: 0 2em;max-width : 100%;z-index: 20;color: rgb(109, 113, 107);box-shadow: rgb(162, 151, 151) 3px 3px 10px;cursor: pointer !important;list-style: none;background: rgb(255, 255, 255);padding: 10px 12px;\">";
                foreach ($passhandskor as $key) {
                    $passhandjwb .= "<li style=\"display: inline-block;width: 100%;padding: 2px;\">".$key->no_soal.". <label style=\"margin-left:15px;\">".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";
                }
                $passhandjwb .= "</ul>
                        </div>";
            } 

            

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($user_id,"",$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }
            $persen_kec = ($benar_kec * 0.0025) * 100;
            // log_message("info",$persen_kec);
            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $persen_kep = ($benar_keb * 0.005) * 100;

            $skskor = "<div style=\"width:100%;text-align:center;\">
                                <table border=\"1\" style=\"line-height:1.5;\"><thead><tr>
                                <th align=\"center\">Kolom</th>
                                <th align=\"center\">Soal Terjawab</th>
                                <th align=\"center\">Benar</th>
                                <th align=\"center\">Salah</th>
                                </tr></thead>
                                <tbody>";
                                
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                    $kolom_nm[] = $key->kolom_nm;
                                    $benar = 0;
                                    $salah = 0;
                                    $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSikapKerja($user_id,"",$key->kolom_id,$materi)->getResult();
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
                                    $skskor .= "<tr><td>".$key->kolom_nm."</td> <td>$soal_terjawab</td> <td>$benar</td> <td>$salah</td></tr>";
                                }
                                $persen_sk = ($ttl_benar_sk * 0.0005) * 100;
                        $skskor .= "</tbody></table>
                            </div>";

            $total_skor = $persen_sk + $persen_kep + $persen_kec;
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }
            $ret = "<div style=\"width:100%;text-align:center;color:#000000;\">
                            <h1>".$resuser[0]->person_nm."</h1>
                            <h1>Materi ".$materi."</h1>
                            <h1>".$total_skor."</h1>
                        </div>";
            $ret .= "<div>
                        <div>
                        <table border=\"1\" style=\"table-layout:fixed;color:#000000;\">
                        <tbody>
                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td width=\"150\">Passhand</td>
                            <td width=\"20\" colspan=\"2\" style=\"text-align:center;\">:</td></tr>
                            <tr style=\"font-size:10px;border-bottom:1px solid black;\"><td colspan=\"3\">$passhandjwb</td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Kecerdasan</td>
                            <td width=\"20\" style=\"text-align:center;\">:</td>
                            <td width=\"50\" style=\"text-align:center;\"><label>$persen_kec</label></td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Kepribadian</td>
                            <td style=\"text-align:center;\">:</td>
                            <td style=\"text-align:center;\"><label>$persen_kep</label></td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Sikap Kerja</td>
                            <td style=\"text-align:center;\">:</td>
                            <td style=\"text-align:center;\"><label>$persen_sk</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
            $ret .= $skskor;
            // $ret .= "";
           $ret .= "<div class=\"card-body\">
                    <div class=\"chart\">
                        <canvas id=\"barChart\" style=\"min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;\"></canvas> 
                    </div>
                    </div>";
            $ret .= "</div>";
            $js = "<script src=\"../../../../plugins/jquery/jquery.min.js\"></script><script src=\"../../../../plugins/chart.js/Chart.min.js\"></script>";
            $js .= "var barChartCanvas = $(\"#barChart\").get(0).getContext(\"2d\");
            var areaChartData = {
            labels  : ".json_encode($kolom_nm).",
            datasets: [
                {
                  label               : \"Jawaban Benar\",
                  backgroundColor     : \"rgba(60,141,188,0.9)\",
                  borderColor         : \"rgba(60,141,188,0.8)\",
                  pointRadius          : false,
                  pointColor          : \"#3b8bba\",
                  pointStrokeColor    : \"rgba(60,141,188,1)\",
                  pointHighlightFill  : \"#fff\",
                  pointHighlightStroke: \"rgba(60,141,188,1)\",
                  data                : ".json_encode($jawaban_benar_chart).",
                  bezierCurve : false
                },
                {
                  label               : \"Soal Terjawab\",
                  backgroundColor     : \"rgba(210, 214, 222, 1)\",
                  borderColor         : \"rgba(210, 214, 222, 1)\",
                  pointRadius         : false,
                  pointColor          : \"rgba(210, 214, 222, 1)\",
                  pointStrokeColor    : \"#c1c7d1\",
                  pointHighlightFill  : \"#fff\",
                  pointHighlightStroke: \"rgba(220,220,220,1)\",
                  data                : ".json_encode($soal_terjawab_chart)."
                },
              ]
          }
          
            
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
            }

            new Chart(barChartCanvas, {
              type: \"bar\",
              data: barChartData,
              options: barChartOptions
            })";

        

        $html = view('admin/hasilpdf',[
			'ret'=> $ret
		]);

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Bintang Timur Prestasi');
		$pdf->SetTitle('Hasil Tes');
		$pdf->SetSubject('Hasil Tes');
        $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
        $pdf->addPage();

        // output the HTML content
        // $pdf->IncludeJS($js);
		$pdf->writeHTML($html, true, false, true, false, '');
        $pdf->IncludeJS($js);
		//line ini penting
		$this->response->setContentType('application/pdf');
		//Close and output PDF document
		$pdf->Output('invoice.pdf', 'I');
    }

    public function hasilweb() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
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
            $date_tes = "";
            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();

            $passhandskor = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
            foreach ($passhandskor as $key) {
                $passhandjwb .= "<li style=\"display: inline-block;width: 100%;padding: 2px;\">".$key->no_soal.". <label style=\"margin-left:15px;\">".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";

                
            }

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($user_id,"",$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }

                $date_tes = $kec->created_dttm;
            }
            $persen_kec = ($benar_kec * 0.0025) * 100;
            // log_message("info",$persen_kec);
            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $persen_kep = ($benar_keb * 0.005) * 100;

            $skskor = "<div style=\"width:100%;text-align:center;\">
                                <ul style=\"list-style-type: none;font-size:15px;\">";
                                
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                    $kolom_nm[] = $key->kolom_nm;
                                    $benar = 0;
                                    $salah = 0;
                                    $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSikapKerja($user_id,"",$key->kolom_id,$materi)->getResult();
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
                $ressession = $this->soalmodel->getSessionSkor($this->session->user_id)->getResult();
                foreach ($ressession as $sesskr) {
                    $persen_kec  = $sesskr->skor_kec; 
                    $persen_kep  = $sesskr->skor_kep;
                    $persen_sk   = $sesskr->skor_sk;
                    $total_skor = $persen_sk + $persen_kep + $persen_kec;
                }
            }
            
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }

            $ret = "<div>
                        <div style=\"width:100%;height: 100%;text-align:center;color:#000000;\">
                            <h1>Materi ".$materi."</h1>
                        </div>
                        <div>
                        <table style=\"table-layout:fixed;color:#000000;width:100%;\">
                        <tbody>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;\"><td width=\"150\">Passhand</td><td width=\"20\" style=\"text-align:center;\">:</td><td></td></tr>

                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Kecerdasan</td><td width=\"20\" style=\"text-align:center;\">:</td><td width=\"50\" style=\"text-align:center;\"><label>$persen_kec</label></td></tr>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Kepribadian</td><td style=\"text-align:center;\">:</td><td style=\"text-align:center;\"><label>$persen_kep</label></td></tr>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Sikap Kerja</td><td style=\"text-align:center;\">:</td><td style=\"text-align:center;\"><label>$persen_sk</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
            $ret .= $skskor;
            $date_tes = date('d F Y', strtotime($date_tes));
            $ret .= "<div class=\"card-body\">
                    <div class=\"chart\">
                        <canvas id=\"barChart\" style=\"min-height: 350px; height: 350px; max-height: 350px; max-width: 80%;\"></canvas> 
                        <img id=\"urls\" />  
                    </div>
                    </div>";
            $ret .= "<div class=\"col-md-12 row\">"
                 . "<div style=\"margin-left:50px;text-align:center;\" class=\"col-md-4\"><p> Hasil CAT : <span style=\"$styletotalskor\">$syarat</span> </p> <span style=\"font-size:100px;\">".$total_skor."</span><p><h4>".$resuser[0]->person_nm."</h4></p></div>"
                 . "<div style=\"margin-left:50px;text-align:right;\" class=\"col-md-6\"><p>Palembang, ".$date_tes."</p><p><img style=\"max-width:100%;height: 150px;margin-right: 30px;\" src=\"".base_url()."/images/frame.png\" /></p><p><h4 style=\"margin-right:55px;\">PENGUJI</h4></p></div>"
                 . "</div>";
            $ret .= "</div>";
          

            $data = [
                'ret' => $ret,
                'kolom_nm' => $kolom_nm,
                'jawaban_benar_chart' => $jawaban_benar_chart,
                'soal_terjawab_chart' => $soal_terjawab_chart
            ];
            return view('admin/hasilweb',$data);

    }

    public function hasillatihan() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $benar_sk  = 0;
        $salah_sk  = 0;
        $persen_sk = 0;
        $ttl_benar_sk = 0;

            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();
            $responlatihan = $this->soalmodel->getResponLatihan($user_id)->getResult();
            $skused = "";
            if (count($responlatihan)>0) {
                foreach ($responlatihan as $lat) {
                    $used = $lat->used;
                    $skused .= "<div style='display:inline-block;border:1px solid black;margin:10px;width: 90px;text-align: center;border-radius:10px;background-color: deepskyblue;cursor:pointer;.'><a target='_blank' href='".base_url()."/admin/users/hasilused/$user_id/$materi/$used' id='dv_used_${used}' style='width: 100%;height:100%;cursor:pointer;color:#000000;'><label for='dv_used_${used}' style='font-size:50px;cursor:pointer;'>".$lat->used."</label><label style='cursor:pointer;' for='dv_used_${used}' style='font-size:14px;'>".$lat->used_dttm."</label></a></div>";
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
            return view('admin/hasillatihan',$data);
    }

    public function hasilused() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $used = $this->request->getUri()->getSegment(6);

        $ret = "<div class='col-lg-12' style='color:#000000;'>
                        <a href='".base_url()."'><button class='btn btn-primary'>Menu Utama</button></a>
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
                                    $res_responSK = $this->soalmodel->getResponSKLatihan($user_id,$used,$key->kolom_id,$materi)->getResult();
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

                $data = [
                    'ret' => $ret,
                    'kolom_nm' => $kolom_nm,
                    'jawaban_benar_chart' => $jawaban_benar_chart,
                    'soal_terjawab_chart' => $soal_terjawab_chart
                ];
                return view('admin/hasilweb',$data);
    }


    
}
