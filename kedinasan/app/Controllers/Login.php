<?php
namespace App\Controllers;
use App\Models\Usersmodel;

class Login extends BaseController
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
                return redirect()->to('home');
            } else {
                return redirect()->to('admin');
            }
        }
        return view('login');
		
	}

	public function register()
    {
        return view('front/register');
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
    	
		$res = $this->usersmodel->checklogin($u,$pwd0)->getResultArray();
			if (count($res) > 0) {
			  foreach ($res as $k) {
			  	$this->session->set($k);
			  }
		  if ($this->session->user_group == "siswa") {
			$ressession = $this->usersmodel->getMaxSessionUser($this->session->user_id)->getResultArray();
			if (count($ressession) > 0) {
				foreach ($ressession as $sess) {
					$session = $sess['session_soal_nm'] + 1;
					$newdata = [
						'session'  => $session,
					];
					$this->session->set($newdata);
				}
			} else {
				$session = 1;
				$newdata = [
					'session'  => $session,
				];
				$this->session->set($newdata);
			}
			$date = date("Y-m-d H:i:s");
			$data = [
				"session_soal_nm" => $session,
				"user_id" => $this->session->user_id,
				"created_dttm" => $date
			];
			$this->usersmodel->simpanSessionUser($data);
			// echo $this->session->session;
		  	return redirect('home');
		  } else if ($this->session->user_group == 'owner') {
		  	return redirect('admin');
		  } else if ($this->session->user_group == 'kasir') {
		  	return redirect('kasir');
		  } else if ($this->session->user_group == 'manajer') {
		  	return redirect('dashboard');
		  } else {
		  	return redirect('/');
		  }
        } else {
          return redirect('/');
        } 
	}

	public function simpanregister() {
        $person_nm = $this->request->getPost("person_nm");
        $satuan = $this->request->getPost("satuan");
        $birth_place = $this->request->getPost("birth_place");
        $birth_dttm = $this->request->getPost("birth_dttm");
        $cellphone = $this->request->getPost("cellphone");
        $addr_txt = $this->request->getPost("addr_txt");
        $user_nm = $this->request->getPost("user_nm");
        $gender_cd = $this->request->getPost("gender_cd");
        $user_group = "siswa";
		$resCellphone = $this->usersmodel->getbyCellphone($cellphone)->getResult();
		if (count($resCellphone)>0) {
			$ret = "userada";
		} else {
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
			$datas = [
				"user_nm" => $user_nm,
				"pwd0" => $pwd,
				"user_group" => $user_group,
				"person_id" => $person_id,
				'status_cd' => 'normal'
			];
			$user_id = $this->usersmodel->simpanuser($datas);

			$ret = "sukses";
		}
		
        echo json_encode($ret);
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