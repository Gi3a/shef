ymaps.ready(init);

function init() {


    var suggestView = new ymaps.SuggestView('address');

    $('#address').change(function (e) {
        geocode();
    });


   
    function geocode() {
        var request = $('#address').val();
        ymaps.geocode(request).then(function (res) {
            var obj = res.geoObjects.get(0),
                error, hint;
            if (obj) {
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.kind')) {
                    case 'locality':
                        break;
                    case 'country':
                        error = 'Неточный адрес, требуется уточнение Города';
                        hint = 'Уточните город';
                    case 'other':
                        error = 'Неточный адрес, требуется уточнение Города';
                        hint = 'Уточните Город';
                }
            } else {
                error = 'Адрес не найден';
                hint = 'Уточните город';
            }
            if (error) {
                showError(error);
                showMessage(hint);
            } else {
                showResult(obj);
            }
        }, function (e) {
            console.log(e)
        })

    }

     function showResult(obj) {
        $('#address').removeClass('input_error');
        $('#address').css('border', '1px solid green');
        $('#noti').css('display', 'none');

        var 
            bounds = obj.properties.get('boundedBy'),
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            ),
            address = [obj.getCountry(), obj.getAddressLine()].join(', '),
            shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
    }

    function showError(message) {
        $('#noti').text(message);
        $('#address').addClass('input_error');
        $('#noti').css('display', 'block');
    }
}