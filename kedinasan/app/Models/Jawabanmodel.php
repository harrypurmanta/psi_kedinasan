<?php namespace App\Models;

use CodeIgniter\Model;

class jawabanmodel extends Model
{
    protected $table      = 'jawaban';
    protected $primaryKey = 'jawaban_id ';
    protected $allowedFields = ['jawaban_id','soal_id','jawaban_nm','status_cd','pilihan_nm','jawaban_img'];
    
    public function getJawabanBysoalId($soal_id) {
        return $this->db->table('jawaban a')
                        ->select('*')
                        ->join('soal b', 'b.soal_id = a.soal_id')
                        ->where('a.soal_id', $soal_id)
                        ->where('a.status_cd', 'normal')
                        ->orderBy('a.pilihan_nm')
                        ->get();
    }
    public function getjawAllJawaban() {
        return $this->db->table('jawaban a')
                        ->select('*')
                        ->join('soal b','b.soal_id=a.soal_id','right')
                        // ->orderby('b.no_soal','ASC')
                        ->where('a.status_cd','normal')
                        ->orderby('b.materi','ASC')
                        ->orderby('a.jawaban_id','ASC')
                        ->get();
    }

    public function getJawbanGroupMateri($group_id,$materi) {
        return $this->db->table('jawaban a')
                        ->select('*')
                        ->join('soal b','b.soal_id=a.soal_id','right')
                        // ->orderby('b.no_soal','ASC')
                        ->where('a.status_cd','normal')
                        ->where('b.group_id',$group_id)
                        ->where('b.materi',$materi)
                        ->orderby('b.materi','ASC')
                        ->orderby('a.jawaban_id','ASC')
                        ->get();
    }

    public function getJawabanByid($jawaban_id) {
        return $this->db->table('jawaban')
                        ->select('*')
                        ->where('jawaban_id',$jawaban_id)
                        ->get();
    }

    public function simpanjawaban($data) {
        return $this->db->table('jawaban')
                 ->insert($data);
    }

    public function updatejawaban($jawaban_id,$data) {
        return $this->db->table('jawaban')
                        ->set($data)
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function hapusjawaban($jawaban_id) {
        return $this->db->table('jawaban')
                        ->set('status_cd','nullified')
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    
}
