$(function() {
    $( "#ditta_search" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "index.php?action=search_ditta",
                dataType: "json",
                data: {
                      ragione_sociale: request.term
                },
                success: function( data ) {
                    response( data.data);
                }
                });
         },     
         minLength: 2,
         select: function( event, ui ) {            
             fill_fields(ui.item);                  
         }
    }).on('change keyup paste',function () {
        $("#search_result").text('');
        $("#ditta_edit_add").prop('disabled',true);
     }).data('ui-autocomplete')._renderItem= function( ul, item ) {
         item.label =item.value=  item.ragione_sociale;
         return $( "<li>" )
         .append( $( "<a>" ).text( item.ragione_sociale ) )
         .appendTo( ul );
    };

    
    function fill_fields(data) {
                  var s_estera = 'Italiana';
                  if (data.estera == 'Y') {
                                    s_estera='Estera';
                  }
        $("#search_result").text(data.ragione_sociale + ' / ' + data.identificativo_fiscale + ' / ' + s_estera);
        $("#ditta_edit_add").prop('disabled',false);
        $("#gara_edit_search_did").val(data.did);
    }
});