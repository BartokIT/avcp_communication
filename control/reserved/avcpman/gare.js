$(function () {
    var deleteCallback = function (e) {
        e.preventDefault();
        var targetUrl = $(this).attr("href"),
            iGaraNum = $(this).parent().parent().children('.counter').text(),
            sSubject = $(this).parent().parent().children('.subject').text();

        $("#modal-box-message").html("Si vuole veramente eliminare la gara n. " + iGaraNum + "<br/> avente come oggetto '" + sSubject + "'?");
        $("#modal-box").dialog({
            resizable: false,
            modal: true,
            title: "Eliminazione gara",
            buttons: {
                "Conferma": function () {
                    window.location.href = targetUrl;
                },
                "Annulla": function () {
                    $(this).dialog("close");
                }
            }
        });
    };

    $(".delete").click(deleteCallback);
    var oTour = new Tour({
        steps: [
            { //step: 0 
                element: "#new-gara",
                title: "Guida iniziale",
                content: "Seguendo questa guida, ti verr&agrave; spiegato in breve il funzionamento di questo sito.<br/>Tramite il pulsante 'Aggiungi gara' potrai aggiungere una nuova gara.<br/><strong> Premilo ora</strong>",
                reflex: true
            },
            {
                path: "?action=new_gara"
            }, //step: 1
            {
                path: "?action=new_gara"
            }, //step: 2 
            { //step: 3
                element: ".dummy .edit-partecipant",
                placement: "top",
                title: "Inserisci partecipanti",
                content: "Ora &egrave; necessario inserire i partecipanti alla gara",
                reflex: true
            },
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 4
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 5
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 6
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 7
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 8
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 9
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 10
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 11
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 12
            {
                path: $(".dummy .edit-partecipant").attr("href")
            }, //step: 13
            { //step: 14
                element: ".dummy .delete",
                placement: "left",
                title: "Elimina gara",
                content: "&Egrave; inoltre possibile eliminare la gara appena creata, per farlo premere questo pulsante",
                reflex: true,
                onNext: function () {
                    window.tmp = {
                        p: 14
                    }
                }
            },
            {
                orphan: true,
                title: "Elimina gara",
                content: "Tutorial completato.<br/>Premi sul pulsante 'Termina tour' per tornare all'applicazione",
                backdrop: true,
                onShow: function (tour) {
                    if (window.tmp && window.tmp.p && window.tmp.p == 14) {
                        window.tmp.p = -1;
                        window.location = $(".dummy .delete").attr("href");
                    }
                }
            } //step:
        ],
        template: "<div class='popover'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <div class='btn-group'> <button class='btn btn-sm btn-default' data-role='prev'>&laquo; Prec.</button> <button class='btn btn-sm btn-default' data-role='next'>Succ. &raquo;</button> <button class='btn btn-sm btn-default' data-role='pause-resume' data-pause-text='Pause' data-resume-text='Resume'>Pausa</button> </div> <button class='btn btn-sm btn-default' data-role='end'>Termina tour</button> </div> </div>",
        onEnd: function (tour) {
            $("a").unbind();
            $(".delete").click(deleteCallback);
        }
    });

    oTour.init();
    oTour.start();
    if (!oTour.ended()) {
        $("a").unbind().click(function (e) {
            e.preventDefault();
        });
    }

    $(".help").click(function () {
        oTour.init();
        oTour.restart();
    });

    $("#current-year").selectmenu({
        change: function (event, data) {            
            window.location.href = "?action=set_current_year&year=" + data.item.value;
        }
    });
    
    $("#view-all-gare").change(function () {
        
        var url = "?action=set_view_all&all=" ;
        if ($(this).prop("checked")) {
            window.location.href = url + "true";
        } else {
            window.location.href = url + "false";
        }
    });

});