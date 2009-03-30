<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR.'ControladorInterfaz.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaInterfaz extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aInterfaz = null;

	/**
	* Constructor de la VistaInterfaz.
	*
	* @param controlador::ControladorInterfaz pControlador Controlador de la pantalla.
	* @return 
	* @access private
	*/
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
			if ($lEvento != "") {
				$this->aControlador->{$lEvento}();
			}
		}
		
		$this->aInterfaz = $this->aControlador->buscarID();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
	?>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=Interfaz" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID",$this->aInterfaz->ID)?>
			<?=HTML::Hidden("ServidorID",1)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Informaci&oacute;n de la Interfaz</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Valores Generales</legend>
						<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
								<tr><td><label>Interfaz:</label></td>
								<td><?=$this->aInterfaz->Nombre;?></td></tr>
								<tr><td><label>IP:</label></td>
								<td><?=$this->aInterfaz->IP?></td></tr>
								<tr><td><label>MAC:</label></td>
								<td><?=$this->aInterfaz->MAC?></td></tr>
								<tr><td valign="top"><label accesskey="d" for="txtDescripcion"><u>D</u>escripción:</label></td>
								<td><?=HTML::TextBox("txtDescripcion", $this->aInterfaz->Descripcion, 20, 20, 1, "textField")?></td></tr>
								<tr><td valign="top"><label>Internet:</label></td>
								<td><?=HTML::CheckBox("chkInternet", 1, ($this->aInterfaz->Internet == 1), 2, "checkbox")?></td></tr>
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
			<br>
		</form>
	<?	
	} // end of member function contenido


} // end of VistaAdministrarInterfaz
?>
