//crear ticket

const clearTexbox = () => {
  // Limpiar el editor SimpleMDE
  if (simplemde) {
    simplemde.value("");
  }

  // Limpiar los campos de texto y selecciones
  document.getElementById("tik_tipo").value = ""; // Asumiendo que "" es el valor por defecto
  document.getElementById("titulo").value = "";
  document.getElementById("asig_group").value = "";

  // Para el elemento con jQuery, si es un input o similar:
  $("#urgencia").val(""); // Si es un campo de entrada

  // O si 'urgencia' es un elemento de texto como un <span> o <div>, usar .text():
  $("#urgencia").text(""); // Si es un elemento de texto
};

function convertirArchivoABase64(file, callback) {
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => callback(reader.result.split(",")[1]); // Obtenemos solo la parte base64
  reader.onerror = (error) => console.log("Error al leer el archivo:", error);
}

$("#button_ticket").click(function () {
  var asunto = simplemde ? simplemde.value() : "";
  let tipo = document.getElementById("tik_tipo").value;
  let urgencia = $("#urgencia").text();
  let titulo = document.getElementById("titulo").value;
  let asig_group = document.getElementById("asig_group").value;
  let [asig_email, id_grupo] = asig_group.split(",");

  let archivosBase64 = [];
  let archivosProcesados = 0;

  if (uploadedFiles.length > 0) {
      uploadedFiles.forEach(file => {
          convertirArchivoABase64(file, base64 => {
              archivosBase64.push({
                  nombre: file.name,
                  tipo: file.type,
                  base64: base64
              });
              archivosProcesados++;
              if (archivosProcesados === uploadedFiles.length) {
                  enviarDatosYArchivos(asunto, tipo, urgencia, titulo, asig_email, id_grupo, archivosBase64, name, email,rut);
              }
          });
      });
  } else {
      enviarDatosYArchivos(asunto, tipo, urgencia, titulo, asig_email, id_grupo, [], name, email,rut);
  }

  clearTexbox();
  $("#show_ticket").hide();
});

function enviarDatosYArchivos(asunto, tipo, urgencia, titulo, asig_email, id_grupo, archivosBase64, name, email,rut) {
  // Asegúrate de definir 'name' y 'email' correctamente
  console.log(name, email);
  
  conn.send(JSON.stringify({
      action: "createTicket",
      data: {
          tipo: tipo,
          rut:rut,
          urgencia: urgencia,
          titulo: titulo,
          asig_group: asig_email,
          asunto: asunto,
          applicant: email,
          name: name,
          idgrupo: id_grupo,
          id_grupo_send: id_grupo,
          archivo: archivosBase64
      },
  }));
}


//end

//cuando tenga algun error
conn.onmessage = function (e) {
  console.log(e);
  let data = JSON.parse(e.data);

  if (data.type === "ticket_created") {
    console.log(e.data.message);
  }

  if (data.type === "alldate") {
    // Procesar datos de grupos
    console.log(data.getAllGroup);
    console.log("Estados", data.getAllState);
    console.log("finish:", data.getAllStateFinishCombobox);

    //fillgroupcombobox  start
    fillComoboxGroup(data);
    //end
    window.loadComboboxFinish = data.getAllStateFinishCombobox.map(
      ({ id_estado, estado }) =>
        `<option value="${id_estado}">${estado}</option>`
    );
    //fillcomboboxstate
    fillComboboxState(data);
    ///end
  } else if (data.type === "ticket_data") {
    // Procesar datos de tickets
    console.log("datos user:", data.allUserGroup);
    console.log("datos asigandos:", data.allAsingadoUser);
    console.log("Datos de tickets todos:", data.allTickets);
    console.log("Datos de tickets resueltos:", data.AllrevolvedTticket);

    //assigned ticket
    showAssignedTicket(data);
    //end
    
    //resolved ticted start
    showResolvedTickets(data);
    //end
    //all tickets
    showAllTickets(data);
    //end
    

    window.loadUserGrupos = data.allUserGroup.map(
      ({ Correo, Nombre, Rut, idroles }) =>
        `<option value="${Correo},${Rut},${idroles}">${Nombre}</option>`
    );
  } else {
    // Otro tipo de mensaje
    console.log("Mensaje recibido:", data);
  }
};
