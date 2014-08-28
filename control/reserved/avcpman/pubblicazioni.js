;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                $el.is(':input') && $el.keypress(function(){
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        doneTyping(el);
                    }, timeout);
                }).blur(function(){
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);

$(function() {
    
	$('#new_publication #pubblicazioni_anno').keydown(function()
	{
		$('#pubblicazioni_anno').css('background-color','white');
		$('#show-error').css('visibility','hidden').text('');
	});
	
	$('#new_publication #pubblicazioni_anno').donetyping(function(){
		if ($('#pubblicazioni_anno').val().length == 4)
		{
			if(!($('#pubblicazioni_anno').val().match(/^\d+$/)))
			{
				$('#show-error').css('visibility','visible').text('Inserire solo caratteri numerici');				
			}
			else
			{
				$('#new_publication #pubblicazioni_anno').addClass('loadinggif');
				$.ajax({
					url: "index.php?action=verify_anno",
					dataType: "json",
					cache:false,
					data: {
						  anno: $('#pubblicazioni_anno').val()
					},
					success: function( data ) {
						 if(data.data.trouble)
						 {
							$('#pubblicazioni_anno').css('background-color','#ed9179');
							$('#show-error').css('visibility','visible').text(data.data.message);
						 }
					},
					complete : function(jqXHR,textStatus)
					{
						$('#new_publication #pubblicazioni_anno').removeClass('loadinggif');
					}
				});
			}
		}
	});
});