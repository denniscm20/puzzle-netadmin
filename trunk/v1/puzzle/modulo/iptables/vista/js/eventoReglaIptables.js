function evtPoliticas () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "aplicarPoliticas";
	theForm.submit();
}

function evtCargarRegla() {
	var theForm = document.getElementById("ActionForm");
	theForm.submit();
}

function evtAgregarReglaPredefinida(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "agregarReglaPredefinida";
	theForm.submit();
}

function evtEliminarReglaPredefinida(id) {
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "eliminarReglaPredefinida";
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

function evtCargarReglaAvanzada() {
	var theForm = document.getElementById("ActionForm");
	theForm.submit();
}

function evtCargarNodoInput() {
	var theForm = document.getElementById("ActionForm");
	theForm.txtIPOrigen.value = theForm.cmbNodoInput.value;
}

function evtCargarNodoOutput() {
	var theForm = document.getElementById("ActionForm");
	theForm.txtIPDestino.value = theForm.cmbNodoOutput.value;
}

function evtSalir () {
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "salir";
	theForm.submit();
}

