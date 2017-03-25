$(document).ready(function() {
    /* #################################### pencarian pendapatan #########################*/
    $("#pendapatan").load('dash/pendapatan');
    setInterval(function(){
        $("#pendapatan").load('../dash/pendapatan');
    }, 100);

    /* #################################### pencarian langsung #########################*/
    // tombol search klik
    $("#submit").click(function(event) {
		event.preventDefault();
    	ajax_search();
    });
    // masukkan nama langsung searching beraksi
    $("#name").keyup(function(event) {
    	event.preventDefault();
    	ajax_search();
    });


    /* #################################### pelanggan #########################*/
    //tampilan pelanggan
    classactive("#pelanggan", "#e_pelanggan, #list, #pesan");
    tampil("page/pelanggan", "#tampil");
    //menu tampil pelanggan dan batal di list
    $(document).on("click", "#pelanggan, #batallist, .close-modal", function(e) {
        classactive("#pelanggan", "#e_pelanggan, #list, #pesan");
        tampil("page/pelanggan", "#tampil");
    })
    //remove pelanggan
    $(document).on("click", ".action", function(e) {
 		var id = $(this).attr('id');
        loader("delete/pelanggan/" + id, "page/pelanggan");
    });
    $(document).on("click", ".test", function(e) {
        var id = $(this).attr('id');
        loader("delete/pelanggan/" + id, "page/pelanggan");
    });
    //delete pelanggan
    //bkdhst
    $(document).on("click", ".del_pelanggan", function(e) {
 		var id = $(this).attr('id');
 		loader("delete/no/" + id, "page/pelanggan");
    });
    //tambah pelanggan
    $("#tambah").click(function(event) {
        if ($('#nama, #no_hp, #alamat').val() == '') {
            $('#form-nama, #form-no-hp, #form-alamat').addClass('has-error');
        } else {
            tambah('simpan/pelanggan','#tambahpelanggan', 'page/pelanggan');
            cleared();
            classactive("#pelanggan", "#e_pelanggan, #list, #pesan");
        }
    });
    //validation no telepon
    $(document).on("keypress", "#no_hp", function(e) {
        validAngka(this);
        nospace(event, this);
    }).keyup(function(event) {
        validAngka(this);
        nospace(event, this);
    });
    //masuk menu editing pelanggan
    $(document).on("click", ".edit", function(e) {
        classactive("#e_pelanggan", "#pelanggan, #list, #pesan");
        var id = $(this).attr('id');
        tampil("edit/pelanggan/no_pelanggan/" + id, "#tampil");
        
    });
    //simpan hasil editing pelanggan
    $(document).on("click", "#simpan", function(e) {
        //alert("Simpan");
        tambah('edited/pelanggan','#editpelanggan', 'page/pelanggan');
        classactive("#pelanggan", "#list, #e_pelanggan, #pesan");
    });
    //masuk list pesan type
    $(document).on("click", ".baris", function(e) {
        var id = $(this).attr('id');
        classactive("#list", "#pelanggan, #e_pelanggan, #pesan");
        tampil("list/" + id, "#tampil");
    });



    /* #################################### list pesan type #########################*/
    //hapus list type
    $(document).on("click", ".dellist", function(e) {
        var id = $(this).attr('id');
        var no = $("#no_pelanggan").val();
        loader("delete/list/" + id, "list/" + no);
    });
    //tambah listing
    $(document).on("click", "#simpanlist", function(e) {
        var id = $("#no_pelanggan").val();
        tambah('simpan/list','#form-list', 'list/' + id);
        cleared();
        classactive("#list", "#pelanggan, #e_pelanggan, #pesan");
    });
    //masuk lihat pesanan
    $(document).on("click", ".list", function(e) {
        classactive("#pesan", "#pelanggan, #e_pelanggan, #list");
        var id = $(this).attr('id');
        var pelanggan = $('#no_pelanggan').val();
        tampil("pesanan/" + pelanggan + "/" + id, "#tampil");
    });


    /* #################################### pesanan #########################*/
    //hapus pesan
    $(document).on("click", ".delpesan", function(e) {
        var id = $(this).attr('id');
        var no_resi = $('#no').val();
        var pelanggan = $('#no_pelanggan').val();
        loader("delete/pesanan/" + id, "pesanan/" + pelanggan + "/" + no_resi);
    });
    //batal pesan kembali ke list
    $(document).on("click", ".batalpesan", function(e) {
        var pelanggan = $(this).attr('id');
        classactive("#list", "#pelanggan, #e_pelanggan, #pesan");
        tampil("list/" + pelanggan, "#tampil");
    });
    //simpan pesanan
    $(document).on("click", "#simpanpesan", function(e) {
        var id = $("#no").val();
        var pelanggan = $('#no_pelanggan').val();
        tambah('simpan/pesanan','#formpesan', "pesanan/" + pelanggan + "/" + id);
    });   
    //validation jumlah
    $(document).on("keyup, keypress", "#jumlah", function(e) {
        validAngka(this);
        nospace(event, this);
    });

    /* #################################### Admin menu #########################*/

    /* #################################### Karyawan ############################## */
    //tampilan tambah karyawan
    $(document).on("click", "#t_karyawan, #li_t_karyawan", function(e) {
        //$("#begin").load('admin/page/karyawan');
        $("#begin").load('admin/page/karyawan', function() {
            //add class untuk aktif
            $("#li_t_karyawan").addClass("active");
            //tampilan tambah karyawan
            tampil("admin/page/tambahkaryawan", "#tampilan");
            //validasi telpon agar nomor
            $("#no_hp").keypress(function(event) {
                validAngka(this);
                nospace(event, this);
            }).keyup(function(event) {
                validAngka(this);
                nospace(event, this);
            });
        });
    });
    //tampilan data karyawan
    $(document).on("click", "#batalkaryawan, #d_karyawan, #li_karyawan", function(e) {
        $("#begin").load('admin/page/karyawan', function() {
            $("#li_karyawan").addClass("active");
            tampil("admin/page/datakaryawan", "#tampilan");
        });
    });
    //edit data karyawan
    $(document).on("click", ".editkar", function(e) {
        var id = $(this).attr('id');
        $("#begin").load('admin/page/karyawan', function() {
            $("#li_e_karyawan").addClass("active");
            tampil("admin/edit/karyawan/no_user/" + id, "#tampilan");
        });
    });
    //tambah data karyawan
    $(document).on("click", "#simpankaryawan", function(e) {
        var data = $("#form-karyawan").serialize();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/simpan/user',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_karyawan", "#begin #li_t_karyawan");
                $('#tampilan').load('admin/page/datakaryawan');
            },
            error: function(data) {
                $('#tampilan').load('admin/page/tambahkaryawan');
            }
        });
    });

    //hapus data karyawan
    $(document).on("click", ".delkar", function(e) {
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url : 'admin/delete/user/' + id,
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                $('#tampilan').load('admin/page/datakaryawan');
            },
            error: function (data) {
                $('#tampilan').load('admin/page/form-failed');
                $('#tampilan').load('admin/page/datakaryawan');

            }
        });
    });

    $(document).on("click", "#btnkaryawan", function(e) {
        var data = $("#editkaryawan").serialize();
        var id = $("#no_user").val();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/edited/user',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_karyawan", "#begin #li_e_karyawan");
                $('#tampilan').load('admin/page/datakaryawan');
            },
            error: function(data) {
                $('#tampilan').load('admin/edit/karyawan/no_user/' + id);
            }
        });
    });

    $(document).on("click", "#inlineCheckbox1", function (e) {
        var cek = $("#inlineCheckbox1").is(":checked");
        if (cek) {
            $("#username").removeAttr('readonly');
        } else {
            $("#username").attr('readonly', 'readonly');
        }
    });

    $(document).on("click", ".edpass", function (e) {
        var id = $(this).attr('id');
        $("#begin").load('admin/page/karyawan', function() {
            $("#li_c_pass").addClass("active");
            tampil("admin/edit/changepass/username/" + id, "#tampilan");
        });
    });

    $(document).on("click", "#btn-pass", function (e) {
        var data = $("#form-pass").serialize();
        var id = $("#username").val();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/edited/pass',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_karyawan", "#begin #li_c_pass");
                $('#tampilan').load('admin/page/datakaryawan');
            },
            error: function(data) {
                $('#tampilan').load('admin/edit/changepass/username/' + id);
            }
        });
    });


    /* #################################### Order ############################## */
    /* #################################### kategori ############################## */
    $(document).on("click", "#kategori, #li_kategori, #btn-c-kategori", function (e) {
        $('#begin').load('admin/page/kategori', function() {
            $('#li_kategori').addClass('active');
            $('#tampilan').load('admin/page/datakategori');
        });
    });
    $(document).on("click", "#e_kat", function (e) {
        var id = $(this).attr('data-id');
        $('#begin').load('admin/page/kategori', function() {
            $('#li_e_kategori').addClass('active');
            $('#tampilan').load('admin/edit/ekat/kode/' + id);
        });
    });
    
    $(document).on("click", "#d_kat", function (e) {
        var id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url : 'admin/delete/kategori/' + id,
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                $('#tampilan').load('admin/page/datakategori');
            },
            error: function (data) {
                $('#tampilan').load('admin/page/form-failed');
                $('#tampilan').load('admin/page/datakategori');

            }
        });
    });
    $(document).on("click", "#btn-e-kategori", function (e) {
        var data = $("#form-kategori").serialize();
        var id = $("#kode_kategori").val();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/edited/kategori',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_kategori", "#begin #li_e_kategori");
                $('#tampilan').load('admin/page/datakategori');
            },
            error: function(data) {
                $('#tampilan').load('admin/edit/ekat/kode/' + id);
            }
        });
    });
    
    $(document).on("click", "#li_t_kategori", function (e) {
        $('#begin').load('admin/page/kategori', function() {
            $('#li_t_kategori').addClass('active');
            $('#tampilan').load('admin/page/tambahkategori');
        });
    });

    $(document).on("click", "#btn-t-kategori", function (e) {
        var data = $("#form-kategori").serialize();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/simpan/kategori',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_kategori", "#begin #li_t_kategori");
                $('#tampilan').load('admin/page/datakategori');
            },
            error: function(data) {
                $('#tampilan').load('admin/page/tambahkategori');
            }
        });
    });

    /* #################################### Type ############################## */
    $(document).on("click", "#type, #li_type, #btn-c-type", function (e) {
        $('#begin').load('admin/page/type', function() {
            $('#li_type').addClass('active');
            $('#tampilan').load('admin/page/datatype');
        });
    });

    $(document).on("click", "#li_t_type", function (e) {
        $('#begin').load('admin/page/type', function() {
            $('#li_t_type').addClass('active');
            $('#tampilan').load('admin/page/tambahtype');
        });
    });

    $(document).on("click", "#btn-t-type", function (e) {
        var data = $("#form-type").serialize();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/simpan/type',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_type", "#begin #li_t_type");
                $('#tampilan').load('admin/page/datatype');
            },
            error: function(data) {
                $('#tampilan').load('admin/page/tambahtype');
            }
        });
    });

    $(document).on("click", "#e_type", function (e) {
        var id = $(this).attr('data-id');
        $('#begin').load('admin/page/type', function() {
            $('#li_e_type').addClass('active');
            $('#tampilan').load('admin/edit/etype/no/' + id);
        });
    });

    $(document).on("click", "#btn-e-type", function (e) {
        var data = $("#form-type").serialize();
        var id = $("#no_type").val();
        $.ajax({
            type: 'POST',
            data: data,
            url : 'admin/edited/type',
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                classactive("#begin #li_type", "#begin #li_e_type");
                $('#tampilan').load('admin/page/datatype');
            },
            error: function(data) {
                $('#tampilan').load('admin/edit/etype/no/' + id);
            }
        });
    });
    $(document).on("click", "#d_type", function (e) {
        var id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url : 'admin/delete/type/' + id,
            success : function(data) {
                // jika data sukses diambil dari server, tampilkan di <select id=kota>
                $('#tampilan').load('admin/page/datatype');
            },
            error: function (data) {
                $('#tampilan').load('admin/page/form-failed');
                $('#tampilan').load('admin/page/datatype');

            }
        });
    });
});