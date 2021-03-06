<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Main_Model extends CI_Model {

		public function __construct() {
			parent::__construct();
		}

		public function peserta_form() {
			$data['ftxt_nama']=array('name'=>'txt_nama','size'=>25,'required'=>true,'class'=>"form-control");
        	$data['ftxt_univ']=array('name'=>'txt_univ','size'=>25,'required'=>true,'class'=>"form-control");
        	$data['ftxt_jur']=array('name'=>'txt_jur','size'=>25,'required'=>true,'class'=>"form-control");
       		$data['ftxt_email']=array('name'=>'txt_email','size'=>25,'class'=>"form-control");
        	$data['ftxt_telp']=array('name'=>'txt_telp','size'=>25,'required'=>true,'class'=>"form-control");

        	return $data;
		}

		public function find_berita() {
			$this->db->select()
					 ->from("master_berita")
					 ->order_by("tanggal",'desc')
					 ->limit(5,0);
			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				return $result->result();
			}
			return NULL;
		}

		public function find_latar_belakang() {
			$this->db->select("latar_belakang as latar_belakang")
					->from("master_tampilan_utama");
			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				return $result->result();
			}
			return NULL;
		}

		public function find_susunan_acara() {
			$this->db->select("susunan_acara")
					->from("master_tampilan_utama");
			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				return $result->result();
			}
			return NULL;
		}

		private function _get_prefix() {
			$this->db->select("nomor")
					 ->from("master_prefix")
					 ->order_by('id','desc')
					 ->limit(1,0);
			$result = $this->db->get();
			if ($result->num_rows() > 0) {
				return $result->result();
			}
			return NULL;
		}

		public function save_peserta($data) {
			$nomor = $this->_get_prefix();
			$nmr = 1;
			$new_nomor = 1;
			if ($nomor == NULL) {
				$new_nomor = $nmr;
			} else {
				$new_nomor = $nomor['nomor'] + 1;
			}
			$result = $this->db->insert('master_prefix',array('nomor'=>$new_nomor));
			$data['no_pendaftaran']=$new_nomor;
			$result = $this->db->insert('master_peserta',$data);
			if ($result) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
?>