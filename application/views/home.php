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
<div class="container">
	<h1>Hello, <?php echo $this->CURL->status('nama');?></h1>
</div>
<!-- footer start -->
<?php $this->load->view('footer');?>
<!-- footer end -->

</body>
</html>