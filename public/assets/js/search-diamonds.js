var global_search_values = [];
var global_search_array = [];
var global_group_id = 0;
var new_call = true;

function getDiamonds(values, array, group_id) {
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
    var ajax_data = {
        'attribute_values': selected_values,
        'group_id': group_id,
        'web': 'web',
        'category': global_category,
        'category_slug': global_category_slug
    };
    if (global_category == 3) {
        columns_data = [
            { data: 'barcode', name: 'barcode' },
            { data: 'shape', name: 'shape' },
            { data: 'carat', name: 'carat' },
            { data: 'color', name: 'color' },
            { data: 'clarity', name: 'clarity' },
            { data: 'cut', name: 'cut' },
            { data: 'price_per_carat', name: 'price_per_carat' },
            { data: 'total', name: 'total' },
            { data: 'compare', name: 'compare' }
        ]
    } else {
        columns_data = [
            { data: 'barcode', name: 'barcode' },
            { data: 'shape', name: 'shape' },
            { data: 'carat', name: 'carat' },
            { data: 'color', name: 'color' },
            { data: 'clarity', name: 'clarity' },
            { data: 'price_per_carat', name: 'price_per_carat' },
            { data: 'total', name: 'total' },
            { data: 'compare', name: 'compare' }
        ]
    }

    var table = $('#result-table').DataTable({
        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: 0
        }],
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
        "pageLength": 100,
        'deferRender': true,
        "bScrollInfinite": true,
        "ajax": {
            'url': "/customer/list-diamonds",
            'data': function(data) {
                data.params = {
                    'attribute_values': selected_values,
                    'group_id': group_id,
                    'web': 'web',
                    'category': global_category,
                    'category_slug': global_category_slug
                }
            },
            'complete': function() {
                $('#result-tab').text('Results (' + $('#result-table tbody tr').length + ')');
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
            $(row).children(':nth-child(3)').addClass('text-right');
            $(row).children(':nth-child(4)').addClass('text-center');
            $(row).children(':nth-child(5)').addClass('text-center');

            if (global_category == 3) {
                $(row).children(':nth-child(6)').addClass('text-center');
                $(row).children(':nth-child(7)').addClass('text-right');
                $(row).children(':nth-child(8)').addClass('text-right');
                $(row).children(':nth-child(9)').addClass('text-center');
            } else {
                $(row).children(':nth-child(6)').addClass('text-right');
                $(row).children(':nth-child(7)').addClass('text-right');
                $(row).children(':nth-child(8)').addClass('text-center');
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
getDiamonds(global_search_values, global_search_array, global_group_id);
$(document).on('click', '#result-table .diamond-checkbox', function() {
    $(this).attr('checked', true);
    $('#compare-table tbody').append($(this).closest('tr')[0].outerHTML);
    $(this).closest('tr').remove();
});
$(document).on('click', '#compare-table .diamond-checkbox', function() {
    $(this).attr('checked', false);
    $('#result-table tbody').append($(this).closest('tr')[0].outerHTML);
    $(this).closest('tr').remove();
});
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
        $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $('.filter-toggle').css({
            'height': 0,
            'visibility': 'collapse'
        });
    } else {
        $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        $('.filter-toggle').css({
            'height': 'auto',
            'visibility': 'visible'
        });
    }
});

$(document).on('click', '#export-search-diamond,#export-search-diamond-admin', function() {
    var group_id = $(this).attr('data-group_id');
    var export_value = $(this).attr('data-export');
    var discount = $("#export-discount").val();
    if ($(this).attr('data-selected') == 1) {
        $(this).css('border', '4px solid #00000000');
        $(this).attr('data-selected', 0);
    } else {
        $(this).css('border', '4px solid #D2AB66');
        $(this).attr('data-selected', 1);
    }
    var values = [];
    $('.diamond-shape .item img').each(function(index, element) {
        if ($(this).attr('data-selected') == 1) {
            values.push({ 'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name') });
        }
    });
    exportDiamondTables(values, [], group_id, export_value, discount);
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

    $.ajax({
        type: 'post',
        url: '/customer/search-diamonds',
        data: {
            'attribute_values': selected_values,
            'group_id': group_id,
            'category': global_category,
            'export': export_value,
            'discount': discount
        },
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
        error: function(blob) {
            console.log(blob);
        }
    });
}

function roundLabel(el) {
    var label_path = $(el[0].target).next('.rs-container').find('.rs-tooltip');
    label_path.text(parseFloat(label_path.text()).toFixed(2));
}
onchange_call = false;