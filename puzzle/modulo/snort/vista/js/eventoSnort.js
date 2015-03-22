
function evtGuardar () {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("Los datos serán guardados \n ¿Desea continuar?");
	
	if (confirmacion) {
		theForm.Evento.value = "guardar";
		theForm.submit();
	}
}

function evtAnterior(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "anterior";
	theForm.submit();
}

function evtSiguiente(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "siguiente";
	theForm.submit();
}

function evtCancelar(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "cancelar";
	theForm.submit();
}

function evtAgregar() {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "agregar";
	theForm.submit();
}

function evtRemover(id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "remover";
	theForm.Elemento.value = id;
	theForm.submit();
}

function evtCargarCombo() {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "cargarParametros";
	theForm.submit();
}

function evtImportar () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "importar";
	theForm.submit();
}
