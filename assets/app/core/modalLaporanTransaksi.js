
$(() => {
    $(document.getElementsByClassName('input-daterange')).datepicker({
        todayBtn: 'linked',
        format: "dd-mm-yyyy",
        autoclose: true,
    });

    $(document.getElementById('search')).click(() => {
        var start = $(document.getElementById('start')).val();
        var end = $(document.getElementById('end')).val();
        if (start != '' && end != '') {
            LoadDate(id);
        } else {
            alert("Tanggal keduanya harus di isi!");
        }
    });

});

$('#search').click(function(){
    table.draw();
});


var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min =  $(document.getElementById('start')).val();
        var max = $(document.getElementById('end')).val();
        var date = new Date( data[4] );
        alert(min+max)
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);
 
$(document).ready(function() {
    // Create date inputs
    minDate = new DateTime($('#start'), {
        format: 'dd-mm-yyyy'
    });
    maxDate = new DateTime($('#end'), {
        format: 'dd-mm-yyyy'
    });
 
    // DataTables initialisation
    var table = $('#mytable').DataTable();
 
    // Refilter the table
    $('#start, #end').on('change', function () {
        alert('sukses');
       
    });
});