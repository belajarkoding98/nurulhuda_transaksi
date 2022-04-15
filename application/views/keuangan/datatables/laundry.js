let table;

$(document).ready(function() {
    table = $("#mytable").addClass('nowrap').DataTable({
       
        initComplete: function() {
            let api = this.api();
            $('#karyawan_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    api.search(this.value).draw();
                });
        },
        responsive: true,
        processing: true,
        serverSide: true,
        colReorder: true,
        oLanguage: {
            sProcessing: "loading..."
        },
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Show all']
        ],
        "order": [
            [3, 'desc']
        ],
        ajax: {
            "url": base_url + "laporan/laundrydata",
            "type": "POST",
        },
        columns: [{
                'data': 'id',
                defaultContent: ''
            },
            {
                'data': "tanggal"
            },
            {
                'data': "id_transaksi"
            },
            {
                'data': "nps"
            },
            {
                'data': "nama_nasabah"
            },
            {
                'data': "debit",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' ),
            },
            {
                'data': "keterangan"
            },
        ],
    
    dom: 'Bfrtip',
        buttons: [
            'colvis',
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'excel',
                title: 'Data Transaksi '+Tanggal,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'copy',
                title: 'Data Transaksi '+Tanggal,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Data Transaksi '+Tanggal ,
                orientation: 'landscape',
                pageSize: 'A4',
                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
                customize: function(doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyOdd.alignment = 'center';
                },
            },
            {
                extend: 'print',
                oriented: 'landscape',
                pageSize: 'A4',
                title: 'Data Transaksi '+Tanggal,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
        ],
        initComplete: function() {
            var $buttons = $('.dt-buttons').hide();
            $('#exportLink').on('change', function() {
                var btnClass = $(this).find(":selected")[0].id ?
                    '.buttons-' + $(this).find(":selected")[0].id :
                    null;
                if (btnClass) $buttons.find(btnClass).click();
            })
        },
        rowId: function(a) {
            return a;
        },
        drawCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
        },
    });
    // $('#mytable tbody').on('click', '.name', function() {
    //     var row = $(this).closest('tr');

    //     var data = table.row(row).data().name;
    //     console.log(data);
    // });

    var formatRupiah = $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' ).display;

    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
            table.cell(cell).invalidate('dom');
        });
    }).draw();

    if (checkLogin == 0) {
        $('.btn-create-data').hide();
        $('.btn-warning').css("display", "none");
    }
});