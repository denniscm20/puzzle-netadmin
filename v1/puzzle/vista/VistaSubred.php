<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CONTROLADOR.'ControladorSubred.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaSubred extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aSubred = null;
	
	private $aInterfaces = null;
	
	private $aInterfaz = null;
	
	private $aNodo = null;

	/**
	* Constructor de la VistaInterfaz.
	*
	* @param controlador::ControladorInterfaz pControlador Controlador de la pantalla.
	* @return 
	* @access private
	*/
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		$lEvento = "";
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
		}
		$this->aControlador->procesar($lEvento);

		$this->aSubred = $this->aControlador->getSubred();
		$this->aInterfaces = $this->aControlador->getInterfaces();
		$this->aInterfaz = $this->aControlador->getInterfaz();
		$this->aNodo = $this->aControlador->getNodo();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=Subred";
		if ($this->aSubred->ID) {
			$lAccion .= "&Subred=".$this->aSubred->ID;
		}
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("ID","")?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Informaci&oacute;n de la Subred</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Valores Generales</legend>
						<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
							<tr><td><label accesskey="s" for="txtNombre"><u>S</u>ubred:</label></td><td><?=HTML::TextBox("txtNombre",$this->aSubred->Nombre,50,50,1,"textField");?></td></tr>
							<tr><td><label accesskey="n" for="cmbInterfaz">I<u>n</u>terfaz:</label></td><td><?=HTML::ComboBox("cmbInterfaz",$this->aInterfaces,"ID","Nombre",2,$this->aInterfaz->ID,"combobox","evtCargar();")?></td></tr>
							<tr><td><label accesskey="i" for="txtIP"><u>I</u>P:</label></td><td><?=HTML::TextBox("txtIP",$this->aSubred->IP,50,15,3,"textField");?></td></tr>
							<tr><td><label accesskey="m" for="txtMascara"><u>M</u>&aacute;scara:</label></td><td><?=HTML::TextBox("txtMascara",$this->aSubred->Mascara,50,15,4,"textField");?></td></tr>
							<tr><td><label accesskey="c" for="txtMascaraCorta">Máscara <u>C</u>orta:</label></td><td><?=HTML::TextBox("txtMascaraCorta",$this->aSubred->MascaraCorta,5,2,5,"textField");?></td></tr>
							<tr><td colspan="2" align="right">
							<?=HTML::Button("btnAgregar","Guardar",6,"button","evtGuardar()");?>
							&nbsp;
							<?=HTML::Button("btnCancelar","Salir",7,"button","evtCancelar()");?>
							</td></tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<?if ($this->aSubred->ID) {?>
			<tr>
				<td>
					<fieldset>
					<legend>Nodos Registrados</legend>
						<?
						$lTabla = new Tabla(array("N&deg;","IP","Hostname","Acciones"));
						$lNodos = $this->aSubred->Nodos;
						$lIndex = 0;
						foreach ($lNodos as $lNodo) {
							$lIndex++;
							$lFila = array($lIndex, $lNodo->IP, $lNodo->Hostname, HTML::ImageButton("btnEliminar", IMAGENES."boton/delete.png", "Eliminar Nodo", 0, "", "evtEliminarNodo(".$lNodo->ID.")"));
							$lTabla->addRow($lFila);
						}
						$lFila = array($lIndex+1, HTML::TextBox("txtIPNodo", $this->aNodo->IP, 20, 50, 1, "textField"), HTML::ImageButton("btnHost", IMAGENES."boton/hostname.png", "Obtener Hostname", 0, "", "evtObtenerHost()")."&nbsp;".HTML::TextBox("txtHostnameNodo", $this->aNodo->Hostname, 20, 50, 1, "textField"), HTML::ImageButton("btnNuevo", IMAGENES."boton/new.png", "Nuevo Nodo", 0, "", "evtAgregarNodo()"));
						$lTabla->addRow($lFila);
						echo $lTabla;
						?>
					</fieldset>
				</td>
			</tr>
			<?}?>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido


} // end of VistaAdministrarInterfaz
?>
