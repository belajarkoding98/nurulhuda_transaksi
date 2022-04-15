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
        scrollX: true,
        oLanguage: {
            sProcessing: "loading..."
        },
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Show all']
        ],
        "order": [
            [0, 'asc']
        ],
        ajax: {
            "url": base_url + "nasabah/data",
            "type": "POST",
        },
        columns: [{
                'data': 'id',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                   }
            },
            {
                'data': "id_nasabah"
            },
            {
                'data': "nps"
            },
            {
                'data': "nama_nasabah",
                render: function(data, type, row, meta) {
                    return '<a href="' + window.location.origin + '/' + 'transaksi_nasabah/' + row.nps + '">' + row.nama_nasabah + '</a>';
                }

            },
            {
                'data': "orang_tua"
            },
            {
                'data': "kode_kelas"
            },
            {
                'data': "saldo_utama",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' )
            },
            {
                'data': "saldo_sementara",
                render: $.fn.dataTable.render.number( '\.', '.', 0, 'Rp. ' )
            },
            {
                "data": null,
            },
        ],
        "columnDefs": [{
            "data": {
                "id": "id",
            },
            "targets": 8,
            "orderable": false,
            "searchable": false,
            "render": function(data, type, row, meta) {
                let btn;
                if (checkLogin == 1 || checkLogin == 0) {
                    return `
                        <a href="${base_url}nasabah/update/${data.id}" title="edit" class="btn btn-md btn-warning  btn-edit-data">
                        <i class="fa fa-pencil-square-o"></i> Edit
                        </a>
                        <a href="${base_url}nasabah/delete/${data.id}" title="hapus" class="btn btn-md btn-danger btn3d btn-remove-data">
                        <i class="fa fa-trash"></i> Hapus
                        </a>`;
                }
            }
        }, 

    ],
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
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total_ss = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            pageTotal_ss = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $( api.column( 6 ).footer() ).html('UTAMA : '+formatRupiah(pageTotal)+' ('+formatRupiah(total)+' Total) |'+'SEMENTARA : '+formatRupiah(pageTotal_ss)+' ('+formatRupiah(total_ss)+' Total)');
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

            var hasRows = this.api().rows({ filter: 'applied' }).data().length > 0;
            $('#importsaldo')[0].style.visibility = hasRows ? 'visible' : 'hidden'
        },
    });
    // $('#mytable tbody').on('click', '.name', function() {
    //     var row = $(this).closest('tr');

    //     var data = table.row(row).data().name;
    //     console.log(data);
    // });

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