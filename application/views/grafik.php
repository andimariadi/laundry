<?php
$total1 = $this->CURL->query('SELECT DATE_FORMAT(`list`.`tanggal_masuk`, \'%Y\') as name,SUM(`pesanan`.`jumlah_kg`*`kategori`.`harga_kg`)+`type`.`harga` as `data` FROM `list` 
            LEFT JOIN `pesanan` ON `list`.`no_resi` = `pesanan`.`no_resi`
            LEFT JOIN `kategori` ON `pesanan`.`kode_kategori` = `kategori`.`kode_kategori`
            LEFT JOIN `type` ON `list`.`no_type`=`type`.`no_type`
            WHERE DATE_FORMAT(`tanggal_masuk`, \'%Y\') BETWEEN 2012 AND 2017 GROUP BY DATE_FORMAT(`tanggal_masuk`, \'%Y\')');
$total2 = $this->CURL->query('SELECT `user`.`nama` as name,SUM(`pesanan`.`jumlah_kg`*`kategori`.`harga_kg`)+`type`.`harga` as `data` FROM `list` LEFT JOIN `user` ON `list`.`no_user`=`user`.`no_user` LEFT JOIN `pesanan` ON `list`.`no_resi` = `pesanan`.`no_resi` LEFT JOIN `kategori` ON `pesanan`.`kode_kategori` = `kategori`.`kode_kategori` LEFT JOIN `type` ON `list`.`no_type`=`type`.`no_type` GROUP BY `list`.`no_user`');
$value = $total1;
$title = 'Wow';
    //echo $key['tahun'] . ' ' .$key['total'] . '<br>';

?>
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
<div id="bro"></div>
<?php
            foreach ($value as $key) {
                echo '{';
                    echo 'name: ' . $key['name'];
                    echo ',data: [' . $key['data'] . ']';
                echo '},';
            }
        ?> 
</div>
<!-- footer start -->
<?php $this->load->view('footer');?>
<!-- footer end -->
        <script type="text/javascript">    
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'bro', //letakan grafik di div id container
                //Type grafik, anda bisa ganti menjadi area,bar,column dan bar
                        type: 'column'
                    },
                    title: {
                        text: "zz"
                    },
                    subtitle: {
                        text: 'Laundry Andi'
                    },
                    xAxis: { //X axis menampilkan data tahun 
                        categories: ['tahun']
                    },
                    yAxis: {
                        title: {  //label yAxis
                            text: 'pendapatan dalam Rupiah'
                        }
                    },
                    tooltip: { 
              //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
              //akan menampikan data di titik tertentu di grafik saat mouseover
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                'Rupiah: '+ this.y ;
                        }
                    },
                    
              //series adalah data yang akan dibuatkan grafiknya,
              //saat ini mungkin anda heran, buat apa label indonesia dikanan 
              //grafik, namun fungsi label ini sangat bermanfaat jika
              //kita menggambarkan dua atau lebih grafik dalam satu chart,
              //hah, emang bisa? ya jelas bisa dong, lihat tutorial selanjutnya 
                    series: [{name: '2012',data: [77000]},{name: 'Adi Fahreza',data: [158000]}]
                });
            });
        </script>

</body>
</html>