
/**Acciones para el modulo de Login */
const btnAccionLogin = (accion) => {
  $(".contentLogin").html('<img class="img-fluid" src="./assets/imgs/loader.gif" style="width:250px;">');

  divmiContent = document.querySelector('.list_salas').style.display = 'none';
  $.get("./login/crudLogin.php?accion=" + accion, function (data) {
    setTimeout(() => {
      $(".contentLogin").html(data);
    }, 500);
  });
}




window.addEventListener('load', (event) => {

  $(".miContent").html('<img class="img-fluid" src="./assets/imgs/loader.gif" style="width:250px;">');
  setTimeout(() => {
    $.get("calendario.php?idSala=" + 5, function (data) {
      $(".miContent").html(data);
    });
  }, 1000)
});


/*
document.addEventListener('DOMContentLoaded', (event) => {
  console.log('Holaaaa');
});
*/


$(".btnNombreListaSalas").click(function () {
  //eliminamos la clase activa por si una opción la contiene
  $(".btnNombreListaSalas").removeClass("opcionActivaMenu");
  //asignamos la clase opcionActivaMenu a la opción presionada
  $(this).addClass("opcionActivaMenu")
});


const btnReservar = (idSala) => {
  console.log(idSala)
  $(".miContent").html('<img class="img-fluid" src="./assets/imgs/loader.gif" style="width:250px;">');

  $.post("./calendario.php", { idSala }, function (result) {
    console.log(result)
    setTimeout(() => {
      $(".miContent").html(result);
    }, 800);
  });

}

const modoNocturno = () => {
  document.body.classList.toggle('bodyNocturno');
  document.querySelector('.scrolling-area').classList.toggle('sidebarNocturno')
}


const cerrarAlert = () => {
  let divLog = document.querySelector(".alertLogin");
  divLog.classList.add("hide");
}


const notificacion = (msg = "") => {
  const wrapper = document.querySelector(".wrapper_notificacion"),
    toast = wrapper.querySelector(".toast"),
    closeIcon = toast.querySelector(".close-icon"),
    divMsg = document.querySelector("#msg");

  //crear una funcion que valide
  //Vefifico si la notificacion tiene la clase Hide
  if (wrapper.classList.contains("hide")) {
    console.log('El elemento tiene la clase "hide".');
    wrapper.classList.remove("hide");
  } else {
    console.log('El elemento no tiene la clase "hide".');
  }

  wrapper.style.display = "block";
  divMsg.innerHTML = msg;

  closeIcon.onclick = () => {
    wrapper.classList.add("hide");
  };

  setTimeout(() => {
    wrapper.classList.add("hide");
  }, 10000);
}


/**Funcion Drap- Drop */
function drapDropCalendario(event) {
  console.log("caso 1");

  let id_reserva = event.id;
  let fecha_inicio = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
  let fecha_fin = moment(event.end).format("YYYY-MM-DD HH:mm:ss");

  var sendParamts = {
    id_reserva,
    fecha_inicio,
    fecha_fin,
  };

  $.ajax({
    type: "POST",
    url: "./acciones/acciones.php?accion=3",
    data: sendParamts,
    // data: { id_reserva, fecha_inicio, fecha_fin },
    dataType: "json",
    success: function (data) {
      if (data === true) {
        notificacion("Reservación actualizada");
      } else {
        console.log("Error en Drap - Drop");
      }
    },
  });
}


/*Metodo para Eliminar una Reserva */
if ($(".btnBorrarEvento").length) {
  btnEliminarEvento = document.querySelector(".btnBorrarEvento");
  btnEliminarEvento.addEventListener("click", (e) => {
    console.log('click borrar');
    const idReserva = document.querySelector("#id_reservaDelete").value;
    const id_user = document.querySelector("#ModalDelet #id_user").value;
    $.ajax({
      type: "POST",
      url: "./acciones/acciones.php?accion=4",
      dataType: "json",
      data: { idReserva, id_user },
      success: function (data) {
        if (data === true) {
          notificacion("Reservación eliminada");
          $("#calendar").fullCalendar("removeEvents", idReserva);
        } else {
          console.log("Error al borrar la Reserva");
        }
      },
    });
  });
}



/**Recibiendo y enviando toda la informacion para registrar la nueva reservación */
let form = document.querySelector("#formReservaSala");
form.addEventListener("submit", enviarFormulario);

