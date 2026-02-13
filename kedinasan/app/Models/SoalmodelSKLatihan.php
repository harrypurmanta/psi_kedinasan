<?php namespace App\Models;

use CodeIgniter\Model;

class SoalmodelSKLatihan extends Model
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

    public function getKolomSkLatihan($group_id, $materi_id, $sk_group_id) {
        return $this->db->table('kolom_soal a')
                    ->select('a.kolom_id, b.clue, a.kolom_nm')
                    ->join('soal b', 'b.kolom_id = a.kolom_id AND b.sk_group_id = '.$sk_group_id.' AND b.status_cd = "normal"', 'left')
                    ->groupBy('a.kolom_id, b.clue, a.kolom_nm')
                    ->get();
    }
    
}