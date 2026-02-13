<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
use App\Models\Jawabanmodel;

class Jawaban extends BaseController
{
    protected $session;
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
                'group' => $this->soalmodel->getGroup()->getResult(),
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'jawaban' => $this->jawabanmodel->getjawAllJawaban()->getResult()
            ];
            return view('admin/jawaban',$data);
        }
        
    }

    public function showjawaban() {
        $group_id   = $this->request->getPost('group_id');
        $materi     = $this->request->getPost('materi');
        $filter     = $this->request->getPost('filter');
        $this->session->set("group_filter",$group_id);
        $this->session->set("materi_filter",$materi);

        $resjawaban = $this->jawabanmodel->getJawbanGroupMateri($group_id,$materi)->getResult();

        $ret = "<table id='example2' class='table table-bordered table-hover'>
        <thead>
        <tr>
          <th style='text-align:center;'>No.</th>
          <th style='text-align:center;'>No. Soal</th>
          <th style='text-align:center;'>Materi</th>
          <th style='text-align:center;'>Jawaban</th>
          <th style='text-align:center;'>Pilihan</th>
          <th style='text-align:center;'>Gambar</th>
          <th style='text-align:center;'>Action</th>
        </tr>
        </thead>
        <tbody>";
          $no = 1;
              foreach ($resjawaban as $key) {
                if ($key->jawaban_img == "") {
                  $jawaban_img = "";
                } else {
                  $jawaban_img = "<img style='max-width:200px;heigth:100%;' src='".base_url()."/images/jawaban/materi/".$key->materi."/".$key->jawaban_img.".jpg'>";
                }
                $ret .= "<tr>
                        <td style='text-align:center;'>".$no++."</td>
                        <td style='text-align:center;'>".$key->no_soal."</td>
                        <td style='text-align:center;'>".$key->materi."</td>
                        <td>".$key->jawaban_nm."</td>
                        <td style='text-align:center;'>".$key->pilihan_nm."</td>
                        <td style='text-align:center;'>".$jawaban_img."</td>
                        <td style='text-align:center;'><button onclick='editjawaban(".$key->jawaban_id.",".$key->materi.")' style='font-size:10px;' class='btn btn-secondary' data-toggle='modal' data-target='#modal-lg'>Edit</button> <button onclick='hapusjawaban(".$key->jawaban_id.")' style='font-size:10px;' class='btn btn-danger'>Hapus</button></td>
                        </tr>";
                
            }
        
        $ret .= "</tbody>
      </table>";
      return $ret;
    }
    

    public function tambahjawaban() {
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>";
                    
                    $optsoal = "<option> Pilih Soal</option>";
                    $ressoal = $this->soalmodel->getAllSoal()->getResult();
                    foreach ($ressoal as $sl) {
                        $optsoal .= "<option data-materi='$sl->materi' value='".$sl->soal_id."'>".$sl->no_soal."). [".$sl->group_nm."]-[".$sl->materi_nm."] ".$sl->soal_nm."</option>";
                    }
                    $ret .= "<div class='form-group row'>
                        <label>Soal</label>
                        <select id='soal_id' class='form-control select2' style='width: 100%;'>
                        $optsoal
                        </select>
                    </div>
                    <div class='form-group row'>
                        <label for='jawaban_nm' class='col-sm-2 col-form-label'>Jawaban</label>
                        <div class='col-12'>
                        <textarea class='form-control' id='jawaban_nm' name='jawaban_nm'></textarea>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='pilihan_nm' class='col-sm-2 col-form-label'>Pilihan</label>
                        <div class='col-12'>
                        <input type='text' class='form-control' id='pilihan_nm' name='pilihan_nm'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label class='col-sm-2 col-form-label'>Gambar</label>
                        <div class='col-sm-10'>
                        <input type='file' class='form-control' id='jawaban_img' name='jawaban_img'>
                        </div>
                    </div>
                    </div>
                    <div class='card-footer'>
                    <button onclick='simpanjawaban()' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div> <script>$('.select2').select2()</script>";

        return $ret;
    }

    public function editjawaban() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $materi = $this->request->getPost('materi');
        $resjawaban = $this->jawabanmodel->getJawabanByid($jawaban_id)->getResult();
        foreach ($resjawaban as $key) {
            $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>";
                    
                    $optsoal = "<option> Pilih Soal</option>";
                    $ressoal = $this->soalmodel->getAllSoal()->getResult();
                    foreach ($ressoal as $sl) {
                        $optsoal .= "<option ".($sl->soal_id==$key->soal_id?'selected':'')." data-materi='$sl->materi' value='".$sl->soal_id."'>".$sl->no_soal."). [".$sl->group_nm."]-[".$sl->materi_nm."] ".$sl->soal_nm."</option>";
                    }
                    $ret .= "<div class='form-group row'>
                        <label>Soal</label>
                        <select id='soal_id' class='form-control select2' style='width: 100%;'>
                        $optsoal
                        </select>
                    </div>
                    <div class='form-group row'>
                        <label for='jawaban_nm' class='col-sm-2 col-form-label'>Jawaban</label>
                        <div class='col-12'>
                        <textarea class='form-control' id='jawaban_nm' name='jawaban_nm'>".$key->jawaban_nm."</textarea>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='pilihan_nm' class='col-sm-2 col-form-label'>Pilihan</label>
                        <div class='col-12'>
                        <input type='text' class='form-control' id='pilihan_nm' name='pilihan_nm' value='".$key->pilihan_nm."'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label class='col-sm-2 col-form-label'>Gambar</label>
                        <div class='col-sm-10'>
                        <input type='file' class='form-control' id='jawaban_img' name='jawaban_img'>
                        <input type='hidden' class='form-control' id='jawaban_img_lama' name='jawaban_img_lama' value='".$key->jawaban_img."'>
                        </div>
                        <img style='max-width:200px;heigth:100%;' src='".base_url()."/images/jawaban/materi/$materi/".$key->jawaban_img."'>
                    </div>
                    </div>
                    <div class='card-footer'>
                    <button onclick='updatejawaban(".$key->jawaban_id.")' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div> <script>$('.select2').select2()</script>";

        
        }
        

        return $ret;
    }

    public function simpanjawaban() {
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $pilihan_nm = $this->request->getPost('pilihan_nm');
        $soal_id = $this->request->getPost('soal_id');
        $materi = $this->request->getPost('materi');
        $newName = "";
        $imagefile = $this->request->getFile('jawaban_img');
        if($imagefile){
            $validateImage = $this->validate([
                'file' => [
                    'uploaded[jawaban_img]',
                    'mime_in[jawaban_img, image/png, image/jpg,image/jpeg, image/gif]',
                    'max_size[jawaban_img, 5096]',
                ],
            ]);
            if ($validateImage){
                $newName = $imagefile->getClientName();
                $imagefile->move("../public/images/jawaban/materi/$materi", $newName);
            }
        }


        $data = [
            'soal_id' => $soal_id,
            'jawaban_nm' => $jawaban_nm,
            'pilihan_nm' => $pilihan_nm,
            'jawaban_img' => $newName,
            'status_cd' => 'normal'
        ];
        $simpan = $this->jawabanmodel->simpanjawaban($data);
        echo $simpan;
        
        
        // echo json_encode($group[0]->group_nm);
    }

    public function updatejawaban() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $pilihan_nm = $this->request->getPost('pilihan_nm');
        $soal_id = $this->request->getPost('soal_id');
        $materi = $this->request->getPost('materi');
        $jawaban_img_lama = $this->request->getPost('jawaban_img_lama');
        $newName = "";
        if($imagefile = $this->request->getFiles()){
            foreach($imagefile['jawaban_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $newName = $img->getClientName();
                    $img->move("../public/images/jawaban/materi/$materi", $newName);
                        $data = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm,
                            'pilihan_nm' => $pilihan_nm,
                            'jawaban_img' => $newName,
                            'status_cd' => 'normal'
                        ];
                   }
             }
        } else {
            $data = [
                'soal_id' => $soal_id,
                'jawaban_nm' => $jawaban_nm,
                'pilihan_nm' => $pilihan_nm,
                'status_cd' => 'normal'
            ];
        }

        $res = $this->jawabanmodel->updatejawaban($jawaban_id,$data);
        if ($res) {
            echo "sukses";
        } else {
            echo "gagal";
        }
    }

    public function hapusjawaban() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $res = $this->jawabanmodel->hapusjawaban($jawaban_id);
        if ($res) {
            echo "sukses";
        } else {
            echo "gagal";
        }
    }
}
