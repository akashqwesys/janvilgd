var global_search_values = [];
var global_search_array = [];
var global_group_id = 0;
var new_call = true;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function(xhr) {
        $(".cs-loader").show();
    }
});

$(document).ready(function() {
    if ($('.filter-toggle').length === 0) {
        $('#filter-toggle').attr('disabled', true);
    }
    setTimeout(() => {
        stop_on_change = 1;
        getDiamonds(global_search_values, global_search_array, global_group_id);
    }, 1000);
});

$(document).on('click', '.diamond-shape .item img', function() {
    var group_id = $(this).attr('data-group_id');
    var src_url = null;
    if ($(this).attr('data-selected') == 1) {
        // $(this).css('border', '4px solid #00000000');
        $(this).attr('data-selected', 0);
        src_url = $(this).attr('src').split('/').pop();
        src_url = src_url.substr(0, src_url.lastIndexOf('.'));
        $(this).attr('src', '/assets/images/d_images/' + src_url + '_b.svg');
    } else {
        // $(this).css('border', '4px solid #D2AB66');
        $(this).attr('data-selected', 1);
        src_url = $(this).attr('src').split('/').pop();
        src_url = src_url.substr(0, src_url.lastIndexOf('.')).slice(0, -2);
        $(this).attr('src', '/assets/images/d_images/' + src_url + '.svg');
    }
    var values = [],
        values_all = [];
    var cnt = 0;
    $('.diamond-shape .item img').each(function(index, element) {
        if ($(this).attr('data-selected') == 1) {
            values.push({ 'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name') });
        } else {
            values_all.push({ 'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name') });
            cnt++;
        }
    });
    new_call = true;
    if (cnt == $('.diamond-shape .item img').length) {
        $('#result-table').DataTable().destroy();
        getDiamonds(values_all, [], group_id);
    } else {
        $('#result-table').DataTable().destroy();
        getDiamonds(values, [], group_id);
    }
});

