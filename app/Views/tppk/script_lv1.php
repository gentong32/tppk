<script>
    var kolom_angka2 = 2;
    $('#tabel2').DataTable({
        scrollX: teru,
        columnDefs: [{
                targets: kolom_angka2,
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },

            {
                className: 'text-right',
                targets: [(kolom_angka2), (kolom_angka2 + 2)]
            },
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

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
            $(api.column((kolom_angka2)).footer()).html(numFormat(<?= $jml_satgas ?>));
            $(api.column((kolom_angka2)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka2 + 1)).footer()).html(numFormat(<?= $jml_satgas_valid ?>));
            $(api.column((kolom_angka2 + 1)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });
            $(api.column((kolom_angka2 + 2)).footer()).html(numFormat(total2));
            $(api.column((kolom_angka2 + 2)).footer()).css({
                'text-align': 'right',
                'padding-right': '15px'
            });

        },
        "processing": true,
    });
</script>