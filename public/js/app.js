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

    $('#newMenu').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var restaurant_id = button.data('restaurantid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input.restaurant-id').val(restaurant_id)
    });

    $('#updateMenu').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var menu_id = button.data('menuid') // Extract info from data-* attributes
        var name = button.data('name')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input.menu-id').val(menu_id);
        modal.find('.modal-body input.name').val(name);
    });

    $('#newSection').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var menu_id = button.data('menuid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input.menu-id').val(menu_id);
    });
    $('#updateSection').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var section_id = button.data('sectionid') // Extract info from data-* attributes
        var name = button.data('name')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input.section-id').val(section_id);
        modal.find('.modal-body input.name').val(name);

    });

    $('#newElement').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var section_id = button.data('sectionid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body input.section-id').val(section_id);
    });

    $('#updateElement').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var element_id = button.data('elementid'); // Extract info from data-* attributes
        var name = button.data('name');
        var price = button.data('price');
        var description = button.data('description');
        var img = button.data('img');

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#element-id').val(element_id);
        modal.find('.modal-body input#element-name').val(name);
        modal.find('.modal-body input#element-price').val(price);
        modal.find('.modal-body textarea#element-description').val(description);
        modal.find('.modal-body img#img_preview_menu').attr('src', img);
    });

});