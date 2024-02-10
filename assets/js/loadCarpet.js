$(document).ready(function () {
  $(document).on("click", ".archivo a", function (e) {
    e.stopPropagation(); // Previene que el evento de clic en el enlace se propague al .archivo
  });

  function habilitarDragAndDrop() {
    // Aplica los eventos de drag & drop a cada carpeta
    $(".carpeta").each(function () {
      $(this).on("dragover", function (e) {
        e.preventDefault(); // Necesario para permitir el drop
        e.stopPropagation(); // Detiene la propagación hacia elementos padres
        $(this).addClass("carpeta-hover"); // Añade la clase para resaltar
      });

      $(this).on("dragleave", function (e) {
        e.stopPropagation(); // Detiene la propagación hacia elementos padres
        $(this).removeClass("carpeta-hover"); // Remueve la clase al salir
      });

      $(this).on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation(); // Detiene la propagación hacia elementos padres, evitando múltiples cargas
        $(this).removeClass("carpeta-hover"); // Limpia todos los hovers

        var rutaCarpeta = $(this).data("ruta"); // Recupera la ruta de la carpeta
        var archivos = e.originalEvent.dataTransfer.files; // Los archivos arrastrados

        // Llama a la función subirArchivos solo para esta carpeta
        subirArchivos(archivos, rutaCarpeta);
      });
    });
  }

  // Función para subir archivos al servidor
  function subirArchivos(archivos, rutaCarpeta) {
    var formData = new FormData();
    formData.append("rutaCarpeta", rutaCarpeta); // Agregar la ruta de la carpeta al FormData

    // Agregar los archivos al FormData
    for (var i = 0; i < archivos.length; i++) {
      formData.append("archivo" + i, archivos[i]);
    }
    // Preparar la barra de progreso
    $("#progressBar").width(0);
    // Realizar la petición AJAX para subir los archivos
    $.ajax({
      url: "../controller/RHH/subir_archivo.php", // Ajusta esto a tu script PHP real
      type: "POST",
      data: formData,
      contentType: false, // Necesario para FormData
      processData: false, // Necesario para FormData
      xhr: function () {
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) {
          // Para manejar el progreso de la carga
          myXhr.upload.addEventListener(
            "progress",
            function (e) {
              if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                $("#progressBar").width(percentComplete + "%");
              }
            },
            false
          );
        }
        return myXhr;
      },
      success: function (response) {
        alert(response); // Mostrar respuesta del servidor
        cargarEstructuraDirectorios(); // Opcional: recargar estructura de directorios
        $("#progressBar").width(0); // Restablecer la barra de progreso
      },
      error: function () {
        alert("Error al subir archivos.");
        $("#progressBar").width(0); // Restablecer la barra de progreso en caso de error
      },
    });
  }

  // Función para cargar y mostrar la estructura de directorios
  function cargarEstructuraDirectorios() {
    $.ajax({
      url: "../controller/RHH/carga_archivos.php", // Asegúrate de que la ruta al script PHP sea correcta
      type: "GET",
      dataType: "json",
      success: function (data) {
        $("#estructuraDirectorios").html(crearEstructuraHTML(data, ""));
        // Asegúrate de reasignar el evento click a las nuevas carpetas cargadas
        $(".carpeta")
          .off("click")
          .on("click", function (e) {
            e.stopPropagation(); // Evita que el evento click se propague a elementos padres
            $(this).children(".contenido-carpeta").toggle(); // Expande o contrae la subcarpeta
          });
        habilitarDragAndDrop();
        habilitarAccionArchivos();
        habilitarEliminacionCarpetas();
      },
    });
  }

  // Función para construir el HTML de la estructura de directorios
  function crearEstructuraHTML(carpetas, rutaActual) {
    let html = "<ul>";
    for (let elemento of carpetas) {
      // Aquí, asegúrate de que rutaActual ya es relativa al directorio base y refleja correctamente la estructura dentro de tu servidor web
      let rutaCompleta = rutaActual + "/" + elemento.nombre; // Esta es la ruta relativa desde el directorio base
      if (elemento.tipo === "carpeta") {
        html += `<li style="font-size:20px;" class="carpeta" data-ruta="${rutaCompleta}">📁 ${elemento.nombre}`;
        if (elemento.hijos && elemento.hijos.length > 0) {
          html +=
            '<div class="contenido-carpeta" style="display: none;">' +
            crearEstructuraHTML(elemento.hijos, rutaCompleta) + // Asegúrate de pasar la ruta actualizada a la función recursivamente
            "</div>";
        }
      } // Dentro de crearEstructuraHTML, caso para archivos
      else if (elemento.tipo === "archivo") {
        let iconoArchivo = obtenerIconoArchivo(elemento.nombre);
        let urlDescarga = `../controller/RHH/download.php?file=${encodeURIComponent(
          rutaCompleta
        )}`;
        // Asegurarse de que data-ruta se asigna correctamente para archivos
        html += `<div class="archivo-y-descarga">
        <li class="archivo" data-ruta="${rutaCompleta}">
            ${iconoArchivo} <span class="nombre-archivo">${elemento.nombre}</span>
        </li>
        <a href="${urlDescarga}" target="_blank" class="icono-descarga">🔽</a>
     </div>`;
      }

      html += "</li>";
    }
    html += "</ul>";
    return html;
  }

  // Función para determinar el ícono según el tipo de archivo
  function obtenerIconoArchivo(nombreArchivo) {
    let extension = nombreArchivo.split(".").pop().toLowerCase();
    switch (extension) {
      case "csv":
        return "📄"; // ícono para CSV
      case "txt":
        return "📝"; // ícono para TXT
      case "doc":
      case "docx":
        return "📃"; // ícono para DOC
      case "rar":
      case "zip":
        return "🗜️"; // ícono para archivos comprimidos
      default:
        return "📄"; // ícono genérico para otros tipos de archivos
    }
  }

  $(document).on("contextmenu", ".carpeta", function (e) {
    e.preventDefault(); // Evitar el menú contextual predeterminado
    e.stopPropagation(); // Detener la propagación del evento

    var rutaBase = $(this).data("ruta"); // Obtener la ruta completa de la carpeta
    var nombreSubcarpeta = prompt("Ingrese el nombre de la nueva carpeta:");

    if (nombreSubcarpeta) {
      $.ajax({
        url: "../controller/RHH/createFile.php", // Ajusta esto a tu script PHP real
        type: "POST",
        data: {
          rutaBase: rutaBase,
          nombreSubcarpeta: nombreSubcarpeta,
        },
        success: function (response) {
          alert(response); // Mostrar el resultado
          cargarEstructuraDirectorios(); // Refrescar la estructura de directorios
        },
        error: function () {
          alert("Error al crear la carpeta.");
        },
      });
    }
  });

  //elimina los archivos
  // Habilitar eliminación para carpetas con doble clic
  // Habilitar eliminación para carpetas con doble clic
  function habilitarEliminacionCarpetas() {
    $(".carpeta")
      .off("dblclick")
      .on("dblclick", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var rutaCarpeta = $(this).data("ruta"); // Recupera la ruta de la carpeta

        // Verifica si la ruta de la carpeta incluye "Documentos"
        if (
          
          rutaCarpeta === "/Documentos"
        ) {
          alert("El archivo raíz no se puede eliminar.");
          return; // Detiene la ejecución adicional para no proceder con la eliminación
        }

        var confirmacion = confirm(
          "¿Quiere eliminar esta carpeta y todo su contenido?"
        );
        if (confirmacion) {
          eliminarElemento(rutaCarpeta, "carpeta");
        }
      });
  }

  // Habilitar acción (como eliminación) para archivos con un clic simple
  // Habilitar acción (como eliminación) para archivos con un clic simple
  function habilitarAccionArchivos() {
    $(".archivo")
      .off("click")
      .on("click", function (e) {
        var rutaArchivo = $(this).data("ruta");
        var confirmacion = confirm("¿Quiere eliminar este archivo?");
        if (confirmacion) {
          eliminarElemento(rutaArchivo, "archivo");
        }
      });
  }

  function eliminarElemento(rutaElemento, tipoElemento) {
    $.ajax({
      url: "../controller/RHH/eliminar_elemento.php",
      type: "POST",
      data: {
        rutaElemento: rutaElemento,
        tipoElemento: tipoElemento,
      },
      success: function (response) {
        alert(tipoElemento + " eliminado(a) exitosamente.");
        cargarEstructuraDirectorios(); // Recargar la estructura de directorios
      },
      error: function () {
        alert("Error al eliminar el(a) " + tipoElemento + ".");
      },
    });
  }

  // Cargar la estructura de directorios inicial
  cargarEstructuraDirectorios();
});
