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