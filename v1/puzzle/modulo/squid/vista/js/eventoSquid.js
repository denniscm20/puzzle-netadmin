
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

function evtAgregarPuerto(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "agregarPuerto";
	theForm.submit();
}

function evtEliminarPuerto(numero){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Puerto.value = numero;
	theForm.Evento.value = "eliminarPuerto";
	theForm.submit();
}

function evtCancelar(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "cancelar";
	theForm.submit();
}

function evtImportar () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "importar";
	theForm.submit();
}