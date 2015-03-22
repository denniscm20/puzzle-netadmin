function evtExportar (id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "exportar";
	theForm.ID.value = id;
	theForm.submit();
}

function evtBuscar() {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "buscar";
	theForm.submit();
}

function evtEliminar(id) {
	var confirmacion = false;
	confirmacion = confirm("¿Desea eliminar el registro histórico?");
	
	if (confirmacion) {
		var theForm = document.getElementById("ActionForm");
		
		theForm.ID.value = id;
		theForm.Evento.value = "eliminar";
		theForm.submit();
	}
}

function evtAplicar(id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.ID.value = id;
	theForm.Evento.value = "aplicar";
	theForm.submit();
}
