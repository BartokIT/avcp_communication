            function escapeHTML( string )
            {
                var pre = document.createElement('pre');
                var text = document.createTextNode( string );
                pre.appendChild(text);
                return pre.innerHTML;
            }
			
            /**
             * Create a model for a view of the data object
             * */
            function DataView(render_callback){
               this._element = undefined;
               this._callback = render_callback;
               this.update = function(data){
                  var parameter = data;
                  if (this._element) 
                     $(this._element).html( $(this._callback(data)).html());
                  else
                     this._element = this._callback(data);
               };
               this.el = function() { return this._element;};
            };
            
	        /**
             * Make a structured 
	        * */            
            function DataObject() {
               //this.data= new Object();
               this.views=new Object();
            };
            
            DataObject.prototype.data = {}
            /**
            * Add a method to store a view
            * */
            DataObject.prototype.addView = function(name,view_object)
            {
               this.views[name]= view_object;
            }
            
            DataObject.prototype.getView = function(name)
            {
               return this.views[name];
            }
            
            DataObject.prototype.get = function(name)
            {
               
               //return this.data[name];
               return this[name];
            };
            
            DataObject.prototype.getEscaped = function(name)
            {
               return escapeHTML(this[name]);
            };
            
            DataObject.prototype.set = function(values)
            {
               //Update all the object property
               for (var name in values)
               {
                  this.data[name]=values[name];
                  this[name]=values[name];
               }
               
               //Update all the object views 
               for (var k in this.views)
               {
                  if (!!k && this.views.hasOwnProperty(k))
                  {
                     this.views[k].update(this);
                  }
               }
            };
            
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
               function initialize(){
                        var s_anno_pubblicazione=$("#anno_pubblicazione").val()
						$._r({
							area:"pubblicazioni",
							subarea:"pubblicazioni",
							action:"get_years"
						},{},
						{
							success: function( data ) {
                            
						   $(data.anni).each(function(i,e){
                              var v = new DataView(function(d){
                                return $('<tr class="year"><td><a href="' + $._l("pubblicazioni","pubblicazioni") + '&anno=' + d.get("anno") +'">' + d.get("anno") +'</td></tr>');
                              });
                              var o = new Year();
                              o.addView("year_list",v);
                               o.set(e);								
                              $("#year_list tbody").append(o.getView("year_list").el());
                              oYears[e.anno]=o;
						   });
                            
                           if (!oYears[s_anno_pubblicazione].get("generare") || (oYears[s_anno_pubblicazione].get("generare") == "F"))
                           {
                              $("#index_url_container").hide();
                           }
                           else
                           {
                              $("#make_index").attr("checked","checked");
                              $("#index_url").val(oYears[s_anno_pubblicazione].get("url"));
                           }
                           
                        }
                    });
                                    
                  $._r({
						area:"pubblicazioni",
						subarea:"pubblicazioni",
						action:"get_pubblicazioni"
						},
						{
							anno:s_anno_pubblicazione
						},
                        {
							success: function( data )
							{
                            $(data.pubblicazioni).each(function(i,e){
                                 var v = new DataView(function(d){
                                    return $('<tr><td>'+ d.get("numero") + '</td><td><a href="#" class="publication_detail">' + d.getEscaped("titolo") + '</a></td><td><a href="#" class="edit_publication">e</a></td><td><a href="#" class="delete_publication">x</a></td></tr>');
                                 });
                                 var o = new Publication();
                                 o.addView("publication_list",v);
                                 o.set(e);
                                 $("#publications_list tbody").append(o.getView("publication_list").el());
                                 oPub[e.numero]=o;
                              });
							} 
						});
               };
               initialize();
               /**
			    * Permette di visualizzare i dettagli di una pubblicazione
			    * */
               $(document).on("click",".publication_detail",function(){
                  var s_numero_pubblicazione=$(this).closest("tr").find("td:first-child").text();
                  var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                   $._r({
						area:"pubblicazioni",
						subarea:"pubblicazioni",
						action:"get_gare"
						},
						{
							anno:s_anno_pubblicazione,
                            numero: s_numero_pubblicazione
						},
                        {
							success: function( data )
							{
								//Elimino tutti i nodi associati alle gare e publisco l'array associativo
								for (i in oContests)
								{
									$(oContests[i].getView("contest_list").el()).remove();
								}
								$oContests={};
								
								//Visualizzo tutti i dati della pubblicazione
								$(data.gare).each(
									function(i,e) {
										var v = new DataView(function(d){
											return $('<tr class="contest"><td><a href="' + $._l("pubblicazioni","gare") + '&cig=' + d.get("cig") +'">' + d.get("cig") +'</td><td>' +  d.get("oggetto") + '</td></tr>');
										});
										var o = new Contest();
										o.addView("contest_list",v);
										o.set(e);								
										$("#contest_list tbody").append(o.getView("contest_list").el());
										oContests[e.cig]=o;
									}
								);
								//Aggiorno il link dell'aggiunta di una gara
								$("#new_contest").attr("href", $._l("pubblicazioni","gare","new",{anno:s_anno_pubblicazione,numero:s_numero_pubblicazione}) );
							} 
						});
               });
               $("#data_pubblicazione" ).datepicker({minDate: 0});
               $("#data_aggiornamento" ).datepicker({minDate: 0});
			   
               /* Pulsante che gestisce l'inserimento delle informazioni di pubblicazione*/               
               $("#new_publication").click(function() {
						$( "#new-publication-form" ).dialog({
								modal: true,
                                width: 550,
								buttons: {
										"Inserisci": function(){
												var o_this = this;                                            
												var o_to_send = {
														titolo : $("#titolo_pubblicazione").val(),
														abstract : $("#abstract_pubblicazione").val(),
														data_pubblicazione : $("#data_pubblicazione").val(),
														data_aggiornamento : $("#data_aggiornamento").val(),
														anno : $("#anno_pubblicazione").val(),
														url : 	$("#url_pubblicazione").val()
													};
										        $._r({
														area:"pubblicazioni",
														subarea:"pubblicazioni",
														action:"insert"
													},o_to_send,
													{
														success: function( data ) {
																if (data.outcome) {
																	var v = new DataView(function(d){
																		return $('<tr><td>'+ d.get("numero") + '</td><td><a href="#" class="publication_detail">' + d.getEscaped("titolo") + '</a></td><td><a href="#" class="edit_publication">e</a></td><td><a href="#" class="delete_publication">x</a></td></tr>');
																	});
																	var o = new Publication();
																	o.addView("publication_list",v);
																	o_to_send.numero = data.number;
																	o.set(o_to_send);
																	 
																	$("#publications_list tbody").append(o.getView("publication_list").el());																	
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
			   
			   /**
			    * Gestisce la cancellazione di una pubblicazione
			    * */
                $(document).on("click",".delete_publication",function(){
                  var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                  var s_numero_pubblicazione=$(this).closest("tr").find("td:first-child").text();
				  var o_this = this;
                   $.ajax({
                           url: "index.php",
                           dataType: "json",
                           data: {
                                   area:"pubblicazioni",
                                   subarea:"pubblicazioni",
                                   action:"delete",
                                   anno: s_anno_pubblicazione,
                                   numero: s_numero_pubblicazione
                           },
                           success : function()
                           {
							  var o_tr=$(o_this).closest("tr");
							  $(o_tr).remove();
                              return;
                           }
                  });
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
										"Salva": function(){
												var o_this = this;
                                                var s_titolo=$("#titolo_pubblicazione").val();
												var s_abstract=$("#abstract_pubblicazione").val();
                                                var s_data_pubblicazione=$("#data_pubblicazione").val();
                                                var s_data_aggiornamento=$("#data_aggiornamento").val();
                                                var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                                                var s_url=$("#url_pubblicazione").val();
										        $.ajax({
														url: "index.php",
														dataType: "json",
														data: {
																area:"pubblicazioni",
																subarea:"pubblicazioni",
																action:"update",
                                                                titolo:s_titolo,
                                                                abstract:s_abstract,
                                                                data_pubblicazione:s_data_pubblicazione,
                                                                data_aggiornamento:s_data_aggiornamento,
                                                                anno: s_anno_pubblicazione,
                                                                url: s_url,
                                                                numero: s_numero_pubblicazione
														},
														success: function( data ) {
															   if (data.outcome) {
																  oPub[data.outcome].set({titolo:s_titolo});                   
															   }
                                                               $(o_this).dialog("close");
												   }
												 });	
										},
										"Annulla":function(){
												$( this ).dialog( "close" );
										}
								}
						});
						
				});
				
                /*
				 * Permette di salvare le modifiche all'url
                */
                $( '#index_url' ).keyup( function( eventObj ) {
					var o_this = this;
                     if ( eventObj.which == 13 )
                     {
                        $.ajax({
						url: "index.php",
						dataType: "json",
						data: {
								area:"pubblicazioni",
								subarea:"pubblicazioni",
								action:"update_index_url",
								url:$('#index_url' ).val(),
								anno:$("#anno_pubblicazione").val()
						},
						success: function()
						{

						  
						}
                     });
                     }
                 } );
				
               $("#make_index").change(function(e,o){
                  var b_checked=false;
                  var s_anno_pubblicazione=$("#anno_pubblicazione").val();
                  if( $(this).is(':checked') )
                  {
                     b_checked=true;
                     $("#index_url_container").show();
                  }
                  else
                  {
                     b_checked=false;
                     $("#index_url_container").hide();
                  }  
                  $.ajax({
                              url: "index.php",
                              dataType: "json",
                              data: {
                                      area:"pubblicazioni",
                                      subarea:"pubblicazioni",
                                      action:"generate_index",
                                      crea:b_checked,
                                      anno:s_anno_pubblicazione
                              },
                              success: function()
                              {
                               
                              }
                  });
               });
        	});