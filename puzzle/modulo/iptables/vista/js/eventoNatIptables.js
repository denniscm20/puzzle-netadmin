function evtPoliticas () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "aplicarPoliticas";
	theForm.submit();
}

function evtAgregarRegla(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "agregarRegla";
	theForm.submit();
}

function evtEliminarRegla(id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "eliminarRegla";
	theForm.submit();
}

function recargar() {
	var theForm = document.getElementById("ActionForm");
	theForm.submit();
}

function evtSalir () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "salir";
	theForm.submit();
}

