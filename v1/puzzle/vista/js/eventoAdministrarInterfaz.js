function evtEliminar(id) {
	var confirmacion = false;
	var theForm = document.getElementById("ActionForm");
	
	confirmacion = confirm("¿Desea eliminar el registro?");
	
	if (confirmacion) {
		theForm.SubredID.value = id;
		theForm.Evento.value = "eliminar";
		theForm.submit();
	}
}