//when stop state
const stateStop = (e, state, idticket, asunto, idgrupo_send) => {
  e.preventDefault();
  /* console.log("el estado", state);
  console.log("elidticket", idticket);
  console.log("el asunto", asunto);

  console.log("RUTSS ", rut);
  console.log("IDGRUPOR", idgrupo);
  console.log("GRUPOO ENVIAR", idgrupo_send);
  console.log("IDGRUPOR", email);
*/
  conn.send(
    JSON.stringify({
      action: "stopState",
      data: {
        Rut: rut,
        idticket: idticket,
        asunto: asunto,
        idstate: state,
        rol: rol,
        idgroupibelong: idgrupo,
        id_grupo_send: idgrupo_send,
        asig_email: email,
      },
    })
  );

  $(".jq-toast-wrap").remove();
};
//end

//tickets resolved
const resolvedTicketUser = (e, state, idticket, asunto, idgrupo_send) => {
  e.preventDefault();

  conn.send(
    JSON.stringify({
      action: "resolvedTicket",
      data: {
        Rut: rut,
        idticket: idticket,
        asunto: asunto,
        idstate: state,
        rol: rol,
        idgroupibelong: idgrupo,
        id_grupo_send: idgrupo_send,
        asig_email: email,
      },
    })
  );
  $(".jq-toast-wrap").remove();
};
//end

const changeState = (state, idticket, asunto, idgrupo_send) => {
  //delete button finalize
  $("#bottonAssigned").children().slice(1).hide();

  //button stop
  if (state == 4) {
    $("#user_derivar").hide();
    $("#asignar_usu").hide();
    $("#bottonAssigned")
      .append(`<button class="btn btn-light mr-3"  style="width:100%; padding:7px" onclick="stateStop(event, \`${state}\`, \`${idticket}\`,\`${asunto}\`,\`${idgrupo_send}\`)">
<i class="mdi mdi-check text-danger"></i> Stop </button>`);
  } else if (state == 5) {
    // these the botton finalize
    $("#bottonAssigned")
      .append(`<button class="btn btn-light mr-3" style="width:100%; padding:7px" onclick="resolvedTicketUser(event, \`${state}\`, \`${idticket}\`,\`${asunto}\`,\`${idgrupo_send}\`)">
  <i class="mdi mdi-check text-success"></i> Finalizar </button>`);

    $("#user_derivar").hide();
    $("#asignar_usu").hide();
    //$("#asignar_usu").show();
  } else {
    $("#user_derivar").show();
    $("#asignar_usu").show();
  }
};

//finish tickets
const finishResolvedTickets = (e, idticket, asunto, idgrupo_send,asigando) => {
  e.preventDefault();
  let state = $("#change_stateFinsh").val();
  conn.send(
    JSON.stringify({
      action: "finishTicket",
      data: {
        Rut: rut,
        idticket: idticket,
        asunto: asunto,
        idstate: state,
        rol: rol,
        idgroupibelong: idgrupo,
        id_grupo_send: idgrupo_send,
        asig_email: asigando,
      },
    })
  
  );
  $(".jq-toast-wrap").remove();
};

const changStateReopen = (state, idticket, asunto, idgrupo_send) => {
  console.log("el estado", idgrupo_send);
  console.log("elidticket", idticket);
  console.log("el asunto", asunto);
  $("#bottonAssigned2").children().slice(1).hide();
  if (state == 7) {
    $("#asignar_usu").hide();
    $("#bottonAssigned2")
      .append(`<button class="btn btn-light mr-3"  style="width:100%; padding:7px" onclick="reopenTicket(event, \`${state}\`, \`${idticket}\`,\`${asunto}\`,\`${idgrupo_send}\`)">
<i class="mdi mdi-check text-danger"></i> Reabrir </button>`);
  } else {
    $("#asignar_usu").show();
  }
};

const reopenTicket = (e, state, idticket, asunto, idgrupo_send) => {
  e.preventDefault();

  conn.send(
    JSON.stringify({
      action: "reopenTicket",
      data: {
        Rut: rut,
        idticket: idticket,
        asunto: asunto,
        idstate: state,
        rol: rol,
        idgroupibelong: idgrupo,
        id_grupo_send: idgrupo_send,
        asig_email: email,
      },
    })
  );
  $(".jq-toast-wrap").remove();
};

