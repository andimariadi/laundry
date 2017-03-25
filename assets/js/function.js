function ajax_search() {
	classactive("#pelanggan", "#list, #e_pelanggan, #pesan");
	if($("#name").val() == "") {
		tampil("page/pelanggan", "#tampil");
	} else {
		var judul = $("#name").val();
		tampil("cari/pelanggan/" + judul, "#tampil");
	}
}

function cleared() {
	$(this).parent().removeClass('has-error');
	//hapus inputan
	$(':input','#tambahpelanggan').not(':button, :submit, :reset, :hidden').val('');
	$("#nama").focus();
	$('#form-nama, #form-no-hp, #form-alamat').removeClass('has-error');
}

function tampil(urls='', variable='') {
	$(variable).load(urls);
}

function tambah(urls, id_form, load, variable = '#tampil') {
	var data = $(id_form).serialize();
	$.ajax({
    	type: 'POST',
    	data: data,
	    url : urls,
	    success : function(data) {
	    	// jika data sukses diambil dari server, tampilkan di <select id=kota>
	    	$(variable).load(load);
	    },
	    error: function(data) {
	    	$(failed).load(load);
	    }
	});
}
function loader(urls, pages, ids="#tampil") {
	$.ajax({
	    type: 'POST',
	    url : urls,
	    success : function(data) {
	    	// jika data sukses diambil dari server, tampilkan di <select id=kota>
	    	$(ids).load(pages);
	    }
	}, 2000);
}

function classactive(active, remove) {
	$(active).addClass("active");
    $(remove).removeClass("active");
}
function validAngka(a)
{
	var str = $(a).val();
	var regex = /^[0-9.]+$/;
	if(!regex.test(str)) {
		a.value = a.value.substring(0,a.value.length-1);
	}
}
function nospace(event, keys) {
	if (event.which === 32) {
        var str = $(keys).val();
        str = str.replace(/\s/g, '');
        $(keys).val(str);
    }
}