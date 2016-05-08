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
});