// show resovedTickets
const showResolvedTickets = (data) => {
  if (
    data &&
    Array.isArray(data.AllrevolvedTticket) &&
    data.AllrevolvedTticket.length > 0
  ) {
    $("#onhold-tickets").children().slice(1).remove();
    $("#onhold-tickets").append(
      data.AllrevolvedTticket.map(
        ({
          idticket,
          asignado,
          Correo,
          estado,
          fecha,
          dateEnd,
          Nombre,
          texto,
          tipo,
          titulo,
          urgencia,
          idUsuario,
          idgrupo,
        }) => {
          let ticketTime = new Date(fecha).toLocaleTimeString();
          return `
    <a class="tickets-card row">
<div class="tickets-details  col-6 " >
    <div class="wrapper">
    <h5 id="id_ticket" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">#${idticket} - ${titulo}</h5>
        <div class="badge badge-info">${tipo}</div>
    </div>
    <div class="wrapper text-muted">
        <span>Assignado a: </span>
        <span>${asignado}</span>
        <span><i class="mdi mdi-clock-outline"></i>${dateEnd}</span>
    </div>
</div>
<div class="ticket-float col-2 " >
     <span>Solicitud de: </span>
    <span class="text-muted"> ${Nombre}</span>
</div>
<div class="ticket-float  col-2"  >
    <span class="text-muted">${estado}</span>
</div>
<div class="ticket-float col-2">
    <button class="btn btn-light mr-3" style="width: 70%; padding: 5px 5px;" onclick="showToastViewAlone(\`${titulo}\`,\`${texto}\`)">
        <i class="mdi mdi-eye text-primary"></i> View
    </button>
    <button hidden class="btn btn-light" style="width: 50%; padding: 5px 10px;">
        <i class="mdi mdi-close text-danger"></i> Remove
    </button>
</div>
</a>
    `;
        }
      )
    );
  }
};
//end

//show all tickets
const showAllTickets = (data) => {
  console.log("este es mi rollllllllllll", rol);
  let loadTicket = data.allTickets.map(
    ({
      Rut,
      idticket,
      asignado,
      Correo,
      estado,
      fecha,
      dateStart,
      Nombre,
      texto,
      tipo,
      titulo,
      urgencia,
      idUsuario,
      groupFirst,
      groupSecond,
      createState,
      idstate,
      idrol,
    }) => {
      let ticketTime = new Date(fecha).toLocaleTimeString();
      return `
      <a class="tickets-card row">
  <div class="tickets-details  col-6 " >
      <div class="wrapper">
      <h5 id="id_ticket" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">#${idticket} - ${titulo}</h5>
          <div class="badge badge-info">${tipo}</div>
      </div>
      <div class="wrapper text-muted">
          <span>Assignado a: </span>
          <span>${asignado}</span>
          <span><i class="mdi mdi-clock-outline"></i>${dateStart}</span>
      </div>
  </div>
  <div class="ticket-float col-2 " >
       <span>Solicitud de: </span>
      <span class="text-muted"> ${Nombre}</span>
  </div>
  <div class="ticket-float  col-2"  >
      <span class="text-muted">${estado}</span>
  </div>
  <div class="ticket-float col-2">
  ${
    rol === 6 &&
    idrol === rol &&
    groupSecond == idgrupo &&
    (idstate == 1 || idstate == 4 || idstate == 7)
      ? `<button class="btn btn-light mr-3" style="width: 70%; padding: 0px 5px;" onclick="showAssigned(\`${texto}\`, \`${idticket}\`,\`${groupFirst}\`,\`${titulo}\`)">
        <i class="mdi mdi-hand-pointing-right text-primary" style="transform: rotate(90deg);"></i>Asignar
      </button>`
      : idstate == 5 && createState == 1 && Rut == rut
      ? `<button class="btn btn-light mr-3" style="width: 70%; padding: 0px 5px;" onclick="showToastViewReopen(\`${texto}\`, \`${idticket}\`,\`${groupFirst}\`,\`${titulo}\`,\`${asignado}\`)">
          <i class="mdi mdi-hand-pointing-right text-primary" style="transform: rotate(90deg);"></i> Finalizar
        </button>`
      : `<button class="btn btn-light mr-3" style="width: 70%; padding: 0px 1px;" onclick="showToastViewAlone(\`${texto}\`,\`${titulo}\`)">
          <i class="mdi mdi-eye text-primary"></i> View
        </button>`
  }
        </div>
  </a>`;
    }
  );
  $("#open-tickets").children().slice(1).remove();
  $("#open-tickets").append(loadTicket);
};
//end

