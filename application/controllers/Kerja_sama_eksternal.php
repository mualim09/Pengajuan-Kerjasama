<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kerja_sama_eksternal extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
		$this->load->model('m_kerja_sama_eksternal');
		$this->load->model('m_kategori_kerja_sama');
		$this->load->model('m_status_kerja_sama');
		$this->load->model('m_user');
	}


	public function view_admin()
	{

		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 1) {

		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal()->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul();
		$data['kategori_kerja_sama'] = $this->m_kategori_kerja_sama->get_kategori_kerja_sama();
		$data['status_kerja_sama'] = $this->m_status_kerja_sama->get_status_kerja_sama();
		$data['user'] = $this->m_user->get_user();
		$this->load->view('admin/view_kerja_sama_eksternal', $data);

		}else{
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}

	public function filter_admin($id_kategori_kerja_sama)
	{

		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 1) {

		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_by_kategori($id_kategori_kerja_sama)->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul_by_kategori($id_kategori_kerja_sama);
		$data['kategori_kerja_sama'] = $this->m_kategori_kerja_sama->get_kategori_kerja_sama();
		$data['status_kerja_sama'] = $this->m_status_kerja_sama->get_status_kerja_sama();
		$data['user'] = $this->m_user->get_user();
		$this->load->view('admin/view_kerja_sama_eksternal', $data);

		}else{
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}

	public function input_data_admin(){
		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 1) {

		$no_usulan = $this->input->post("no_usulan");
		$keterangan = $this->input->post("keterangan");
		$id_lembaga_mitra = $this->input->post("id_lembaga_mitra");
		$id_pengusul = $this->input->post("id_pengusul");
		$id_status_kerja_sama = $this->input->post("id_status_kerja_sama");
		$id_kategori_kerja_sama = $this->input->post("id_kategori_kerja_sama");
		$file_name = md5($no_usulan.$keterangan);
		
		$path = './assets/kerja_sama_eksternal/admin/';

		$this->load->library('upload');
		$config['upload_path'] = './assets/kerja_sama_eksternal/admin';
		$config['allowed_types'] = 'pdf|docx';
		$config['max_size'] = '1048';  //2MB max
		$config['max_width'] = '4480'; // pixel
		$config['max_height'] = '4480'; // pixel
		$config['file_name'] = $file_name;
		$this->upload->initialize($config);
		$file_kerja_sama_eksternal_upload = $this->upload->do_upload('file_kerja_sama_eksternal');

			if($file_kerja_sama_eksternal_upload){
				$file_kerja_sama_eksternal = $this->upload->data();
			}else{
				$this->session->set_flashdata('error_file','error_file');
				redirect('Kerja_sama_eksternal/view_admin');
			}
		
			$hasil = $this->m_kerja_sama_eksternal->tambah_kerja_sama_eksternal($no_usulan, $keterangan, $id_lembaga_mitra, $id_pengusul, $id_status_kerja_sama, $file_kerja_sama_eksternal['file_name'], $id_kategori_kerja_sama);
	
			if($hasil==false){
				$this->session->set_flashdata('eror','eror');
			
			}else{
				$this->session->set_flashdata('input','input');
			
			}

			redirect('Kerja_sama_eksternal/view_admin');

		}else{
				$this->session->set_flashdata('loggin_err','loggin_err');
				redirect('Login/index');
		}
		

	}

	public function edit_data_admin(){
		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 1) {
		
		$id_kerja_sama_eksternal = $this->input->post("id_kerja_sama_eksternal");
		$no_usulan = $this->input->post("no_usulan");
		$keterangan = $this->input->post("keterangan");
		$id_lembaga_mitra = $this->input->post("id_lembaga_mitra");
		$id_pengusul = $this->input->post("id_pengusul");
		$id_status_kerja_sama = $this->input->post("id_status_kerja_sama");
		$id_kategori_kerja_sama = $this->input->post("id_kategori_kerja_sama");
		$file = $this->input->post('file_kerja_sama_eksternal_old');
		$file_name = md5($no_usulan.$keterangan);
		
		// echo $id_kerja_sama_eksternal;
		// echo "<br>";
		// echo $no_usulan;
		// echo "<br>";
		// echo $keterangan;
		// echo "<br>";
		// echo $id_lembaga_mitra;
		// echo "<br>";
		// echo $id_pengusul;
		// echo "<br>";
		// echo $id_status_kerja_sama;
		// echo "<br>";
		// echo $file_name;
		// echo "<br>";
		// echo $file;
		// die();
		$path = './assets/kerja_sama_eksternal/admin/';



		$this->load->library('upload');
		$config['upload_path'] = './assets/kerja_sama_eksternal/admin';
		$config['allowed_types'] = 'pdf|docx';
		$config['max_size'] = '4048';  //2MB max
		$config['max_width'] = '4480'; // pixel
		$config['max_height'] = '4480'; // pixel
		$config['file_name'] = $file_name;
		$this->upload->initialize($config);
		$file_kerja_sama_eksternal_upload = $this->upload->do_upload('file_kerja_sama_eksternal');

			if($file_kerja_sama_eksternal_upload){
				$file_kerja_sama_eksternal = $this->upload->data();
			}else{
				$this->session->set_flashdata('error_file','error_file');
				redirect('Kerja_sama_eksternal/view_admin');
			}
		
			$hasil = $this->m_kerja_sama_eksternal->update_kerja_sama_eksternal($id_kerja_sama_eksternal, $no_usulan, $keterangan, $id_lembaga_mitra, $id_pengusul, $id_status_kerja_sama, $file_kerja_sama_eksternal['file_name'], $id_kategori_kerja_sama);
	
			if($hasil==false){
				$this->session->set_flashdata('eror_edit','eror_edit');
			
			}else{
				$this->session->set_flashdata('edit','edit');
			}
			@unlink($path.$this->input->post('file_kerja_sama_eksternal_old'));

			redirect('Kerja_sama_eksternal/view_admin');

		}else{
				$this->session->set_flashdata('loggin_err','loggin_err');
				redirect('Login/index');
		}
		

	}
	public function hapus_kerja_sama_eksternal($id_kerja_sama_eksternal)
	{
	if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 1) {
		// $file = $this->input->post('file_kerja_sama_eksternal_old');
		// echo $file;
		// die();
		$this->m_kerja_sama_eksternal->hapus_kerja_sama_eksternal($id_kerja_sama_eksternal);
		$hasil = $this->m_kerja_sama_eksternal->hapus_kerja_sama_eksternal($id_kerja_sama_eksternal);
		if($hasil==false){
			$this->session->set_flashdata('eror_hapus','eror_hapus');
		}else{
			$this->session->set_flashdata('hapus','hapus');
		}
		$path = './assets/kerja_sama_eksternal/admin/';
		@unlink($path.$this->input->post('file_kerja_sama_eksternal_old'));
		redirect('Kerja_sama_eksternal/view_admin');
		}else{
			
			redirect('welcome');
		}
	}

	public function view_mitra()
	{
		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 2) {

		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal()->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul();
		
		$this->load->view('mitra/view_kerja_sama_eksternal', $data);

		}else{
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}

	public function filter_mitra($id_kategori_kerja_sama)
	{

		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_user_level') == 2) {

		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_by_kategori($id_kategori_kerja_sama)->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul_by_kategori($id_kategori_kerja_sama);
		$data['kategori_kerja_sama'] = $this->m_kategori_kerja_sama->get_kategori_kerja_sama();
		$data['status_kerja_sama'] = $this->m_status_kerja_sama->get_status_kerja_sama();
		$data['user'] = $this->m_user->get_user();
		$this->load->view('mitra/view_kerja_sama_eksternal', $data);

		}else{
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}

	public function view_anggota()
	{
		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal()->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul();

		$this->load->view('anggota/view_kerja_sama_eksternal', $data);
	}

	public function filter_anggota($id_kategori_kerja_sama)
	{
		$data['kerja_sama_eksternal'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_by_kategori($id_kategori_kerja_sama)->result_array();
		$data['kerja_sama_eksternal_pengusul'] = $this->m_kerja_sama_eksternal->get_kerja_sama_eksternal_pengusul_by_kategori($id_kategori_kerja_sama);

		$this->load->view('anggota/view_kerja_sama_eksternal', $data);
	}

}