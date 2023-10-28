<script>
    var kolom_angka2 = 3;
    var table = $('#tabel2').DataTable({
        scrollX: teru,
        columnDefs: [{
                targets: kolom_angka2,
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },
            {
                targets: 3, // Kolom "Age"
                visible: true // Sembunyikan kolom saat inisialisasi
            },
            {
                className: 'text-right',
                targets: [2, (kolom_angka2), (kolom_angka2 + 1), (kolom_angka2 + 2), (kolom_angka2 + 3)]
            },
            // {
            //     "targets": [6],
            //     "createdCell": function(td, cellData, rowData, row, col) {
            //         var kolom4 = parseFloat(rowData[4]);
            //         var kolom5 = parseFloat(rowData[5]);
            //         var persentase = (kolom5 / kolom4) * 100;
            //         $(td).text(persentase.toFixed(2) + '%');
            //     }
            // }
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            var totalPersentase = 0;

            // converting to interger to find total
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            var total1 = api
                .column((kolom_angka2))
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var total2 = api
                .column((kolom_angka2 + 1))
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var total3 = api
                .column((kolom_angka2 + 2))
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            // Update footer by showing the total with the reference of the column index
            var numFormat = $.fn.dataTable.render.number('.', ',', 0, '').display;

            $(api.column(0).footer()).html('');
            $(api.column(1).footer()).html('TOTAL SEMUA');
            $(api.column(2).footer()).html('');

            $(api.column((3)).footer()).html(numFormat(total1));
            $(api.column((3)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka2 + 1)).footer()).html(numFormat(total2));
            $(api.column((kolom_angka2 + 1)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka2 + 2)).footer()).html(numFormat(total3));
            $(api.column((kolom_angka2 + 2)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });

            totalPersentase = total3 / total2 * 100;
            $(this.api().column(6).footer()).html(totalPersentase.toFixed(2) + '%');
            $(this.api().column(6).footer()).css({
                'text-align': 'right',
                'padding-right': '0px'
            });

        },
        "processing": true,
    });

    // table.columns().every(function(index) {
    //     this.visible(true); // Tampilkan kolom kembali
    //     this.columns.adjust().draw(); // Atur ulang lebar kolom
    //     this.visible(index !== 3); // Sematikan kolom dengan indeks 1 (kolom "Age")
    // });
</script>