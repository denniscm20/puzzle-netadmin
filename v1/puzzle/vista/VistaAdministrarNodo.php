<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once 'controlador/ControladorAdministrarNodo.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaAdministrarNodo extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	private $aInterfaces = null;
	private $aSubredes = null;
	private $aSubredesSinClasificar = null;
	private $aSubred = null;
	private $aNodo = null;

	/**
	* Constructor del VistaAdministrarInterfaz.
	*
	* @param controlador::ControladorAdministrarInterfaz pControlador Controlador de la pantalla.

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
		
		$this->aNodo = $this->aControlador->getNodo();
		$this->aSubred = $this->aControlador->getSubred();
		$this->aInterfaces = $this->aControlador->listarInterfacesPorServidor();
		$this->aSubredes = $this->aControlador->listarSubredes();
		$this->aSubredesSinClasificar = $this->aControlador->listarSubredesSinInterfaz();
	} // end of member function __construct
	
	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
	?>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=AdministrarNodo" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("SubredID","")?>
			<?=HTML::Hidden("NodoID","")?>
			<?=HTML::Hidden("ServidorID",1)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Listado de Nodos</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=AdministrarInterfaz">
						<img src="<?=IMAGENES?>boton/nic.png" alt="[Administrar Interfaz]" title="Administrar Interfaz">&nbsp;Administrar Interfaz
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Subredes Detectadas</legend>
						<?
						$lCountInterfaces = count($this->aInterfaces);
						for ($i = 0; $i < $lCountInterfaces; $i++) {
							$lSubredes = $this->aInterfaces[$i]->Subredes;
							$lCountSubredes = count($lSubredes);
						?>
							<div style="color:#003300;">
							<h2>Interfaz: <?=$this->aInterfaces[$i]->Nombre?></h2>
						<?
							if ($lCountSubredes > 0) {
								for ($j = 0; $j < $lCountSubredes; $j++) {
								?>
									
									<h3>Subred: <?=$lSubredes[$j]->Nombre?></h3>
									
									<?
									$lNodos = $lSubredes[$j]->Nodos;
									$lCountNodos = count($lNodos);
									$lTabla = new Tabla(array("N&deg;","IP","Hostname","Acciones"));
									for ($k = 0; $k < $lCountNodos; $k++) {
										$lNodo = $lNodos[$k];
										$lFila = array($k + 1, $lNodo->IP, $lNodo->Hostname, HTML::ImageButton("btnEliminar", IMAGENES."boton/delete.png", "Eliminar Nodo", 0, "", "evtEliminarNodo(".$lNodo->ID.")"));
										$lTabla->addRow($lFila);
									}
									$lFila = array( $lCountNodos+1, 
										HTML::TextBox("txtIPNodo".$lSubredes[$j]->ID, ($lSubredes[$j]->ID != $this->aSubred->ID)?"0.0.0.0":$this->aNodo->IP, 20, 50, 1, "textField"), 
										HTML::ImageButton("btnHost".$lSubredes[$j]->ID, IMAGENES."boton/hostname.png", "Obtener Hostname", 0, "", "evtObtenerHost(".$lSubredes[$j]->ID.")")."&nbsp;".HTML::TextBox("txtHostnameNodo".$lSubredes[$j]->ID, ($lSubredes[$j]->ID != $this->aSubred->ID)?"":$this->aNodo->Hostname, 20, 50, 1, "textField"), 
										HTML::ImageButton("btnNuevo".$lSubredes[$j]->ID, IMAGENES."boton/new.png", "Nuevo Nodo", 0, "", "evtAgregarNodo('".$lSubredes[$j]->ID."')"));
									$lTabla->addRow($lFila);
									echo $lTabla;
								}
							} else {
								echo "No existen subredes registradas para esta interfaz.";
							}
							?>
							</div>
							<br><hr><br>
						<?
						}
						?>
					</fieldset>
					<fieldset>
					<legend>Subredes sin Clasificar</legend>
					<div style="color:#003300;">
					<?
					$lCountSubredes = count($this->aSubredesSinClasificar);
					if ($lCountSubredes > 0) {
						for ($j = 0; $j < $lCountSubredes; $j++) {
					?>
							<h3>Subred: <?=$this->aSubredesSinClasificar[$j]->Nombre?>&nbsp;<?=HTML::ImageButton("btnEliminarSubred", IMAGENES."boton/delete.png", "Eliminar Subred", 0, "", "evtEliminarSubred(".$this->aSubredesSinClasificar[$j]->ID.")")?></h3>
						<?
							$lNodos = $this->aSubredesSinClasificar[$j]->Nodos;
							$lCountNodos = count($lNodos);
							$lTabla = new Tabla(array("N&deg;","IP","Hostname", "Destino","Acciones"));
							for ($k = 0; $k < $lCountNodos; $k++) {
								$lNodo = $lNodos[$k];
								$lFila = array($k + 1, $lNodo->IP, $lNodo->Hostname, HTML::ComboBox("cmbDestino".$lNodo->ID, $this->aSubredes, "ID", "Nombre", 0, "0", "", "evtMover(".$lNodo->ID.")"), HTML::ImageButton("btnEliminar", IMAGENES."boton/delete.png", "Eliminar Nodo", 0, "", "evtEliminarNodo(".$lNodo->ID.")"));
								$lTabla->addRow($lFila);
							}
							echo $lTabla;
						}
					} else {
						echo "No existen subredes sin clasificar.";
					}
					?>
					</div>
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