$(document).ready(function() {
    var table_recent = $("#recent-view").on("draw.dt", function() {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).DataTable({
        "lengthChange": false,
        "bFilter": false,
        "bInfo": false,
        'bSortable': false,
        "ordering": false,
        "sScrollX": "100%",
        "sScrollY": "500",
        "paging": false
    });
    var table_compare = $("#compare-table").on("draw.dt", function() {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).DataTable({
        "lengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        'bSortable': false,
        "sScrollX": "100%",
        "sScrollY": "500",
        "paging": false
    });
});

function getDiamonds(values, array, group_id) {
    if (stop_on_change === 0) {
        global_search_values = values;
        global_search_array = array;
        global_group_id = group_id;
        return false;
    }
    // console.log(stop_on_change);
    var selected_values = [];
    if (values.length > 1 && typeof values == 'string') {
        var strArray = values.split(",");
    }
    if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
        var first_index = array.map(function(e) {
            return e.name;
        }).indexOf(strArray[0]);
        var last_index = array.map(function(e) {
            return e.name;
        }).indexOf(strArray[1]);
        for (let i = first_index; i <= last_index; i++) {
            selected_values.push(array[i]);
        }
    } else if (array.length === 0) {
        selected_values = values;
    } else {
        selected_values = strArray;
    }
    if (global_category == 3) {
        columns_data = [
            { data: 'barcode_tag', name: 'barcode_tag', /* width: '12%' */ },
            { data: 'shape', name: 'shape', /* width: '11%' */ },
            { data: 'carat', name: 'carat', /* width: '15%' */ },
            { data: 'color', name: 'color', /* width: '8%' */ },
            { data: 'clarity', name: 'clarity', /* width: '8%' */ },
            { data: 'cut', name: 'cut', /* width: '8%' */ },
            { data: 'price_per_carat', name: 'price_per_carat', /* width: '12%', */ render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'total', name: 'total', /* width: '12%', */ render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'compare', name: 'compare', /* width: '10%' */ }
        ]
    } else if (global_category == 2) {
        columns_data = [
            { data: 'barcode_tag', name: 'barcode_tag', /* width: '12%' */ },
            { data: 'shape', name: 'shape', /* width: '10%' */ },
            { data: 'makable_cts', name: 'makable_cts', /* width: '12%' */ },
            { data: 'carat', name: 'carat', /* width: '8%' */ },
            { data: 'color', name: 'color', /* width: '8%' */ },
            { data: 'clarity', name: 'clarity', /* width: '8%' */ },
            { data: 'cut', name: 'cut', /* width: '9%' */ },
            { data: 'price_per_carat', name: 'price_per_carat', /* width: '9%', */ render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'total', name: 'total', /* width: '12%', */ render: $.fn.dataTable.render.number(',', '.', 2, '$') },
            { data: 'compare', name: 'compare', /* width: '9%' */ }
        ]
    } else {
        columns_data = [
            { data: 'barcode_tag', name: 'barcode_tag', /* width: '12%' */ },
            { data: 'shape', name: 'shape', /* width: '11%' */ },
            { data: 'makable_cts', name: 'makable_cts', /* width: '15%' */ },
            { data: 'carat', name: 'carat', /* width: '8%' */ },
            { data: 'color', name: 'color', /* width: '8%' */ },
            { data: 'clarity', name: 'clarity', /* width: '8%' */ },
            { data: 'price_per_carat', name: 'price_per_carat', render: $.fn.dataTable.render.number(',', '.', 2, '$'), /* width: '12%' */ },
            { data: 'total', name: 'total', render: $.fn.dataTable.render.number(',', '.', 2, '$'), /* width: '12%' */ },
            { data: 'compare', name: 'compare', /* width: '10%' */ }
        ]
    }

    var table = $('#result-table').DataTable({
        // columnDefs: [{
        //     className: 'control',
        //     orderable: false,
        //     targets: 0
        // }],
        'scrollY': 500,
        'scrollX': true,
        'scroller': {
            loadingIndicator: true
        },
        "lengthMenu": [10, 50, 100, 500, 1000],
        'scrollCollaps': true,
        'buttons': false,
        "lengthChange": false,
        "bInfo": false,
        "processing": true,
        "serverSide": true,
        'deferRender': true,
        "bScrollInfinite": true,
        'colReorder': true,
        // "language": {
        //     "processing": "",
        // },
        "ajax": {
            'url': "/customer/list-diamonds",
            'data': function(data) {
                // $(".cs-loader").show();
                data.params = {
                    'attribute_values': selected_values,
                    'group_id': group_id,
                    'web': 'web',
                    'category': global_category,
                    'category_slug': global_category_slug
                }
            },
            'complete': function(data) {
                $('#result-tab').text('Results (' + data.responseJSON.recordsFiltered + ')');
                $(".cs-loader").hide();
            }
        },
        columns: columns_data,
        "createdRow": function(row, data) {
            $(row).addClass('removable_tr');
            $(row).attr('data-diamond', data['diamond_id']);
            $(row).attr('data-barcode', data['barcode']);
            $(row).attr('data-image', (data['image'].length > 0 ? data['image'][0] : '/assets/images/No-Preview-Available.jpg'));
            $(row).attr('data-name', data['name']);
            $(row).attr('data-price', data['total']);
            $(row).children(':nth-child(1)').addClass('text-center');
            $(row).children(':nth-child(2)').addClass('text-center');
            $(row).children(':nth-child(3)').addClass('text-center');
            $(row).children(':nth-child(4)').addClass('text-center');
            $(row).children(':nth-child(5)').addClass('text-center');
            $(row).children(':nth-child(6)').addClass('text-center');
            $(row).children(':nth-child(7)').addClass('text-center');

            if (global_category == 2) {
                $(row).children(':nth-child(8)').addClass('text-center');
                $(row).children(':nth-child(9)').addClass('text-right');
                $(row).children(':nth-child(10)').addClass('text-center exclude');
            } else {
                $(row).children(':nth-child(8)').addClass('text-right');
                $(row).children(':nth-child(9)').addClass('text-center exclude');
            }
            $(row).children('td').attr('scope', 'col');
        }
    });
    $('#myInput').on('keyup', function() {
        table.search(this.value).draw();
    });
    $(window).resize(function() {
        table.columns.adjust();
    });
}
$(document).on('click', '#result-table tr', function(e) {
    e.preventDefault();
    if ($(e.target).hasClass('checkmark')) {
        $(e.target).siblings('.diamond-checkbox').attr('checked', true);
        $('#compare-table tbody').append($(this).closest('tr')[0].outerHTML);
        $(this).closest('tr').remove();
    } else if ($(e.target).hasClass('add-to-cart')) {
        addToCart($(e.target));
        // $(e.target).trigger('click');
    } else {
        window.open($(this).find('td').eq(0).find('a').eq(0).attr('href'), '_blank');
    }
});
// getDiamonds(global_search_values, global_search_array, global_group_id);

/* $(document).on('click', '#result-table .diamond-checkbox', function() {
    $(this).attr('checked', true);
    $('#compare-table tbody').append($(this).closest('tr')[0].outerHTML);
    $(this).closest('tr').remove();
});
$(document).on('click', '#compare-table .diamond-checkbox', function() {
    $(this).attr('checked', false);
    $('#result-table tbody').append($(this).closest('tr')[0].outerHTML);
    $(this).closest('tr').remove();
}); */
$(document).on('mouseover', '#recent-view tbody tr', function() {
    $('.recent-tab-content .select-diamond-temp').hide();
    $('.recent-tab-content .select-diamond').show();
    $('.recent-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/' + $(this).attr('data-barcode')).text('View Diamond');
    $('.recent-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.recent-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.recent-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('mouseover', '#result-table tbody tr', function() {
    $('.result-tab-content .select-diamond-temp').hide();
    $('.result-tab-content .select-diamond').show();
    $('.result-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/' + $(this).attr('data-barcode')).text('View Diamond');
    $('.result-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.result-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.result-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('mouseover', '#compare-table tbody tr', function() {
    $('.compare-tab-content .select-diamond-temp').hide();
    $('.compare-tab-content .select-diamond').show();
    $('.compare-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/' + $(this).attr('data-barcode')).text('View Diamond');
    $('.compare-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.compare-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.compare-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('click', '.reset-btn', function() {
    location.reload();
});
$(document).on('click', '#filter-toggle', function() {
    if ($('.filter-toggle').height() > 1) {
        $('.filter-toggle').css({
            'visibility': 'hidden',
        });
        $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $(".filter-toggle").animate({ height: '0px' });
    } else {
        $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        $(".filter-toggle").animate({ height: '60px' });
        $('.filter-toggle').css({
            'visibility': 'visible',
        });
    }
});

$(document).on('click', '#export-search-diamond,#export-search-diamond-admin', function() {
    var export_value = $(this).attr('data-export');
    var discount = $("#export-discount").val();
    exportDiamondTables([], [], '', export_value, discount);
});

function exportDiamondTables(values, array, group_id, export_value, discount) {
    var selected_values = [];
    if (values.length > 1 && typeof values == 'string') {
        var strArray = values.split(",");
    }
    if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
        var first_index = array.map(function(e) {
            return e.name;
        }).indexOf(strArray[0]);
        var last_index = array.map(function(e) {
            return e.name;
        }).indexOf(strArray[1]);
        for (let i = first_index; i <= last_index; i++) {
            selected_values.push(array[i]);
        }
    } else if (array.length === 0) {
        selected_values = values;
    } else {
        selected_values = strArray;
    }

    var params_data = {};
    params_data.params = {
        'attribute_values': selected_values,
        'group_id': group_id,
        'category': global_category,
        'export': export_value,
        'discount': discount,
        'category_slug': global_category_slug,
        'web': 'web'
    };

    $.ajax({
        type: 'get',
        url: '/customer/search-diamonds',
        data: params_data,
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {

            var blob = new Blob([response]);

            var link = document.createElement('a');

            link.href = window.URL.createObjectURL(blob);

            if (export_value == 'export') {
                link.download = "Diamonds-data.pdf";
            } else {
                link.download = "Diamonds-data.xlsx";
            }

            link.click();
        },
        error: function(response) {
            // console.log(response);
            $.toast({
                heading: 'Error',
                text: response,
                icon: 'error',
                position: 'top-right'
            });
        }
    });
}

function roundLabel(el) {
    var label_path = $(el[0].target).next('.rs-container').find('.rs-tooltip');
    label_path.text(parseFloat(label_path.text()).toFixed(2));
}
onchange_call = false;