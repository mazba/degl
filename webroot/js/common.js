/**
 * Created by Mazba on 11/11/2015.
 */
$(document).ready(function(){
    $( document ).ajaxSend(function(event, xhr, options) {
        if(options.type.toUpperCase() === "POST")
        {
            $('#loader').show();
        }
    });
    $( document ).ajaxStop(function() {
        $('#loader').hide();
    });
})