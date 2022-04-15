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
            [0, 'asc']
        ],
        ajax: {
            "url": base_url + "tahunajaran/data",
            "type": "POST",
        },
        columns: [
            { 'data': 'id', defaultContent: '' },
            { 'data': "kode_ta" },
            { 'data': "tahun_ajaran" },
            { 'data': "status" },
            {
                "data": null,
            },
        ],
        "columnDefs": [{
            "data": {
                "id": "id",
            },
            "targets": 4,
            "orderable": false,
            "searchable": false,
            "render": function(data, type, row, meta) {
                let btn;
                if (checkLogin == 1) {
                    return `
                        <a href="${base_url}tahunajaran/update/${data.id}" title="edit" class="btn btn-md btn-warning  btn-edit-data">
                        <i class="fa fa-pencil-square-o"></i> Edit
                        </a>
                        <a href="${base_url}tahunajaran/delete/${data.id}" title="hapus" class="btn btn-md btn-danger btn3d btn-remove-data">
                        <i class="fa fa-trash"></i> Hapus
                        </a>`;
                }
            }
        }, ],
        dom: 'Blfrtip',
        buttons: [
            'colvis',
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: 'excel',
                title: 'Data Tahun Ajaran',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: 'copy',
                title: 'Data Tahun Ajaran',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: 'pdf',
                oriented: 'portrait',
                pageSize: 'legal',
                title: 'Data Tahun Ajaran',
                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
                customize: function(doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyOdd.alignment = 'center';
                },
            },
            {
                extend: 'print',
                oriented: 'portrait',
                pageSize: 'A4',
                title: 'Data Tahun Ajaran',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
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
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
        },
    });
    table.on('order.dt search.dt', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
            table.cell(cell).invalidate('dom');
        });
    }).draw();

    if (checkLogin == 0) {
        $('.btn-create-data').hide();
        $('.btn-warning').css("display", "none");
    }
});