//show assigned ticket
const showAssignedTicket = (data = {}) => {

  let resulAssig = Array.isArray(data.allAsingadoUser) ? data.allAsingadoUser.map(
      ({
        Rut,
        asignado,
        correo,
        estado,
        fecha,
        fecha_estado,
        Nombre,
        texto,
        asunto,
        tipo,
        titulo,
        urgencia,
        idUsuario,
        idgrupo,
        idticket,
        groupFirst,
        tassign,
        assignState,
        resultState,
      }) => {
        let ticketTime = new Date(fecha).toLocaleTimeString();
        return `
    <a class="tickets-card row">
<div class="tickets-details col-6" >
    <div class="wrapper">
    <h5 id="id_ticket" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">#${idticket} - ${titulo}</h5>
        <div class="badge badge-info">${tipo}</div>
    </div>
    <div class="wrapper text-muted">
        <span>Assignado a: </span>
        <span>${asignado}</span>
        <span><i class="mdi mdi-clock-outline"></i>${ticketTime}</span>
    </div>
</div>
<div class="ticket-float  col-2">
     <span>Solicitud de: </span>
    <span class="text-muted"> ${Nombre}</span>
</div>
<div class="ticket-float col-2" >
    <span class="text-muted">${estado}</span>
</div>
<div class="ticket-float col-2">
${
  idUsuario == rut  && tassign == 1 
    ? `<button class="btn btn-light mr-3" style="width: 70%; padding: 0px 5px;" onclick="showAssigned(\`${asunto}\`, \`${idticket}\`,\`${groupFirst}\`,\`${titulo}\`)">
     <i class="mdi mdi-hand-pointing-right text-primary" style="transform: rotate(90deg);"></i>Asignar
  </button>`
    : `<button class="btn btn-light mr-3" style="width: 70%; padding: 0px 1px;" onclick="showToastViewAlone(\`${asunto}\`,\`${titulo}\`)">
    <i class="mdi mdi-eye text-primary"></i> View
  </button>`
}
</div>
</a>`;}
) : []

    
    $("#pending-tickets").children().slice(1).remove();
    $("#pending-tickets").append(resulAssig);

  }

//end
//asignar ticket user  POR REVISAR ALGUNAS FUNCIONALIDADES
function asignarUser(e) {
  e.preventDefault();

  let derivar_user = document.getElementById("derivar_user").value;
  console.log(derivar_user);
  let [asig_email, Rut, rol] = derivar_user.split(","); //de la persona a la que se va asignar
  var [idticket, id_grupo_send] = $(e.target)
    .closest("button")
    .data("ticket-id")
    .split(",");

  let asunto = simplemde ? simplemde.value() : "";
  let change_state = document.getElementById("change_state").value;

  let asignar_usu = document.getElementById("asignar_usu").value;

  //let asig_group = document.getElementById("derivar_user").value;
  // let htmlContent = $(".html-content").html(); // Obtener el contenido HTML
  // Obtener el ID del ticket del botón que fue presionado

  console.log("el id ", Rut);
  console.log("ticket", idticket);
  console.log("asunto este::", asunto);
  console.log("estado", change_state);

  console.log("butoon", asig_email);
  console.log("uno", asignar_usu);

  console.log("al grupo que genero el ticket", id_grupo_send);
  console.log("este es grupo pertenesco", idgrupo);

  conn.send(
    JSON.stringify({
      action: "AssigUserTickets",
      data: {
        Rut: Rut, //ready
        idticket: idticket, //ready
        asunto: asunto,
        idstate: change_state,
        asig_email: asig_email,
        rol: rol,
        rutibelong:rut,
        id_grupo_send: id_grupo_send,
        idgroupibelong: idgrupo,
      },
    })
  );

  //console.log(htmlContent);

  //para cerrar el ticket
  $(".jq-toast-wrap").hide();
}
//end

//delete ticket
const deleteTicket = (id, rut, idgrupo) => {
  conn.send(
    JSON.stringify({
      action: "deleteTicket",
      data: {
        id: id,
        rut: rut,
        idgrupo: idgrupo,
      },
    })
  );
};
//end

//fillcombobox of groupos
const fillComoboxGroup = (data) => {
  $("#asig_group").html(
    data.getAllGroup.map(
      ({ correo, grupo, Rut, id_grupo }) =>
        `<option  value="${correo},${id_grupo}">${grupo}</option>`
    )
  );
};

const fillComboboxState = (data) => {
  window.loadStateGrupos = data.getAllState.map(
    ({ id_estado, estado }) =>
      `<option data-id="${id_estado}" value="${id_estado}">${estado}</option>`
  );
};

//clear fields
const clearFielts = () => {};
