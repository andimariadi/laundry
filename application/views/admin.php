<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Laundry Andi's</title>

    <link href="<?php echo base_url('/assets/css/bootstrap.min.css');?>" rel="stylesheet"/>
    <link href="<?php echo base_url('/assets/css/styles.css');?>" rel="stylesheet"/>
</head>
<body>

<!-- header start -->
<?php $this->load->view('header');?>
<!-- header end -->
<div class="cotainer-fluid">


	<!-- menu -->

		<div class="col-md-4">
			  	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          <span class="glyphicon glyphicon-user"></span> Karyawan
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				        
			  			
			  			<li class="list-group-item"><a href="#" id="d_karyawan"><span class="glyphicon glyphicon-th-list"></span> Data Karyawan</a></li>
  						<li class="list-group-item"><a href="#" id="t_karyawan"><span class="glyphicon glyphicon-plus"></span> Tambah Karyawan</a></li>


				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          <span class="glyphicon glyphicon-download-alt"></span> Order
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				        
				        <li class="list-group-item"><a href="#" id="kategori"><span class="glyphicon glyphicon-folder-close"></span> Kategori</a></li>
  						<li class="list-group-item"><a href="#" id="type"><span class="glyphicon glyphicon-menu-hamburger"></span> Type</a></li>


				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingThree">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				        	<span class="glyphicon glyphicon-print"></span> Laporan
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				      <div class="panel-body">
				        
				        <li class="list-group-item"><a href="#" id="kategori"><span class="glyphicon glyphicon-folder-close"></span> Kategori</a></li>
  						<li class="list-group-item"><a href="#" id="type"><span class="glyphicon glyphicon-menu-hamburger"></span> Type</a></li>

  						
				      </div>
				    </div>
				  </div>
				</div>
		</div>

		<!-- tampilan ajax -->
		<div class="col-md-8" id="begin"></div>
	





</div>

<!-- footer start -->
<?php $this->load->view('footer');?>
<!-- footer end -->

</body>
</html>