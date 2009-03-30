<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaNatIptables.php
 * @class vista/VistaNatIptables.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES.'Nodo.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Subred.php';
require_once CLASES_IPTABLES.'Accion.php';
require_once CLASES_IPTABLES.'Iptables.php';
require_once CLASES_IPTABLES.'ReglaIptables.php';
require_once CLASES_IPTABLES.'Categoria.php';
require_once CLASES_IPTABLES.'Cadena.php';
require_once CLASES_IPTABLES.'Politica.php';
require_once CLASES_IPTABLES.'Protocolo.php';
require_once CLASES_IPTABLES.'Estado.php';
require_once CLASES_IPTABLES.'Table.php';
require_once CLASES_IPTABLES.'ReglaPredefinida.php';
require_once CONTROLADOR_IPTABLES.'ControladorReglaIptables.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaNatIptables
 */
class VistaNatIptables extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	private $aIptables = null;
	private $aTablaNat = null;
	private $aReglaNat = null;
	private $aPoliticas = array();
	private $aAcciones = array();
	private $aInterfaces = array();
	private $aSubredEntrada = array();
	private $aSubredSalida = array();
	private $aNodoSalida = array();
	private $aProtocolos = array();
	
	private $aFocus = array();
	private $aReady = array();
	private $aContent = array();
	
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

		$this->aIptables = $this->aControlador->getIptables();
		$this->aTablaNat = $this->aControlador->getTablaNat();
		$this->aReglaNat = $this->aControlador->getReglaNat();
		$this->aPoliticas = $this->aControlador->getPoliticas();
		$this->aAcciones = $this->aControlador->getAcciones();
		$this->aInterfaces = $this->aControlador->getInterfaces();
		$this->aSubredEntrada = $this->aControlador->getSubredEntrada();
		$this->aSubredSalida = $this->aControlador->getSubredSalida();
		$this->aNodoSalida = $this->aControlador->getNodoSalida();
		$this->aProtocolos = $this->aControlador->getProtocolos();
		
		$this->aFocus = array();
		$this->aReady = array();
		$this->aContent = array();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaNatIptables
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=NatIptables&Modulo=Iptables";
		if (isset($_GET["Regla"])) {
			$lRegla = $_GET["Regla"];
			if (($lRegla == "Politica") or ($lRegla == "Personalizada") or ($lRegla == "404")) {
				$lAccion .= "&Regla=".$_GET["Regla"];
			} else {
				header("Location:".$lAccion."&Regla=404");
			}
		}
	?>
		<script type="text/javascript" language="JavaScript">
			<?
				$lCount = count($this->aTablaNat->Cadenas);
				$this->aFocus = array();
				$this->aReady = array();
				$this->aContent = array();
				for ($i = 0; $i < $lCount; $i++) {
					$lIndex = $i + 1;
					$this->aFocus[] = "'tab".$lIndex."focus'";
					$this->aReady[] = "'tab".$lIndex."ready'";
					$this->aContent[] = "'content".$lIndex."'";
				}
			?>
			idlist = new Array(<?=implode(",",$this->aFocus).",".implode(",",$this->aReady).",".implode(",",$this->aContent)?>);
		</script>
		<table id="content" align="center" cellpadding="0" cellspacing="0" >
		<tr><th><h1>Configuraci&oacute;n de las Reglas del Nat</h1></th></tr>
		<? if ($this->aIptables->ID > 0) { ?>
		<tr>
			<td>
				<div id="toolbar">
					<a href="index.php?Pagina=NatIptables&amp;Modulo=Iptables&amp;Regla=Politica">
					<img src="<?=IMAGENES_IPTABLES?>boton/policy.png" alt="[Politicas]" title="Políticas">&nbsp;Políticas
					</a>
					&nbsp;
					<a href="index.php?Pagina=NatIptables&amp;Modulo=Iptables&amp;Regla=Personalizada">
					<img src="<?=IMAGENES_IPTABLES?>boton/settings.png" alt="[Personalizadas]" title="Reglas Personalizadas">&nbsp;Reglas Personalizadas
					</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>" method="POST">
					<?=HTML::Hidden("Evento","")?>
					<?=HTML::Hidden("ReglaID","")?>
					<?=HTML::Hidden("Iptables",$this->aIptables->ID)?>
					<br>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<?
								$lFuncion = "texto".(isset($_GET["Regla"])?$_GET["Regla"]:"Politica");
								$this->{$lFuncion}();
							?>
						</td>
					</tr>
					</table>
					<?
					$lFuncion = "cargar".(isset($_GET["Regla"])?$_GET["Regla"]:"Politica");
					$this->{$lFuncion}();
					?>
					<br>
					<div align="right"><?=Html::Button("btnSalir", "Salir", 1, "button", "evtSalir()")?></div>
				</form>
			</td>
		</tr>
		<? } else { ?>
		<tr>
			<td>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
				<tr>
					<td>
						<p align="center" style="font-weight:normal;">
						<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> No se ha definido una configuración activa. 
						Para seleccionar una, acceda al siguiente <u><a href="index.php?Pagina=HistoricoIptables&amp;Modulo=Iptables">enlace</a></u>.
						</p>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<? } ?>
		</table>
		<br>
	<?	
	} // end of member function contenido
	
	protected function textoPolitica(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla pueden asingar las políticas predefinidas 
		para cada cadena.  Estos valores se ejecutará en caso el paquete entrante no cumpla con ninguna regla registrada en la cadena.
		</p>
		<?
	}
	
	protected function textoPersonalizada() {
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede registrar nuevas reglas que usted defina 
		para la funcionalidad de filtrado de paquetes del Iptables.
		</p>
		<?
	}
	
	protected function cargarPolitica() {
		?>
		<fieldset>
			<legend>Políticas de Seguridad</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<? 
				$lIndex = 0;
				foreach ($this->aTablaNat->Cadenas as $lCadena) {
			?>
				<tr>
					<td valign="top" width="120px"><?=HTML::ComboBox("cmbCadena".$lCadena->ID, $this->aPoliticas, "ID", "Nombre", "0", $lCadena->Politica->ID, "combobox") ?></td>
					<td valign="top" align="left"><b><?=$lCadena->Nombre.": "?></b></td>
					<td valign="top" align="left"><?=$lCadena->Descripcion ?></td>
				</tr>
			<?
					$lIndex++;
				}
			?>
			<tr><td colspan="3" align="right"><br><?=Html::Button("btnPolitica", "Guardar", 1, "button", "evtPoliticas()")?></td></tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function cargarPersonalizada() {
		?>
		<fieldset>
			<legend>Reglas NAT</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr><td>
				<p>
					<ul style="list-style-type: none; margin: 0; padding: 0;">
						<? foreach ($this->aAcciones as $lAccion) {	?>
						<li><?=HTML::RadioButton("rdbTipo[]", $lAccion->ID, ($this->aReglaNat->Accion->ID == $lAccion->ID), $pTabIndex = 0, "")?>&nbsp;<?=$lAccion->Descripcion?></li>
						<? } ?>
					</ul>
				</p>
				<br>
			</td></tr>
			</table>
			<br>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr><td>
				<p><b>Dirección de Origen:</b></p>
				<p>
					IP de Origen: <?=HTML::TextBox("txtIPEntrada", "", 15, 15, 0, "textField")?><br>
					Interfaz / Subred de Origen: <?=HTML::ComboBox("cmbInterfazEntrada", $this->aInterfaces, "ID", "Nombre", 0, $this->aReglaNat->InterfazOrigen->ID, "combobox", "recargar();")?>
					&nbsp;<?=HTML::ComboBox("cmbSubredEntrada", $this->aReglaNat->InterfazOrigen->Subredes, "ID", "Nombre", 0, $this->aSubredEntrada->ID, "combobox", "")?><br>
				</p>
				<p><b>Dirección con la que se Enmascarará el Origen:</b></p>
				<p>
					IP de Enmascaramiento: <?=HTML::TextBox("txtIPNueva", "", 15, 15, 0, "textField")?><br>
					Interfaz / Subred Destino: <?=HTML::ComboBox("cmbInterfazSalida", $this->aInterfaces, "ID", "Nombre", 0, $this->aReglaNat->InterfazDestino->ID, "combobox", "recargar();")?>
					&nbsp; <?=HTML::ComboBox("cmbSubredSalida", $this->aReglaNat->InterfazDestino->Subredes, "ID", "Nombre", 0, $this->aSubredSalida->ID, "combobox", "")?><br>
				</p>
				<p>Protocolo: <?=HTML::ComboBox("cmbProtocolo", $this->aProtocolos, "ID", "Nombre", 3, $this->aReglaNat->Protocolo->ID, "combobox")?></p>
				<p>Reemplazar puertos:</p>
					<?=HTML::TextBox("txtPuertoDestinoInicial", "", 6, 6, 0, "textField")?>
					&nbsp;:&nbsp;
					<?=HTML::TextBox("txtPuertoDestinoFinal", "", 6, 6, 0, "textField")?>
					&nbsp;con&nbsp;
					<?=HTML::TextBox("txtPuertoNuevoInicial", "", 6, 6, 0, "textField")?>
					&nbsp;:&nbsp;
					<?=HTML::TextBox("txtPuertoNuevoFinal", "", 6, 6, 0, "textField")?>
				</p>
			</td></tr>
			<tr><td colspan="3" align="right"><br><?=Html::Button("btnAgregar", "Agregar", 1, "button", "evtAgregarRegla()")?></td></tr>
			</table>
			<br>
			<table width="590" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<? 
					$lCount = count($this->aTablaNat->Cadenas);
					for ($i = 0; $i < $lCount; $i++) {
						$lCadena = $this->aTablaNat->Cadenas[$i];
				?>
				<td>
					<div id="<?=substr($this->aFocus[$i],1,strlen($this->aFocus[$i])-2)?>" class="tab tabfocus" style="display:<?=($i == 0)?"block":"none"?>;">
						<?=$lCadena->Nombre?> 
					</div>
					<div id="<?=substr($this->aReady[$i],1,strlen($this->aReady[$i])-2)?>" class="tab tabhold" style="display:<?=($i == 0)?"none":"block"?>;">
						<?
							$lManageDisplayLabel = "";
							for ($j = 0; $j < $lCount; $j++) {
								if (($j) == $i ) {
									$lManageDisplayLabel .= $this->aFocus[$j].",";
								} else {
									$lManageDisplayLabel .= $this->aReady[$j].",";
								}
							}
							$lManageDisplayLabel .= $this->aContent[$i];
						?>
						<span onclick="ManageTabPanelDisplay(<?=$lManageDisplayLabel?>)"><?=$lCadena->Nombre?></span>
					</div>
				</td>
				<?
					}
				?>
			</tr>
			<tr>
				<td colspan="<?=$lCount?>">
					<? 
					$lCabecera = array("N&deg;","Origen","Destino","Tipo de NAT","");
					for ($i = 0; $i < $lCount; $i++) { 
						$lReglasIptables = $this->aTablaNat->Cadenas[$i]->ReglasIptables;
					?>
					<div id="<?=substr($this->aContent[$i],1,strlen($this->aContent[$i])-2)?>" class="tabcontent" style="display:<?=($i==0)?"block":"none"?>;">
						<?
							$lTabla = new Tabla($lCabecera);
							$lNum = 0;
							foreach ($lReglasIptables as $lReglaIptables) {
								$lNum++;
								$lIPOrigen = $lReglaIptables->IPOrigen;
								$lPuertoOrigen = "[".($lReglaIptables->PuertoOrigenFinal == ""? $lReglaIptables->PuertoOrigenInicial : $lReglaIptables->PuertoOrigenInicial.":".$lReglaIptables->PuertoOrigenFinal)."]";
								$lIPDestino = $lReglaIptables->IPDestino;
								$lPuertoDestino = "[".($lReglaIptables->PuertoDestinoFinal == ""? $lReglaIptables->PuertoDestinoInicial : $lReglaIptables->PuertoDestinoInicial.":".$lReglaIptables->PuertoDestinoFinal)."]";
								$lEjecutar = $lReglaIptables->Accion->Nombre;
								$lEliminar = HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Subred",0,"","evtEliminarRegla(".$lReglaIptables->ID.")");
								$lLinea = array($lNum, $lIPOrigen."&nbsp".$lPuertoOrigen,$lIPDestino."&nbsp;".$lPuertoDestino, $lEjecutar,$lEliminar);
								$lTabla->addRow($lLinea);
							}
							echo $lTabla;
						?>
						<br>
					</div>
					<?}?>
				</td></tr>
			</table>
		</fieldset>
	<?
	}
	
	protected function texto404(){
		?>
		<p align="center" style="font-weight:bold;">
		<img alt="[Error]" src="<?=IMAGENES?>mensaje/error.png">No ha sido posible encontrar la Página Solicitada.
		</p>
		<p align="center">
		(**) Se recomienda no modificar los valores ubicados en la barra URL del navegador.
		</p>
		<?
	}
	
	protected function cargar404() {
	}

} // end of VistaNatIptables
?>
