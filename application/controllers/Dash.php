<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Dash extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		//$models = array('CURL', 'Valid', 'Fungsi');
		//$this->load->model($models);
		if ($this->CURL->status('username') =='') {
			redirect(base_url('home/logout'));
		}
	}
	
	public function index()
	{
		$this->load->view('home');
	}

	public function entri()
	{
		$this->load->view('entri');
	}

	public function cari($page, $search)
	{
		if ($page == 'pelanggan') {
			$array = array('nama' => $search, 'no_pelanggan' => $search);
			$this->Valid->caripelanggan($array);
		}
	}

	public function delete($page, $state)
	{
		if ($page == 'pelanggan') {
			$where = array('no_pelanggan' => $state);
			$foreach = $this->CURL->cari($page, $where);
			foreach ($foreach->result_array() as $data) {
				if ($data['status'] == 'available') {
					$data = array('status' => 'delete');
				} else {
					$data = array('status' => 'available');
				}
				$this->CURL->edit($page, $where, $data);
			}
		}

		elseif ($page == 'no') {
			$where = array('no_pelanggan' => $state);
			$this->CURL->hapus('pelanggan', $where);
		}

		elseif ($page == 'list') {
			$where = array('no_resi' => $state);
			$this->CURL->hapus('list', $where);
		}

		elseif ($page == 'pesanan') {
			$where = array('no_pesanan' => $state);
			$this->CURL->hapus('pesanan', $where);
		}

	}
	public function edit($page, $field,$state)
	{
		if($page == 'pelanggan') {
			$this->Valid->editpelanggan($page, $field,$state);
		}
	}

	public function edited($page)
	{
		if ($page == 'pelanggan') {
			$no_pelanggan = $this->input->post('no');
			$nama = $this->input->post('nama');
			$no_hp = $this->input->post('no_hp');
			$alamat = $this->input->post('alamat');

			$where = array('no_pelanggan' => $no_pelanggan);
			$data = array('no_pelanggan' => $no_pelanggan, 'nama' => $nama, 'no_hp' => $no_hp, 'alamat' => $alamat);
		}

		elseif ($page == 'user') {
			$no = $this->input->post('no');
			$no_ktp = $this->input->post('no_ktp');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$no_hp = $this->input->post('no_hp');

			$where = array('no_user' => $no);
			$data = array('no_ktp' => $no_ktp, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp);
			$this->session->set_flashdata('done', '<strong>Great!</strong> Data berhasil diedit!');
		}
		
		$this->CURL->edit($page, $where, $data);
	}

	public function simpan($table)
	{
		if ($table == 'pelanggan') {
			$nama = $this->input->post('nama');
			$no_hp = $this->input->post('no_hp');
			$alamat = $this->input->post('alamat');

			$data = array('nama' => $nama, 'no_hp' => $no_hp, 'alamat' => $alamat, 'status' => 'available');
		} elseif ($table == 'pesanan') {
			$no_resi = $this->input->post('no');
			$kategori = $this->input->post('kategori');
			$jumlah = $this->input->post('jumlah');
			
			$data = array('no_resi' => $no_resi, 'kode_kategori' => $kategori, 'jumlah_kg' => $jumlah);
		} elseif ($table == 'list') {
			$no_resi = kode(date('H:i:s'));
			$no_user = $this->CURL->status('no_user');
			$no_pelanggan = $this->session->userdata('list');
			$date = date('Y-m-d H:i:s');
			$type = $this->input->post('type');
			$data_selesai = $this->CURL->cari('type', array('no_type' => $type))->result_array();
			$date_selesai = date('Y-m-d H:i:s', strtotime('+' . $data_selesai[0]['jam'] . ' hours'));
			$data = array('no_resi'=>$no_resi,'no_user' => $no_user, 'no_pelanggan' => $no_pelanggan, 'tanggal_masuk' => $date, 'tanggal_selesai' => $date_selesai, 'no_type' => $type);
		}
		$this->CURL->tambah($table, $data);
	}


	public function list($no)
	{
		$this->Valid->formlist($no);
		$this->session->set_userdata(array('list' => $no));
		$join = array('user'=>'list.no_user = user.no_user', 'type' => 'list.no_type = type.no_type');
		$where = array('list.no_pelanggan' => $no);
		$order_by = array('order'=>'list.tanggal_masuk', 'by'=>'DESC');
		$data = $this->CURL->multijoinwhere('list', $join, $where, $order_by, '*');
		$table = $data->result_array();

		$this->Valid->listing($table);
	}

	public function pesanan($pelanggan,$no)
	{
		$this->Valid->pesanan($this->session->userdata('list'), $no);
		$this->tampilpesanan($no);
	}
	public function tampilpesanan($no)
	{
		echo '<table class="table table-hover table-striped">';
		echo '
				<thead>
					<tr>
						<th>No.</th>
						<th>Kategori</th>
						<th>Jumlah/Kg</th>
						<th>Total Harga</th>
					</tr>
				</thead>
				<tbody>';

		// menampilkan tampilkan semua pelanggan
		$join = array('kategori' => 'pesanan.kode_kategori = kategori.kode_kategori', 'list' => 'pesanan.no_resi = list.no_resi', 'type' => 'list.no_type = type.no_type');
		$where = array('pesanan.no_resi' => $no);
		$order_by = array('order'=>'pesanan.no_resi','by'=>'ASC');
		$data = $this->CURL->multijoinwhere('pesanan', $join, $where, $order_by, '*');
		

		// menampilkan tampilkan harga total seluruhnya
		$data2 = $this->CURL->multijoinwhere('pesanan', $join, $where, $order_by, 'SUM(pesanan.jumlah_kg*kategori.harga_kg)+type.harga as totalsemua, SUM(pesanan.jumlah_kg*kategori.harga_kg) as total')->result_array();

		//untuk cari tambahan harga
		$join = array('type' => 'list.no_type = type.no_type');
		$where = array('list.no_resi' => $no);
		$order_by = array('order' => 'type.no_type', 'by' => 'asc');
		$multijoin = $this->CURL->multijoinwhere('list', $join, $where, $order_by, "*")->result_array();

		//tampilkan data pesanan pelanggan
		$this->Valid->tampilpesanan($data);
		$this->Valid->totalpesanan($data2, $multijoin);
		echo "</table>";
	}

	//admin

	public function page($page)
	{
		if ($page == 'pelanggan') {
			$array = array('status' => 'available');
			$order_by = array('order' => 'no_pelanggan', 'by' => 'desc');
			$this->Valid->tampilpelanggan($array, $order_by);
		}
		
	}
	public function test()
	{
		//$data = array('No.','Nama','Nomor Handphone','Alamat','Jum. Pesan' ,'Belanja Total');
		//$array = array('nama' => 'andi', 'no_pelanggan' => 'andi');
		//$datas = array('status' => 'available');			
		//$body = $this->CURL->likeorand('pelanggan', $array, $datas)->result_array();
		//$this->Fungsi->tablehover($data, $body);
		$awal = 1;
		$akhir = 100;
		for ($i=$awal; $i <= $akhir ; $i++):
			if ($i <> $awal) {
				echo ", \n";
			}
			$feed = 9;
			$buzz = 6;
			$feedbuzz = ($feed*$buzz);
			if ($i % $feedbuzz == 0) {
				echo "<span style=\"color: red;\">$i</span>";
			} /*elseif($i % $buzz == 0) {
				echo "<span style=\"color: green;\">$i</span>";
			} elseif($i % $feed == 0 ) {
				echo "<span style=\"color: blue;\">$i</span>";
			} */else {
				echo $i;
			}
		endfor;
		echo "<br>";
		echo "Beasa ################ <br>";
		echo "<br>";

		$this->load->view('grafik');
		
	}

	public function pendapatan()
	{
		$join = array('list' => '`user`.`no_user`=`list`.`no_user`', 'type' => '`list`.`no_type`=`type`.`no_type`', 'pesanan' => '`list`.`no_resi` = `pesanan`.`no_resi`', 'kategori' => '`pesanan`.`kode_kategori`=`kategori`.`kode_kategori`');
        $where = array('user.no_user' => $this->CURL->status('no_user'));
        $order_by = array('order' => 'user.no_user', 'by' => 'ASC');
        $select = 'SUM(`pesanan`.`jumlah_kg`*`kategori`.`harga_kg`)+`type`.`harga` as `total`';
        $total = $this->CURL->multijoinwhere('user', $join, $where, $order_by, $select)->result_array();
        echo rupiah($total[0]['total']);
	}

	

	

	/* ################################### hanya sebuah modal ################################

	public function danger($id)
	{
		echo '<div class="modal-alert" style="position: fixed;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.51);opacity: 1;top: 0;left: 0;z-index: 1;">
			<div class="modal-body" style="position: absolute;background-color: #f54848;opacity: 1;z-index: 2;min-width: 200px; left: 45%;top: 25%;border-radius: 6px;padding: 15px;color: #fff;">
				<div class="body-top-modal" style="position: relative;color: #fff;font-weight: 800;text-align: center;border-bottom: 1px solid #eee;padding: 10px 15px;text-transform: uppercase;">Apakah data ingin dihapus ?</div>
				<div class="body-modal" style="padding: 15px 0;text-align: center;">
					<a href="#" class="close-modal btn btn-danger test" id="'.$id.'">Ya!</a>
					<a href="#" class="close-modal btn btn-default">Batal</a>
				</div>
			</div>
			</div>';
	}
	*/
}
?>