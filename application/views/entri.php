<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Laundry Andi's</title>

    <link href="<?php echo base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/assets/css/styles.css" rel="stylesheet"/>
</head>
<body>
<?php $this->load->view('header');?>

<div class="container">
	<ul class="nav nav-tabs">
		<li role="presentation" id="pelanggan"><a href="#">Pelanggan</a></li>
		<li role="presentation" id="list" class="disabled"><a href="#">Daftar</a></li>
		<li role="presentation" id="pesan" class="disabled"><a href="#">Pesanan</a></li>
		<li role="presentation" id="e_pelanggan" class="disabled"><a href="#">Edit Pelanggan</a></li>
	</ul>

	<br/>
	<label for="inputHelpBlock">Cari pelanggan</label>
	<div class="row">
			<div class="col-xs-8">
				<input type="text" class="form-control" name="name" id="name" placeholder="Ex: <?php echo $this->session->userdata('username')?>, nomor pelanggan">
				<span id="helpBlock" class="help-block">Masukkan nama pelanggan, mesin pencari akan menampilkan daftar pelanggan secara otomatis.</span>
			</div>
			<div class="col-xs-2">
				<button type="submit" id="submit" class="btn btn-default">Search!</button>
			</div>
			<div class="col-md-2">
				<a href="#" id="viewmodal" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus-sign"></span> Tambah Pelanggan</a>
			</div>
	</div>

	<div id="tampil"></div>


<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">


			<form id="tambahpelanggan" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Tambah Pelanggan</h4>
				</div>

				<div class="modal-body">
					
						<div class="form-group" id="form-nama">
							<label class="control-label">Nama</label>
							<input type="text" id="nama" class="form-control" name="nama" placeholder="Nama">
							
						</div>
						<div class="form-group" id="form-no-hp">
							<label class="control-label">No Handphone</label>
							<input type="text" id="no_hp" class="form-control" name="no_hp" placeholder="No Handphone">
						</div>
						<div class="form-group" id="form-alamat">
							<label class="control-label">Alamat</label>
							<textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
						</div>
				</div>

				<div class="modal-footer">
					<button type="button" id="resetdulu" class="btn btn-default" data-dismiss="modal" onclick="cleared()">Close</button>
					<a href="#" id="tambah" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-plus-sign"></span> Tambah Data</a>
				</div>
			</form>


		</div>
	</div>
</div>


<?php $this->load->view('footer')?>
</body>
</html>