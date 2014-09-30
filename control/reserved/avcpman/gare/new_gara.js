$(function() {
    $( "#gare_edit_job_start_date" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#gare_edit_job_end_date" ).datepicker({ dateFormat: 'dd/mm/yy' });
    
    var s =[{
        'o':$('#gare_edit_year'),
        'm':'Inserire un anno nel formato corretto a 4 cifre (Es. 2013)',
        't': function(s)
        {
            return /^[0-9][0-9][0-9][0-9]/i.test(s);
        }
    },
    {
        'o':$('#gare_edit_cig'),
        'm':'Inserire un cif di massimo 10 caratteri',
        't': function(s)
        {
            if (s.length > 0 &&s.length < 11) 
                return true;
            else
                return false;
        }
    } ,
    {
        'o':$('#gare_edit_subject'),
        'm':'Inserire un oggetto di massimo 250 caratteri',
        't': function(s)
        {
            if (s.length > 0 &&s.length < 251) 
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
    
    $("#edit-gara").submit(function(event)
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
                        path : "?area=avcpman%2Fgare",
						element: "#new-gara",
						title: "Aggiungi una nuova gara",
						content: "Tramite questo pulsante potrai aggiungere una nuova gara."
					},
					{
						element: ".box",
						title: "Inserimento dati",
                        onNext: function (tour) {
                            $('#gare_edit_cig').val("0000000");
                            $('#gare_edit_subject').val("Gara di prova");
                            $('#gare_edit_payed_amount').val("10000");
                            $('#gare_edit_job_start_date').val("01/01/2014");                            
                        },
						content: "Tramite questa schermata potrai inserire i dati relativi ad alla nuova gara. <br/> Andando avanti verranno inseriti dei dati esemplificativi."
					},
                    {
						element: ".save",
						title: "Salva la gara",
						content: "Finito l'inserimento sar&agrave; necessario premere il pulsante 'Inserisci' per effettuare il salvataggio.<br/><strong>Premilo ora</strong>",
                        onNext: function (tour) {
                            //$(".save").trigger("click");
                        }
					},
                    {
						path : "?gid=-1&action=submit&gare_edit_year=2014&gare_edit_cig=0000000&gare_edit_subject=Gara+di+prova&gare_edit_contest_type=1&gare_edit_amount=0&gare_edit_payed_amount=10000&gare_edit_job_start_date=01%2F01%2F2014&gare_edit_job_end_date=&submit=save&nonce=" + $("[name='nonce']").val(),
						title: "Inserisci i partecipanti",
						content: "Finito l'inserimento sarà necessario premere il pulsante 'Inserisci' per effettuare il salvataggio"
					}
			]});
			oTour.init();
			oTour.start();
            if (!oTour.ended()) {
                $(".save").click(function(e){
                                //e.preventDefault(); 
                                var iStep = oTour.getCurrentStep()
                                if (iStep == 2) {                                    
                                    oTour.next();                                    
                                }                                
                            })    
            }
            
            
            
});