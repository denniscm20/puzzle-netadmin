
function evtAgregarRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "agregarRegla";
	theForm.submit();
}

function evtRemoverRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "removerRegla";
	theForm.submit();
}

function evtEliminarRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "eliminarRegla";
	theForm.submit();
}

function evtSalir(){
	var theForm = document.getElementById("ActionForm");
	
	theForm.Evento.value = "salir";
	theForm.submit();
}

function evtAprobarRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "aprobarRegla";
	theForm.submit();
}

function evtDenegarRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "denegarRegla";
	theForm.submit();
}

function evtSeleccionarNombre() {
	var theForm = document.getElementById("ActionForm");
	theForm.txtNombre.value = theForm.cmbNombre.value;
}