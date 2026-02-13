<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
use App\Models\Jawabanmodel;

class Jawaban extends BaseController
{
    protected $soalmodel;
    protected $jawabanmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->jawabanmodel = new Jawabanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'jawaban' => $this->jawabanmodel->getjawAllJawaban()->getResult()
            ];
            return view('admin/jawaban',$data);
        }
        
    }

    public function jawaban() {
        
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
                        <label style='margin:0px 10px;' for='materi_1'><input value='materi1' type='radio' id='materi_1' name='materi' ".('materi1'==$key->materi?'checked':'')."/> Materi 1</label> 
                        <label style='margin:0px 10px;' for='materi_2'><input value='materi2' type='radio' id='materi_2' name='materi' ".('materi2'==$key->materi?'checked':'')."/> Materi 2</label>
                        <label style='margin:0px 10px;' for='materi_3'><input value='materi3' type='radio' id='materi_3' name='materi' ".('materi3'==$key->materi?'checked':'')."/> Materi 3</label>";
                        
                        
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

    
}
