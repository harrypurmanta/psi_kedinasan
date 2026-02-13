<?php

namespace App\Controllers;

use App\Models\Usersmodel;

class Belakang  extends BaseController
{
	protected $session;
	protected $usersmodel;
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->usersmodel = new Usersmodel();
	}

	public function index()
	{
		if ($this->session->get("user_nm") != "") {
			if ($this->session->get("user_group") == "siswa") {
				return redirect('home');
			} else if ($this->session->get("user_group") == "owner") {
                return redirect('admin');
            } else {
				return redirect('admin');
			}
		} else {
			return view('loginadmin');
		}
		
	}

	

	public function squrity()
	{
		if ($this->session->get("username") == "") {
			return redirect('/');
		} 
	}

	public function checklogin() {
		
		$u = $this->request->getPost('username');
		$p = $this->request->getPost('password');
		$pwd0 = md5($p);
    	
		$res = $this->usersmodel->checkloginadmin($u,$pwd0)->getResultArray();
			if (count($res) > 0) {
			  foreach ($res as $k) {
			  	$this->session->set($k);
			  }
		  if ($this->session->user_group == "owner") {
		  	return redirect('admin');
		  } else {
		  	return redirect('/');
		  }
        } else {
          return redirect('/');
        } 
	}


	public function logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to('/');

		// $this->session->destroy();
		// return redirect()->to(site_url('/'));
	}
}