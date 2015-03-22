<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
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
 * class VistaAdministrarInterfaz
 */
class VistaReglaIptables extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	private $aIptables = null;
	private $aReglaIptables = null;
	private $aTable = null;
	private $aProtocolos = array();
	private $aPoliticas = array();
	private $aCategorias = array();
	private $aCategoria = null;
	private $aEstados = array();
	private $aReglasPredefinidas = array();
	private $aAcciones = array();
	private $aInterfaces = array();
	
	private $aReglasPredefinidasShow = array();
	
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
		$this->aTable = $this->aControlador->getTable();
		$this->aPoliticas = $this->aControlador->getPoliticas();
		$this->aCategorias = $this->aControlador->getCategorias();
		$this->aCategoria = $this->aControlador->getCategoria();
		$this->aProtocolos = $this->aControlador->getProtocolos();
		$this->aEstados = $this->aControlador->getEstados();
		$this->aReglasPredefinidas = $this->aControlador->getReglasPredefinidas();
		$this->aInterfaces = $this->aControlador->getInterfaces();
		$this->aSubredesInput = $this->aControlador->getSubredesInput();
		$this->aSubredInput = $this->aControlador->getSubredInput();
		$this->aNodosInput = $this->aControlador->getNodosInput();
		$this->aSubredesOutput = $this->aControlador->getSubredesOutput();
		$this->aSubredOutput = $this->aControlador->getSubredOutput();
		$this->aNodosOutput = $this->aControlador->getNodosOutput();
		$this->aAcciones = $this->aControlador->getAcciones();
		$this->aReglaIptables = $this->aControlador->getReglaIptables();
		$this->aReglasPredefinidasShow = $this->aControlador->getReglasPredefinidasShow();
		
		$this->aFocus = array();
		$this->aReady = array();
		$this->aContent = array();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=ReglaIptables&amp;Modulo=Iptables";
		if (isset($_GET["Regla"])) {
			$lRegla = $_GET["Regla"];
			if (($lRegla == "Politica") or ($lRegla == "Predefinida") or ($lRegla == "Personalizada") or ($lRegla == "404")) {
				$lAccion .= "&amp;Regla=".$_GET["Regla"];
			} else {
				header("Location:".$lAccion."&amp;Regla=404");
			}
		}
	?>
		<script type="text/javascript" language="JavaScript">
			<?
				$lCount = count($this->aTable->Cadenas);
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
		<tr><th><h1>Configuraci&oacute;n de las Reglas Iptables</h1></th></tr>
		<? if ($this->aIptables->ID > 0) { ?>
		<tr>
			<td>
				<div id="toolbar">
					<a href="index.php?Pagina=ReglaIptables&amp;Modulo=Iptables&Regla=Politica">
					<img src="<?=IMAGENES_IPTABLES?>boton/policy.png" alt="[Politicas]" title="Políticas">&nbsp;Políticas
					</a>
					&nbsp;
					<a href="index.php?Pagina=ReglaIptables&amp;Modulo=Iptables&Regla=Predefinida">
					<img src="<?=IMAGENES_IPTABLES?>boton/folder.png" alt="[Predefinidas]" title="Reglas Predefinidas">&nbsp;Reglas Predefinidas
					</a>
					&nbsp;
					<a href="index.php?Pagina=ReglaIptables&amp;Modulo=Iptables&Regla=Personalizada">
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
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla pueden asignar las políticas predefinidas 
		para cada cadena.  Estos valores se ejecutará en caso el paquete entrante no cumpla con ninguna regla registrada en la cadena.
		</p>
		<?
	}
	
	protected function textoPredefinida(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla puede agregar nuevas reglas seleccionandolas de 
		una lista de reglas clasificadas por categorías.
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
			foreach ($this->aTable->Cadenas as $lCadena) {
			?>
			<tr>
				<td valign="top" width="120px"><?=HTML::ComboBox("cmbCadena".$lCadena->ID, $this->aPoliticas, "ID", "Nombre", "0", $lCadena->Politica->ID, "combobox") ?></td>
				<td valign="top" align="left"><b><?=$lCadena->Nombre.": "?></b></td>
				<td><?=$lCadena->Descripcion ?></td>
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
	
	protected function cargarPredefinida() {
		?>
		<fieldset>
			<legend>Reglas Predeterminadas</legend>
			<?
			$lCabecera = array("N&deg;","Categoría","Regla","Permitir?","");
			$lTabla = new Tabla($lCabecera);
			$lNum = 0;
			foreach ($this->aReglasPredefinidasShow as $lCategoriaRegla) {
				$lReglas = $lCategoriaRegla->ReglasPredefinidas;
				foreach($lReglas as $lReglaPredefinida) {
					$lNum++;
					$lCategoria = $lCategoriaRegla->Nombre;
					$lRegla = $lReglaPredefinida->Nombre;
					$lPermiso = $lReglaPredefinida->Accion->Nombre;
					$lAcciones = HTML::ImageButton("btnEliminar", IMAGENES_IPTABLES."boton/delete.png", "Eliminar regla", 4, "", "evtEliminarReglaPredefinida(".$lReglaPredefinida->ID.")");
					$lFila = array($lNum,$lCategoria,$lRegla,$lPermiso,$lAcciones);
					$lTabla->addRow($lFila);
				}
			}
			
			$lCategoria = HTML::ComboBox("cmbCategoria", $this->aCategorias, "ID", "Nombre", 1, $this->aCategoria->ID, "combobox", "evtCargarRegla()");
			$lRegla = HTML::ComboBox("cmbReglaPredefinida", $this->aReglasPredefinidas, "ID", "Nombre", 2, "0", "combobox");
			$lPermiso = HTML::ComboBox("cmbAccion", $this->aAcciones, "ID", "Nombre", 3, "0", "combobox");
			$lAcciones = HTML::ImageButton("btnAgregar", IMAGENES_IPTABLES."boton/new.png", "Agregar regla", 4, "", "evtAgregarReglaPredefinida()");
			$lFila = array("",$lCategoria,$lRegla,$lPermiso,$lAcciones);
			$lTabla->addRow($lFila);
			echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function cargarPersonalizada() {
		?>
		<fieldset>
			<legend><a name="ReglasAvanzadas">Reglas Avanzadas</a></legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td>
					<p>Para todos los paquetes con:</p>
					<p>ORIGEN (*): <?=HTML::ComboBox("cmbInterfazInput", $this->aInterfaces, "ID", "Nombre", 3, $this->aReglaIptables->InterfazOrigen->ID, "combobox", "evtCargarReglaAvanzada()")?></p>
					<ul>
						<li style="height:25px;">Puerto(s):<?=
							HTML::TextBox("txtPuertoOrigenInicial",  $this->aReglaIptables->PuertoOrigenInicial, 6, 6, 0, "textField") . 
							" : " . HTML::TextBox("txtPuertoOrigenFinal", $this->aReglaIptables->PuertoOrigenFinal, 6, 6, 0, "textField")
						?></li>
						<li style="height:25px;">Dirección:<?=
							HTML::ComboBox("cmbSubredInput", $this->aSubredesInput, "ID", "Nombre", 3, $this->aSubredInput->ID, "combobox", "evtCargarReglaAvanzada()").
							"&nbsp;".HTML::ComboBox("cmbNodoInput", $this->aNodosInput, "IP", "Hostname", 3, "0", "combobox", "evtCargarNodoInput()").
							"&nbsp;".HTML::TextBox("txtIPOrigen", $this->aReglaIptables->IPOrigen, 15, 15, 0, "textField").
							" / ".HTML::TextBox("txtMascaraOrigen", $this->aReglaIptables->MascaraOrigen, 2, 2, 0, "textField")
						?></li>
					</ul>
							
					<p>DESTINO (*): <?=HTML::ComboBox("cmbInterfazOutput", $this->aInterfaces, "ID", "Nombre", 3,  $this->aReglaIptables->InterfazDestino->ID, "combobox", "evtCargarReglaAvanzada()")?></p>
					<ul>
						<li style="height:25px;">Puerto(s):<?=
							HTML::TextBox("txtPuertoDestinoInicial", $this->aReglaIptables->PuertoDestinoInicial, 6, 6, 0, "textField") . 
							" : " . HTML::TextBox("txtPuertoDestinoFinal", $this->aReglaIptables->PuertoDestinoFinal, 6, 6, 0, "textField")
						?></li>
						<li style="height:25px;">Dirección:<?=
							HTML::ComboBox("cmbSubredOutput", $this->aSubredesOutput, "ID", "Nombre", 3, $this->aSubredOutput->ID, "combobox", "evtCargarReglaAvanzada()").
							"&nbsp;".HTML::ComboBox("cmbNodoOutput", $this->aNodosOutput, "IP", "Hostname", 3, "0", "combobox", "evtCargarNodoOutput()").
							"&nbsp;".HTML::TextBox("txtIPDestino", $this->aReglaIptables->IPDestino, 15, 15, "0", "textField").
							" / ".HTML::TextBox("txtMascaraDestino", $this->aReglaIptables->MascaraDestino, 2, 2, 0, "textField")
						?></li>
					</ul>
					<p>MAC: <?=HTML::TextBox("txtMAC", $this->aReglaIptables->MAC, 17, 17, 0, "textField")?></p>
					<p>Estado: <?=HTML::ComboBox("cmbEstado", $this->aEstados, "ID", "Nombre", 3, $this->aReglaIptables->Estado->ID, "combobox")?></p>
					<p>Protocolo: <?=HTML::ComboBox("cmbProtocolo", $this->aProtocolos, "ID", "Nombre", 3, $this->aReglaIptables->Protocolo->ID, "combobox")?></p>
					<p>Ejecutar (*): <?=HTML::ComboBox("cmbAccion", $this->aAcciones, "ID", "Nombre", 3, $this->aReglaIptables->Accion->ID, "combobox")?></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="right">
					<br><?=Html::Button("btnAgregar", "Agregar", 1, "button", "evtAgregarRegla()")?>
				</td>
			</tr>
			</table>
			<br>
			<table width="590" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<? 
				$lCount = count($this->aTable->Cadenas);
				for ($i = 0; $i < $lCount; $i++) {
					$lCadena = $this->aTable->Cadenas[$i];
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
					$lCabecera = array("N&deg;","Origen","Destino","Permitir?","");
					for ($i = 0; $i < $lCount; $i++) { 
						$lReglasIptables = $this->aTable->Cadenas[$i]->ReglasIptables;
					?>
					<div id="<?=substr($this->aContent[$i],1,strlen($this->aContent[$i])-2)?>" class="tabcontent" style="display:<?=($i==0)?"block":"none"?>;">
					<?
					$lTabla = new Tabla($lCabecera);
					$lNum = 0;
					foreach ($lReglasIptables as $lReglaIptables) {
						$lNum++;
						$lIPOrigen = trim($lReglaIptables->IPOrigen) != "" ? $lReglaIptables->IPOrigen : "*";
						$lPuertoOrigen = ($lReglaIptables->PuertoOrigenFinal == ""? $lReglaIptables->PuertoOrigenInicial : $lReglaIptables->PuertoOrigenInicial.":".$lReglaIptables->PuertoOrigenFinal);
						$lPuertoOrigen = ($lPuertoOrigen == "")? "" : "[".$lPuertoOrigen."]";
						$lIPDestino = trim($lReglaIptables->IPDestino) != "" ? $lReglaIptables->IPDestino : "*";
						$lPuertoDestino = ($lReglaIptables->PuertoDestinoFinal == ""? $lReglaIptables->PuertoDestinoInicial : $lReglaIptables->PuertoDestinoInicial.":".$lReglaIptables->PuertoDestinoFinal);
						$lPuertoDestino = ($lPuertoDestino == "")? "" : "[".$lPuertoDestino."]";
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
				</td>
			</tr>
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

} // end of VistaAdministrarInterfaz
?>
