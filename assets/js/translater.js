function changeLang(lang) {
    lang = lang || localStorage.getItem('app-lang') || 'es';
    if ( lang == 'es') {
        $('span.ms-middle img.ms-dd-option-image')[0].setAttribute('src',"view/img/language_logo/spain-logo.png");
        $('span.ms-dd-label').text("Español");
    } else if ( lang == 'ca') {
        $('span.ms-middle img.ms-dd-option-image')[0].setAttribute('src',"view/img/language_logo/catalán-logo.png");
        $('span.ms-dd-label').text("Catalá");
    } else if ( lang == 'en') {
        $('span.ms-middle img.ms-dd-option-image')[0].setAttribute('src',"view/img/language_logo/Britanica-logo.jpg");
        $('span.ms-dd-label').text("English");
    }

    localStorage.setItem('app-lang', lang);
    var elmnts = document.querySelectorAll('[data-tr]');
    $.ajax({
        url: 'view/lang/' + lang + '.json',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                for (var i = 0; i < elmnts.length; i++) {
                    elmnts[i].innerHTML = data.hasOwnProperty(lang) ? data[lang][elmnts[i].dataset.tr] : elmnts[i].dataset.tr;
                }
            }
    })
}

$(document).ready(function() {
 
    changeLang();
    $('select#language').on('change', function () {
        var id = $('select#language option:selected').attr("id");
        changeLang(id);
    
    });
});