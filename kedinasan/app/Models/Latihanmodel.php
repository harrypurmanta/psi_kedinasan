<?php namespace App\Models;

use CodeIgniter\Model;

class Latihanmodel extends Model
{
    protected $table      = 'soal_latihan';
    protected $primaryKey = 'soal_id';
    protected $allowedFields = ['soal_id','no_soal','soal_nm','soal_img','kunci','status_cd','group_id','materi'];

    public function hapusgambarsoal($soal_id) {
        return $this->db->table('soal_latihan')
                        ->set('soal_img', NULL)
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    public function hapusgambar($jawaban_id) {
        return $this->db->table('jawaban_latihan')
                        ->set('jawaban_img', NULL)
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function simpansoallatihan($data) {
        $this->db->table('soal_latihan')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpanjawaban($data) {
        return $this->db->table('jawaban_latihan')
                 ->insert($data);
    }
    public function getNoSoal($jenis_id, $group_id) {
        return $this->db->table('soal_latihan')
                        ->select('max(no_soal) as no_soal')
                        ->where('jenis_id',$jenis_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getJenisSoal() {
        return $this->db->table('jenis_soal')
                        ->select('*')
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

    public function getJenis() {
        return $this->db->table('jenis_soal')
                        ->select('jenis_id,jenis_nm,group_id')
                        ->get();
    }

    public function getJenisByGroupId($group_id) {
        return $this->db->table('jenis_soal')
                        ->select('jenis_id,jenis_nm,group_id')
                        ->where('group_id', $group_id)
                        ->get();
    }

    public function getJenisById($jenis_id) {
        return $this->db->table('jenis_soal')
                        ->select('jenis_nm')
                        ->where('jenis_id', $jenis_id)
                        ->get()
                        ->getRow();
    }

    public function getLastUsed($user_id, $jenis_id, $group_id, $materi) {
        return $this->db->table('user_exam_latihan')
                        ->select('used')
                        ->where('user_id', $user_id)                        
                        ->where('jenis_id', $jenis_id)
                        ->where('group_id', $group_id)
                        ->where('materi_id', $materi)
                        ->orderBy('user_exam', 'DESC')
                        ->limit(1)
                        ->get()
                        ->getRow();
    }

    public function insertexam($data) {
        return $this->db->table('user_exam_latihan')
                        ->insert($data);
    }

    public function getGroup() {
        return $this->db->table('group_soal')
                        ->select('group_soal_id,group_nm')
                        ->get();
    }

    public function getGroupByid($group_id) {
        return $this->db->table('group_soal')
                        ->select('*')
                        ->where('group_soal_id',$group_id)
                        ->get();
    }
    
    public function getGroupLatihan() {
        return $this->db->table('group_soal')
                        ->select('group_soal_id,group_nm')
                        ->whereNotIn('group_soal_id', [4])
                        ->get();
    }

    public function getAllSoal() {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->join('materi c','c.materi_id=a.materi')
                        ->where('a.status_cd','normal')
                        ->orderby('a.group_id','ASC')
                        ->get();
    }

    public function getMaxNoSoal($group_id,$materi) {
        return $this->db->table('soal_latihan')
                        ->select('MAX(no_soal) as max_nosoal')
                        ->where('status_cd','normal')
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->get();
    }


public function getAllSoalSK() {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->whereIn('a.status_cd',['normal','disable'])
                        ->where('a.group_id',4)
                        ->where('a.materi',5)
                        ->orderby('a.kolom_id','ASC')
                        ->get();
    }
    public function getSoalBygrJns($group_id, $jenis_id) {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('jenis_soal b', 'b.jenis_id = a.jenis_id')
                        ->where('a.status_cd', 'normal')
                        ->where('a.jenis_id', $jenis_id)
                        ->get();
    }

    public function getTotalSoal($jenis_id,$materi) {
        return $this->db->table('soal_latihan')
                        ->select('*')
                        ->where('jenis_id',$jenis_id)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->orderby('no_soal','asc')
                        ->get();
    }

    public function getTotalSoalLatihan($jenis_id, $group_id) {
        return $this->db->table('soal_latihan')
                        ->select('*')
                        ->where('jenis_id',$jenis_id)
                        ->where('group_id',$group_id)
                        ->where('status_cd','normal')
                        ->orderby('no_soal','asc')
                        ->get();
    }

    public function updateFinishRespon($materi_id,$jenis_id,$user_id,$used,$data) {
        return $this->db->table('respon_latihan')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('jenis_id',$jenis_id)
                        ->where('created_user_id',$user_id)
                        ->where('used',$used)
                        ->where('status_cd','normal')
                        ->update();
    }

    public function getSoal($no_soal, $jenis_id, $materi, $group_id) {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('jenis_soal b','b.jenis_id=a.jenis_id','left')
                        ->where('a.group_id',$group_id)
                        ->where('a.no_soal',$no_soal)
                        ->where('a.jenis_id',$jenis_id)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getSoalSK($no_soal,$group_id,$materi,$kolom_id,$sk_group_id) {
        return $this->db->table('soal_latihan a')
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

    public function getSoalByid($soal_id) {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('jenis_soal b', 'b.jenis_id = a.jenis_id')
                        ->join('group_soal c', 'c.group_soal_id = b.group_id')
                        ->where('a.soal_id',$soal_id)
                        ->get();
    }

    public function getSoalBymateri($materi) {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.materi',$materi)
                        ->get();
    }

    public function resSoalKec($group_id,$materi) {
        return $this->db->table('soal_latihan a')
                        ->select('*')
                        ->join('group_soal b','b.group_soal_id=a.group_id')
                        ->where('a.status_cd','normal')
                        ->where('a.materi',$materi)
                        ->where('a.group_id',$group_id)
                        ->get();
    }

    public function getjawaban($soal_id) {
        return $this->db->table('jawaban_latihan')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getJawabanById($jawaban_id) {
        return $this->db->table('jawaban_latihan a')
                        ->select('*')
                        ->join('soal_latihan b', 'b.soal_id = a.soal_id')
                        ->where('a.jawaban_id', $jawaban_id)
                        ->where('a.status_cd', 'normal')
                        ->get();
    }

    public function getJawabanBysoalId($soal_id) {
        return $this->db->table('jawaban_latihan a')
                        ->select('*')
                        ->join('soal_latihan b', 'b.soal_id = a.soal_id')
                        ->where('a.soal_id', $soal_id)
                        ->where('a.status_cd', 'normal')
                        ->orderBy('a.pilihan_nm')
                        ->get();
    }

    public function getResponexcel($soal_id,$jawaban_id,$user_id,$materi) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',2)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponexcelx($soal_id,$jawaban_id,$user_id,$materi) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('group_id',3)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByPrev($soal_id,$jenis_id,$materi,$user_id,$used) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('jenis_id',$jenis_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('used',$used)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByPrevSK($soal_id,$group_id,$materi,$user_id,$session,$kolom_id) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('kolom_id',$kolom_id)
                        ->where('group_id',$group_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('session',$session)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByUser($user_id, $jenis_id, $group_id, $materi, $used) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('jenis_id',$jenis_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('group_id',$group_id)
                        ->where('used',$used)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponLatihan($jenis_id, $user_id, $used, $group_id) {
        return $this->db->table('respon_latihan a')
                        ->select('c.kunci, a.pilihan_nm as pilihan_respon, a.kolom_id as kolom_respon,a.soal_id as soal_id_respon, c.soal_id as soal_id_jwb, a.created_dttm as used_dttm')
                        // ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=a.soal_id','left')
                        // ->where('b.status_cd','normal')
                        ->where('a.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.used',$used)
                        ->where('a.materi',99)
                        ->where('a.jenis_id',$jenis_id)
                        ->where('a.group_id',$group_id)
                        ->get();
    }

    public function getMaxUsed($user_id) {
        return $this->db->table('respon_latihan')
                        ->select('MAX(used) as maxused')
                        ->where('created_user_id',$user_id)
                        ->where('materi',5)
                        ->where('group_id',4)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponSK($user_id,$session,$kolom_id,$materi,$used,$sk_group_id) {
        if ($session == "") {
            return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
            return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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

    public function getResponSKLatihan($user_id,$used,$kolom_id,$materi) {
        return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        ->where('a.used',$used)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.group_id',4)
                        ->get();
    }

    public function getResponSikapKerja($user_id,$session,$kolom_id,$materi) {
        if ($session == "") {
            return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon,a.kolom_id as kolom_respon,a.soal_id as soal_id_respon,b.soal_id as soal_id_jwb')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('a.status_cd','normal')
                        ->where('b.status_cd','normal')
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.kolom_id',$kolom_id)
                        ->where('a.group_id',4)
                        ->get();
        } else {
            return $this->db->table('respon_latihan a')
                        ->select('*,a.pilihan_nm as pilihan_respon,a.kolom_id as kolom_respon,a.soal_id as soal_id_respon,b.soal_id as soal_id_jwb')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('jawaban_id',$jawaban_id)
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        ->where('session',$session)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponBox($soal_id,$jenis_id,$materi,$user_id,$used, $group_id) {
        return $this->db->table('respon_latihan')
                        ->select('*')
                        ->where('soal_id',$soal_id)
                        ->where('jenis_id',$jenis_id)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->where('materi',$materi)
                        ->where('group_id',$group_id)
                        ->where('used',$used)
                        ->get();
    }

    public function getResponBoxPembahasan($soal_id,$jenis_id,$materi,$user_id,$used) {
        return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('soal_latihan b','b.soal_id = a.soal_id')
                        ->where('a.soal_id',$soal_id)
                        ->where('a.jenis_id',$jenis_id)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.status_cd','normal')
                        ->where('a.materi',$materi)
                        ->where('a.used',$used)
                        ->get();
    }

    public function getJawabannmPembahasan($key, $soal_id) {
        return $this->db->table('jawaban_latihan')
                        ->select('*')
                        ->where('pilihan_nm',$key)
                        ->where('soal_id',$soal_id)
                        ->get();
    }

    public function getResponCountByMateriUser($jenis_id, $materi, $user_id, $used) {
        return $this->db->table('respon_latihan')
                        ->select('count(respon_id) as jumlah_jawab')
                        ->where('jenis_id',$jenis_id)
                        ->where('created_user_id',$user_id)
                        ->where('used',$used)
                        ->where('materi',$materi)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponCountByLatihan($jenis_id, $group_id, $user_id, $used) {
        return $this->db->table('respon_latihan')
                        ->select('count(respon_id) as jumlah_jawab')
                        ->where('jenis_id',$jenis_id)
                        ->where('created_user_id',$user_id)
                        ->where('used',$used)
                        ->where('group_id',$group_id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getResponByMateriId($user_id,$sk_group_id) {
        return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('soal_latihan b','b.soal_id=a.soal_id','left')
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
            return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('b.status_cd','normal')
                        ->where('a.status_cd','normal')
                        ->where('a.group_id',1)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->get();
        } else {
            return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
            return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get(); 
        } else {
            return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
            return $this->db->table('respon_latihan a')
                        ->select('*, a.pilihan_nm as pilihan_respon, a.no_soal as no_soal_respon,c.kunci as kunci_soal,b.jawaban_nm as jawaban_nmx')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',3)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        } else {
            return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
            return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
                        ->where('a.group_id',4)
                        ->where('a.created_user_id',$user_id)
                        // ->where('a.session',$session)
                        ->where('c.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
        } else {
            return $this->db->table('respon_latihan a')
                        ->select('*')
                        ->join('jawaban_latihan b','b.jawaban_id=a.jawaban_id','left')
                        ->join('soal_latihan c','c.soal_id=b.soal_id','left')
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
        $this->db->table('respon_latihan')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpanResponSK($data) {
        $this->db->table('respon_latihan')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function simpansoal($data) {
        $this->db->table('soal_latihan')
                 ->insert($data);
        return $this->db->insertID();
    }

    // public function simpanjawaban($data) {
    //     $this->db->table('jawaban_latihan')
    //              ->insert($data);
    //     return $this->db->insertID();
    // }

    public function updateResponPrev($soal_id,$jawaban_id,$jenis_id,$materi,$user_id,$used,$data) {
        return $this->db->table('respon_latihan')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->where('jenis_id',$jenis_id)
                        ->where('materi',$materi)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->where('used',$used)
                        ->update();
    }

    public function updatejawaban($jawaban_id,$data) {
        return $this->db->table('jawaban_latihan')
                        ->set($data)
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function updatesoal($soal_id,$data) {
        return $this->db->table('soal_latihan')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    public function updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status) {
        $db = db_connect();
        return $db->query("UPDATE jawaban_latihan a JOIN soal_latihan b ON b.soal_id = a.soal_id SET a.status_cd = '$status_cd' WHERE a.jawaban_nm = '$jawaban_nm' AND b.kolom_id = $kolom_id");
    }

    public function hapussoal($soal_id,$data) {
        $this->hapusJawabanBySoalId($soal_id, $data);

        return $this->db->table('soal_latihan')
                        ->set($data)
                        ->where('soal_id',$soal_id)
                        ->update();
        
    }

    public function hapusJawabanBySoalId($soal_id, $data) {
        return $this->db->table('jawaban_latihan')
                        ->set('status_cd','nullified')
                        ->where('soal_id',$soal_id)
                        ->update();
    }

    public function deletejawaban($jawaban_id) {
        return $this->db->table('jawaban_latihan')
                        ->set('status_cd','nullified')
                        ->where('jawaban_id',$jawaban_id)
                        ->update();
    }

    public function insertsoalSKlatihan($data) {
        $this->db->table('soal_latihan')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function insertjawabanSKlatihan($datax) {
        $this->db->table('jawaban_latihan')
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

    public function getSKgroup() {
        return $this->db->table('sk_group')
                        ->select('*')
                        ->where('status_cd','normal')
                        ->orderby('sk_group_id','ASC')
                        // ->limit(1)
                        ->get();
    }

    public function insertSKgroup($data) {
        $this->db->table('sk_group')
                 ->insert($data);
        return $this->db->insertID();
    }

    public function cekRespon($group_id,$materi,$user_id,$session) {
        return $this->db->table('respon_latihan a')
                        ->select('count(a.respon_id) as jml_respon')
                        ->where('a.group_id',2)
                        ->where('a.created_user_id',$user_id)
                        ->where('a.session',$session)
                        ->where('a.materi',$materi)
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getSoalAll() {
        return $this->db->table('soal_latihan a')
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
        return $this->db->table('respon_latihan')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('group_id',$group_id)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->update();
    }

    public function resetsemua($materi_id,$data,$user_id) {
        return $this->db->table('respon_latihan')
                        ->set($data)
                        ->where('materi',$materi_id)
                        ->where('created_user_id',$user_id)
                        ->where('status_cd','normal')
                        ->update();
    }
}