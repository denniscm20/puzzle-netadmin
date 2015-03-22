function evtIniciar(id) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "iniciar";
	theForm.Servicio.value = id;
	theForm.submit();
}

function evtDetener(id) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "detener";
	theForm.Servicio.value = id;
	theForm.submit();
}

function evtReiniciar(id) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "reiniciar";
	theForm.Servicio.value = id;
	theForm.submit();
}