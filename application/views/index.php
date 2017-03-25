<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Laundry Andi's</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/styles.css');?>" rel="stylesheet"/>
</head>
<body>

<!-- header start -->
<?php $this->load->view('header');?>
<!-- header end -->
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-8">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Masuk Sistem</h3>
			  </div>
			  <div class="panel-body">
			  <div id="alert"></div>
			  <?php
		        // Pesan error masuk
		        if($this->session->flashdata('pesan') <> '') {
		          echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $this->session->flashdata('pesan') . '</div>';
		      	}
		        ?>
			    <form method="post" method="post" id="form-login" action="<?php echo base_url('home/login');?>">
				  <div class="form-group">
				    <label>Username</label>
				    <input type="text" name="username" class="form-control" placeholder="Username">
				  </div>
				  <div class="form-group">
				    <label>Password</label>
				    <input type="password" name="password" class="form-control" placeholder="Password">
				  </div>	
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" name="login" value="y"> Ingat saya!
				    </label>
				  </div>
				  <button type="submit" class="btn btn-primary">Masuk</button>
				  <button type="reset" class="btn btn-default">Batal</button>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>
<!-- footer start -->
<?php $this->load->view('footer');?>
<!-- footer end -->

</body>
</html>