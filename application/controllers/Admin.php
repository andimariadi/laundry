<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Admin extends CI_Controller {
	// Class untuk validasi semua tentang admin

	function __construct()
	{
		parent:: __construct();
		if ($this->CURL->status('status') != 'admin') {
			redirect(base_url('dash'));
		}
	}

	public function index()
	{
		$this->load->view('admin');
	}

	public function page($page='')
	{
		if ($page == 'karyawan') {
			$this->load->view($page);
		}

		elseif($page == 'tambahkaryawan') {
			$this->Valid->tambahkaryawan();
		}

		elseif($page == 'datakaryawan') {
			$table = $this->CURL->tampil('user');
			$this->Valid->datakaryawan($table);
		}

		elseif ($page == 'form-failed') {
			$this->session->set_flashdata('done', '<strong>Oh!</strong> Data tidak dapat dihapus!');
		}

		elseif ($page == 'kategori') {
			$this->load->view('kategori');
		}
		
		elseif ($page == 'datakategori') {

			if ($this->session->flashdata('done') != '') {
				echo '<div class="alert alert-success alert-dismissible" role="alert">
	  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('done') . '</div>';
			}
			$head =array('table_open' =>'<table class="table table-hover table-striped">' ,' heading_row_start' =>' <tr>');
	        $this->table->set_template($head);
	        $this->table->set_heading('Kode', 'Nama Kategori', 'Harga per Kg', 'Action');
	        
	        //tampilan cuy
	        $datas = $this->CURL->tampil('kategori');
	        foreach ($datas as $data):
	            $this->table->add_row($data['kode_kategori'], $data['nama'], $data['harga_kg'], '<a class="btn btn-xs btn-primary" id="e_kat" data-id="' . $data['kode_kategori'] . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <a class="btn btn-xs btn-danger" id="d_kat" data-id="' . $data['kode_kategori'] . '"><span class="glyphicon glyphicon-trash"></span> Hapus</a>');
	        endforeach;
	        echo $this->table->generate();
	        echo '<a href="#" id="li_t_kategori" class="btn btn-primary">Tambah Kategori</a>';
		}

		elseif ($page == 'tambahkategori') {
			$this->Form->tambah_text('kategori', array('nama', 'harga kg'));
		}

		elseif ($page == 'type') {

			$this->load->view('type');
		}

		elseif ($page == 'datatype') {

			if ($this->session->flashdata('done') != '') {
				echo '<div class="alert alert-success alert-dismissible" role="alert">
	  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('done') . '</div>';
			}
			$head =array('table_open' =>'<table class="table table-hover table-striped">' ,' heading_row_start' =>' <tr>');
	        $this->table->set_template($head);
	        $this->table->set_heading('Nama Type', 'Harga Tambahan', 'Selesai/Jam', 'Action');
	        
	        //tampilan cuy
	        $datas = $this->CURL->tampil('type');
	        foreach ($datas as $data):
	            $this->table->add_row($data['type'], rupiah($data['harga']), $data['jam'] . ' Jam', '<a class="btn btn-xs btn-primary" id="e_type" data-id="' . $data['no_type'] . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <a class="btn btn-xs btn-danger" id="d_type" data-id="' . $data['no_type'] . '"><span class="glyphicon glyphicon-trash"></span> Hapus</a>');
	        endforeach;
	        echo $this->table->generate();
	        echo '<a href="#" id="li_t_type" class="btn btn-primary">Tambah Type</a>';
		}

		elseif ($page == 'tambahtype') {
			$this->Form->tambah_text('type', array('type', 'harga tambahan', 'jam'));
		}

		/* elseif ($page == 'pelanggan') {
			$array = array('status' => 'available');
			$order_by = array('order' => 'no_pelanggan', 'by' => 'desc');
			$this->Valid->tampilpelanggan($array, $order_by);
		}*/
	}

	public function edit($page, $field,$state)
	{
		if ($page == 'karyawan') {
			$this->Valid->editkaryawan('user', $field,$state);
		}

		elseif ($page == 'changepass') {
			$this->Valid->changepass($state);
		}

		elseif ($page == 'ekat') {
			$this->Form->edit_text('kategori', array('kode_kategori' => $state), array('kode kategori', 'nama', 'harga kg'));
		}

		elseif ($page == 'etype') {
			$this->Form->edit_text('type', array('no_type' => $state), array('no type', 'type', 'harga', 'jam'));
		}
	}

	public function simpan($table)
	{
		if($table == 'user') {
			//data inputan
			$no_ktp = $this->input->post('no_ktp');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$no_hp = $this->input->post('no_hp');
			$username = $this->input->post('username');
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$status = 'user';

			// validasi kosong
			if ($no_ktp == '' or $nama == '' or $alamat =='' or $no_hp=='' or $username=='' or $password =='') {
				$this->session->set_flashdata('error', '<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Data tidak boleh kosong!</strong>');
			} else {
				$cek = $this->CURL->cari('user', array('username' => $username ));
				if ($cek->num_rows() > 0) {
					$this->session->set_flashdata('error', '<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Failed:</span> Username sudah ada!</strong>');
				} else {
					if ($this->input->post('password') == $this->input->post('password_2')) {
						$this->session->set_flashdata('done', '<strong>Heads up!</strong> Data berhasil disimpan!');
						$data = array('no_ktp' => $no_ktp, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp, 'username' => $username, 'password' => $password, 'status' => $status);
					} else {
						$this->session->set_flashdata('error', '<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Kesalahan saat menyimpan!</strong>');
					}
				}
			}
		}

		elseif($table == 'kategori') {
			$nama = $this->input->post('nama');
			$harga = $this->input->post('harga_kg');
			$kode = noalpa($nama);

			if ($nama == '' or $harga == '') {
				$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Please entri data!');
			} else {
				$data = array('kode_kategori' => $kode, 'nama' => $nama, 'harga_kg' => $harga);
				$this->session->set_flashdata('done', '<strong>Data is save!</strong> This good bro!');
			}
		}

		elseif($table == 'type') {
			$nama = $this->input->post('type');
			$harga = $this->input->post('harga_tambahan');
			$jam = $this->input->post('jam');

			if ($nama == '' or $harga == '' or $jam=='') {
				$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Please entri data!');
			} else {
				$data = array('type' => $nama, 'harga' => $harga, 'jam' => $jam);
				$this->session->set_flashdata('done', '<strong>Data is save!</strong> This good bro!');
			}
		}
		$this->CURL->tambah($table, $data);
	}

	public function delete($page, $state)
	{
		if ($page == 'user') {
			$where = array('no_user' => $state);
			$cek_admin = $this->CURL->cari('user', $where)->result_array();
			if ($cek_admin[0]['status'] == 'admin') {
				$this->session->set_flashdata('done', '<strong>Oh Snap!</strong> Data admin tidak dapat dihapus!');
			} else {
				$this->CURL->hapus('user', $where);
				$this->session->set_flashdata('done', '<strong>Well Done!</strong> Data sudah dihapus!');
			}
		}

		elseif ($page == 'kategori') {
			$where = array('kode_kategori' => $state);
			$this->CURL->hapus('kategori', $where);
			$this->session->set_flashdata('done', '<strong>Well Done!</strong> Data sudah dihapus!');
		}

		elseif ($page == 'type') {
			$where = array('no_type' => $state);
			$this->CURL->hapus('type', $where);
			$this->session->set_flashdata('done', '<strong>Well Done!</strong> Data sudah dihapus!');
		}
	}

	public function edited($page)
	{
		if ($page == 'user') {
			$username = $this->input->post('username');
			$no = $this->session->userdata('no_karyawan');
			$no_ktp = $this->input->post('no_ktp');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$no_hp = $this->input->post('no_hp');

			//periksa id apakah sama dengan username
			$id = $this->CURL->cari('user', array('no_user' => $no))->result_array();

			if ($id[0]['username'] == $username) {
				$where = array('no_user' => $no);
				$data = array('username' => $username,'no_ktp' => $no_ktp, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp);
				$this->session->set_flashdata('done', '<strong>Great!</strong> Data berhasil diedit!');
			} else {
				//periksa perubahan username
				$cek = $this->CURL->cari('user', array('username' => $username ));
				if ($no_ktp == '' or $nama == '' or $alamat =='' or $no_hp=='') {
					$this->session->set_flashdata('done', '<strong>Sorry!</strong> No data entri!');
				} else {
					if ($cek->num_rows() > 0) {
					$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Username sudah ada!');
					} else {
						$where = array('no_user' => $no);
						$data = array('username' => $username,'no_ktp' => $no_ktp, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp);
						$this->session->set_flashdata('done', '<strong>Great!</strong> Data berhasil diedit!');
					}
				}
			}
			
		}
		
		elseif($page == 'pass') {
			$username = $this->input->post('username');
			$pass = $this->input->post('password');
			$pass_2 = $this->input->post('password_2');

			if ($pass == '' or $pass_2 == '') {
				$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Please entri data!');
			} else {
				if ($pass == $pass_2) {
					$where = array('username' => $username);
					$data = array('password' => password_hash($pass, PASSWORD_DEFAULT));
					$this->session->set_flashdata('done', '<strong>Great!</strong> Password changed!');
				} else {
					$this->session->set_flashdata('done', '<strong>Oh Snap!</strong> Password tidak sama!');
				}
			}
			
			$page = 'user';
		}

		elseif($page == 'kategori') {
			$kode = $this->input->post('kode_kategori');
			$nama = $this->input->post('nama');
			$harga = $this->input->post('harga_kg');

			if ($kode == '' or $nama == '' or $harga == '') {
				$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Please entri data!');
			} else {
				$where = array('kode_kategori' => $kode);
				$data = array('nama' => $nama, 'harga_kg' => $harga);
				$this->session->set_flashdata('done', '<strong>Great!</strong> Data edited!');
			}
		}

		elseif($page == 'type') {
			$kode = $this->input->post('no_type');
			$nama = $this->input->post('type');
			$harga = $this->input->post('harga');
			$jam = $this->input->post('jam');

			if ($nama == '' or $harga == '' or $jam=='') {
				$this->session->set_flashdata('done', '<strong>Hmmm!</strong> Please entri data!');
			} else {
				$where = array('no_type' => $kode);
				$data = array('type' => $nama, 'harga' => $harga, 'jam' => $jam);
				$this->session->set_flashdata('done', '<strong>Great!</strong> Data edited!');
			}
		}
		$this->CURL->edit($page, $where, $data);
	}

	public function grafik($page='')
	{
		if ($page=='tahun') {
			# code...
			$cek = $this->CURL->query('SELECT * FROM `list` WHERE DATE_FORMAT(`tanggal_masuk`, \'%Y\') = ' . date('Y'));
			$date_awal = date('Y', strtotime($cek[0]['tanggal_masuk'] . '-5 YEAR'));
			$date_akhir = date('Y', strtotime($cek[0]['tanggal_masuk']));

			$total = $this->CURL->query('SELECT DATE_FORMAT(`list`.`tanggal_masuk`, \'%Y\') as name,SUM(`pesanan`.`jumlah_kg`*`kategori`.`harga_kg`)+`type`.`harga` as `data` FROM `list` 
			LEFT JOIN `pesanan` ON `list`.`no_resi` = `pesanan`.`no_resi`
			LEFT JOIN `kategori` ON `pesanan`.`kode_kategori` = `kategori`.`kode_kategori`
			LEFT JOIN `type` ON `list`.`no_type`=`type`.`no_type`
			WHERE DATE_FORMAT(`tanggal_masuk`, \'%Y\') BETWEEN ' . $date_awal . ' AND ' . $date_akhir . ' GROUP BY DATE_FORMAT(`tanggal_masuk`, \'%Y\')');
			$this->Form->grafik($total, 'Pendapatan Per 5 tahun Laundry');
		}

		elseif ($page=='karyawan') {
			$total = $this->CURL->query('SELECT `user`.`nama` as name,SUM(`pesanan`.`jumlah_kg`*`kategori`.`harga_kg`)+`type`.`harga` as `data` FROM `list` LEFT JOIN `user` ON `list`.`no_user`=`user`.`no_user` LEFT JOIN `pesanan` ON `list`.`no_resi` = `pesanan`.`no_resi` LEFT JOIN `kategori` ON `pesanan`.`kode_kategori` = `kategori`.`kode_kategori` LEFT JOIN `type` ON `list`.`no_type`=`type`.`no_type` GROUP BY `list`.`no_user` ');
			$this->Form->grafik($total, 'Pendapatan Per Karyawan Laundry');
		}
		
	}

}
?>