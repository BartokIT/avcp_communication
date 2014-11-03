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
					{   path : "index.php?area=avcpman%2Fgare"},  //step:0
					{   //step: 1
						element: ".box",
						title: "Inserimento dati",                        
						content: "Tramite questa schermata potrai inserire i dati relativi ad alla nuova gara. <br/> Andando avanti verranno inseriti dei dati esemplificativi."
					},
                    {   //step: 2
						element: ".save",
						title: "Salva la gara",
                        placement: 'left',
                        reflex: true,
						content: "Finito l'inserimento sar&agrave; necessario premere il pulsante 'Inserisci' per effettuare il salvataggio.<br/><strong>Premilo ora</strong>",
                        onShow: function (tour) {
                            $('#gare_edit_cig').val("0000000");
                            $('#gare_edit_subject').val("Gara di prova");
                            $('#gare_edit_payed_amount').val("10000");
                            $('#gare_edit_job_start_date').val("01/01/2014");                            
                        }                        
					},
                    {   //step: 3
                        path : "?gid=-1&action=submit&gare_edit_year=2014&gare_edit_cig=0000000&gare_edit_subject=Gara+di+prova&gare_edit_contest_type=1&gare_edit_amount=0&gare_edit_payed_amount=10000&gare_edit_job_start_date=01%2F01%2F2014&gare_edit_job_end_date=&dummy=dummy&submit=save&nonce=" + $("[name='nonce']").val(),
                        element: ".dummy .edit-partecipant"
					},
                    {   path : "?area=avcpman%2Fgare"},  //step:4
                    {   path : "?area=avcpman%2Fgare"},  //step:5
                    {   path : "?area=avcpman%2Fgare"},  //step:6
                    {   path : "?area=avcpman%2Fgare"},  //step:7
                    {   path : "?area=avcpman%2Fgare"},  //step:8
                    {   path : "?area=avcpman%2Fgare"},  //step:10
                    {   path : "?area=avcpman%2Fgare"},  //step:11
                    {   path : "?area=avcpman%2Fgare"},  //step:12
                    {   path : "?area=avcpman%2Fgare"},  //step:13
                    {   path : "?area=avcpman%2Fgare"}  //step:14

			],
			template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>",			
			onEnd: function(tour)
			{
				$("a").unbind();
			}});
			oTour.init();
			oTour.start();
            if (!oTour.ended()) {
                $("a").unbind().click(function(e){e.preventDefault();});
                $("button").unbind().click(function(e){e.preventDefault();});
            }
            
            
            
});