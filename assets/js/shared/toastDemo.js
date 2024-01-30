(function ($) {
  showToastViewAlone = function (texto, titulo) {
    "use strict";
    resetToastPosition();

    var converter = new showdown.Converter();
    // Convertir Markdown a HTML
    var htmlContent = converter.makeHtml(texto);
    var htmltitulo = converter.makeHtml(titulo);

    var combinedContent = `<div class='html-content'>${htmlContent}</div>`;

    $.toast({
      heading: htmltitulo,
      text: combinedContent,
      showHideTransition: "slide",
      icon: "success",
      hideAfter: false,
      afterShown: function () {
        $(".jq-toast-wrap").css({
          width: "700px",
          height: "700px",
          color: "white",
        });
      },
      loaderBg: "#f96868",
      position: "top-right",
    });
  };
  showInfoToast = function () {
    "use strict";
    resetToastPosition();
    $.toast({
      heading: "Info",
      text: "And these were just the basic demos! Scroll down to check further details on how to customize the output.",
      showHideTransition: "slide",
      icon: "info",
      loaderBg: "#46c35f",
      position: "top-right",
    });
  };

  var miToast;

  //show created tickets
  showAssigned = function (texto, idticket, idgrupo, titulo) {
    "use strict";
    resetToastPosition();

    // Crear una instancia de Showdown Converter
    var converter = new showdown.Converter();

    // Convertir Markdown a HTML
    var htmlContent = converter.makeHtml(texto);
    var htmltitulo = converter.makeHtml(titulo);

    var selectHtml = `
    <div class="form-group row justify-content-end" id="toastAssigned">
    <form>
    
    <div class="form-group row justify-content-end" style="width:100%">
    <div class="col-lg-13" style="width: 100%; height:auto;">
    <textarea id="simpleMde2" name="simpleMde2" style="width: 100%; height: 100px; max-height: 300px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;"></textarea>
</div>

        <div class="col-lg-4">
            <select name="change_state" id="change_state" class="form-control bg-dark text-light rounded-input" style="border-radius: 5px;">
                ${window.loadStateGrupos}
            </select>
        </div>
        <div class="col-lg-5" id="user_derivar">
            <select name="derivar_user" id="derivar_user" class="form-control bg-dark text-light rounded-input" style="border-radius: 5px;">
                ${window.loadUserGrupos}
            </select>
        </div>
        <div class="col-lg-3" id="bottonAssigned">
            <button class="btn btn-light mr-3" data-ticket-id="${idticket},${idgrupo}" onclick="asignarUser(event)"
            style="width:100%; padding:7px" id="asignar_usu" name="asignar_usu">
                <i class="mdi mdi-hand-pointing-left text-primary"></i>Asignar
            </button>
        </div>
        </div>
        
    </div>
    </form>
</div>`;

    var combinedContent = `<div class='select-content'>${selectHtml}</div>`;

    miToast = $.toast({
      heading: htmltitulo,
      text: combinedContent,
      showHideTransition: "slide",
      icon: "info",
      loaderBg: "#57c7d4",
      position: "top-right",
      hideAfter: false,
      afterShown: function () {
        $(".jq-toast-wrap").css({
          width: "700px",
          height: "700px",
          color: "white",
        });
      },
    });

    if ($("#simpleMde2").length) {
      simplemde = new SimpleMDE({
        element: $("#simpleMde2")[0],
      });

      $(".CodeMirror .CodeMirror-scroll").css({
        height: "auto",
        "min-height": "100px",
        "max-height": "300px",
      });
    }

    //change state
    $("#change_state").change(function (e) {
      e.preventDefault();

      let state = $(this).val();
      var asunto = simplemde ? simplemde.value() : "";
      changeState(state, idticket, asunto, idgrupo);
    });
  };
  // end

  showToastAssignedUsers = function (asunto, titulo) {
    "use strict";
    resetToastPosition();

    // Crear una instancia de Showdown Converter
    var converter = new showdown.Converter();

    // Convertir Markdown a HTML
    var htmlContent = converter.makeHtml(asunto);
    var htmltitulo = converter.makeHtml(titulo);

    var combinedContent = `<div class='html-content'>${htmlContent}</div>`;

    $.toast({
      heading: htmltitulo,
      text: combinedContent,
      icon: "info",
      hideAfter: false,
      position: {
        left: 270,
        top: 505,
      },
      afterShown: function () {
        $(".jq-toast-wrap").css({
          width: "500px",
          height: "900px",
          color: "white",
        });
      },
      stack: false,
      loaderBg: "#f96868",
    });
  };

  showToastViewReopen = function (texto, idticket, idgrupo, titulo,asignado) {
    "use strict";
    resetToastPosition();

    // Crear una instancia de Showdown Converter
    var converter = new showdown.Converter();

    // Convertir Markdown a HTML
    var htmlContent = converter.makeHtml(texto);
    var htmltitulo = converter.makeHtml(titulo);

    var selectHtml = `
     <div class="form-group row justify-content-end">
     <form>
     
     <div class="form-group row justify-content-end" style="width:100%">
            <div class="col-lg-13" style="width: 100%; height:auto;">
            <textarea id="simpleMde3" name="simpleMde3" style="width: 100%; height: 100px; max-height: 300px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;"></textarea>
          </div>
         <div class="col-lg-4">
             <select name="change_stateFinsh" id="change_stateFinsh" class="form-control bg-dark text-light rounded-input" style="border-radius: 5px;">
                 ${window.loadComboboxFinish}
             </select>
         </div>
         <div class="col-lg-3" id="bottonAssigned2">
             <button class="btn btn-light mr-3" data-ticket-id="${idticket},${idgrupo}" onclick="finishResolvedTickets(event, \`${idticket}\`,\`${texto}\`,\`${idgrupo}\`,\`${asignado}\`)"
             style="width:100%; padding:7px" id="asignar_usu" name="asignar_usu">
                 <i class="mdi mdi-hand-pointing-left text-primary"></i>Finalizar
             </button>
         </div>
         </div>
         
     </div>
     </form>
 </div>`;

    var combinedContent = `<div class='select-content'>${selectHtml}</div>`;

    $.toast({
      heading: htmltitulo,
      text: combinedContent,
      showHideTransition: "slide",
      icon: "info",
      loaderBg: "#57c7d4",
      position: "top-right",
      hideAfter: false,
      afterShown: function () {
        $(".jq-toast-wrap").css({
          width: "700px",
          height: "700px",
          color: "white",
        });
      },
    });

    if ($("#simpleMde3").length) {
      simplemde = new SimpleMDE({
        element: $("#simpleMde3")[0],
      });

      $(".CodeMirror .CodeMirror-scroll").css({
        height: "auto",
        "min-height": "100px",
        "max-height": "300px",
      });
    }

    $("#change_stateFinsh").change(function (e) {
      e.preventDefault();

      let state = $(this).val();
      var asunto = simplemde ? simplemde.value() : "";
      changStateReopen(state, idticket, asunto, idgrupo);
    });
  };
  //end

  resetToastPosition = function () {
    $.toast().reset("all"); // Esto cierra todos los toasts abiertos
    $(".jq-toast-wrap").removeClass(
      "bottom-left bottom-right top-left top-right mid-center"
    ); // to remove previous position class
    $(".jq-toast-wrap").css({
      top: "",
      left: "",
      bottom: "",
      right: "",
    }); //to remove previous position style
  };
})(jQuery);
