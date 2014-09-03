$(function() {
    
    
    $( "#pubblicazione_edit_pubblicazione" ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#pubblicazione_edit_aggiornamento" ).datepicker({ dateFormat: 'dd/mm/yy' });    
    var s =[{
        'o':$('#pubblicazione_edit_url'),
        'm':'Inserire una url nel formato corretto',
        't': 'url'
    },
    {
        'o':$('#pubblicazione_edit_titolo'),
        'm':'Inserire un titolo per la pubblicazione',
        't':function(o){
            if (o == '') 
                return false;
            else
                return true;
        }
    }
    ,
    {
        'o':$('#pubblicazione_edit_pubblicazione'),
        'm':'Inserire una data nel formato corretto',
        't':'date'
    },
    {
        'o':$('#pubblicazione_edit_aggiornamento'),
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
    
    $("#edit_publication").submit(function(event)
    {
        
        if (sButtonPressed == "undo") {
            return true;
        }
        else
            return validateElements(s);
    });
    
});