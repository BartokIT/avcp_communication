            
            
            function Publication() {};
            function Year(){};
			function Contest(){};
			
            Publication.prototype= new DataObject();
            Year.prototype = new DataObject();
			Contest.prototype= new DataObject();
			
            var oPub={};
            var oYears={};
            var oContests={};
			
             $(function(){               


               /* Pulsante che gestisce l'inserimento delle informazioni di pubblicazione*/               
               $("#new_single_partecipant").click(function() {
						$( "#new_single_partecipant_form" ).dialog({
								modal: true,
                                width: 550,
								buttons: {
										"Inserisci": function(){
										},
										"Annulla":function(){
												$( this ).dialog( "close" );
										}
								}
						});
						
				});
			   
			   
				$("#tipo_partecipante_singolo").autocomplete({
                      source: function( request, response ) {
                      $._r( {
                             area:"pubblicazioni",
                             subarea:"gare",
							 action:"search_ditta"
                      },{
							"stringa_ricerca":request.term
					  },
					  {
						success: function( data ) {
                             response( $.map( data, function( item ) {
                             return {
                                           label: item.name  + " (" + item.prov_code +")"+ ", " + item.postal_code + " - " + item.region,
                                           info: item,
                                           value: item.name
                                    }
                             }));
                        }
                      });
                    },
                    autoFocus: true,
                    minLength: 2
				});
			   
			   /**
			    * Gestisce la cancellazione di una pubblicazione
			    * */
                $(document).on("click",".delete_publication",function(){
                  var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                  var s_numero_pubblicazione=$(this).closest("tr").find("td:first-child").text();
				  var o_this = this;

                });
				
                /* Pulsante che gestisce il salvataggio delle informazioni di pubblicazione*/
            	$(document).on("click",".edit_publication", function() {
                        var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                        var s_numero_pubblicazione=$(this).closest("tr").find("td:first-child").text();
                        
                        $("#titolo_pubblicazione").val(oPub[s_numero_pubblicazione*1].get("titolo"));
                        $("#abstract_pubblicazione").val(oPub[s_numero_pubblicazione*1].get("abstract"));
                        $("#data_pubblicazione").val(oPub[s_numero_pubblicazione*1].get("data_pubblicazione"));
                        $("#data_aggiornamento").val(oPub[s_numero_pubblicazione*1].get("data_aggiornamento"));                                                            
                        $("#url_pubblicazione").val(oPub[s_numero_pubblicazione*1].get("url"));
                        
						$( "#new-publication-form" ).dialog({
								modal: true,
                                width: 550,
								buttons: {

								}
						});
						
				});
				

			   
			   
			   
			   });
			