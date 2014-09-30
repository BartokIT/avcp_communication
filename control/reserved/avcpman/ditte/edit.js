$(function() {

    var s =[{
        'o':$('#ditta_edit_identificativo'),
        'm':'Inserire un identificativo fiscale corretto',
        't':'idfiscale'
    },
	{
		'o': $('#ditta_edit_ragione_sociale'),
		'm':'Inserire la ragione sociale della ditta',
		't':function(s)
		{
			if (s.length > 0) 
				return true;
			else
				return false;
		}
	}
    ];
    
    var sButtonPressed;
    $('button').click(function() { 
        sButtonPressed = $(this).attr('value') 
    });
    
    $(s).each(function(i,v){
        v.o.keydown(function()
        {
		v.o.removeClass('red-background-error');
		v.o.next('div').text('');
        });
        
        v.o.change(function()
        {
		v.o.removeClass('red-background-error');
		v.o.next('div').text('');
        });
    });
    
    $("#edit-ditta").submit(function(event)
    {
        
        if (sButtonPressed == "undo") {
            return true;
        }
        else
            return validateElements(s);
    });
    			var oTour = new Tour({
				steps:[
					{
						element: "#new-gara",
						title: "0",
						content: "Seguendo questa guida, ti verr&agrave; spiegato in breve il funzionamento di questo sito.<br/>Tramite il pulsante 'Aggiungi gara' potrai aggiungere una nuova gara.<br/><strong> Premilo ora</strong>"
					},
					{
						path:"?action=new_gara",
						element: ".box",
						title: "1",
						content: "Tramite questo pulsante potrai aggiungere una nuova gara"
					},
                    {
						path:"?action=new_gara",
						element: ".save",
						title: "2",
						content: "Finito l'inserimento sar&agrave; necessario premere il pulsante 'Inserisci' per effettuare il salvataggio"
					},
                    {
						path : "?area=avcpman%2Fgare",
						element: ".edit-partecipant",
						placement:"top",
						title: "3",
						content: "Ora &egrave; necessario inserire i partecipanti alla gara"
					},
					{
						element: "#add-partecipant-ditta",
						placement:'left',
						title:"Aggiungi un partecipante",
						content: "&Egrave; necessario aggiungere un partecipante oppure un ragguppamento. Clicca sul pulsante per andare avanti",
					},
					{
						element:  $(".container-main .message:first"),
						placement:'left',
						prev: 3,
						title:"Aggiungi un partecipante",
						content: "&Egrave; possibile aggiungere una ditta, oppure ricercarne una in rubrica<br/> Prova a cercare il Comune di Terracina e selezionalo",
					},
					{
						element:  $("#ditta_edit_add"),
						placement:'left',
						title:"Aggiungi un partecipante",
						content: "Ora premi sul pulsante Aggiungi",
					},
					{
						
					}
			],
			template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>"
			});
			oTour.init();
			oTour.start();
			 if (!oTour.ended()) {
				//$("[type='submit']").click(function(e){e.preventDefault()});
				$("#ditta_edit_add").click(function(e){                
					oTour.next();
					return true;
            })
			}
});