<?php

/**
 * @package /vista/
 * @class VistaAdministrarCuenta
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
 
	require_once(LIB."html.php");
	require_once(LIB."tabla.php");
	require_once BASE.'Vista.php';
	require_once(CONTROLADOR."ControladorAdministrarCuenta.php");
	require_once(CLASES."Usuario.php");
	
	/**
	* @class VistaAdministrarCuenta
	* Vista que genera la pantalla de registro de usuarios.
	*/
	class VistaAdministrarCuenta extends Vista {
		
		private $aControlador = null;
		private $aUsuario = null;
		
		/**
		* Contructor de la VistaUsuario
		*
		* @param controlador::ControladorCambiarPassword aControlador Objeto controlador 
		* @access public
		*/
		public function __construct($pControlador) {
			$this->aControlador = $pControlador;
			$this->aUsuario = new Usuario();
			if (isset($_POST['Evento'])) {
				$lEvento = $_POST['Evento'];
				if ($lEvento != "") {
					$this->aControlador->{$lEvento}();
				}
			}
			
			$this->aUsuario = unserialize($_SESSION["usuario"]);
		}
	
		/**
		* Muestra el contenido de la página.
		*
		* @access public
		*/
		public function contenido() {
		?>
			<form id="ActionForm" name="ActionForm" action="index.php?Pagina=AdministrarCuenta" method="POST">
				<?=HTML::Hidden("Evento","")?>
				<?=HTML::Hidden("ID",$this->aUsuario->ID)?>
				<?=HTML::Hidden("usuario",$this->aUsuario->Nombre);?>
				<table id="content" align="center" cellpadding="0" cellspacing="0">
				<tr><th><h1>Administrar Cuenta</h1></th></tr>
				<tr>
					<td>
						<fieldset>
							<legend>Datos del Usuario</legend>
							<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
								<tr><td><label accesskey="u" for="usuario"><u>U</u>suario</label></td>
								<td><?=$this->aUsuario->Nombre;?></td></tr>
								<tr><td><label accesskey="c" for="password"><u>C</u>ontrase&ntilde;a:</label></td>
								<td><?=HTML::Password("txtPassword","",43,20,2,"textField")?></td></tr>
								<tr><td><label accesskey="o" for="confirmacion">C<u>o</u>nfirmar Contrase&ntilde;a:</label></td>
								<td><?=HTML::Password("txtConfirmacion","",43,20,3,"textField");?></td></tr>
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