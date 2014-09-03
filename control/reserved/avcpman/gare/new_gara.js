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
            if (s.length < 11) 
                return true;
            else
                return false;
        }
    }    
    ,
    {
        'o':$('#gare_edit_job_start_date'),
        'm':'Inserire una data nel formato corretto',
        't':'date'
    },
    {
        'o':$('#gare_edit_job_end_date'),
        'm':'Inserire una data nel formato corretto',
        't':'date'
        
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
});