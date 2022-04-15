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
            "url": base_url + "nasabah/detaildata/",
            "type": "POST",
            "data": { 'id': UriSegment },
        },
        columns: [{
                'data': 'id',
                defaultContent: ''
            },
            {
                'data': "nps",
                render: function(data, type, row, meta) {
                    if (row.kredit == 0) {
                        return `
                            <a title="Debit" class="btn btn-md btn-danger btn-upload">
                            <i class="fa fa-upload"></i> DEBIT
                            </a>`;
                        }else{
                        return `
                            <a title="Debit" class="btn btn-md btn-success btn-upload">
                            <i class="fa fa-download"></i> KREDIT
                            </a>`;
    
                    }
                }

            },
            {
                'data': "tanggal"
            },
            {
                'data': "id_transaksi"
            },
            {
                'data': "id_nasabah"
            },
            {
                'data': "nps"
            },
            {
                'data': "kredit",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' )
            },
            {
                'data': "debit",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' ),
            },
            {
                'data': "saldo",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' )
            },
            {
                'data': "keterangan"
            },

            {
                "data": null,
            },
        ],
        "columnDefs": [{
            "data": {
                "id": "id",
            },
            "targets": 10,
            "orderable": false,
            "searchable": false,
            "render": function(data, type, row, meta) {
                let btn;
                if (checkLogin == 1 || checkLogin == 0) {
                    return `
                        <a href="${base_url}nasabah/deletetransaksi/${row.id_transaksi}" title="hapus" class="btn btn-md btn-danger btn3d btn-remove-data">
                        <i class="fa fa-trash"></i> Hapus
                        </a>`;
                }
            }
        },
    ],
    "fnRowCallback": function(row, data, dataIndex ) {
        if (data['debit'] == "0") {
          $('td', row).css('background-color', '#defff1');
        } else if (data['kredit'] == "0") {
          $('td', row).css('background-color', '#feeeea');
        }
      },
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api();

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\Rp.,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        /* Fungsi formatRupiah */
        var formatRupiah = $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' ).display;

        // Total over all pages
        total = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total_ss = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            var saldo = total_ss - total;
        // Update footer
        $('#saldo').html(formatRupiah(saldo));
    },
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
                title: 'Data Transaksi '+NamaNasabah,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'copy',
                title: 'Data Transaksi '+NamaNasabah,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Data Transaksi '+NamaNasabah ,
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
                title: 'Data Transaksi '+NamaNasabah,
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

            var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
            $('#tariktunai')[0].style.visibility = hasRows ? 'visible' : 'hidden'
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