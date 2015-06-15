$(function () {
    $("#current-year").selectmenu({
        change: function (event, data) {            
            window.location.href = "?action=set_current_year&year=" + data.item.value;
        }
    });
    $("#destination-year").selectmenu();    
    $("#view-all-gare").change(function () {
        
        var url = "?action=set_view_all&all=" ;
        if ($(this).prop("checked")) {
            window.location.href = url + "true";
        } else {
            window.location.href = url + "false";
        }
    });

});