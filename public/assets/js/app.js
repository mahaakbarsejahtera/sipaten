async function Request(options = {}) {

    return $.ajax(options);

}

function Toast(status = "success", message = "") { 

    toastr[status](message);

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

$('[data-toggle=sort]').click(function(e){
    e.preventDefault();

    let fas = $(this).find('.fas');

    if(fas.hasClass('fa-sort-amount-down')) {
        fas.removeClass('fa-sort-amount-down').addClass('fa-sort-amount-up'); 
        $(this).data('sort', 'desc'); 
    }
    else {
        fas.removeClass('fa-sort-amount-up').addClass('fa-sort-amount-down');  
        $(this).data('sort', 'asc'); 
    }

});

$(document).on('click', '#pagination-wrapper .page-item', function(e){

    $(this).find('a').html(`<span class="fas fa-spin fa-spinner"></span>`)

});


$(document).on('change keyup', '[data-toggle=get-margin]', function(e){

    let value   = parseFloat($(this).val());
    let bind    = parseFloat($($(this).data('bind')).val());
    let target  = $($(this).data('target'))
    let action = $(this).data('action');

    let persentase = 0.0;

    if(action == "harga-jual") {
        persentase = InternalCalculation.getPersentaseMargin(bind, value).toFixed(2);
    }

    if(action == "harga-pokok") {
        persentase = InternalCalculation.getPersentaseMargin(value, bind).toFixed(2);
        
    }

    persentase = !isNaN(persentase) && (persentase > 0) ? `<span class="text-success">${persentase}%<span>`: `<span class="text-danger">${persentase}%<span>`;
    target.html(persentase);
    
})



let InternalCalculation = {

    getPersentaseMargin: function(hargaPokok, hargaJual) {

        return ((hargaJual - hargaPokok) / hargaPokok) * 100;

    }

}

// esc value
function escStr(value) { 

    if (value === null || value === '') return '';

    return value;
}


function createRowHasilSurvey(id = 0, name = '', qty = 0, unit = '') {

    let html = `
        <tr>
            <th>
                <input name="items[name][${id}]" type="text" class="form-control" placeholder="Nama item" value="${name}" readonly>
            </th>
            <th>
                <input name="items[qty][${id}]" type="text" class="form-control" placeholder="Jumlah" value="${qty}" readonly>
            </th>
            <th>
                <input name="item[unit][${id}]" type="text" class="form-control mr-2" placeholder="Unit" value="${unit}" readonly>
            </th>
            <th>
                <a href="javascript:void(0)" data-item="${id}" class="btn btn-danger js-remove-item"><span class="fas fa-minus"></span></a>
            </th>
        </tr>`

    return html;

}

