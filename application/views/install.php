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

<!-- header start -->
<?php $this->load->view('header');?>
<!-- header end -->

<!-- content -->
<div class="container">
	<form class="form-horizontal" method="post" action="<?php echo base_url('/home/aksiinstall');?>">
	  <div class="form-group">
	    <label class="col-sm-2 control-label">No KTP</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="no_ktp" placeholder="No KTP">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Nama</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="nama" placeholder="Nama">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Alamat</label>
	    <div class="col-sm-10">
	      <textarea class="form-control" rows="3" name="alamat" placeholder="Alamat"></textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">No Handphone</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="no_hp" placeholder="No Handphone">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-2 control-label">Username</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" name="username" placeholder="Username">
	    </div>
	  </div>
	  <div class="form-group">
	    <label  class="col-sm-2 control-label">Password </label>
	    <div class="col-sm-10">
	      <input type="password" class="form-control" name="password" placeholder="Password">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" name="daftar" class="btn btn-default">Daftar</button>
	      <button type="reset" class="btn btn-default">Reset</button><br />
	    </div>
	  </div>
	</form>
</div>

<!-- footer start -->
<?php $this->load->view('footer');?>
<!-- footer end -->

</body>
</html>