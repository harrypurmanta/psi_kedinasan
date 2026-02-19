<?php namespace App\Models;

use CodeIgniter\Model;

class Soalmodel extends Model
{
    protected $table      = 'soal';
    protected $primaryKey = 'soal_id ';
    protected $allowedFields = ['soal_id','no_soal','soal_nm','soal_img','kunci','status_cd','group_id','materi'];

    public function hapusgambarpembsoal($soal_id) {
        return $this->db->table('soal')
                        ->set('pembahasan_img', NULL)
                        ->where('soal_id',$soal_id)
                        ->update();
    }
    
    public function getSoalIdByClue($clue,$group_id,$sk_group_id,$kolom_id) {
        return $this->db->table('soal')
                        ->select('soal_id')
                        ->where('clue',$clue)
                        ->where('group_id',$group_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('kolom_id',$kolom_id)
                        ->orderby('soal_id', 'ASC')
                        ->get();
    }

    public function getSoalIdByClueSKGambar($clue,$group_id,$sk_group_id,$kolom_id, $materi) {
        return $this->db->table('soal')
                        ->select('soal_id')
                        ->where('clue',$clue)
                        ->where('group_id',$group_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('kolom_id',$kolom_id)
                        ->where('materi',$materi)
                        ->orderby('soal_id', 'ASC')
                        ->get();
    }

    public function checkNoSoalExist($soal_id, $no_soal, $group_id, $materi_id) {
        return $this->db->table('soal')
                        ->select('no_soal')
                        ->where('group_id',$group_id)
                        ->where('materi',$materi_id)
                        ->where('no_soal',$no_soal)
                        ->where('soal_id !=', $soal_id)
                        ->where('status_cd','normal')
                        ->get();
    }
    public function getNoSoal($materi_id, $group_id) {
        return $this->db->table('soal')
                        ->select('max(no_soal) as no_soal')
                        ->where('group_id',$group_id)
                        ->where('materi',$materi_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getAllJMateri() {
        return $this->db->table('materi')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->get();
    }
    
    public function getjawAllJMateri() {
        return $this->db->table('materi')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->whereNotIn('materi_nm',["Sikap Kerja","Latihan"])
                        ->get();
    }

    public function getMateriSK() {
        return $this->db->table('materi')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->whereIn('materi_nm',["Sikap Kerja"])
                        ->get();
    }

    public function getMateriById($materi_id) {
        return $this->db->table('materi')
                        ->select('*')
                        ->where('materi_id',$materi_id)
                        ->get();
    }

    public function getKolomSoal() {
        return $this->db->table('kolom_soal')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getKolomById($kolom_id) {
        return $this->db->table('kolom_soal')
                        ->select('*')
                        ->where('kolom_id', $kolom_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getKolomSoalAdmin() {
        return $this->db->table('kolom_soal')
                        ->select('kolom_id AS soal_id, kolom_nm AS soal_nm, NULL AS no_soal, NULL AS kunci')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getGroup() {
        return $this->db->table('group_soal')
                        ->select('group_soal_id,group_nm')
                        ->get();
    }

    public function getGroupLatihan() {
        return $this->db->table('group_soal')
                        ->select('group_soal_id,group_nm')
                        ->whereNotIn('group_soal_id', [4])
                        ->get();
    }

    public function getGroupByid($group_id) {
        return $this->db->table('group_soal')
                        ->select('*')
                        ->where('group_soal_id',$group_id)
                        ->get();
    }

    public function getAllSoal() {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->join('materi c','c.materi_id=a.materi')
                        ->where('a.status_cd','normal')
                        ->orderby('a.group_id','ASC')
                        ->get();
    }

    public function getMaxNoSoal($group_id,$materi) {
        return $this->db->table('soal')
                        ->select('MAX(no_soal) as max_nosoal')
                        ->where('status_cd','normal')
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->get();
    }


public function getAllSoalSK() {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->whereIn('a.status_cd',['normal','disable'])
                        ->where('a.group_id',4)
                        ->where('a.materi',5)
                        ->orderby('a.kolom_id','ASC')
                        ->get();
    }
    public function getSoalBygrmt($group_id,$materi) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.group_id',$group_id)
                        ->where('a.materi',$materi)
                        ->get();
    }

    public function getSoalSKBySkGroupId($sk_group_id) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.sk_group_id',$sk_group_id)
                        ->get();
    }

    public function getTotalSoal($group_id,$materi) {
        return $this->db->table('soal')
                        ->select('*')
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->orderby('no_soal','asc')
                        ->get();
    }

    public function getSoal($no_soal,$group_id,$materi,$kolom_id) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id','left')
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.no_soal',$no_soal)
                        ->where('a.group_id',$group_id)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getSoalSK($no_soal,$group_id,$materi,$kolom_id,$sk_group_id) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id','left')
                        ->where('a.no_soal',$no_soal)
                        ->where('a.group_id',$group_id)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.sk_group_id',$sk_group_id)
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getSoalByNoSoalGrpMtri($no_soal, $group_id, $materi_id) {
        return $this->db->table('soal')
                        ->select('*')
                        ->where('no_soal',$no_soal)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getSoalByIdSK($kolom_id, $group_id, $materi_id, $sk_group_id) {
        return $this->db->table('soal')
                        ->select('*')
                        ->where('kolom_id',$kolom_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getSoalByid($soal_id) {
        return $this->db->table('soal')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->get();
    }

    public function getSoalBymateri($materi) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.materi',$materi)
                        ->get();
    }

    public function resSoalKec($group_id,$materi) {
        return $this->db->table('soal a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.materi',$materi)
                        ->where('a.group_id',$group_id)
                        ->get();
    }

    public function getjawaban($soal_id) {
        return $this->db->table('jawaban')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getJawabanBysoalId($soal_id) {
        return $this->db->table('jawaban')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponexcel($soal_id,$jawaban_id,$user_id,$materi) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',2)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponexcelx($soal_id,$jawaban_id,$user_id,$materi) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',3)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByPrev($soal_id,$group_id,$materi,$user_id) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByPrevSK($soal_id,$group_id,$materi,$user_id,$session,$kolom_id) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('kolom_id',$kolom_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('session',$session)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponLatihan($user_id) {
        return $this->db->table('respon a')
                        ->select('*,a.pilihan_nm as pilihan_respon,a.kolom_id as kolom_respon,a.soal_id as soal_id_respon,b.soal_id as soal_id_jwb,a.created_dttm as used_dttm')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('b.status_cd','normal')
                        ->where('a.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',5)
                        ->where('a.group_id',4)
                        ->groupby('a.used')
                        ->get();
    }

    public function getMaxUsed($user_id) {
        return $this->db->table('respon')
                        ->select('MAX(used) as maxused')
                        ->where('created_user_id',$user_id)
                        ->where('materi',5)
                        ->where('group_id',4)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponSK($user_id,$session,$kolom_id,$materi,$used,$sk_group_id) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.used',$used)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('c.sk_group_id',$sk_group_id)
                        ->where('a.group_id',4)
                        ->get();
        } else {
            return $this->db->table('respon a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('a.used',$used)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.group_id',4)
                        ->get();
        }
    }

    public function getResponSKLatihan($user_id, $used, $kolom_id, $materi) {
        return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban b', 'b.jawaban_id = a.jawaban_id', 'left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id', $user_id)
                        ->where('a.used', $used)
                        ->where('a.materi', $materi)
                        ->where('a.kolom_id', $kolom_id)
                        ->where('a.group_id', 4)
                        ->get();
    }

    public function getResponSikapKerja($user_id,$session,$kolom_id,$materi) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*,a.pilihan_nm as pilihan_respon,a.kolom_id as kolom_respon,a.soal_id as soal_id_respon,b.soal_id as soal_id_jwb')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.group_id',4)
                        ->get();
        } else {
            return $this->db->table('respon a')
                        ->select('*,a.pilihan_nm as pilihan_respon,a.kolom_id as kolom_respon,a.soal_id as soal_id_respon,b.soal_id as soal_id_jwb')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.group_id',4)
                        ->get();
        }
    }

    public function getResponByJawabanId($jawaban_id,$group_id,$materi,$user_id,$session) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('jawaban_id',$jawaban_id)
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        ->where('session',$session)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponBox($soal_id,$group_id,$materi,$user_id) {
        return $this->db->table('respon')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->where('materi',$materi)
                        ->get();
    }

    public function getResponCountByMateriUser($group_id,$materi,$user_id) {
        return $this->db->table('respon')
                        ->select('count(respon_id) as jumlah_jawab')
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        // ->where('session',$session)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByMateriId($user_id,$sk_group_id) {
        return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('soal b','b.soal_id=a.soal_id','left')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.materi',98)
                        ->where('a.group_id',4)
                        ->where('b.sk_group_id',$sk_group_id)
                        ->where('a.status_cd','normal')
                        ->orderBy('a.used','DESC')
                        ->limit(1)
                        ->get();
    }


    public function getPasshandSkor($user_id,$session,$materi) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('b.status_cd','normal')
                        ->where('a.status_cd','normal')
                        ->where('a.group_id',1)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->get();
        } else {
            return $this->db->table('respon a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',1)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        }
    }

    public function getKecerdasanSkor($user_id,$session,$materi) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get(); 
        } else {
            return $this->db->table('respon a')
                        ->select('*')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        }
        
        
    }

    public function getKepribadianSkor($user_id,$session,$materi) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',3)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        } else {
            return $this->db->table('respon a')
                        ->select('*')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',3)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        }
        
        
    }

    public function getSikapKerjaSkor($user_id,$session,$materi) {
        if ($session == "") {
            return $this->db->table('respon a')
                        ->select('*')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',4)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        } else {
            return $this->db->table('respon a')
                        ->select('*')
                        ->join('jawaban b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',4)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        }
        
    }

    public function getMaxSessionUser($user_id) {
        return $this->db->table('session_soal')
                        ->select('MAX(session_soal_nm) as session')
                        ->where('user_id',$user_id)
                        ->get();
    }

    public function simpanRespon($data) {
        $this->db->table('respon')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpanResponSK($data) {
        $this->db->table('respon')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpansoal($data) {
        $this->db->table('soal')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpanjawaban($data) {
        $this->db->table('jawaban')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function updateResponPrev($soal_id,$jawaban_id,$group_id,$materi,$user_id,$data) {
        return $this->db->table('respon')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        // ->where('session',$session)
                        ->update();
    }

    public function updatejawaban($jawaban_id,$data) {
        return $this->db->table('jawaban')
                        ->set($data)
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function updatejawabansk($jawaban_nm,$data,$soal_id,$jawaban_nm_lama) {
        return $this->db->table('jawaban')
                        ->set($data)
                        ->where('jawaban_nm',$jawaban_nm_lama)
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    public function updatesoal($soal_id,$data) {
        return $this->db->table('soal')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    public function updatesoalsk($group_id,$sk_group_id,$kolom,$data,$soal_id,$jawaban_nm_lama) {
        return $this->db->table('soal')
                        ->set($data)
                        ->where('group_id',$group_id)
                        ->where('sk_group_id',$sk_group_id)
                        ->where('kolom_id',$kolom)
                        ->where('soal_id',$soal_id)
                        ->where('clue',$jawaban_nm_lama)
                        ->update();
    }

    public function updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status) {
        $db = db_connect();
        return $db->query("UPDATE jawaban a JOIN soal b ON b.soal_id = a.soal_id SET a.status_cd = '$status_cd' WHERE a.jawaban_nm = '$jawaban_nm' AND b.kolom_id = $kolom_id");
    }

    public function hapussoal($soal_id,$data) {
        return $this->db->table('soal')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    

    public function deletejawaban($jawaban_id) {
        return $this->db->table('jawaban')
                        ->set('status_cd','nullified')
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function insertsoalSKlatihan($data) {
        $this->db->table('soal')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function insertjawabanSKlatihan($datax) {
        $this->db->table('jawaban')
                 ->insert($datax);
    }

    public function insertsessionskor($data) {
        return $this->db->table('session_soal')
                        ->insert($data);
    }

    public function getSessionSkor($user_id) {
        return $this->db->table('session_soal')
                        ->select('*')
                        ->where('session_soal_nm','materi4')
                        ->where('user_id',$user_id)
                        ->get();
    }

    public function getSKgroupAll() {
        return $this->db->table('sk_group')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getSKgroup() {
        return $this->db->table('sk_group')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->orderby('sk_group_id','DESC')
                        ->limit(1)
                        ->get();
    }

    public function insertSKgroup($data) {
        $this->db->table('sk_group')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function cekRespon($group_id,$materi,$user_id,$session) {
        return $this->db->table('respon a')
                        ->select('count(a.respon_id) as jml_respon')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getSoalAll() {
        return $this->db->table('soal a')
                        ->select('*')
                        ->where('a.status_cd','normal')
                        // ->where('a.soal_id >=',6001)
                        // ->where('a.soal_id <=',7000)
                        ->get();
    }

    public function selectRemainingTime($user_id,$materi_id,$type) {
        return $this->db->table('times_remaining')
                        ->select('*')
                        ->where('user_id',$user_id)
                        ->where('materi_id',$materi_id)
                        ->where('type',$type)
                        ->get();
    }

    public function insertRemainingTime($data) {
        $this->db->table('times_remaining')
                 ->insert($data);
    }

    public function updateRemainingTime($user_id,$materi_id,$data,$type) {
        return $this->db->table('times_remaining')
                        ->set($data)
                        ->where('user_id',$user_id)
                        ->where('materi_id',$materi_id)
                        ->where('type',$type)
                        ->update();
    }

    public function resetbygroup($materi_id,$group_id,$data,$user_id) {
        return $this->db->table('respon')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('group_id',$group_id)
                        ->where('status_cd','normal')
                        ->where('created_user_id',$user_id)
                        ->update();
    }

    public function resetsemua($materi_id,$data,$user_id) {
        return $this->db->table('respon')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('status_cd','normal')
                        ->where('created_user_id',$user_id)
                        ->update();
    }

    public function updateFinishRespon($materi_id,$group_id,$user_id,$data) {
        return $this->db->table('respon')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->update();
    }

    public function getRespon($group_id,$materi,$user_id) {
        return $this->db->table('respon a')
                        ->select("c.group_soal_id, c.group_nm,
                                    COUNT(*) as total_soal,
                                    SUM(CASE WHEN b.kunci = a.pilihan_nm THEN 1 ELSE 0 END) as total_benar,
                                    SUM(CASE WHEN b.kunci != a.pilihan_nm THEN 1 ELSE 0 END) as total_salah")
                        ->join('soal b','b.soal_id=a.soal_id')
                        ->join('group_soal c','c.group_soal_id=a.group_id')
                        ->where('a.materi',$materi)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.status_cd', 'finish')
                        ->whereNotIn('a.group_id', [10])
                        ->groupBy('a.group_id')
                        ->get();
    }

    public function getKolomSoalPauli() {
        return $this->db->table('soal a')
                        ->select('a.kolom_id')
                        // ->join('kolom_soal b','b.kolom_id = a.kolom_id')
                        ->where('a.status_cd','normal')
                        ->where('a.group_id', 9)
                        // ->orderBy('a.soal_id', 'ASC')
                        ->groupBy('a.kolom_id')
                        ->get();
    }

    public function getSoalPauliFast($no_soal, $group_id, $materi, $kolom_id, $sk_group_id)
    {
        return $this->db->table('soal')
            ->select('soal_id, soal_nm')
            ->where([
                'no_soal'     => $no_soal,
                'group_id'    => $group_id,
                'materi'      => $materi,
                'kolom_id'    => $kolom_id,
                'sk_group_id' => $sk_group_id,
                'status_cd'   => 'normal'
            ])
            ->limit(1)
            ->get()
            ->getRow();
    }

    public function getjawabanPauli($soal_id) {
        return $this->db->table('jawaban')
                        ->select('*')
                        ->where('soal_id', $soal_id)
                        ->where('status_cd','normal')
                        ->orderBy('(jawaban_nm = 0), jawaban_nm', '', false)
                        ->get();
    }

    public function getResponPauli($soal_id,$group_id,$materi,$user_id,$sk_group_id) {
        return $this->db->table('respon a')
                        ->select('*')
                        ->join('soal b','b.soal_id=a.soal_id')
                        ->where('a.soal_id',$soal_id)
                        ->where('a.group_id',$group_id)
                        ->where('a.materi',$materi)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.status_cd', 'normal')
                        ->where('b.sk_group_id',$sk_group_id)
                        ->get();
    }

    public function updateResponPauli($soal_id,$group_id,$materi,$user_id,$sk_group_id,$data) {
        return $this->db->table('respon')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->update();
    }

    public function getHasilPauliByUserUsed($user_id, $sk_group_id, $materi_id, $used)
    {
        $responSub = $this->db->table('respon')
            ->select('respon_id, soal_id, pilihan_nm')
            ->where('created_user_id', $user_id)
            ->where('used', $used)
            // ->where('materi', $materi_id)
            ->where('status_cd', 'finish')
            ->getCompiledSelect();

        return $this->db->table('kolom_pauli k')
            ->select([
                'k.kolom_id', 'k.kolom_nm',

                'COUNT(c.soal_id) AS total_soal',

                'COALESCE(SUM(CASE 
                    WHEN r.pilihan_nm IS NOT NULL AND r.pilihan_nm <> "" 
                    THEN 1 ELSE 0 
                END),0) AS terjawab',

                'COALESCE(SUM(CASE 
                    WHEN r.pilihan_nm IS NULL OR r.pilihan_nm = "" 
                    THEN 1 ELSE 0 
                END),0) AS tidak_terjawab',

                'COALESCE(SUM(CASE 
                    WHEN r.pilihan_nm IS NOT NULL 
                    AND r.pilihan_nm <> "" 
                    AND r.pilihan_nm <> c.kunci 
                    THEN 1 ELSE 0 
                END),0) AS salah'
            ])
            ->join(
                'soal c',
                'c.kolom_id = k.kolom_id
                AND c.group_id = 10
                AND c.status_cd = "normal"
                AND c.materi = '.$this->db->escape($materi_id).'
                AND c.sk_group_id = '.$this->db->escape($sk_group_id),
                'left'
            )
            ->join(
                "($responSub) r",
                'r.soal_id = c.soal_id',
                'left'
            )
            ->groupBy('k.kolom_id')
            ->orderBy('k.kolom_id', 'ASC')
            ->get();
    }

    public function getLastUsedPauli($user_id, $group_id, $materi) {
        return $this->db->table('respon')
            ->selectMax('used')
            ->where('created_user_id', $user_id)
            ->where('group_id', $group_id)
            ->where('materi', $materi)
            ->get();
    }
}