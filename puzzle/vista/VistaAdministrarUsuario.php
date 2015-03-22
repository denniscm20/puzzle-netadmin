<?php

/**
 * @package /vista/
 * @class VistaAdministrarUsuario
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
	require_once(LIB."html.php");
	require_once(LIB."tabla.php");
	require_once(BASE."Vista.php");
	require_once(CONTROLADOR."ControladorAdministrarUsuario.php");
	require_once(CLASES."Usuario.php");
	
	/**
	 * @class VistaAdministrarUsuario
	 * Vista que genera la pantalla de administración de usuarios.
	 */
	class VistaAdministrarUsuario extends Vista {
		
		private $aControlador = null;
		private $aUsuario = null;
		
		/**
		 * Contructor de la VistaUsuario
		 *
		 * @param controlador::ControladorAdministrarUsuario aControlador Objeto controlador 
		 * @access public
		 */
		public function __construct($pControlador) {
			$this->aControlador = $pControlador;
			$this->aRestringido = true;
			$this->aUsuario = new Usuario();
			if (isset($_POST['Evento'])) {
				$lEvento = $_POST['Evento'];
				if ($lEvento != "") {
					$this->aControlador->{$lEvento}();
				}
			}
		}
	
		/**
		 * Permite cargar la grilla de usuarios.
		 *
		 * @access private
		 */
		private function cargarGrilla() {
			$lCabecera = array("N&deg;","Nombre Usuario","Tipo Usuario","Acciones");
			$lTabla = new Tabla($lCabecera);
			
			$lUsuarios = $this->aControlador->listarTodos();
			$lIndice = 1;
			foreach ($lUsuarios as $lUsuario) {
				$lAcciones = "<a href=\"index.php?Pagina=Usuario&ID=".$lUsuario->ID."\"><img src=\"".IMAGENES."boton/edit.png\" alt=\"[Editar Usuario]\" title=\"Editar Usuario\"></a>";
				if (!$lUsuario->Administrador) {
					$lAcciones .= "&nbsp".HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Usuario",0,"","evtEliminar(".$lUsuario->ID.")");
				}
				$lFila = array( $lIndice,
								$lUsuario->Nombre,
								($lUsuario->Administrador)?"Administrador":"Usuario",
								$lAcciones
								);
				$lTabla->addRow($lFila);
				$lIndice++;
			}

			return $lTabla;
		}
		
		/**
		 * Muestra el contenido de la página.
		 *
		 * @access public
		 */
		public function contenido() {
?>
			<form id="ActionForm" name="ActionForm" action="index.php?Pagina=AdministrarUsuario" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("UsuarioID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0">
			<tr><th><h1>Administrar Usuarios</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=Usuario">
						<img src="<?=IMAGENES?>boton/user.png" alt="[Nuevo Usuario]" title="Nuevo Usuario">&nbsp;Nuevo Usuario
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Lista de Usuarios</legend>
					<?=$this->CargarGrilla();?>
					</fieldset>
				</td>
			</tr>
			</table>
			</form>
<?php
		}
	}
?>