$.fn.dataTable.Api.register('initSelect2()', function () {
    var options = this.init();
    var self = this;
    $.each(options.select2, function (index, value) {
        self.columns(value).every(function () {
            var column = this;
            var id = 'select2-' + column.index() + '-' + self.table().node().id;
            var colheader = this.header();
            var placeholder = $(colheader).text().trim();
            $('<p></p>').appendTo(colheader);
            var select = $('<select id="' + id + '" class="dt-select2"><option value="" >All</option></select>')
                .appendTo($(column.header()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });

            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d.replace(/<[^>]+>/g, '') + '">' + d.replace(/<[^>]+>/g, '') + '</option>')
            });
            var select2Options = {
                "allowClear": true,
                "theme": "bootstrap",
                "width": "100%",
                "placeholder": placeholder,
                "language": "th",
                "sizeCss": "input-sm"
            };
            if (jQuery('#' + id).data('select2')) {
                jQuery('#' + id).select2('destroy');
            }
            jQuery.when(jQuery('#' + id).select2(select2Options)).done(initS2Loading(id, 'select2Options'));
            $("#" + id + ",span.select2-container--bootstrap").addClass("input-sm");
        });
    });
    return self;
});

$.fn.dataTable.Api.register('initColumnIndex()', function () {
    var self = this;
    self.on('order.dt search.dt draw.dt', function () {
        self.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    return self;
});

$.fn.dataTable.Api.register('rowGrouping()', function () {
    var options = this.init();
    var self = this;
    var rows = self.rows({page: 'current'}).nodes();
    var last = null;
    var colspan = self.columns().data().length;


    self.column(options.rowGroup.column, {page: 'current'}).data().each(function (group, i) {
        if (last !== group) {
            $(rows).eq(i).before(
                '<tr id="row-' + i + '"><td colspan="' + colspan + '">' + group + '</td></tr>'
            );

            if (undefined !== options.rowGroup.rowOptions) {
                $.each(options.rowGroup.rowOptions, function (index, value) {
                    $('#row-' + i).attr(index, value);
                });
            }

            last = group;
        }
    });
    return self;
});

$.fn.dataTable.Api.register('initDeleteConfirm()', function () {
    var self = this;
    $("#"+self.table().node().id + ' tbody').on('click', 'tr td a[data-method="post"]', function (event) {
        event.preventDefault();
        var elm = this;
        var url = $(elm).attr('href');
        var message = $(elm).attr('data-confirm');
        if (typeof url !== typeof undefined && url !== false || typeof url !== typeof undefined && url !== false) {
            swal({
                title: '' + message + '',
                text: "",
                type: "question",
                showCancelButton: true,
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                allowEscapeKey: false,
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            type: $(elm).attr('data-method'),
                            url: $(elm).attr('href'),
                            success: function (data, textStatus, jqXHR) {
                                self.ajax.reload();
                                swal({
                                    type: "success",
                                    title: "Deleted!",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                resolve();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                swal({
                                    type: "error",
                                    title: errorThrown,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            },
                            dataType: "json"
                        });
                    });
                },
            }).then((result) => {
                if (result.value) {
                    swal({
                        type: "success",
                        title: "Deleted!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
        return false;
    });
    return self;
});

