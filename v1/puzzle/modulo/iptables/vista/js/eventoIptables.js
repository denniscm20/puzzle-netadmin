
function evtGuardar () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "guardar";
	theForm.submit();
}

function evtImportar () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "importar";
	theForm.submit();
}
