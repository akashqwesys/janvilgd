var global_search_values = [];
var global_search_array = [];
var global_group_id = 0;
var new_call = true;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function(xhr) {
        // $(".cs-loader").show();
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
    global_data_offset = 0;
    $("#result-table tbody").html("");
    if (cnt == $('.diamond-shape .item img').length) {
        getDiamonds(values_all, [], group_id);
    } else {
        getDiamonds(values, [], group_id);
    }
});
$(document).on('keyup', '#myInput', function(e) {
    if ([32, 9, 18, 16, 17, 20, 37, 38, 39, 40].includes(e.which)) {
        return;
    }
    global_data_offset = 0;
    $('#result-table tbody').html('');
    new_call = true;
    getDiamonds(global_search_values, global_search_array, global_group_id);
});
$(document).on('click', '#result-table thead th', function() {
    if ($(this).attr('data-name') == 'compare') {
        return;
    }
    $('#result-table tbody').html('');
    global_sort_column = $(this).attr('data-name');
    if ($(this).hasClass('sorting_asc')) {
        $(this).removeClass('sorting_asc').addClass('sorting');
        global_sort_order = 'desc';
    } else {
        $('#result-table thead .sorting_yes').removeClass('sorting_asc').addClass('sorting');
        $(this).removeClass('sorting').addClass('sorting_asc');
        global_sort_order = 'asc';
    }
    global_data_offset = 0;
    new_call = true;
    getDiamonds(global_search_values, global_search_array, global_group_id);
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

    var params_data = {};
    params_data.params = {
        'attribute_values': selected_values,
        'group_id': group_id,
        'category': global_category,
        'category_slug': global_category_slug,
        'web': 'web',
        'column': global_sort_column,
        'asc_desc': global_sort_order,
        'search_barcode': $('#myInput').val(),
        'offset': global_data_offset
    };

    $.ajax({
        beforeSend: function(xhr) {
            if (new_call === true) {
                $(".cs-loader").show();
            }
        },
        type: "post",
        url: "/customer/list-diamonds",
        data: params_data,
        // cache: false,
        dataType: "json",
        success: function(response) {
            $('.cs-loader').hide();
            global_search_values = values;
            global_search_array = array;
            global_group_id = group_id;
            global_filter_data = response.data;
            if (new_call === true) {
                $('#result-tab').text('Results (' + response.count + ')');
            }

            if (global_filter_data.length > 0) {
                for (let i = 0; i < global_filter_data.length; i++) {
                    $('#result-table tbody').append(global_filter_data[i]);
                }
            } else if (new_call === true && response.count < 1) {
                $('.result-tab-content .select-diamond-temp').show();
                $('.result-tab-content .select-diamond').hide();
                // $('#result-table tbody').html('<tr class="no-data"><td class="text-center" colspan="9">No records found</td></tr>');
            }
            //set ajax_in_progress object false, after completion of ajax call
            // $(window).data('ajax_in_progress', false);
            new_call = false;
            var lastScrollTop = 0,
                delta = 5;
            setTimeout(() => {
                // lazy_load_scroll();
                $(table_scroll).scroll(function() {
                    var nowScrollTop = $(this).scrollTop();
                    if (Math.abs(lastScrollTop - nowScrollTop) >= delta) {
                        if (nowScrollTop > lastScrollTop && lastScrollTop != 0 && global_filter_data.length > 1) {
                            clearTimeout($.data(this, 'scrollTimer'));
                            $.data(this, 'scrollTimer', setTimeout(function() {
                                global_data_offset += 50;
                                getDiamonds(global_search_values, global_search_array, global_group_id);
                            }, 250));
                        }
                        lastScrollTop = nowScrollTop;
                    }
                });
            }, 500);
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

function loadMoreData() {
    if (global_filter_data.length > 0) {
        for (let i = global_data_offset; i < (global_data_offset + 50); i++) {
            $('#result-table tbody').append(global_filter_data[i]);
        }
        global_data_offset += 50;
        setTimeout(() => {
            lazy_load_scroll();
        }, 500);
    } else {
        // $('#result-table tbody').html('<tr><td class="text-center" colspan="9">No records found</td></tr>');
    }
}

function lazy_load_scroll() {
    var lastScrollTop = 0,
        delta = 5;
    $(table_scroll).scroll(function() {
        var nowScrollTop = $(this).scrollTop();
        // console.log($(window).data('ajax_in_progress'));
        //check if any other ajax request is already in progress or not, if true then it exit here
        // if ($(window).data('ajax_in_progress') === true)
        //     return;
        //check, whether we reached at the bottom of page or not, true when we reach at the bottom
        if (Math.abs(lastScrollTop - nowScrollTop) >= delta) {
            if (nowScrollTop > lastScrollTop) {
                // console.log(123);
                // if ($(table_scroll).scrollTop() > ($('#result-table').height() * 80 / 100) - $(table_scroll).height()) {
                getDiamonds(global_search_values, global_search_array, global_group_id);
                // }
                //set ajax_in_progress object true, before making a ajax call
                $(window).data('ajax_in_progress', true);
                // new_call = false;
            }
            lastScrollTop = nowScrollTop;
        }
    });
}

$(document).on('click', '#result-table tbody tr', function(e) {
    e.preventDefault();
    if ($(e.target).hasClass('checkmark')) {
        if ($(e.target).siblings('.diamond-checkbox').attr('checked') == 'checked') {
            $(e.target).siblings('.diamond-checkbox').attr('checked', false);
            $('#compare-table tbody tr[data-diamond=' + $(e.target).siblings('.diamond-checkbox').attr('data-id') + ']').remove();
            $('#comparision-tab span').text(parseInt($('#comparision-tab span').text()) - 1);
        } else {
            $(e.target).siblings('.diamond-checkbox').attr('checked', true);
            $('#compare-table tbody').append($(this).closest('tr')[0].outerHTML);
            $('#comparision-tab span').text(parseInt($('#comparision-tab span').text()) + 1);
        }
        // $(this).closest('tr').remove();
    } else if ($(e.target).hasClass('add-to-cart')) {
        addToCart($(e.target));
        // $(e.target).trigger('click');
    } else if ($(e.target).hasClass('show-certi')) {
        window.open($(this).find('td').eq(0).find('a').eq(0).attr('href'), '_blank');
    } else {
        window.open($(this).find('td').eq(0).find('a').eq(1).attr('href'), '_blank');
    }
});
$(document).on('click', '#compare-table tbody tr', function(e) {
    e.preventDefault();
    if ($(e.target).hasClass('checkmark')) {
        $('#result-table tbody tr[data-diamond="' + $(e.target).siblings('.diamond-checkbox').attr('data-id') + '"]').find('.diamond-checkbox').attr('checked', false);
        $('#comparision-tab span').text(parseInt($('#comparision-tab span').text()) - 1);
        $(this).closest('tr').remove();
    } else if ($(e.target).hasClass('add-to-cart')) {
        addToCart($(e.target));
    } else if ($(e.target).hasClass('show-certi')) {
        window.open($(this).find('td').eq(0).find('a').eq(0).attr('href'), '_blank');
    } else {
        window.open($(this).find('td').eq(0).find('a').eq(1).attr('href'), '_blank');
    }
});
$(document).on('click', '#recent-view tbody tr', function(e) {
    e.preventDefault();
    if ($(e.target).hasClass('add-to-cart')) {
        addToCart($(e.target));
    } else {
        window.open($(this).find('td').eq(0).find('a').eq(0).attr('href'), '_blank');
    }
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
    if ($(this).hasClass('no-data')) {
        return;
    }
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

$(document).on('click', '#export-search-diamond, #export-search-diamond-admin', function() {
    var export_value = $(this).attr('data-export');
    var discount = $("#export-discount").val();
    if ($('#compare-table tbody').children().length == 0) {
        exportDiamondTables([], [], '', export_value, discount);
    } else {
        var ids = [];
        $.each($('#compare-table tbody tr'), function(indexInArray, valueOfElement) {
            ids.push($(this).attr('data-diamond'));
        });
        exportDiamondTables(ids, [], 'selected', export_value, discount);
    }
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
    if (group_id == 'selected') {
        params_data.params = {
            'selected_d': 'selected',
            'category': global_category,
            'export': export_value,
            'discount': discount,
            'category_slug': global_category_slug,
            'ids': JSON.stringify(selected_values),
            'web': 'web',
            'column': global_sort_column,
            'asc_desc': global_sort_order
        };
    } else {
        params_data.params = {
            'selected_d': false,
            'attribute_values': selected_values,
            'group_id': group_id,
            'category': global_category,
            'export': export_value,
            'discount': discount,
            'category_slug': global_category_slug,
            'web': 'web',
            'column': global_sort_column,
            'asc_desc': global_sort_order
        };
    }

    $.ajax({
        type: 'post',
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

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("result-table");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}