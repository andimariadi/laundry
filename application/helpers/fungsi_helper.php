<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/

	function rupiah($nilai, $pecahan=0)
    {
        return "Rp. " . number_format($nilai, $pecahan, ',' , '.') . ",-";
    }

    function tablehead($head)
    {
		echo '<thead>
				<tr>';
			foreach ($head as $data):
				echo "<th>" . $data . "</th>";
			endforeach;
		echo '</tr>
		</thead>';
    }

    function under ($data) {
    	$search = array(' ');
    	$replace = array('_');
    	return str_replace($search, $replace, strtolower($data));
    }

    function noalpa ($data) {
        $search = array('a', 'e', 'u', 'i', 'o', 'A', 'E', 'U', 'I', 'O', ' ', '.', rand(9, 0));
        $replace = array('');
        return str_replace($search, $replace, strtolower($data));
    }

    function kode($data=''){
        $data = password_hash($data, PASSWORD_DEFAULT);

        $kode1 = date('now') . time('now');
        $con = noalpa(strlen($kode1)/rand(100, 0));
        $kode1 = substr($con, strlen($con)/rand(5,0), 3);
        
        $kode2 = md5($data);
        $kode2 = substr($kode2, 0, 5);

        $kode3 = sha1($data);
        $kode3 = substr($kode3, 0, 5);

        //strlen($kode2, )
        return $kode1 . '-' . $kode2 . '-' . $kode3;
    }
?>