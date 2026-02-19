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


    
}
