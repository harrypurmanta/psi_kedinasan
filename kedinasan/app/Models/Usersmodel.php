<?php namespace App\Models;

use CodeIgniter\Model;

class Usersmodel extends Model
{
    protected $table      = 'users';
    // protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_nm', 'pwd0','user_group','person_id','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];


    public function checklogin($u,$p) {
        return $this->db->table('users a')
                        ->join('person b','b.person_id = a.person_id')
                        ->where('a.user_nm', $u)
                        ->where('a.pwd0',$p)
                        ->where('a.user_group','siswa')
                        ->get();
    }
    public function checkloginadmin($u,$p) {
        return $this->db->table('users')
                        ->where('user_nm', $u)
                        ->where('pwd0',$p)
                        ->where('user_group','owner')
                        ->get();
    }

    public function getbyCellphone($cellphone) {
        return $this->db->table('person a')
                        ->select('*')
                        ->join('users b', 'b.person_id = a.person_id','left')
                        ->where('a.status_cd', 'normal')
                        ->where('a.cellphone', $cellphone)
                        ->get();
    }

    public function getbynormal() {
        return $this->db->table('person a')
                        ->select('*')
                        ->join('users b', 'b.person_id = a.person_id','left')
                        ->where('a.status_cd', 'normal')
                        ->get();
    }

    public function getbyId($id){
        return $this->db->table('person a')
                 ->select('*')
                 ->join('users b', 'b.person_id = a.person_id','left')
                 ->where('a.person_id',$id)
                 ->get();
    }

    public function getbyUserId($user_id){
        return $this->db->table('person a')
                 ->select('*')
                 ->join('users b', 'b.person_id = a.person_id','left')
                 ->where('b.user_id',$user_id)
                 ->get();
    }

    public function getbyUsernm($user_nm){
        return $this->db->table('users')
                        ->where('user_nm',$user_nm)
                        ->get();
    }

    public function updateuser($person_id,$data) {
        return $this->db->table('users')
                        ->set($data)
                        ->where('person_id',$person_id)
                        ->update();
    }

    public function updateperson($person_id,$data) {
        return $this->db->table('person')
                        ->set($data)
                        ->where('person_id',$person_id)
                        ->update();
    }

    public function getMaxSessionUser($user_id) {
        return $this->db->table('session_soal')
                        ->select('session_soal_nm')
                        ->where('user_id',$user_id)
                        ->orderby('session_soal_id','desc')
                        ->limit(1)
                        ->get();
    }

    public function simpanSessionUser($data) {
        $this->db->table('session_soal')
                 ->insert($data);
    }

    public function simpanuser($data) {
        $this->db->table('users')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpanperson($data) {
        $this->db->table('person')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function hapususer($person_id) {
        $this->db->table("person")
                 ->set("status_cd","nullified")
                 ->where("person_id",$person_id)
                 ->update();

        $this->db->table("users")
                 ->set("status_cd","nullified")
                 ->where("person_id",$person_id)
                 ->update();
    }

    public function getjawAllJMateri() {
        return $this->db->table('materi')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->whereNotIn('materi_nm',["Sikap Kerja","Latihan"])
                        ->get();
    }

    public function gethasillatihanbyid($user_id) {

    }

    public function getJenisSoal() {
        return $this->db->table('jenis_soal')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponLatihanmateri($user_id,$materi_id) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('created_user_id',$user_id)
                        ->where('materi',$materi_id)
                        ->groupby('used')
                        ->get();
    }

    public function getlatihanKecerdasanSkor($user_id,$used,$materi_id) {
        return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.used',$used)
                        ->where('a.materi',$materi_id)
                        ->get(); 
    }

    public function getlatihanKepribadianSkor($user_id,$used,$materi_id) {
        return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',3)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.used',$used)
                        ->where('a.materi',$materi_id)
                        ->get(); 
    }

    
}