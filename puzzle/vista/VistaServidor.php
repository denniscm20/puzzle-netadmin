<?php
/**
 * @package /vista/
 * @class VistaServidor.php
 * @author Dennis Cohn Muroy
 * @version 1.0
 */

require_once CONTROLADOR.'ControladorServidor.php';
require_once CLASES.'Servidor.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'IPv4Valida.php';
require_once BASE.'Vista.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * @class VistaServidor
 * Vista que genera la pantalla de datos del servidor.
 */
class VistaServidor extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la vista VistaServidor.
	 * @access private
	 */
	private $aControlador = null;

	 private $aServidor = null;

	/**
	 * Contrusctor de la VistaServidor
	 *
	 * @param controlador::ControladorServidor pControlador Controlador la pantalla VistaServidor

	 * @return 
	 * @access public
	 */
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		$this->aServidor = new Servidor();
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
			if ($lEvento != "") {
				$this->aControlador->{$lEvento}();
			}
		}
			
		$this->aServidor = $this->aControlador->buscarID();
	} // end of member function __construct

	/**
	 * Genera el contenido de la página VistaServidor.
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
?>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=Servidor" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("IPValidaID","")?>
			<?=HTML::Hidden("ServidorID",$this->aServidor->ID)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Datos del Servidor</h1></th></tr>
			<tr>
				<td>
					<fieldset>
					<legend>Valores Generales</legend>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background:#669966">
					<tr><td width="200px"><label>Nombre del Host:</label></td><td><?=$this->aServidor->Hostname;?></td></tr>
					<tr><td><label>Puerta de Enlace:</label></td><td><?=$this->aServidor->Gateway;?></td></tr>
					<tr><td><label>DNS primario:</label></td><td><?=$this->aServidor->DNS1;?></td></tr>
					<tr><td><label>DNS secundario:</label></td><td><?=$this->aServidor->DNS2;?></td></tr>
					<tr><td><label>Reenv&iacute;o de paquetes:</label></td><td><?= ($this->aServidor->Reenvio == 0)? "Deshabilitado&nbsp;".HTML::ImageButton("btnHabilitar", $pSrc = IMAGENES."boton/iniciar.png", "Habilitar", 0, "", "evtHabilitar()"): "Habilitado&nbsp;".HTML::ImageButton("btnDeshabilitar", $pSrc = IMAGENES."boton/detener.png", "Deshabilitar", 0, "", "evtHabilitar()")?></td></tr>
					</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Interfaces Detectadas</legend>
					<?
					$lCabecera = array("N&deg;","Interfaz","IP","MAC");
					$lTabla = new Tabla($lCabecera);
					$lInterfaces = $this->aServidor->Interfaces;
					//$lInterfaces = array(array(0,"eth0","0.0.0.0"),array(1,"lo","127.0.0.1"),array(2,"wlan0","0.0.0.0"));
					$lIndex = 0;
					foreach ($lInterfaces as $lInterfaz) {
						$lIndex++;
						$lFila = array($lIndex,$lInterfaz->Nombre,$lInterfaz->IP,$lInterfaz->MAC);
						$lTabla->addRow($lFila);
					}
					echo $lTabla;
					?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Direcciones IP V&aacute;lidas</legend>
					<?
					$lCabecera = array("N&deg;","IP","Acciones");
					$lTabla = new Tabla($lCabecera);
					$lIPv4Validas = $this->aServidor->IpHabiles;
					$lIndex = 0;
					foreach ($lIPv4Validas as $lIPv4Valida) {
						$lIndex++;
						$lFila = array($lIndex,$lIPv4Valida->IP,HTML::ImageButton("btnEliminar",IMAGENES."boton/delete.png","Eliminar IP",0,"","evtEliminarIP(".$lIPv4Valida->ID.")"));
						$lTabla->addRow($lFila);
					}
					if (unserialize($_SESSION["usuario"])->esAdministrador()) {
						$lFila = array($lIndex+1,HTML::TextBox("txtNuevoIP","",20,15,1,"textField"),HTML::ImageButton("btnNuevo",IMAGENES."boton/new.png","Nuevo IP",0,"","evtAgregarIP()"));
						$lTabla->addRow($lFila);
					}
					echo $lTabla;
					?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td align="right">
					<?=HTML::button("btnRecargar","Recargar...",1,"button","evtRecargar()")?>
				</td>
			</tr>
			</table>
			<br>
		</form>
<?php
	} // end of member function contenido

} // end of VistaServidor
?>
