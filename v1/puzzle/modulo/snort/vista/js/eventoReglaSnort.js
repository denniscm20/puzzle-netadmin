
function evtAgregarRegla(id){
	var theForm = document.getElementById("ActionForm");
	
	theForm.ReglaID.value = id;
	theForm.Evento.value = "agregarRegla";
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

