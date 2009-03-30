function evtHabilitar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "habilitar";
	theForm.submit();
}

function evtAgregarIP() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "agregarIP";
	theForm.submit();
}

function evtRecargar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "recargar";
	theForm.submit();
}

function evtEvento(evento) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = evento;
	theForm.submit();
}

function evtEliminarIP(id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea eliminar el registro?");
	
	if (confirmacion) {
		theForm.IPValidaID.value = id;
		theForm.Evento.value = "eliminarIP";
		theForm.submit();
	}
}