<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
use App\Models\Tokenmodel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Token extends BaseController
{
    protected $usermodel;
    protected $soalmodel;
    protected $tokenmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usermodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
        $this->tokenmodel = new Tokenmodel();
	}


    public function checktoken()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
           
            $token = $this->request->getPost('token');
            $group_id = $this->request->getPost('group_id');
            $check = $this->tokenmodel->checktokenUsername($token)->getResult();
            if (count($check)>0) {
                $ret = "sukses";
            } else {
                $ret = "gagal";
            }
            echo json_encode($ret);
        }
    }

    public function InsertNoTest() {
        $notest = $this->request->getPost('notest');
        $group_id = $this->request->getPost('group_id');
       
        $dataexam = [
            "group_id" => $group_id,
            "materi_id" => 1,
            "user_id" => $this->session->user_id,
            "no_antrian" => $notest,
        ];
        $insertexam = $this->soalmodel->insertexam($dataexam);
        if ($insertexam) {
            $ret = "sukses"; 
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }
}
