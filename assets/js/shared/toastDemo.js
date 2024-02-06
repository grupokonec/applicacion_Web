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
  showAssigned = function (texto, idticket, idgrupo, titulo, Correo) {
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
    
<div class="card-body" id="drop-area1" style="width: 100%; height:auto;>
        <h4 class="card-title">Descripcion</h4>
   <textarea id="simpleMde2" name="simpleMde2"> </textarea>
 </div>
  <div class="carga de archivos">
    <div id="file-list1"></div>
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

      const dropArea = document.getElementById("drop-area1");

      // Prevenir el comportamiento por defecto de arrastrar y soltar
      ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        dropArea.addEventListener(eventName, preventDefaults, false);
      });

      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      // Resaltar drop area cuando el item es arrastrado sobre ella
      ["dragenter", "dragover"].forEach((eventName) => {
        dropArea.addEventListener(eventName, highlight, false);
      });

      ["dragleave", "drop"].forEach((eventName) => {
        dropArea.addEventListener(eventName, unhighlight, false);
      });

      function highlight(e) {
        dropArea.classList.add("hover");
      }

      function unhighlight(e) {
        dropArea.classList.remove("hover");
      }

      // Manejar el archivo soltado
      dropArea.addEventListener("drop", handleDrop, false);

      function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
      }

      window.uploadedFiles1= []; // Array para almacenar las referencias de los archivos cargados
      window.Correo = Correo;
      function handleFiles(files) {
        uploadedFiles1.push(...files); // Añadir nuevos archivos al array
        displayFiles(); // Actualizar la lista de archivos
      }

      function displayFiles() {
        const fileList = document.getElementById("file-list1");
        fileList.innerHTML = ""; // Limpiar lista actual

        uploadedFiles1.forEach((file) => {
          const fileElement = document.createElement("div");
          fileList.appendChild(fileElement);

          // Mostrar una previsualización para imágenes
          if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.height = 60; // Ejemplo de altura para la miniatura
            img.onload = () => URL.revokeObjectURL(img.src); // Liberar memoria
            fileElement.appendChild(img);
          } else {
            // Para otros tipos de archivos, muestra un icono o nombre del archivo
            let icon;
            switch (file.type) {
              case "application/pdf":
                icon = "📄";
                break;
              case "text/csv":
                icon = "📑";
                break;
              case "application/zip":
              case "application/x-zip-compressed":
                icon = "🗜️";
                break;
              case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
              case "application/msword":
                icon = "📝";
                break;
              default:
                icon = "📁"; // Icono genérico para otros tipos de archivos
            }
            fileElement.textContent = `${icon} ${file.name}`;
          }
        });
      }



      $(".CodeMirror .CodeMirror-scroll").css({
        height: "auto",
        "min-height": "100px",
        "max-height": "300px",
      });
    }
     console.log("estoy en el toast",uploadedFiles1);
    //change state
    $("#change_state").change(function (e) {
      e.preventDefault();

      let state = $(this).val();
      var asunto = simplemde ? simplemde.value() : "";
      changeState(state, idticket, asunto, idgrupo,Correo);
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

  showToastViewReopen = function (texto, idticket, idgrupo, titulo, asignado,Correo) {
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
     <div class="card-body" id="drop-area2" style="width: 100%; height:auto;>
     <h4 class="card-title">Descripcion</h4>
<textarea id="simpleMde3" name="simpleMde3"> </textarea>
</div>
<div class="carga de archivos">
 <div id="file-list2"></div>
</div>
         <div class="col-lg-4">
             <select name="change_stateFinsh" id="change_stateFinsh" class="form-control bg-dark text-light rounded-input" style="border-radius: 5px;">
                 ${window.loadComboboxFinish}
             </select>
         </div>
         <div class="col-lg-3" id="bottonAssigned2">
             <button class="btn btn-light mr-3" data-ticket-id="${idticket},${idgrupo}" onclick="finishResolvedTickets(event, \`${idticket}\`,\`${texto}\`,\`${idgrupo}\`,\`${asignado}\`,\`${Correo}\`)"
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
      const dropArea = document.getElementById("drop-area2");

      // Prevenir el comportamiento por defecto de arrastrar y soltar
      ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        dropArea.addEventListener(eventName, preventDefaults, false);
      });

      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      // Resaltar drop area cuando el item es arrastrado sobre ella
      ["dragenter", "dragover"].forEach((eventName) => {
        dropArea.addEventListener(eventName, highlight, false);
      });

      ["dragleave", "drop"].forEach((eventName) => {
        dropArea.addEventListener(eventName, unhighlight, false);
      });

      function highlight(e) {
        dropArea.classList.add("hover");
      }

      function unhighlight(e) {
        dropArea.classList.remove("hover");
      }

      // Manejar el archivo soltado
      dropArea.addEventListener("drop", handleDrop, false);

      function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
      }

      window.uploadedFiles2= []; // Array para almacenar las referencias de los archivos cargados

      function handleFiles(files) {
        uploadedFiles2.push(...files); // Añadir nuevos archivos al array
        displayFiles(); // Actualizar la lista de archivos
      }

      function displayFiles() {
        const fileList = document.getElementById("file-list2");
        fileList.innerHTML = ""; // Limpiar lista actual

        uploadedFiles2.forEach((file) => {
          const fileElement = document.createElement("div");
          fileList.appendChild(fileElement);

          // Mostrar una previsualización para imágenes
          if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.height = 60; // Ejemplo de altura para la miniatura
            img.onload = () => URL.revokeObjectURL(img.src); // Liberar memoria
            fileElement.appendChild(img);
          } else {
            // Para otros tipos de archivos, muestra un icono o nombre del archivo
            let icon;
            switch (file.type) {
              case "application/pdf":
                icon = "📄";
                break;
              case "text/csv":
                icon = "📑";
                break;
              case "application/zip":
              case "application/x-zip-compressed":
                icon = "🗜️";
                break;
              case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
              case "application/msword":
                icon = "📝";
                break;
              default:
                icon = "📁"; // Icono genérico para otros tipos de archivos
            }
            fileElement.textContent = `${icon} ${file.name}`;
          }
        });
      }

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
