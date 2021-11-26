var stop_on_change = 0;
var global_search_values = [];
var global_search_array = [];
var global_group_id = 0;
var new_call = true;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function( xhr ) {
        // $( ".cs-loader" ).show();
    }
});
$(document).ready(function () {
    if ($('.filter-toggle').length === 0) {
        $('#filter-toggle').attr('disabled', true);
    }
    setTimeout(function(){
        stop_on_change = 1;
        getAttributeValues(global_search_values, global_search_array, global_group_id);
    }, 2000);
});
$(document).on('click', '.diamond-shape .item img', function () {
    var group_id = $(this).attr('data-group_id');
    if ($(this).attr('data-selected') == 1) {
        $(this).css('border', '4px solid #00000000');
        $(this).attr('data-selected', 0);
    } else {
        $(this).css('border', '4px solid #D2AB66');
        $(this).attr('data-selected', 1);
    }
    var values = [], values_all = [];
    var cnt = 0;
    $('.diamond-shape .item img').each(function(index, element) {
        if ($(this).attr('data-selected') == 1) {
            values.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
        } else {
            values_all.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
            cnt++;
        }
    });
    new_call = true;
    if (cnt == $('.diamond-shape .item img').length) {
        getAttributeValues(values_all, [], group_id);
    } else {
        getAttributeValues(values, [], group_id);
    }
});

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
        var first_index = array.map(function (e) {
            return e.name;
        }).indexOf(strArray[0]);
        var last_index = array.map(function (e) {
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
    console.log(selected_values);

    $.ajax({
        beforeSend: function( xhr ) {
            if (new_call === true) {
                $( ".cs-loader" ).show();
            }
        },
        type: "post",
        url: "/customer/search-diamonds",
        data: {
            'attribute_values': selected_values,
            'group_id': group_id,
            'web': 'web',
            'category': global_category,
            'category_slug': global_category_slug
        },
        // cache: false,
        dataType: "json",
        success: function (response) {
            $('.cs-loader').hide();
            global_search_values = values;
            global_search_array = array;
            global_group_id = group_id;
            /* if (response.success == 1) {
                $.toast({
                    heading: 'Success',
                    text: response.message,
                    icon: 'success',
                    position: 'top-right'
                });
            }
            else {
                $.toast({
                    heading: 'Error',
                    text: response.message,
                    icon: 'error',
                    position: 'top-right'
                });
            } */
            if (new_call === true) {
                $('#result-table tbody').html(response.data);
                setTimeout(() => {
                    $('.result-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$('#result-table tbody tr').eq(0).attr('data-barcode')).text('View Diamond');
                    $('.result-tab-content .select-diamond .diamond-name').text($('#result-table tbody tr').eq(0).attr('data-name'));
                    $('.result-tab-content .select-diamond .diamond-cost').text($('#result-table tbody tr').eq(0).attr('data-price'));
                    $('.result-tab-content .select-diamond .diamond-img img').attr('src', $('#result-table tbody tr').eq(0).attr('data-image'));
                }, 1000);
                $(table_scroll).scrollTop($(table_scroll).scrollTop() + $('#result-table').position().top);
            } else {
                $('#result-table tbody').append(response.data);
            }
            //set ajax_in_progress object false, after completion of ajax call
            $(window).data('ajax_in_progress', false);
        },
        failure: function (response) {
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
    $(table_scroll).scroll(function() {
        //check if any other ajax request is already in progress or not, if true then it exit here
        if ($(window).data('ajax_in_progress') === true)
        return;
        //check, whether we reached at the bottom of page or not, true when we reach at the bottom
        if ($(table_scroll).scrollTop() > ($('#result-table').height() * 80 / 100) - $(table_scroll).height()) {
            //set ajax_in_progress object true, before making a ajax call
            $(window).data('ajax_in_progress', true);
            new_call = false;
            //make ajax call
            getAttributeValues(global_search_values, global_search_array, global_group_id);
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
    $('.recent-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-barcode')).text('View Diamond');
    // document.querySelector('.recent-tab-content .select-diamond a').href = $(this).attr('data-barcode');
    $('.recent-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.recent-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.recent-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('mouseover', '#result-table tbody tr', function() {
    $('.result-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-barcode')).text('View Diamond');
    $('.result-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.result-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.result-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('mouseover', '#compare-table tbody tr', function() {
    $('.compare-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-barcode')).text('View Diamond');
    $('.compare-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
    $('.compare-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
    $('.compare-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
});
$(document).on('click', '.reset-btn', function() {
    location.reload();
});
$(document).on('click', '#filter-toggle', function() {
    if ($('.filter-toggle').height() > 1) {
        $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        $('.filter-toggle').css({
            'height': 0,
            'visibility': 'collapse'
        });
    }
    else {
        $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $('.filter-toggle').css({
            'height': 'auto',
            'visibility': 'visible'
        });
    }
});

$(document).on('click', '#export-search-diamond,#export-search-diamond-admin', function () {
    var group_id = $(this).attr('data-group_id');
    var export_value = $(this).attr('data-export');
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
            values.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
        }
    });
    exportDiamondTables(values, [], group_id,export_value);
});

function exportDiamondTables(values, array, group_id,export_value) {

    var selected_values = [];
    if (values.length > 1 && typeof values == 'string') {
        var strArray = values.split(",");
    }
    if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
        var first_index = array.map(function (e) {
            return e.name;
        }).indexOf(strArray[0]);
        var last_index = array.map(function (e) {
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
            'export': export_value
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){

            var blob = new Blob([response]);

            var link = document.createElement('a');

            link.href = window.URL.createObjectURL(blob);

            if(export_value=='export'){
                link.download = "Diamonds-data.pdf";
            }else{
                link.download = "Diamonds-data.xlsx";
            }

            link.click();
        },
        error: function(blob){
            console.log(blob);
        }
    });
}

function roundLabel(el) {
    var label_path = $(el[0].target).next('.rs-container').find('.rs-tooltip');
    label_path.text(parseFloat(label_path.text()).toFixed(2));
}
