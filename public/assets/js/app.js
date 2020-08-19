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

        let selisih = (hargaJual - hargaPokok);
        let selisihPer = selisih / hargaPokok;
        let persentase = selisihPer * 100;

        if(isNaN(persentase)) return 0

        return persentase;

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

function Rp( nominal ){
    return currency(nominal, {
        separator: '.', 
        precision: 0,
        symbol: 'Rp. '
    })
    .format()
}

function selisihHasil(nilai1, nilai2) {

    let hasil = nilai1 - nilai2;

    if(isNaN(hasil)) return 0;

    if(!isFinite(hasil)) return 0;

    hasil = Math.abs(hasil);

    return hasil;

}


function createRowBoq(data) {

    let html = ``;

    let itemNameInputHTML = `
        <input name="item_name[${data.id_item}]" data-id="${data.id_item}" class="form-control" value="${data.item_name}" id="boq-item-name-${data.id_item}">                             
    `

    let itemQtyInputHTML = `
        <input name="item_qty[${data.id_item}]" data-id="${data.id_item}" class="form-control" value="${data.item_qty}" id="boq-item-qty-${data.id_item}">        
    `

    let itemUnitInputHTML = `
        <input name="item_unit[${data.id_item}]" data-id="${data.id_item}" class="form-control" value="${data.item_unit}" id="boq-item-unit-${data.id_item}">        
    `

    html += `

        <tr>
            <td>${itemNameInputHTML}</td>
            <td>${itemQtyInputHTML}</td>
            <td>${itemUnitInputHTML}</td>
            <td>
                <a href="javascript:void(0)" class="btn btn-danger js-delete-boq-item" data-id="${data.id_item}">
                    <span class="fas fa-trash"></span>
                </a>
                <a href="javascript:void(0)" class="btn btn-warning js-update-boq-item" data-id="${data.id_item}">
                    <span class="fas fa-edit"></span>
                </a>
            </td>
        </tr>

    `


    return html;


}