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

    if(action == "harga-jual") {
        let persentase = InternalCalculation.getPersentaseMargin(bind, value).toFixed(2);
        persentase = !isNaN(persentase) ? persentase + "%" : 0;
        target.html(persentase);
    }

    if(action == "harga-pokok") {
        let persentase = InternalCalculation.getPersentaseMargin(value, bind).toFixed(2);
        persentase = !isNaN(persentase) ? persentase + "%" : 0;
        target.html(persentase);
    }

    

})



let InternalCalculation = {

    getPersentaseMargin: function(hargaPokok, hargaJual) {

        return ((hargaJual - hargaPokok) / hargaPokok) * 100;

    }

}