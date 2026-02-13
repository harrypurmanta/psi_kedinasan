<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
class Soal extends BaseController
{
    protected $soalmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroup()->getResult(),
                'soal' => $this->showsoal()
            ];
            return view('admin/soal',$data);
        }
        
    }

    public function showsoal() {
        $group_id   = $this->request->getPost('group_id');
        $materi     = $this->request->getPost('materi');
        $filter     = $this->request->getPost('filter');
        $this->session->set("group_filter",$group_id);
        $this->session->set("materi_filter",$materi);
        if ($filter == "all") {
            $res = $this->soalmodel->getAllSoalSK()->getResult();
        } else if (isset($materi) && !isset($group_id)) {
            $res = $this->soalmodel->getSoalBymateri($materi)->getResult();
        } else if ($materi == 5 && $group_id == 4) {
            $res = $this->soalmodel->getSoalBymateri(5)->getResult();
        } else {
            $res = $this->soalmodel->getSoalBygrmt($group_id,$materi)->getResult();
        }
        
        $no = 1;
        
        $ret = "<table id='example2' class='table table-bordered table-hover'>
                    <thead>
                    <tr>
                    <th style='text-align:center;width:50px;'>No.</th>
                    <th style='text-align:center;width:100px;'>No. Soal</th>
                    <th style='text-align:center;'>Soal</th>
                    <th style='text-align:center;width:50px;'>Kunci</th>
                    <th style='text-align:center;width:50px;'>Kolom</th>
                    <th style='text-align:center;'>Jawaban</th>
                    <th style='text-align:center;'>Gambar</th>
                    <th style='text-align:center;'>Action</th>
                    </tr>
                    </thead>
                    <tbody>";
                    
                foreach ($res as $key) {
                    $soal_id = $key->soal_id;
                    $kolom_id = $key->kolom_id;
                    $ret .= "<tr>
                            <td style='text-align:center;'>". $no++."</td>
                            <td style='text-align:center;'>".$key->no_soal."</td>
                            <td style='text-align:center;'>".$key->soal_nm."</td>
                            <td style='text-align:center;'>".$key->kunci."</td>
                            <td style='text-align:center;'>$kolom_id</td>
                            <td style='width:200px;'>
                            <div style='display:inline-block;'>
                                <a onclick='showjawaban(".$key->soal_id.")' class='btn btn-app btn-secondary' style='height: 44px;padding: 5px 5px;min-width: 40px;'>
                                <i style='font-size: 15px;' class='fas fa-edit'></i> Edit
                                </a>
                            </div>
                            <div style='display:inline-block;'>
                            <ul style='list-style-type: none;text-align:left;padding:0;margin-left:10px;'>";
                                $db = db_connect();
                                $jawaban_nm = "";
                                $status_jwb = "";
                                $query = $db->query("SELECT * FROM jawaban WHERE soal_id = $soal_id AND status_cd IN ('normal','disable')");
                                foreach ($query->getResult() as $jwb) {
                                $jawaban_nm = $jwb->jawaban_nm;
                                $status_jwb = $jwb->status_cd;
                                $ret .= "<li>".$jwb->pilihan_nm .". ". $jwb->jawaban_nm."</li>";
                                }
                            
                    $ret .= "</ul>
                            </div>
                            
                            </td>

                            <td style='text-align:center;'>";
                            if ($key->soal_img == "") {
                                $ret .= "";
                            } else {
                                $ret .= "<img style='max-width:300px;heigth:100%;' src='".base_url()."/images/soal/materi/".$key->materi."/".$key->soal_img."'>";
                            }
                    $ret .= "</td>
                            <td style='text-align:center;'><button onclick='editsoal(".$key->soal_id.")' style='font-size:16px;' class='btn btn-secondary' data-toggle='modal' data-target='#modal-lg'>Edit</button> <button onclick='hapussoal(".$key->soal_id.")' style='font-size:16px;' class='btn btn-danger'>Hapus</button> <div class='form-group'>
                            <div class='custom-control custom-switch'>
                              <input onclick='checkboxenable(\"$jawaban_nm\",$kolom_id,$soal_id)' type='checkbox' class='custom-control-input' id='customSwitch1_${kolom_id}_${soal_id}' ".($status_jwb=='normal'?'checked':'')."/>
                              <label class='custom-control-label' for='customSwitch1_${kolom_id}_${soal_id}'>enable/disable</label>
                            </div>
                          </div></td>
                            </tr>
                                <tr class='tr_parentdata' style='background-color:#ececec54;' id='tr_data_${soal_id}'>
                                </tr>";
                        }
                    
                $ret .= "</tbody>
                </table>";

        return $ret;
    }

    public function tambahsoal() {
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div class='form-group row'>
                        <div class='col-lg-12'><label for='no_soal'>Group : </label>  ";
                        $resgroup = $this->soalmodel->getGroup()->getResult();
                        foreach ($resgroup as $g) {
                            $group_id = $g->group_soal_id;
                            $ret .= "<label style='margin:0px 10px;' for='group_nm_${group_id}'><input value='".$g->group_soal_id."' type='radio' id='group_nm_${group_id}' name='group_nm' ".($group_id==$this->session->group_id?'checked':'')."/> ".$g->group_nm."</label> ";
                        }
                        
                    $ret .= "</div>
                        
                    </div>
                    <div class='form-group row'>
                        <div class='col-lg-12'><label for='no_soal'>Materi : </label>
                        <label style='margin:0px 10px;' for='materi_1'><input value='materi1' type='radio' id='materi_1' name='materi' ".('materi1'==$this->session->materi?'checked':'')."/> Materi 1</label> 
                        <label style='margin:0px 10px;' for='materi_2'><input value='materi2' type='radio' id='materi_2' name='materi' ".('materi2'==$this->session->materi?'checked':'')."/> Materi 2</label>
                        <label style='margin:0px 10px;' for='materi_3'><input value='materi3' type='radio' id='materi_3' name='materi' ".('materi3'==$this->session->materi?'checked':'')."/> Materi 3</label>";
                    $ret .= "</div>
                        
                    </div>
                    <div class='form-group row'>
                        <label for='no_soal' class='col-sm-2 col-form-label'>No Soal</label>
                        <div class='col-2'>
                        <input type='text' class='form-control' id='no_soal' name='no_soal'>
                        </div>
                        <label for='no_soal' class='col-sm-2 col-form-label'>Kunci</label>
                        <div class='col-2'>
                        <input type='text' class='form-control' id='kunci' name='kunci'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='soal_nm' class='col-sm-2 col-form-label'>Soal</label>
                        <div class='col-sm-10'>
                        <textarea class='form-control' id='soal_nm' name='soal_nm'></textarea>
                        </div>
                    </div>
                    </div>
                    <div class='card-footer'>
                    <button onclick='simpansoal()' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div>";

        return $ret;
    }

    public function editsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $ressoal = $this->soalmodel->getSoalByid($soal_id)->getResult();
        foreach ($ressoal as $key) {
            $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div class='form-group row'>
                        <div class='col-lg-12'><label for='no_soal'>Group : </label>  ";
                        $resgroup = $this->soalmodel->getGroup()->getResult();
                        foreach ($resgroup as $g) {
                            $group_id = $g->group_soal_id;
                            $ret .= "<label style='margin:0px 10px;' for='group_nm_${group_id}'><input value='".$g->group_soal_id."' type='radio' id='group_nm_${group_id}' name='group_nm' ".($group_id==$key->group_id?'checked':'')."/> ".$g->group_nm."</label> ";
                        }
                        
                    $ret .= "</div>
                        
                    </div>
                    <div class='form-group row'>
                        <div class='col-lg-12'><label for='no_soal'>Materi : </label>
                        <label style='margin:0px 10px;' for='materi_1'><input value='1' type='radio' id='materi_1' name='materi' ".(1==$key->materi?'checked':'')."/> Materi 1</label> 
                        <label style='margin:0px 10px;' for='materi_2'><input value='2' type='radio' id='materi_2' name='materi' ".(2==$key->materi?'checked':'')."/> Materi 2</label>
                        <label style='margin:0px 10px;' for='materi_3'><input value='3' type='radio' id='materi_3' name='materi' ".(3==$key->materi?'checked':'')."/> Materi 3</label>
                        <label style='margin:0px 10px;' for='materi_4'><input value='4' type='radio' id='materi_4' name='materi' ".(4==$key->materi?'checked':'')."/> Materi 4</label>";
                        
                        
                    $ret .= "</div>
                        
                    </div>
                    <div class='form-group row'>
                        <label for='no_soal' class='col-sm-2 col-form-label'>No Soal</label>
                        <div class='col-2'>
                        <input type='text' class='form-control' id='no_soal' name='no_soal' value='".$key->no_soal."'>
                        </div>
                        <label for='no_soal' class='col-sm-2 col-form-label'>Kunci</label>
                        <div class='col-2'>
                        <input type='text' class='form-control' id='kunci' name='kunci' value='".$key->kunci."'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='soal_nm' class='col-sm-2 col-form-label'>Soal</label>
                        <div class='col-sm-10'>
                        <textarea class='form-control' id='soal_nm' name='soal_nm'>".$key->soal_nm."</textarea>
                        </div>
                    </div>
                    </div>
                    <div class='card-footer'>
                    <button onclick='updatesoal(".$key->soal_id.")' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
            $ret .= "</div>
                    </div>
                    </div>
                    </div>
                    </div>";
        }
        

        echo json_encode($ret);
    }

    public function simpansoal() {
        $soal_nm = $this->request->getPost('soal_nm');
        $materi = $this->request->getPost('materi');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $this->session->set("group_id",$group_id);
        $this->session->set("materi",$materi);
        $group = $this->soalmodel->getGroupByid($group_id)->getResult();
        $data = [
            'soal_nm' => $soal_nm,
            'group_id' => $group_id,
            'no_soal' => $no_soal,
            'kunci' => $kunci,
            'materi' => $materi,
            'status_cd' => 'normal'
        ];
        $soal_id = $this->soalmodel->simpansoal($data);
        echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        // echo json_encode($group[0]->group_nm);
    }

    public function updatesoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal_nm = $this->request->getPost('soal_nm');
        $materi = $this->request->getPost('materi');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $this->session->set("group_id",$group_id);
        $this->session->set("materi",$materi);
        $data = [
            'soal_nm' => $soal_nm,
            'group_id' => $group_id,
            'no_soal' => $no_soal,
            'kunci' => $kunci,
            'materi' => $materi,
            'status_cd' => 'normal'
        ];
        $this->soalmodel->updatesoal($soal_id,$data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function hapussoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->soalmodel->hapussoal($soal_id,$data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function showjawaban() {
        $soal_id = $this->request->getPost('soal_id');
        $res = $this->soalmodel->getJawabanBysoalId($soal_id)->getResult();
        $cntform = 1;
        if (count($res)>0) {
            $ret = "<td class='td_form' colspan='2'></td>
                        <td colspan='4' class='td_form'>
                        <table id='tb_jawaban${soal_id}' class='table table-bordered table-hover'>
                        <tbody>";
                        foreach ($res as $key) {
                            $jawaban_id = $key->jawaban_id;
                            $ret .= "<tr id='tr_form_${soal_id}_${jawaban_id}'>
                                      <td style='text-align:center;width:50px;'><button onclick='timesbtn($soal_id,$jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td>
                                      <td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' value='".$key->pilihan_nm."' id='pilihan_nm_${jawaban_id}' name='pilihan_nm[]' data-id='$jawaban_id'/> </td>
                                      <td><input style='padding-left:10px;width:100%;' type='text' value='".$key->jawaban_nm."' id='jawaban_nm_${jawaban_id}' name='jawaban_nm[]'/> </td>
                                      <td style='text-align:center;width:50px;'>
                                      <button onclick='deletebtn($soal_id,$jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-trash'></i></button>
                                      </td>
                                      <td style='text-align:center;'>";
                                $ret .= "<div><input type='file' id='jawaban_img_${jawaban_id}' name='jawaban_img[]' data-jawaban_id='$jawaban_id' style='max-width: 200px;'/> <button onclick='hapusgambarjawaban($jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-trash'></i></button> <button onclick='simpangambarjawaban($soal_id,$jawaban_id)' type='button' class='btn btn-outline-success'><i class='fa  fa-save'></i></button></div>";
                                    if ($key->jawaban_img == "") {
                                        $ret .= "";
                                    } else {
                                        $ret .= "<div><img style='max-width:150px;heigth:100%;' src='".base_url()."/images/jawaban/materi/".$this->session->materi_filter."/".$key->jawaban_img.".jpg'></div>";
                                    }
                                $ret .= "</td>
                                     </tr>";
                        }
            $ret .= "</tbody>
                    </table>
                    </td>
                    <td class='td_form' colspan='4' style='line-height: 10;'>
                    <button onclick='plusbtn($soal_id)' type='button' class='btn btn-outline-primary'><i class='fa fa-plus'></i></button>
                   
                    <button onclick='checkbtn($soal_id)' type='button' class='btn btn-outline-success'><i class='fa fa-check'></i></button>
                    </td>";
                    
        } else {
            $ret = "<td class='td_form' colspan='2'></td>
                        <td class='td_form'>
                        <table id='tb_jawaban${soal_id}' class='table table-bordered table-hover'>
                        <tbody>";
                $ret .= "<tr class='tr_form' id='tr_form_${soal_id}_${cntform}'>
                            <td style='text-align:center;width:50px;'><button onclick='timesbtn($soal_id,$cntform)' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td>
                            <td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' value='' name='pilihan_nm[]' data-id='new'/> </td>
                            <td><input style='padding-left:10px;width:100%;' type='text' value='' name='jawaban_nm[]'/> </td>
                        </tr>";
            $ret .= "</tbody>
                    </table>
                    </td>
                    <td class='td_form' colspan='4' style='line-height: 10;'>
                    <button onclick='plusbtn($soal_id)' type='button' class='btn btn-outline-primary'><i class='fa fa-plus'></i></button>
                   
                    <button onclick='checkbtn($soal_id)' type='button' class='btn btn-outline-success'><i class='fa fa-check'></i></button>
                    </td>";
        }
        echo json_encode($ret);
    }

    public function simpanjawaban() {
        $soal_id    = $this->request->getPost('soal_id');
        $pilihan_nm = $this->request->getPost('pilihan_nm');
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $jawaban_id = $this->request->getPost('jawaban_id');
        $i = 0;
        foreach ($pilihan_nm as $k => $v) {
            $imagefile = $this->request->getFiles();
        
            if ($v['id'] == "new") {
                if ($imagefile["jawaban_img"][$i]->isValid() && ! $imagefile["jawaban_img"][$i]->hasMoved()){
                    $newName = $soal_id.$pilihan_nm[$i];
                    $imagefile["jawaban_img"][$i]->move("../public/images/materi/".$this->session->materi_filter."/", $newName); // <--- berarti mesti cari ekstension nyo dlu
                }

                $data = [
                    "soal_id" => $soal_id,
                    "pilihan_nm" => $v['value'],
                    "jawaban_nm" => $jawaban_nm[$i],
                    "jawaban_img" => $newName,
                    "status_cd" => "normal"
                ];
                $simpanjawaban = $this->soalmodel->simpanjawaban($data);
            } else {
                $data = [
                    "soal_id" => $soal_id,
                    "pilihan_nm" => $v['value'],
                    "jawaban_nm" => $jawaban_nm[$i],
                    "jawaban_img" => $newName,
                    "status_cd" => "normal"
                ];
                $simpanjawaban = $this->soalmodel->updatejawaban($jawaban_id[$i],$data);
            }
            $i++;
        }

        if ($simpanjawaban) {
            echo json_encode("sukses");
        }
    }

    public function deletejawaban() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $deletejawaban = $this->soalmodel->deletejawaban($jawaban_id);
        if ($deletejawaban) {
            echo json_encode("sukses");
        } else {
            echo json_encode("gagal");
        }
    }

    public function tambahsoallatihan() {
        $materi_id = "";
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div style='margin-bottom:20px;' class='col-lg-12'><label for='no_soal'>Materi : </label>";

                    $allmateri = $this->soalmodel->getAllJMateri()->getResult();
                        foreach ($allmateri as $mat) {
                            $materi_id = $mat->materi_id;
                            $ret .= "<label style='margin:0px 10px;' for='materi_${materi_id}'><input value='".$mat->materi_id."' type='radio' id='materi_${materi_id}' name='materi_${materi_id}' ".($materi_id==$this->session->materi?'checked':'')."/> ".$mat->materi_nm."</label>";
                        }
                    $ret .= "</div>
                    <div class='form-group row'>
                        <label for='kolom1' class='col-form-label'>Kolom 1 </label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom1\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom1' name='kolom1'>
                        </div>

                        <label for='kolom2' class='col-form-label'>Kolom 2</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom2\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom2' name='kolom2'>
                        </div>

                        <label for='kolom3' class='col-form-label'>Kolom 3</label>
                        <div class='col-2' style=\"margin-left:5px;\">
                        <input onkeyup='checkdupe(\"kolom3\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom3' name='kolom3'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='kolom4' class='col-form-label'>Kolom 4</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom4\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom4' name='kolom4'>
                        </div>

                        <label for='kolom5' class='col-form-label'>Kolom 5</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom5\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom5' name='kolom5'>
                        </div>

                        <label for='kolom6' class='col-form-label'>Kolom 6</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom6\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom6' name='kolom6'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='kolom7' class='col-form-label'>Kolom 7</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom7\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom7' name='kolom7'>
                        </div>

                        <label for='kolom8' class='col-form-label'>Kolom 8</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom8\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom8' name='kolom8'>
                        </div>

                        <label for='kolom9' class='col-form-label'>Kolom 9</label>
                        <div class='col-2' style=\"margin-left:5px;\">
                        <input onkeyup='checkdupe(\"kolom9\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom9' name='kolom9'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='kolom10' class='col-form-label'>Kolom 10</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom10\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom10' name='kolom10'>
                        </div>
                    </div>
                  
                    </div>
                    <div class='card-footer'>
                    <button onclick='simpansoallatihan($materi_id)' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div>";

        return $ret;
    }

    public function simpansoallatihan() {
        $materi_id = $this->request->getPost('materi_id');
        $kolom1 = $this->request->getPost('kolom1');
        $kolom2 = $this->request->getPost('kolom2');
        $kolom3 = $this->request->getPost('kolom3');
        $kolom4 = $this->request->getPost('kolom4');
        $kolom5 = $this->request->getPost('kolom5');
        $kolom6 = $this->request->getPost('kolom6');
        $kolom7 = $this->request->getPost('kolom7');
        $kolom8 = $this->request->getPost('kolom8');
        $kolom9 = $this->request->getPost('kolom9');
        $kolom10 = $this->request->getPost('kolom10');
        $res = $this->randomchar($kolom1,1,$materi_id);
        // log_message("info",$res);
        if ($res == "finish") {
            $res = $this->randomchar($kolom2,2,$materi_id);
            if ($res == "finish") {
                $res = $this->randomchar($kolom3,3,$materi_id);
                if ($res == "finish") {
                    $res = $this->randomchar($kolom4,4,$materi_id);
                    if ($res == "finish") {
                        $res = $this->randomchar($kolom5,5,$materi_id);
                        if ($res == "finish") {
                            $res = $this->randomchar($kolom6,6,$materi_id);
                            if ($res == "finish") {
                                $res = $this->randomchar($kolom7,7,$materi_id);
                                if ($res == "finish") {
                                    $res = $this->randomchar($kolom8,8,$materi_id);
                                    if ($res == "finish") {
                                        $res = $this->randomchar($kolom9,9,$materi_id);
                                        if ($res == "finish") {
                                            $res = $this->randomchar($kolom10,10,$materi_id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } 
        
        echo json_encode("sukses");
    }

    public function randsoal($characters,$randSoal) {
        $randomString = $randSoal;
        for ($s = 0; $s < 5; $s++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        
        $randSoal = count_chars($randomString,3);
        log_message("info",$randSoal);
        if (strlen($randSoal) == 5) {
            $soal_nm = str_shuffle($randSoal);
        } else {
            $soal_nm = $this->randsoal($characters,$randSoal);
        }

        return $soal_nm;
    }

    public function randomchar($char,$kolom,$materi_id) {
        $characters = $char;
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        for ($i = 0; $i < 50; $i++) {
            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            if ($kunci == "A") {
                $hilang = $characters[0];
            } else if ($kunci == "B") {
                $hilang = $characters[1];
            } else if ($kunci == "C") {
                $hilang = $characters[2];
            } else if ($kunci == "D") {
                $hilang = $characters[3];
            } else if ($kunci == "E") {
                $hilang = $characters[4];
            }
            
            $soal_txt = $this->randsoal($characters,"");
           
            if (strlen($soal_txt) === 5) {
                $soal_nm = str_replace($hilang,"",$soal_txt);
            } else {
                $soal_nm = $soal_txt;
            }

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => 4,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $characters,
            ];

            $soal_id = $this->soalmodel->insertsoalSKlatihan($data);

            $datax = [
                "soal_id" => $soal_id,
                "pilihan_nm" => $pilihan,
                "jawaban_nm" => $characters,
                "jawaban_img" => "",
                "status_cd" => "normal"
            ];
    
            

            $this->soalmodel->insertjawabanSKlatihan($datax);
            $no++;
        }
        return "finish";
    }

    public function updatestatus() {
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $kolom_id = $this->request->getPost('kolom_id');
        $status_cd = $this->request->getPost('status_cd');
        $old_status = $this->request->getPost('old_status');

        $update = $this->soalmodel->updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status);
        log_message("debug",$status_cd);
    }

}
