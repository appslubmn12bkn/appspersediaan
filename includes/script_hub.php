<script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function() {
    Pace.restart()
  })
  $('.ajax').click(function() {
    $.ajax({
      url: '#',
      success: function(result) {
        $('.ajax-content').html('<hr>Ajax Request Completed !')
      }
    })
  })

  function sum() {
    var txtFirstNumberValue = document.getElementById('acc_qty').value;
    var txtSecondNumberValue = document.getElementById('seriAW').value;
    var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) - 1;
    if (!isNaN(result)) {
      document.getElementById('seriAK').value = result;
    }
  }

  function sum2() {
    var txtFirstNumberValue = document.getElementById('qty').value;
    var txtSecondNumberValue = document.getElementById('nupAW').value;
    var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) - 1;
    if (!isNaN(result)) {
      document.getElementById('nupAK').value = result;
    }
  }
</script>
<script type="text/javascript">
  $("#unut").change(function() {
    // variabel dari nilai combo box provinsi
    var r_idutama = $("#unut").val();
    // tampilkan image load
    $("#imgLoad").show("");
    // mengirim dan mengambil data
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "_set/ambilruang.php",
      data: "unut=" + r_idutama,
      success: function(msg) {
        // jika tidak ada data
        if (msg == '') {
          alert('Tidak ada data unit kerja');
        }
        // jika dapat mengambil data,, tampilkan di combo box kota
        else {
          $("#r_unit").html(msg);
        }
        // hilangkan image load
        $("#imgLoad").hide();
      }
    });
  });
</script>
<script type="text/javascript">
$(document).ready(function(){

 $('#NIP1').change(function(){    // KETIKA ISI DARI FIEL 'NPM' BERUBAH MAKA ......
  var NIP1fromfield = $('#NIP1').val();  // AMBIL isi dari fiel NPM masukkan variabel 'npmfromfield'
  $.ajax({        // Memulai ajax
    method: "POST",      
    url: "_set/ambildatapegawai.php",    // file PHP yang akan merespon ajax
    data: { NIP1: NIP1fromfield}   // data POST yang akan dikirim
  })
    .done(function( hasilajax ) {   // KETIKA PROSES Ajax Request Selesai
        $('#NAMA1').val(hasilajax);  // Isikan hasil dari ajak ke field 'nama' 
    });
 })
});

$(document).ready(function(){

 $('#NIP2').change(function(){    // KETIKA ISI DARI FIEL 'NPM' BERUBAH MAKA ......
  var NIP2fromfield = $('#NIP2').val();  // AMBIL isi dari fiel NPM masukkan variabel 'npmfromfield'
  $.ajax({        // Memulai ajax
    method: "POST",      
    url: "_set/ambildatapegawai2.php",    // file PHP yang akan merespon ajax
    data: { NIP2: NIP2fromfield}   // data POST yang akan dikirim
  })
    .done(function( hasilajax ) {   // KETIKA PROSES Ajax Request Selesai
        $('#NAMA2').val(hasilajax);  // Isikan hasil dari ajak ke field 'nama' 
    });
 })
});
</script>
    <script>
        $(document).ready(function () {
            $('#cari').select2({
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Pilih Kode BMN',
                ajax: {
                    dataType: 'json',
                    url: '_set/tabelbmn.php',
                    delay: 800,
                    data: function (params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function (data, page) {
                        return {
                            results: data
                        };
                    },
                }
            })
        });
    </script>
<script>
  
  $('#table_3').DataTable({
    "lengthMenu": [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"]
    ],
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ baris",
      "zeroRecords": "Maaf - Data tidak ada",
      "infoEmpty": "Tidak ada data",
      "infoFiltered": "(pencarian dari _MAX_ data)"
    },
    "responsive": true,
    "stateSave": true // keep paging
  });
  

  $('#table_1').DataTable({
    "lengthMenu": [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"]
    ],
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ baris",
      "zeroRecords": "Maaf - Data tidak ada",
      "infoEmpty": "Tidak ada data",
      "infoFiltered": "(pencarian dari _MAX_ data)"
    },
    "responsive": true,
    "stateSave": true // keep paging
  });

    $('#table_2').DataTable({
    "lengthMenu": [
      [3, 10, 25, 50, 100, -1],
      [3, 10, 25, 50, 100, "All"]
    ],
    paging: true,
    searching: false,
    ordering: false,
    info: false,
    "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ baris",
      "zeroRecords": "Maaf - Data tidak ada",
      "infoEmpty": "Tidak ada data",
      "infoFiltered": "(pencarian dari _MAX_ data)"
    },
    "responsive": true,
    "stateSave": true // keep paging
  });

    $('#table_4').DataTable({
      'paging'      : false,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ baris",
      "zeroRecords": "Maaf - Data tidak ada",
      "infoEmpty": "Tidak ada data",
      "infoFiltered": "(pencarian dari _MAX_ data)"
    },
    "responsive": true,
    "stateSave": true // keep paging
    })
  </script>

<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2({
    minimumInputLength: 5
    });

    $('.s2').select2();

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<script>
document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);
</script>