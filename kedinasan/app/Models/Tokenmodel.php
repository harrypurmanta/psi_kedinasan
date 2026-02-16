<?php namespace App\Models;

use CodeIgniter\Model;

class Tokenmodel extends Model
{
    protected $table      = 'users';
    // protected $primaryKey = 'user_id';
    protected $allowedFields = ['token', 'start_date','end_date','status_cd'];

    public function getAll() {
        return $this->db->table('token')
                        ->select('*')
                        ->get();
    }

    public function getTokeByDate($start_date,$end_date,$group_id) {
        if ($group_id == "all") {
            return $this->db->table('token a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id = a.group_id','LEFT')
                        ->where('a.start_date >=',$start_date)
                        ->where('a.end_date >=',$start_date)
                        ->where('a.start_date <=',$end_date)
                        ->where('a.end_date <=',$end_date)
                        ->get();
        } else {
            return $this->db->table('token a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id = a.group_id')
                        ->where('a.start_date >=',$start_date)
                        ->where('a.end_date >=',$start_date)
                        ->where('a.start_date <=',$end_date)
                        ->where('a.end_date >=',$end_date)
                        ->where('a.group_id',$group_id)
                        ->get();
        }
        
    }

    public function simpantoken($data) {
        return $this->db->table('token')
                        ->insert($data);
    }

    public function updatetoken($token_id,$data) {
        return $this->db->table('token')
                        ->set($data)
                        ->where("token_id",$token_id)
                        ->update();
    }

    public function checktoken($token,$group_id) {
        $date = date("Y-m-d");
        return $this->db->table('token')
                        ->select('*')
                        ->where('token',$token)
                        ->where('start_date <=',$date)
                        ->where('end_date >=',$date)
                        ->where('group_id',$group_id)
                        ->get();
    }

    public function checktokenUsername($token) {
        return $this->db->table('users')
                        ->select('*')
                        ->where('user_nm',$token)
                        ->get();
    }
}