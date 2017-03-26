<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Valid extends CI_Model
{
	public function caripelanggan($array)
	{
		echo '<table class="table table-hover table-striped">';
		//head
		$head = array('','No.','Nama','Nomor Handphone','Alamat','Jum. Pesan' ,'Belanja Total');
		tablehead($head);

		//body
		echo '<tbody>';
		$order_by = array('no_pelanggan' => "DESC");
		if ($this->CURL->status('status') != 'admin') {
			$datas = array('status' => 'available');			
			$data = $this->CURL->likeorand('pelanggan', $array, $datas);
			foreach ($data->result_array() as $pelanggan):
				echo '<tr>';
					//action
					echo '<td>';
					echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-trash" style="color: red;" data-toggle="tooltip" data-placement="left" title="Remove Data"></span></a>';
					echo ' <a href="#" class="edit" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-pencil"></span></a>';
					echo '</td>';

					echo '<td class="col-md-1">' . $pelanggan['no_pelanggan'] . "</td>";
					echo '<td class="col-md-2"><a href="#"  class="baris" id="' . $pelanggan['no_pelanggan'] . '">' . $pelanggan['nama'] . "</a></td>";
					echo '<td class="col-md-2">' . $pelanggan['no_hp'] . "</td>";
					echo '<td class="col-md-3">' . $pelanggan['alamat'] . "</td>";

						//mencari total laundry
					echo '<td class="col-md-1">';
						echo $this->CURL->cari('list', array('no_pelanggan' => $pelanggan['no_pelanggan']))->num_rows();
					echo "</td>";

						//total belanja
					echo '<td class="col-md-2">';
						$where = array('pelanggan.no_pelanggan' => $pelanggan['no_pelanggan']);
						$join = array('list' => 'pelanggan.no_pelanggan = list.no_pelanggan', 'pesanan' => 'list.no_resi = pesanan.no_resi', 'kategori' => 'pesanan.kode_kategori = kategori.kode_kategori');
						$order_by = array('order' => 'pelanggan.no_pelanggan', 'by' => 'ASC');
						$select = 'SUM(pesanan.jumlah_kg*kategori.harga_kg) as total';
						$total = $this->CURL->multijoinwhere('pelanggan', $join, $where, $order_by, $select)->result_array();

						//result total
						foreach ($total as $hasil):echo rupiah($hasil['total']);endforeach;

					echo "</td>";
				echo '</tr>';
			endforeach;
		} else {
			$data = $this->CURL->like('pelanggan', $array);
			foreach ($data->result_array() as $pelanggan):
				echo '<tr>';
					//action
					echo '<td>';
						if ($pelanggan['status'] == 'delete') {
						echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-repeat" style="color: green;" data-toggle="tooltip" data-placement="left" title="Kembalikan Data"></span></a>';
						echo ' <a href="#" class="del_pelanggan" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" title="Hapus Data"></span></a>';
						} else {
							echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-trash" style="color: red;" data-toggle="tooltip" data-placement="left" title="Remove Data"></span></a>';
						}

						echo ' <a href="#" class="edit" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-pencil"></span></a>';
					echo '</td>';

					echo '<td class="col-md-1">' . $pelanggan['no_pelanggan'] . "</td>";
					echo '<td class="col-md-2"><a href="#"  class="baris" id="' . $pelanggan['no_pelanggan'] . '">' . $pelanggan['nama'] . "</a></td>";
					echo '<td class="col-md-2">' . $pelanggan['no_hp'] . "</td>";
					echo '<td class="col-md-3">' . $pelanggan['alamat'] . "</td>";

						//mencari total laundry
					echo '<td class="col-md-1">';
						echo $this->CURL->cari('list', array('no_pelanggan' => $pelanggan['no_pelanggan']))->num_rows();
					echo "</td>";

						//total belanja
					echo '<td class="col-md-2">';
						$where = array('pelanggan.no_pelanggan' => $pelanggan['no_pelanggan']);
						$join = array('list' => 'pelanggan.no_pelanggan = list.no_pelanggan', 'pesanan' => 'list.no_resi = pesanan.no_resi', 'kategori' => 'pesanan.kode_kategori = kategori.kode_kategori');
						$order_by = array('order' => 'pelanggan.no_pelanggan', 'by' => 'ASC');
						$select = 'SUM(pesanan.jumlah_kg*kategori.harga_kg) as total';
						$total = $this->CURL->multijoinwhere('pelanggan', $join, $where, $order_by, $select)->result_array();

						//result total
						foreach ($total as $hasil):echo rupiah($hasil['total']);endforeach;

					echo "</td>";
				echo '</tr>';
			endforeach;
		}
			if($data->num_rows() <= 0) {
				echo '
					<tr>
					<td colspan="7" align="center">- Tidak ada data -</td>
					</tr>';
			}
			echo '</tbody></table>';
	}
	
	public function tampilpelanggan($array, $order_by) {
		
		echo '<table class="table table-hover table-striped">';
		//head
		$head = array('','No.','Nama','Nomor Handphone','Alamat','Jum. Pesan' ,'Belanja Total');
		tablehead($head);

		//body
		echo '<tbody>';
		if ($this->CURL->status('status') != 'admin') {
			$data = $this->CURL->cariselect('pelanggan', '*',$array, $order_by);
			foreach ($data->result_array() as $pelanggan):
				echo '<tr>';
					//action
					echo '<td>';
					echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-trash" style="color: red;" data-toggle="tooltip" data-placement="left" title="Remove Data"></span></a>';
					echo ' <a href="#" class="edit" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-pencil"></span></a>';
					echo '</td>';

					echo '<td class="col-md-1">' . $pelanggan['no_pelanggan'] . "</td>";
					echo '<td class="col-md-2"><a href="#"  class="baris" id="' . $pelanggan['no_pelanggan'] . '">' . $pelanggan['nama'] . "</a></td>";
					echo '<td class="col-md-2">' . $pelanggan['no_hp'] . "</td>";
					echo '<td class="col-md-3">' . $pelanggan['alamat'] . "</td>";

						//mencari total laundry
					echo '<td class="col-md-1">';
						echo $this->CURL->cari('list', array('no_pelanggan' => $pelanggan['no_pelanggan']))->num_rows();
					echo "</td>";

						//total belanja
					echo '<td class="col-md-2">';
						$where = array('pelanggan.no_pelanggan' => $pelanggan['no_pelanggan']);
						$join = array('list' => 'pelanggan.no_pelanggan = list.no_pelanggan', 'pesanan' => 'list.no_resi = pesanan.no_resi', 'kategori' => 'pesanan.kode_kategori = kategori.kode_kategori', 'type' => 'list.no_type = type.no_type');
						$order_by = array('order' => 'pelanggan.no_pelanggan', 'by' => 'ASC');
						$select = 'SUM(pesanan.jumlah_kg*kategori.harga_kg)+type.harga as total';
						$total = $this->CURL->multijoinwhere('pelanggan', $join, $where, $order_by, $select)->result_array();

						//result total
						foreach ($total as $hasil):echo rupiah($hasil['total']);endforeach;

					echo "</td>";
				echo '</tr>';
			endforeach;
		} else {
			$data = $this->CURL->tampilselect('pelanggan', $order_by);
			foreach ($data->result_array() as $pelanggan):
				echo '<tr>';
					//action
					echo '<td>';
						if ($pelanggan['status'] == 'delete') {
						echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-repeat" style="color: green;" data-toggle="tooltip" data-placement="left" title="Kembalikan Data"></span></a>';
						echo ' <a href="#" class="del_pelanggan" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" title="Hapus Data"></span></a>';
						} else {
							echo '<a href="#" class="action" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-trash" style="color: red;" data-toggle="tooltip" data-placement="left" title="Remove Data"></span></a>';
						}

						echo ' <a href="#" class="edit" id="' . $pelanggan['no_pelanggan'] . '"><span class="glyphicon glyphicon-pencil"></span></a>';
					echo '</td>';

					echo '<td class="col-md-1">' . $pelanggan['no_pelanggan'] . "</td>";
					echo '<td class="col-md-2"><a href="#"  class="baris" id="' . $pelanggan['no_pelanggan'] . '">' . $pelanggan['nama'] . "</a></td>";
					echo '<td class="col-md-2">' . $pelanggan['no_hp'] . "</td>";
					echo '<td class="col-md-3">' . $pelanggan['alamat'] . "</td>";

						//mencari total laundry
					echo '<td class="col-md-1">';
						echo $this->CURL->cari('list', array('no_pelanggan' => $pelanggan['no_pelanggan']))->num_rows();
					echo "</td>";

						//total belanja
					echo '<td class="col-md-2">';
						$where = array('pelanggan.no_pelanggan' => $pelanggan['no_pelanggan']);
						$join = array('list' => 'pelanggan.no_pelanggan = list.no_pelanggan', 'pesanan' => 'list.no_resi = pesanan.no_resi', 'kategori' => 'pesanan.kode_kategori = kategori.kode_kategori', 'type' => 'list.no_type = type.no_type');
						$order_by = array('order' => 'pelanggan.no_pelanggan', 'by' => 'ASC');
						$select = 'SUM(pesanan.jumlah_kg*kategori.harga_kg)+type.harga as total';
						$total = $this->CURL->multijoinwhere('pelanggan', $join, $where, $order_by, $select)->result_array();

						//result total
						foreach ($total as $hasil):echo rupiah($hasil['total']);endforeach;

					echo "</td>";
				echo '</tr>';
			endforeach;
		}
		if($data->num_rows() <= 0) {
			echo '
				<tr>
				<td colspan="7" align="center">- Tidak ada data -</td>
				</tr>';
		}
		echo '</tbody>';
		echo "</table>";
	}

	public function editpelanggan($page, $field,$state)
	{
		$where = array($field => $state);
		$data = array('data' => $this->CURL->cari($page, $where));
		foreach ($data['data']->result_array() as $edit) {
		?>
      <!-- isinya -->
	<form class="form-horizontal" id="editpelanggan" method="post">
	  <div class="form-group">
	    <label class="col-sm-2 control-label">No.</label>
	    <div class="col-sm-3">
	      <input type="text" class="form-control" name="no" placeholder="No KTP" value="<?php echo $edit['no_pelanggan'];?>" readonly>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Nama</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $edit['nama'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">No Handphone</label>
	    <div class="col-sm-4">
	      <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Handphone" value="<?php echo $edit['no_hp'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Alamat</label>
	    <div class="col-sm-8">
	      <textarea class="form-control" name="alamat" rows="3"><?php echo $edit['alamat'];?></textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <a href="#" id="simpan" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</a>
	      <a href="#" id="pelanggan" class="btn btn-default">Batal</a><br />
	    </div>
	  </div>
	</form>
		<?php
		}
	}

	public function listing($table)
	{
		echo '<table class="table table-hover table-striped">';
		echo '
				<thead>
					<tr>
						<th>No. Resi</th>
						<th>Tanggal/Jam Masuk</th>
						<th>Tanggal/Jam Selesai</th>
						<th>Type</th>
						<th>Cs</th>
						<th>Total Belanja</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';

			foreach ($table as $data) {
				echo '<tr>';
					echo '<td class="col-md-1"><a href="#" class="list" id="' . $data['no_resi'] . '">' . $data['no_resi'] . "</a></td>";
					echo '<td class="col-md-2">' . date('d-m-Y H:i', strtotime($data['tanggal_masuk'])) . "</td>";
					echo '<td class="col-md-2">' . date('d-m-Y H:i', strtotime($data['tanggal_selesai'])) . "</td>";
					echo '<td class="col-md-3">' . $data['type'] . " (" . rupiah($data['harga']).")</td>";
					echo '<td class="col-md-2">' . $data['nama'] . "</td>";
					echo '<td class="col-md-2">';

					//cari total semua belanjanya
					$select = 'SUM(pesanan.jumlah_kg*kategori.harga_kg)+type.harga as total';
					$join = array('pesanan' => 'list.no_resi = pesanan.no_resi', 'kategori' => 'pesanan.kode_kategori = kategori.kode_kategori', 'type' => 'list.no_type = type.no_type');
					$where = array('list.no_resi' => $data['no_resi']);
					$order_by = array('order' => 'list.no_resi', 'by' => 'ASC');
					$belanja = $this->CURL->multijoinwhere('list', $join, $where, $order_by, $select)->result_array();
					echo rupiah($belanja[0]['total']);
					//

					echo "</td>";
					echo '<td class="col-md-2"><a href="#" class="dellist" id="' . $data['no_resi'] . '"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="left" title="Hapus Data"></span></a></td>';
				echo '</tr>';
			}
		echo "</table>";
	}

	public function formlist($no)
	{
		$data = $this->CURL->cari('pelanggan', array('no_pelanggan' => $no))->result_array();
		echo '
		<div class="row">
			<label class="col-sm-2 control-label">Nama Pelanggan</label>
			<div class="col-sm-2">
				<input type="text" id="nama" class="form-control" value="';
				// echo nama pelanggan
					echo $data[0]['nama'];

				echo '" readonly>
			</div>

			<div class="col-sm-2">

				<a href="#" id="viewlist" class="btn btn-primary" data-toggle="modal" data-target="#formlist"><span class="glyphicon glyphicon-plus-sign"></span> Pesan</a>
				<a href="#" id="batallist" class="btn btn-default">Batal</a>

			</div>
		</div>
		';
		foreach ($data as $data):
		?>
			<div class="modal fade" id="formlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">


						<form class="form-horizontal" id="form-list" method="post">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Tambah Daftar Pesan</h4>
							</div>

							<div class="modal-body">
								
									<div class="form-group">
										<label class="col-sm-2 control-label">Nomor</label>
										<div class="col-sm-2">
											<input type="text" name="no_pelanggan" id="no_pelanggan" class="form-control" value="<?php echo $data['no_pelanggan'];?>" readonly>
										</div>
										<label class="col-sm-3 control-label">Nama Pelanggan</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" value="<?php echo $data['nama'];?>" readonly>
											</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Type Laundry</label>
										<div class="col-sm-3">
											<select class="form-control" name="type">
								    		<?php

								    		//cari type apa saja
								    			foreach ($this->CURL->tampil('type') as $key):echo '<option value="' . $key['no_type'] . '">' . $key['type'] . ' (' . $key['harga']. ')</option>';endforeach;
								    		?>
								    		</select>
								    	</div>
								    </div>

							</div>

							<div class="modal-footer">
								<a href="#" id="simpanlist" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-plus-sign"></span> Simpan</a>
								<a href="#" class="btn btn-default"  data-dismiss="modal">Batal</a>
							</div> 
						</form>


					</div>
				</div>
			</div>
		<?php
		endforeach;
	}

	public function pesanan($pelanggan, $no)
	{
		$kategori = $this->CURL->tampil('kategori');
		$data_pelanggan = $this->CURL->cari('pelanggan', array('no_pelanggan' => $pelanggan));
		$data_pelanggan = $data_pelanggan->result_array();
		?>
		<div class="form-horizontal">
			<div class="form-group">
			    <label class="col-sm-2 control-label">Nama Pelanggan</label>
			    <div class="col-sm-2">
			      <input type="text" class="form-control" placeholder="Nama Pelanggan" value="<?php foreach ($data_pelanggan as $data):echo $data['nama'];endforeach;?>" readonly>
			    </div>
			</div>
		</div>
		<form class="form-horizontal" id="formpesan" method="post">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">No. Resi</label>
		    <div class="col-sm-2">
		      <input type="text" class="form-control" name="no" id="no" placeholder="No. Resi" value="<?php echo $no;?>" readonly>
		    </div>
		    <label class="col-sm-1 control-label">Kategori</label>
		    <div class="col-sm-2">
		      <select class="form-control" name="kategori">
		      <?php foreach($kategori as $data):?>
		      	<option value="<?php echo $data['kode_kategori'];?>"><?php echo $data['nama'];?> (<?php echo $data['harga_kg'];?>/Kg)</option>
		      <?php endforeach;?>
		      </select>
		    </div>
		    <label class="col-sm-1 control-label">Jumlah</label>
		    <div class="col-sm-2">
		      <input type="text" class="form-control" name="jumlah"  id="jumlah" placeholder="Masukkan Jumlah/Kg">
		    </div>
		    <div class="col-sm-2">
		     <a href="#" id="simpanpesan" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</a>
		     <a href="#" id="<?php echo $this->session->userdata('list');?>" class="btn btn-default batalpesan">Batal</a>
		    </div>
		  </div>
		</form>
		<?php
	}

	public function tampilpesanan($table)
	{
				$no = 0;
			foreach ($table->result_array() as $data):
				$no++;
				echo '<tr>';
					echo '<td class="col-md-1">' . $no . "</td>";
					echo '<td class="col-md-2">' . $data['nama'] . " (" . $data['harga_kg']. "/Kg)</td>";
					echo '<td class="col-md-2">' . $data['jumlah_kg'] . "</td>";
					echo '<td class="col-md-2">' . rupiah($data['jumlah_kg']*$data['harga_kg']) . "</td>";
					echo '<td class="col-md-1"><a href="#" class="delpesan" id="' . $data['no_pesanan'] . '"><span class="glyphicon glyphicon-minus" data-toggle="tooltip" data-placement="left" title="Remove Data"></span></a></td>';
				echo '</tr>';
			endforeach;
	}
	public function totalpesanan($data, $multijoin)
	{
			// cari seluruhnya
				echo '<tr>';
					echo '<th colspan="3">Total Laundry</th>';
					echo '<th colspan="2">';

					echo rupiah($data[0]['total']) . "</th>";
				echo '</tr>';
				echo '<tr>';
		//cari tambahan
			echo "<th colspan=\"3\">Tambahan harga (" . $multijoin[0]['type'] . ")</th>";
			echo '<th colspan="2">';
			
				echo rupiah($multijoin[0]['harga']);
			echo '</th>';
		echo '</tr>';
				echo '<tr>';
					echo '<th colspan="3">Total Seluruhnya</th>';
					echo '<th colspan="2">';

					echo rupiah($data[0]['totalsemua']) . "</th>";
				echo '</tr>';
		echo "</tbody>";
	}


	public function tambahkaryawan()
	{
		?>
		<br />
		<?php
			if ($this->session->flashdata('error') != '') {
				echo '<div class="alert alert-danger" role="alert">
					' . $this->session->flashdata('error'). '
				</div>';
			}
		?>
		<form class="form-horizontal" id="form-karyawan" method="post">
			<div class="form-group">
				<label class="col-sm-2 control-label">Nomor KTP</label>
				<div class="col-sm-4">
					<input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama</label>
				<div class="col-sm-6">
					<input type="text" name="nama" class="form-control" placeholder="Nama Karyawan">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Alamat</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="alamat" rows="3" placeholder="Alamat"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nomor Handphone</label>
				<div class="col-sm-4">
					<input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Nomor Handphone">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Username</label>
				<div class="col-sm-4">
					<input type="text" name="username" class="form-control" placeholder="Username">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Ulangi Password</label>
				<div class="col-sm-4">
					<input type="password" name="password_2" class="form-control" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<a href="#" id="simpankaryawan" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Simpan</a>
					<a href="#" id="batalkaryawan" class="btn btn-default">Batal</a>
				</div>
			</div>
						</form>
		<?php
	}

	public function datakaryawan($table)
	{

		if ($this->session->flashdata('done') != '') {
			echo '<br/><div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('done') . '</div>';
		}
		echo '<table class="table table-hover table-striped">';
		echo '
				<thead>
					<tr>
						<th>Username</th>
						<th>No. KTP</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Nomor Handphone</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';
			foreach ($table as $data) {
				echo '<tr>';
					echo '<td class="col-md-2">' . $data['username'] . "</td>";
					echo '<td class="col-md-1">' . $data['no_ktp'] . "</td>";
					echo '<td class="col-md-3">' . $data['nama'] . "</td>";
					echo '<td class="col-md-2">' . $data['alamat'] . "</td>";
					echo '<td class="col-md-2">' . $data['no_hp'] . "</td>";
					echo '<td class="col-md-2"><a href="#" class="delkar" id="' . $data['no_user'] . '"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="left" title="Hapus Data"></span></a> <a href="#" class="editkar" id="' . $data['no_user'] . '"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Edit Data"></span></a> <a href="#" class="edpass" id="' . $data['username'] . '">
						<span class="glyphicon glyphicon-lock"></span></a>
					</td>';
				echo '</tr>';
			}
		echo "</table>";
	}

	public function editkaryawan($table, $field, $state)
	{
		$this->session->set_userdata(array('no_karyawan' => $state));
		$where = array($field => $this->session->userdata('no_karyawan'));
		$data = array('data' => $this->CURL->cari($table, $where));
		foreach ($data['data']->result_array() as $edit):
		?>
	<br />
	<?php
		if ($this->session->flashdata('done') != '') {
			echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('done') . '</div>';
		}
	?>
      <!-- isinya -->
	<form class="form-horizontal" id="editkaryawan" method="post">
		<div class="form-group">
	    <label class="col-sm-2 control-label">Username</label>
	    <div class="col-sm-3">
	    <input type="text" class="form-control" name="username" id="username" placeholder="No User" value="<?php echo $edit['username'];?>" readonly>
	    </div>
	    <div class="col-sm-2">
	    	<input type="checkbox" id="inlineCheckbox1" value="true"> Edit Username
	    	<input type="text" class="form-control" name="no" id="no_user" placeholder="No User" value="<?php echo $edit['no_user'];?>" style="display: none">
	    </div>
	  </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Nomor KTP</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" name="no_ktp" placeholder="No KTP" value="<?php echo $edit['no_ktp'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Nama</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $edit['nama'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Alamat</label>
	    <div class="col-sm-10">
	    	<textarea class="form-control" name="alamat" placeholder="Alamat" rows="3"><?php echo $edit['alamat'];?></textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">No Handphone</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="no_hp" placeholder="No Handphone" value="<?php echo $edit['no_hp'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <a href="#" id="btnkaryawan" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</a>
	      <a href="#" id="batalkaryawan" class="btn btn-default">Batal</a><br />
	    </div>
	  </div>
	</form>
		<?php endforeach;?>
		<?php
	}

	public function changepass($state)
	{
		echo '<br />';
		if ($this->session->flashdata('done') != '') {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('done') . '</div>';
		}
	?>
      <!-- isinya -->
	<form class="form-horizontal" id="form-pass" method="post">
		<div class="form-group">
	    <label class="col-sm-2 control-label">Username</label>
	    <div class="col-sm-3">
	    <input type="text" class="form-control" name="username" id="username" placeholder="No User" value="<?php echo $state;?>" readonly>
	    </div>
	    
	  </div>
	  </div>
	  
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Password</label>
	    <div class="col-sm-4">
	      <input type="password" class="form-control" name="password" placeholder="Masukkan password">
	    </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">Ulangi Password</label>
	    <div class="col-sm-4">
	      <input type="password" class="form-control" name="password_2" placeholder="Masukkan ulang password">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <a href="#" id="btn-pass" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</a>
	      <a href="#" id="batalkaryawan" class="btn btn-default">Batal</a><br />
	    </div>
	  </div>
	</form>
		<?php
	}
}
?>
