	         $(function(){
            	$("#new_year").button().click(function() {
						$( "#new-year-form" ).dialog({
								modal: true,
								buttons: {
                                    "Ok": function(){
                                      var s_anno=$("#anno").val();
                                      var o_this = this;
                                      $.ajax({
                                              url: "index.php",
                                              dataType: "json",
                                              data: {
                                                      area:"pubblicazioni",
                                                      subarea:"default",
                                                      action:"insert",
                                                      anno: s_anno
                                              },
                                              success: function( data ) {
                                                      if (data.outcome) {
                                                              var o_last=undefined;
                                                              var o_to_be_inserted = $('<tr><td><a class="year" href="#">' + s_anno + "</a></td></tr>");
                                                              var b_inserted=false;
                                                              $("#year_list tbody tr").each(function(i,e){
                                                                      var content = $(e).text()*1;																		
                                                                      o_last=e;
                                                                      if (s_anno > content ) {
                                                                              console.log(content);
                                                                              o_to_be_inserted.insertBefore(e);
                                                                              b_inserted=true;
                                                                              return false;
                                                                      }
                                                                      
                                                              });
                                                              if (!o_last || !b_inserted) {
                                                                      console.log("append");
                                                                      $("#year_list tbody").append(o_to_be_inserted);
                                                              }
                                                              $( o_this ).dialog( "close" );
                                                      }
                                         }
                                       });	
                                     },
                                    "Annulla":function(){
                                            $( this ).dialog( "close" );
                                    }
								}
						});
						
				});
        	});