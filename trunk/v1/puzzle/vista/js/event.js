function evtLogin() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "iniciarSesion";
	theForm.txtPassword.value = cifrar(theForm.txtPassword.value,'SHA-512');
	//prompt("Cifrado", cifrar(theForm.txtPassword.value,'SHA-512'));
	theForm.submit();
}

function evtRecargar() {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Recargar Datos del Servidor?");
	
	if (confirmacion) {
		theForm.Evento.value = "recargar";
		theForm.submit();
	}
}

function evtGuardar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "guardar";
	theForm.submit();
}

function evtRedirigir(id) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "redirigir";
	theForm.ID.value = id;
	theForm.submit();
}

function evtCancelar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "cancelar";
	theForm.submit();
}

function evtEliminar(id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Eliminar el registro?");
	
	if (confirmacion) {
		theForm.ID.value = id;
		theForm.Evento.value = "eliminar";
		theForm.submit();
	}
}

function evtBuscar() {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = "buscar";
	theForm.submit();
}

function evtEvento(evento) {
	var theForm = document.getElementById("ActionForm");

	theForm.Evento.value = evento;
	theForm.submit();
}