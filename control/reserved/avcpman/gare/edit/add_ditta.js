$(function() {
    $( "#ditta_search" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "index.php?action=search_ditta",
                dataType: "json",
                cache:false,
                data: {
                      ragione_sociale: request.term,
                      identificativo_fiscale: request.term
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
    }).on('click',function(e){
        $("#ditta_search").autocomplete('search');
    }).on('keyup paste',function (e) {
        $("#search_result").text('');
        $("#ditta_edit_add").prop('disabled',true);
    }).data('ui-autocomplete')._renderItem= function( ul, item ) {
         item.label =item.value=  item.ragione_sociale;
         return $( "<li>" )
         .append( $( "<a>" ).text( item.ragione_sociale + '/' + item.identificativo_fiscale) )
         .appendTo( ul );
    };

    function fill_fields(data) {
        var s_estera = 'Italiana';
        if (data.estera == 'Y') {
            s_estera='Estera';
        }
        
        $("#search_result").html(create_label('Ragione sociale',data.ragione_sociale) +
                                 create_label('Nazionalit&agrave;',s_estera) +
                                 create_label('Identificativo fiscale', data.identificativo_fiscale));
        
        $("#ditta_edit_add").prop('disabled',false);
        $("#gara_edit_search_did").val(data.did);
    }
    
    function create_label(label,value) {
        var s_html_content = '<div class="label"><span class="left">' + label;
        s_html_content += '</span><span class="right">' + value;
        s_html_content += '</span></div>';
        return s_html_content; 
    }
    
    var oTour = new Tour({
        steps:[
            {   path : "?area=avcpman%2Fgare"},  //step:0
            {   path : "?area=avcpman%2Fgare%2Fnew_gara"},  //step:1
            {   path : "?area=avcpman%2Fgare%2Fnew_gara"},  //step:2
            {   path : "?area=avcpman%2Fgare"},  //step:3
            {   path : "?area=avcpman%2Fgare"},  //step:4
            {	//step: 5
                element:  $(".container-main .message:first"),
                placement:'left',
                title:"Aggiungi un partecipante",
                content: "&Egrave; possibile aggiungere una ditta, oppure ricercarne una in rubrica<br/> Per ora prova a cercare il 'Comune di Terracina' e selezionalo"               
            },
            {	//step: 6
                element:  $("#ditta_edit_add"),
                placement: 'left',
                reflex: true,
                title: "Aggiungi un partecipante",
                content: "Ora premi sul pulsante Aggiungi",
                onShown: function(tour)
                {
                    var gid = $("#gara_edit_search_did").val() ;
                    if (gid != 1) {
                        tour.prev();
                    }
                },
                onNext : function(tour)
                {
                    window.tour._options.steps[7].path = '?action=add&submit=add&gara_edit_search_did=' + $("#gara_edit_search_did").val() + '&gid='+$("#add-ditta [name='gid']").val() + "&nonce=" + $("#add-ditta [name='nonce']").val();
                }
            }, 
            {   //step:7
                path : '?action=add&submit=add&gara_edit_search_did=' + $("#gara_edit_search_did").val() + '&gid='+$("#add-ditta [name='gid']").val() + "&nonce=" + $("#add-ditta [name='nonce']").val()
            },
            {   path : "?area=avcpman%2Fgare"},  //step:8
            { //step9
                element:  ".container-main .message:eq(1)",
                placement: 'left',
                title: "Inserimento di una ditta",
                content: "Tramite questo riquadro potrai inserire direttamente una ditta in archivio.",               
            },
            {   //step: 10
                element : "#edit-ditta select",
                placement: "rigth",
                title : "Specifica del ruolo",
                content : "A differenza di una ditta partecipante singolarmente, facendo parte di un raggruppamento &egrave; necessario specificarne il ruolo.<br/>Andando avanti verranno inseriti dati esemplificativi"               
            },
            {   //step: 11
                element : "#ditta_edit_insert_and_add",
                placement: "left",
                reflex: true,
                title : "Inserimento ditta in archivio",
                content: 'Premi sul pulsante "Inserisci" per inserire la ditta in archivio',
                onShow : function()
                {
                    $("#ditta_edit_ragione_sociale").val("Ditta fantasma");
                    $("#ditta_edit_identificativo").val("1234567891");
                },
                onNext: function ()
                {
                    window.tour._options.steps[12].path = '?action=insert_and_add&submit=add&pid=' + $("#edit-ditta [name='pid']").val()+ '&dummy=dummy&gare_edit_ruolo_type=4&gid='+$("#edit-ditta [name='gid']").val() + "&nonce=" + $("#edit-ditta [name='nonce']").val();
                }                
            },
            {   path: '?action=insert_and_add&submit=add&dummy=dummy' }, //step: 12
            {   path : "?area=avcpman%2Fgare"},  //step:13
            {   path : "?area=avcpman%2Fgare"}  //step:14
    ],
    template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>",
	onEnd: function(tour)
	{
		$("a").unbind();
        $("button").unbind();
	}
    });
    oTour.init();
    oTour.start();
    if (!oTour.ended()) {				
		$("a").unbind().click(function(e){e.preventDefault();});
        $("button").unbind().click(function(e){e.preventDefault();});
	}
    window.tour = oTour;
});