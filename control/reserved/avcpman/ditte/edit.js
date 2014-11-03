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
});