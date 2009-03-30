<?php

/**
 * @package /vista/
 * @class VistaUsuario
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
	require_once(LIB."html.php");
	require_once(LIB."tabla.php");
	require_once(BASE."Vista.php");
	require_once(CONTROLADOR."ControladorAdministrarUsuario.php");
	require_once(CLASES."Usuario.php");
	
	/**
	* @class VistaUsuario
	* Vista que genera la pantalla de registro de usuarios.
	*/
	class VistaUsuario extends Vista {
		
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
			
			$this->aUsuario = $this->aControlador->buscarID();
		}
	
		/**
		* Muestra el contenido de la página.
		*
		* @access public
		*/
		public function contenido() {
			$lAccion = "index.php?Pagina=Usuario";
			if ($this->aUsuario->ID) {
				$lAccion .= "&ID=".$this->aUsuario->ID;
			}
		?>
			<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
				<?=HTML::Hidden("Evento","")?>
				<?=HTML::Hidden("ID",$this->aUsuario->ID)?>
				<table id="content" align="center" cellpadding="0" cellspacing="0">
				<tr><th><h1>Registrar Usuario</h1></th></tr>
				<tr>
					<td>
						<fieldset>
							<legend>Datos del Usuario</legend>
							<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background:#669966;">
								<tr><td><label accesskey="u" for="usuario"><u>U</u>suario</label></td>
								<td><?=HTML::TextBox("usuario",$this->aUsuario->Nombre,43,20,1,"textField");?></td></tr>
								<tr><td><label accesskey="c" for="password"><u>C</u>ontrase&ntilde;a:</label></td>
								<td><?=HTML::Password("password","",43,20,2,"textField")?></td></tr>
								<tr><td><label accesskey="o" for="confirmacion">C<u>o</u>nfirmar Contrase&ntilde;a:</label></td>
								<td><?=HTML::Password("confirmacion","",43,20,3,"textField");?></td></tr>
								<tr><td colspan="2" align="right">
								<?=HTML::Button("btnAgregar","Guardar",4,"button","evtGuardar()");?>
								&nbsp;
								<?=HTML::Button("btnCancelar","Cancelar",5,"button","evtCancelar()");?>
								</td></tr>
							</table>
						</fieldset>
					</td>
				</tr>
				</table>
			</form>
		<?php
		}
	}
?>