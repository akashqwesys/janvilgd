var stop_on_change = 0;
var global_search_values = [];
var global_search_array = [];
var global_group_id = 0;
var new_call = true;
var onchange_call = true;
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
        getAttributeValues1(global_search_values, global_search_array, global_group_id);
    }, 1000);
});
$(document).on('click', '.diamond-shape .item img', function() {
    var group_id = $(this).attr('data-group_id');
    var src_url = null;
    if ($(this).attr('data-selected') == 1) {
        // $(this).css('border', '4px solid #00000000');
        $(this).attr('data-selected', 0);
        src_url = $(this).attr('src').split('/').pop();
        src_url = src_url.substr(0, src_url.lastIndexOf('.')).slice(0, -2);
        $(this).attr('src', '/assets/images/d_images/' + src_url + '.svg');
    } else {
        // $(this).css('border', '4px solid #D2AB66');
        $(this).attr('data-selected', 1);
        src_url = $(this).attr('src').split('/').pop();
        src_url = src_url.substr(0, src_url.lastIndexOf('.'));
        $(this).attr('src', '/assets/images/d_images/' + src_url + '_b.svg');
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
        getAttributeValues1(values_all, [], group_id);
    } else {
        $('#result-table').DataTable().destroy();
        getAttributeValues1(values, [], group_id);
    }
});

var status_load = 0;

function getAttributeValues1(values, array, group_id) {
    if (new_call === true) {
        global_data_offset = 0;
        $(".cs-loader").show();
    }

    if (stop_on_change === 0) {
        global_search_values = values;
        global_search_array = array;
        global_group_id = group_id;
        return false;
    }
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

    var offset_value = 0;
    // alert(global_data_offset);
    // console.log(selected_values);
    var ajax_data = {
        'attribute_values': selected_values,
        'group_id': group_id,
        'web': 'web',
        'category': global_category,
        'category_slug': global_category_slug,
        'offset': offset_value,
        'scroll': 'no'
    };

    var table = $('#result-table').DataTable({
        // "processing": true,
        // "serverSide": true,
        "lengthChange": false,
        // "bFilter": false,
        "bInfo": false,
        'bSortable': true,
        "sScrollX": "100%",
        "paging": false, //Dont want paging

        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: 0
        }],

        "ajax": {
            'method': "post",
            'url': "/customer/search-diamonds",
            'data': ajax_data,
            'complete': function() {
                $('.cs-loader').hide();
                // if (status_load === 0) {
                //     lazy_load_scroll();
                // }
                status_load = 1;
                global_search_values = values;
                global_search_array = array;
                global_group_id = group_id;

                $("#offset_value").val(parseInt(offset_value) + parseInt(25));
                //set ajax_in_progress object false, after completion of ajax call
                $(window).data('ajax_in_progress', false);
                onchange_call = true;
            }
        },
        columns: [
            { data: 'barcode', name: 'barcode' },
            { data: 'shape', name: 'shape' },
            { data: 'carat', name: 'carat' },
            { data: 'color', name: 'color' },
            { data: 'clarity', name: 'clarity' },
            { data: 'cut', name: 'cut' },
            { data: 'total', name: 'total' },
            { data: 'total', name: 'total' },
            { data: 'compare', name: 'compare' }
        ],
        "createdRow": function(row, data, dataIndex) {
            $(row).addClass('removable_tr');
            $(row).attr('data-diamond', data['_source']['diamond_id']);
            $(row).attr('data-barcode', data['_source']['barcode']);
            $(row).attr('data-image', (data['_source']['image'].length > 0 ? data['_source']['image'][0] : '/assets/images/No-Preview-Available.jpg'));
            $(row).attr('data-name', data['_source']['name']);
            $(row).attr('data-price', data['total']);
            $(row).children(':nth-child(1)').addClass('text-center');
            $(row).children(':nth-child(2)').addClass('text-center');
            $(row).children(':nth-child(3)').addClass('text-right');
            $(row).children(':nth-child(4)').addClass('text-center');
            $(row).children(':nth-child(5)').addClass('text-center');
            $(row).children(':nth-child(6)').addClass('text-center');
            $(row).children(':nth-child(7)').addClass('text-right');
            $(row).children(':nth-child(8)').addClass('text-right');
            $(row).children(':nth-child(9)').addClass('text-center');
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

function getAttributeValues(values, array, group_id) {
    if (stop_on_change === 0) {
        global_search_values = values;
        global_search_array = array;
        global_group_id = group_id;
        return false;
    }
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
    // console.log(selected_values);
    var ajax_data = {
        'attribute_values': selected_values,
        'group_id': group_id,
        'web': 'web',
        'category': global_category,
        'category_slug': global_category_slug,
        'offset': global_data_offset
    };
    var offset_value_1 = $("#offset_value").val();
    $.ajax({
        beforeSend: function(xhr) {
            if (new_call === true) {
                $(".cs-loader").show();
            }
        },
        type: "post",
        url: "/customer/search-diamonds",
        data: {
            'attribute_values': selected_values,
            'group_id': group_id,
            'web': 'web',
            'category': global_category,
            'category_slug': global_category_slug,
            'offset': offset_value_1,
            'scroll': 'yes'
        },
        // cache: false,
        dataType: "json",
        success: function(response) {
            $('.cs-loader').hide();
            global_search_values = values;
            global_search_array = array;
            global_group_id = group_id;

            $('#result-table .removable_tr').last().after(response.data);

            // processing = false;

            $("#offset_value").val(parseInt(response.offset));
            // global_data_offset = response.offset;
            //set ajax_in_progress object false, after completion of ajax call
            $(window).data('ajax_in_progress', false);
        },
        failure: function(response) {
            $('.cs-loader').hide();
            $.toast({
                heading: 'Error',
                text: 'Oops, something went wrong...!',
                icon: 'error',
                position: 'top-right'
            });
        }
    });
}

function lazy_load_scroll() {
    var lastScrollTop = 0,
        delta = 5;
    $(table_scroll).scroll(function() {
        var nowScrollTop = $(this).scrollTop();
        //check if any other ajax request is already in progress or not, if true then it exit here
        if ($(window).data('ajax_in_progress') === true)
            return;
        //check, whether we reached at the bottom of page or not, true when we reach at the bottom
        if (Math.abs(lastScrollTop - nowScrollTop) >= delta) {
            if (nowScrollTop > lastScrollTop) {
                // if ($(table_scroll).scrollTop() > ($('#result-table').height() * 80 / 100) - $(table_scroll).height()) {
                //set ajax_in_progress object true, before making a ajax call
                $(window).data('ajax_in_progress', true);
                new_call = false;

                //make ajax call
                // $('#result-table').DataTable().destroy();
                getAttributeValues(global_search_values, global_search_array, global_group_id);
                // }
            }
            lastScrollTop = nowScrollTop;
        }
    });
}
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