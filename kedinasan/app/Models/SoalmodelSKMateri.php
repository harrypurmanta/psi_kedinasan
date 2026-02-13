<?php namespace App\Models;

use CodeIgniter\Model;

class SoalmodelSKMateri extends Model
{
    protected $table      = 'sk_group';
    // protected $primaryKey = 'user_id';
    protected $allowedFields = ['sk_group_nm', 'status_cd'];

    public function getSKgroupAll() {
        return $this->db->table('sk_group')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getKolomSkMateri($group_id, $materi_id)
    {
        return $this->db->table('kolom_soal a')
            ->select('a.kolom_id, b.clue, a.kolom_nm')
            ->join('soal b', 'b.kolom_id = a.kolom_id', 'left')
            ->where('b.materi', $materi_id)
            ->where('b.group_id', $group_id)
            ->where('b.status_cd', 'normal')
            ->groupBy('a.kolom_id, b.clue, a.kolom_nm')
            ->get();
    }

    public function getSoalIdByClueSKGambar($clue, $group_id, $sk_group_id, $kolom_id, $materi) {
        return $this->db->table('soal')
                        ->select('soal_id')
                        // ->where('clue',$clue)
                        ->where('group_id',$group_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('kolom_id',$kolom_id)
                        ->where('materi',$materi)
                        ->orderby('soal_id', 'ASC')
                        ->get();
    }

    public function updatesoalsk($group_id, $sk_group_id, $kolom, $data, $soal_id, $jawaban_nm_lama, $materi_id) {
        return $this->db->table('soal')
                        ->set($data)
                        ->where('group_id',$group_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('kolom_id',$kolom)
                        ->where('soal_id',$soal_id)
                        ->where('materi',$materi_id)
                        // ->where('clue',$jawaban_nm_lama)
                        ->update();
    }

    public function updatejawabansk($jawaban_nm, $data,$soal_id, $jawaban_nm_lama) {
        return $this->db->table('jawaban')
                        ->set($data)
                        ->where('jawaban_nm',$jawaban_nm_lama)
                        ->where('soal_id',$soal_id)
                        ->update();
    }
    
}