function enviarFormulario(event) {
  event.preventDefault();

  let miForm = $("#formReservaSala").serialize();
  let idSalaChecked = document.querySelector("#idSalaSeleccionada").value;

  $.ajax({
    type: "POST",
    url: "./acciones/acciones.php?accion=1",
    data: miForm + "&idSalaSeleccionada=" + idSalaChecked,
    dataType: "json",
    success: function (data) {
      if (data === true) {
        $("#ModalAdd").modal("hide");
        notificacion("Reservación Registrada");
        $("#calendar").fullCalendar("refetchEvents");
      } else {
        console.log("Error registrar Reserva");
      }
    },
  });
  return false;
}



const updateEventoCalendario = (event) => {

  let fecha_inicio = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
  let fecha_fin = moment(event.end).format("YYYY-MM-DD HH:mm:ss");

  $("#ModalEdit #id_reserva").val(event.id);
  $("#ModalEdit #titulo").val(event.title);
  $("#ModalEdit #uso_sala").val(event.description);
  $("#ModalEdit #fecha_inicio").val(fecha_inicio);
  $("#ModalEdit #fecha_fin").val(fecha_fin);

  let arrayColoresEdit = ["#2ecc71", "#3498db", "#f1c40f", "#e74c3c", "#8BC34A", "#009688", "#9c27b0", "#222222", "#ce0e2d",
  ];
  let buscarColor = event.color;
  console.log("color que busco ", buscarColor);
  let valor = "";
  let div = document.querySelector(".customRadiosEdit");

  arrayColoresEdit.forEach((color, posicion) => {
    let valid = buscarColor == color ? "checked" : "";

    valor += `
      <div>
        <input type="radio" id="miColor-${posicion}" name="color" value="${color}" ${valid}>
        <label for="miColor-${posicion}">
          <span>
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked Icon" />
          </span>
        </label>
      </div>
  `;
    div.innerHTML = valor;
  });

  $("#ModalEdit").modal("show");
}


constDeleteEventoCalendario = (event, element) => {
  /**Si hay Session */
  if (respuestaCondicionSesion) {
    let idUserBD = event.id_user; //id_user que viene de BD
    //Si los eventos que existen son del usuario en session que los permita editar.
    if (idUserSession == idUserBD) {
      element
        .find(".fc-content")
        .prepend("<span id='btn-eliminar-reserva' class='bi bi-x'></span>");
    }
  }

  element.find("#btn-eliminar-reserva").on("click", function () {
    document.querySelector("#ModalDelet #id_reservaDelete").value =
      event.id;
    document.querySelector("#ModalDelet #id_user").value;
    document.querySelector("#tituloEvento").innerHTML = event.title;

    $("#ModalDelet").modal("show");
    return false;
  });
}




let formEditarReserva = document.querySelector("#formEditarSala");
formEditarReserva.addEventListener("submit", (e) => {
  e.preventDefault();

  let miFormEdit = $("#formEditarSala").serialize();
  $.ajax({
    type: "POST",
    url: "./acciones/acciones.php?accion=2",
    data: miFormEdit,
    dataType: "json",
    success: function (data) {
      if (data === true) {
        $("#ModalEdit").modal("hide");
        notificacion("Reservación actualizada");
        $("#calendar").fullCalendar("refetchEvents");
      } else {
        console.log("Error editando la Reserva");
      }
    },
  });
  return false;
});


function vistaEventosCalendario(eventObj, $el) {
  var request = new XMLHttpRequest();
  request.open("GET", "", true);
  request.onload = function () {
    $el.popover({
      title: eventObj.title,
      content: eventObj.description,
      trigger: "hover",
      placement: "top",
      container: "body",
    });
  };
  request.send();

}


const viewModalAddEventCalendar = (start, end) => {

  $("#ModalAdd #fecha_inicio").val(
    moment(start).format("YYYY-MM-DD HH:mm:ss")
  );
  $("#ModalAdd #fecha_fin").val(moment(end).format("YYYY-MM-DD HH:mm:ss"));
  $("#ModalAdd").modal("show");

}


/**Funcion que esta pendiente de verificar los parametros de la URL para lanzar una alerta */
verificaAlerta();
function verificaAlerta() {
  if (document.getElementById("#alertLogin") !== null) {
  let divLog = document.querySelector(".alertLogin");
  if (divLog.classList.contains("hide")) {
    console.log("No tiene la clase");
  } else {
    setTimeout(() => {
      document.querySelector(".alertLogin").classList.add("hide");
    }, 12000);
  }
}
}



/** Función que retorna la fecha actual */
function fechaOriginal() {
  const date = new Date();
  const [month, days, years] = [
    date.getMonth() + 1,
    date.getDate(),
    date.getFullYear(),
  ];

  if (days >= 10 || month >= 10) {
    dia = days;
    mes = month;
  } else {
    dia = `0${days}`;
    mes = `0${month}`;
  }
  return `${years}-${mes}-${dia}`;
}