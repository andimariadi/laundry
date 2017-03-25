<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		//$this->load->model('CURL');
		if ($this->session->userdata('status') == 'login') {
			redirect(base_url('/dash'));
		}
	}
	public function index()
	{
		$this->load->view('index');
	}
	
	public function install()
	{
		$data = array('status' => 'admin');
		if ($this->CURL->cari('user', $data)->num_rows() > 0) {
			redirect(base_url());
		} else {
			$this->load->view('install');
		}
	}

	public function aksiinstall()
	{
		$no_ktp = $this->input->post('no_ktp');
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$no_hp = $this->input->post('no_hp');
		$username = $this->input->post('username');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$status = 'admin';
		$data = array('no_ktp' => $no_ktp, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp, 'username' => $username, 'password' => $password, 'status' => $status);
		$this->CURL->tambah('user', $data);
		redirect(base_url());
	}

	public function login()
	{
		//data form
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$data = array('username' => $username);

		//pencarian user
		$tampil = $this->CURL->cari('user', $data);
		$datas = $tampil->result_array();

		if ($tampil->num_rows() > 0) {
			if (password_verify($password, trim($datas[0]['password']))) {
				if ($this->input->post('login') == 'y') {
					$session = array('username' => $data['username'], 'status' => 'login');
				} else {
					$session = array('username' => $data['username'], 'status' => 'false');
				}
				$this->session->set_userdata($session);
				redirect(base_url('/dash'));
					
			} else {
				$this->session->set_flashdata('pesan', '<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span></strong> Username or Password Incorrect!');
				redirect(base_url());
			}

		} else {
			$this->session->set_flashdata('pesan', '<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span></strong> Username or Password Incorrect!');
			redirect(base_url());
		}
	}
	
}
