function evtGuardar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "guardar";
	theForm.submit();
}

function evtCancelar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "cancelar";
	theForm.submit();
}

function evtAgregarNodo() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "agregarNodo";
	theForm.submit();
}

function evtEliminarNodo(id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea eliminar el registro?");
	
	if (confirmacion) {
		theForm.ID.value = id;
		theForm.Evento.value = "eliminarNodo";
		theForm.submit();
	}
}

function evtObtenerHost() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "obtenerHostname";
	theForm.submit();
}

function evtCargar() {
	var theForm = document.getElementById("ActionForm");
	
	theForm.txtIP.value = "";
	theForm.txtMascara.value = "";
	theForm.submit();
}
