 /* Get the Modal */

$( "#btn-geo" ).click(function() {
	var modal = $('#geo');
	var main = $('main');

	if (modal.css('display') == 'none'){
		modal.css('display', 'block');
		main.css('opacity', '0.4');
	}else{
		modal.css('display', 'none');
		main.css('opacity', '1');
	}

	$( "#btn-close" ).click(function() {
		if (modal.css('display') != 'none'){

			modal.css('display', 'none');
			main.css('opacity', '1');
		}
	});

    $("#save").click(function(){
        if (modal.css('display') != 'none'){

            modal.css('display', 'none');
            main.css('opacity', '1');
        }
    });

});

if (localStorage != null) {
    var geo = $("#btn-geo");
    geo.hide();
    $('#suggest').val(localStorage.city);
    $('#address').val(localStorage.country+', '+localStorage.city);
}

ymaps.ready(init);

function init() {


    var suggestView = new ymaps.SuggestView('suggest');

    var btn = $("#save");
    btn.hide();


    $('#suggest').change(function (e) {
        geocode();
    });
    function geocode() {
        var request = $('#suggest').val();
        ymaps.geocode(request).then(function (res) {
            var obj = res.geoObjects.get(0),
                error, hint;
            if (obj) {
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, требуется уточнение';
                        hint = 'Уточните номер дома, через запятую';
                        break;
                    case 'other':
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните адрес, улица, дом';
                }
            } else {
                error = 'Адрес не найден';
                hint = 'Уточните адрес';
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
        $('#suggest').removeClass('input_error');
        $('#suggest').css('border', '1px solid green');
        $('#nota').css('display', 'none');
        btn.show();

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
        $('#nota').text(message);
        $('#suggest').addClass('input_error');
        $('#nota').css('display', 'block');
    }

    $(btn).click(function() {
        var str = $('#suggest').val();
        var geo = str.split(', ');
        if (localStorage != null) {
            localStorage.clear();
        }
        if (geo[4] != null) {
            localStorage.country = geo[0];
            localStorage.city = geo[1];
            localStorage.region = geo[2];
            localStorage.street = geo[3];
            localStorage.house = geo[4];
        }else if(geo[5] != null){
            localStorage.country = geo[0];
            localStorage.city = geo[1];
            localStorage.region = geo[2];
            localStorage.area = geo[3];
            localStorage.street = geo[4];
            localStorage.house = geo[5];
        }
        else{
            localStorage.country = geo[0];
            localStorage.city = geo[1];
            localStorage.stret = geo[2];
            localStorage.house = geo[3];
        }
    });
}