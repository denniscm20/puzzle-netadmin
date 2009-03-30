function evtEliminarNodo (id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea eliminar el registro?");
	
	if (confirmacion) {
		theForm.NodoID.value = id;
		theForm.Evento.value = "eliminarNodo";
		theForm.submit();
	}
}

function evtEliminarSubred (id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea eliminar la subred con sus respectivos nodos?");
	
	if (confirmacion) {
		theForm.SubredID.value = id;
		theForm.Evento.value = "eliminarSubred";
		theForm.submit();
	}
}

function evtMover (id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea mover el nodo a la subred seleccionada?");
	
	if (confirmacion) {
		theForm.NodoID.value = id;
		theForm.Evento.value = "modificarNodo";
		theForm.submit();
	}
}

function evtAgregarNodo (id) {
	var theForm = document.getElementById("ActionForm");
	theForm.SubredID.value = id;
	theForm.Evento.value = "agregarNodo";
	theForm.submit();
}

function evtObtenerHost(id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.SubredID.value = id;
	theForm.Evento.value = "obtenerHostname";
	theForm.submit();
}