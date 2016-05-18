$(function() {
    $('#monday_oh').timepicker();
    $('#monday_ch').timepicker();
    
    $('#tuesday_oh').timepicker();
    $('#tuesday_ch').timepicker();
    
    $('#wednesday_oh').timepicker();
    $('#wednesday_ch').timepicker();
    
    $('#thursday_oh').timepicker();
    $('#thursday_ch').timepicker();
    
    $('#friday_oh').timepicker();
    $('#friday_ch').timepicker();

    $('#saturday_oh').timepicker();
    $('#saturday_ch').timepicker();

    $('#sunday_oh').timepicker();
    $('#sunday_ch').timepicker();

    
    /*Image preview for restaurant*/
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });

    /*Image preview for menu element*/
    function readURL_menu(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img_preview_menu').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp_menu").change(function(){
        readURL_menu(this);
    });

    //Location for creating a restaurant
    if($('#us2').length > 0){
        $('#us2').locationpicker({
            location: {
                latitude: 46.15242437752303,
                longitude: 2.7470703125
            },
            radius: 0,
            inputBinding: {
                latitudeInput: $('#us2-lat'),
                longitudeInput: $('#us2-lon'),
                radiusInput: $('#us2-radius'),
                locationNameInput: $('#us2-address')
            },
            enableAutocomplete: true
        });
    }

    //Location for showing a restaurant
    if($('#us3').length > 0){
        $('#us3').locationpicker({
            location: {
                latitude: $('#us3-lat')[0].value,
                longitude: $('#us3-lon')[0].value
            },
            radius: 0
        });
    }

    //Location for editing a restaurant
    if($('#us4').length > 0){
        $('#us4').locationpicker({
            location: {
                latitude: $('#us4-lat')[0].value,
                longitude: $('#us4-lon')[0].value
            },
            radius: 0,
            inputBinding: {
                latitudeInput: $('#us4-lat'),
                longitudeInput: $('#us4-lon'),
                locationNameInput: $('#us4-address')
            },
            enableAutocomplete: true
        });
    }


});