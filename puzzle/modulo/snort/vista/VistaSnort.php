<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once CLASES.'Interfaz.php';
require_once CLASES.'Nodo.php';
require_once CONTROLADOR_SNORT.'ControladorSnort.php';
require_once CLASES_SNORT.'Snort.php';
require_once CLASES_SNORT.'Servicio.php';
require_once CLASES_SNORT.'Libreria.php';
require_once CLASES_SNORT.'Preprocesador.php';
require_once CLASES_SNORT.'Parametro.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaSnort extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aSnort = null;
	private $aTipoPreprocesadores = null;
	private $aTipoLibrerias = null;
	private $aTipoValores = null;
	private $aInterfaces = null;
	private $aTipoServicios = null;
	private $aTipoPreprocesador = null;
	private $aParametros = null;
	private $aPagina = 0;
	
	/**
	* Constructor de la VistaInterfaz.
	*
	* @param controlador::ControladorInterfaz pControlador Controlador de la pantalla.
	* @return 
	* @access private
	*/
	public function __construct( $pControlador = null ) {
		$this->aControlador = $pControlador;
		$this->aRestringido = true;
		$lEvento = "";
		if (isset($_POST['Evento'])) {
			$lEvento = $_POST['Evento'];
		}
		$this->aControlador->procesar($lEvento);
		
		$this->aSnort = $this->aControlador->getSnort();
		$this->aPagina = $this->aControlador->getPagina();
		$this->aTipoPreprocesadores = $this->aControlador->getTipoPreprocesadores();
		$this->aTipoPreprocesador = $this->aControlador->getTipoPreprocesadorSeleccionado();
		$this->aTipoLibrerias = $this->aControlador->getTipoLibrerias();
		$this->aTipoValores = $this->aControlador->getTipoValores();
		$this->aTipoServicios = $this->aControlador->getTipoServicios();
		$this->aInterfaces = $this->aControlador->getInterfaces();
		$this->aNodos = $this->aControlador->getNodos();
		$this->aParametros = $this->aControlador->getParametros();
	} // end of member function __construct

	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
		$lAccion = "index.php?Pagina=Snort&Modulo=Snort";
		$lRegla = "";
		if (isset($_GET["Origen"])) {
			$lRegla = $_GET["Origen"];
			if (($lRegla == "Importar") or ($lRegla == "404")) {
				$lAccion .= "&Origen=".$lRegla;
			} else {
				header("Location:".$lAccion."&Origen=404");
			}
		}
	?>
		<form id="ActionForm" name="ActionForm" action="<?=$lAccion?>"<?=($lRegla=="Importar")?" enctype=\"multipart/form-data\"":""?> method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("Elemento","")?>
			<?=HTML::Hidden("Pagina",$this->aPagina)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Configuraci&oacute;n del Snort</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=Snort&amp;Modulo=Snort">
						<img src="<?=IMAGENES_SNORT?>boton/settings.png" alt="[Configuración]" title="Configuración">&nbsp;Configurar Snort
						</a>
						&nbsp;
						<a href="index.php?Pagina=Snort&amp;Modulo=Snort&amp;Origen=Importar">
						<img src="<?=IMAGENES_SNORT?>boton/import.png" alt="[Importar]" title="Importar Configuración">&nbsp;Importar Configuración
						</a>
					</div>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
					<tr>
						<td>
							<?
								$lFuncion = "";
								if($lRegla == "") {
									$lFuncion = "texto".$this->aPagina;
								} else {
									$lFuncion = "texto".$lRegla;
								}
								$this->{$lFuncion}();
							?>
						</td>
					</tr>
					</table>
					<? 
						$lFuncion = "";
						if($lRegla == "") {
							$lFuncion = "cargarPagina".$this->aPagina;
						} else {
							if ($lRegla == "Importar") {
								$lFuncion = "cargarImportar";
							} else if ($lRegla = "404") {
								$lFuncion = "cargarPagina0";
							}
						}
						$this->{$lFuncion}();
					?>
				</td>
			</tr>
			<? if($lRegla == "") { ?>
			<tr>
				<td align="right">
					<? 
						$lCaption = ($this->aPagina < 6)?"Siguiente":"Guardar";
						$lEvento = "evt".$lCaption."()";
					?>
					<?= ($this->aPagina > 0)? Html::Button("btnAnterior", "Anterior", 100, "button", "evtAnterior()") : "" ?>
					<?=Html::Button("btnSiguiente", $lCaption, 101, "button", $lEvento)?>
					<?=Html::Button("btnCancelar", "Cancelar", 102, "button", "evtCancelar()")?>
				</td>
			</tr>
			<? } ?>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido
			
	protected function textoImportar(){
		?>
		<p align="center" style="font-weight:normal;">
		<img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla cargue los valores haciendo uso de un archivo de
		configuración previamente exportado por la aplicación.
		</p>
		<?
	}
			
	protected function cargarImportar() {
		?>
		<fieldset>
			<legend>Importar Configuración</legend>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
				<tr><td>Archivo a Importar:</td>
				<td>
				<INPUT type="hidden" name="MAX_FILE_SIZE" value="5000" />
				<INPUT type="file" name="txtFile" id="txtFile" class="textfield">
				</td>
				</tr>
				<tr><td colspan="2" align="right"><?=Html::Button("btnImportar", "Importar", 2, "button", "evtImportar()")?></td></tr>
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

	protected function texto0(){
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> La presente pantalla le guiará paso a paso a lo largo de toda la configuración de la herramienta Snort, 
  		la cual le proporcionará las funcionalidades de un Sistema de Detección de Intrusos.</p>
		<p align="justify">Para dar inicio sírvase pulsar sobre el botón Siguiente ubicado en la parte inferior de la pantalla.</p>
		<?
	}
	
	protected function cargarPagina0(){
		?>
		<br>
		<?
	}
	
	protected function texto1(){
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla indique las interfaces que interconectan la red interna (LAN) con la externa (Internet).</p>
		<?
	}
	
	protected function cargarPagina1(){
		?>
		<fieldset>
			<legend>Configuración de las Interfaces</legend>
			<?
				$lHeader = array("Nombre","Conexión a","Interfaz Interna","Interfaz Externa");
				$lTabla = new Tabla($lHeader);
				foreach ($this->aInterfaces as $lInterfaz) {
					$lNombre = $lInterfaz->Nombre;
					$lConexion = $lInterfaz->Internet?"Internet":"Red local";
					$lHallado = false;
					$lInterno = false;
					foreach ($this->aSnort->InterfazInterna as $lInterfazInterna) {
						if ($lInterfaz->ID == $lInterfazInterna->ID) {
							$lHallado = true;
							$lInterno = true;
							break;
						}
					}
					if (!$lHallado) {
						foreach ($this->aSnort->InterfazExterna as $lInterfazExterna) {
							if ($lInterfaz->ID == $lInterfazExterna->ID) {
								$lHallado = true;
								break;
							}
						}
					}
					$lChkInterno = HTML::RadioButton("rdbInterfaz".$lInterfaz->ID, "in", ($lHallado && $lInterno)?true:false, 0, "radiobutton");
					$lChkExterno = HTML::RadioButton("rdbInterfaz".$lInterfaz->ID, "out", ($lHallado && !$lInterno)?true:false, 0, "radiobutton");
					$lFila = array($lNombre,$lConexion,$lChkInterno,$lChkExterno);
					$lTabla->addRow($lFila);
				}
				
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function texto2(){
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla indique los servicios presentes en la red local.</p>
		<?
	}
	
	protected function cargarPagina2(){
		?>
		<fieldset>
			<legend>Configuración de los Servicios</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="120"><label accesskey="s" for="cmbServicio">Tipo de <u>S</u>ervicio:</label></td>
				<td><?=HTML::ComboBox("cmbServicio", $this->aTipoServicios, "ID", "Nombre", 1, 0, "combobox");?></td>
			</tr>
			<tr>
				<td valign="top"><label accesskey="n" for="lstNodos[]">Listado de <u>N</u>odos:</label></td>
				<td valign="top"><?=HTML::ListItems("lstNodos[]", $this->aNodos, 4, "ID", "Hostname", 2, "list");?></td>
			</tr>
			<tr>
				<td valign="top"><label accesskey="p" for="txtPuertos">Lista de <u>P</u>uertos (**):</label></td>
				<td valign="top"><?=HTML::TextBox("txtPuertos", "", 54, 100, 3, "textField");?></td>
			</tr>
			<tr><td colspan="2" align="left"><strong>(**) Separe los puerto utilizando un espacio en blanco &quot;&nbsp;&quot;.</strong></td></tr>
			<tr>
				<td colspan="2" align="right"><?=Html::Button("btnAgregar", "Agregar", 4, "button", "evtAgregar()")?></td>
			</tr>
			</table>
			<br>
			<?
				$lHeader = array("N&deg;","Nombre del Servicio","Nodo(s)","Puertos","");
				$lTabla = new Tabla($lHeader);
				$lNum = 0;
				foreach ($this->aSnort->Servicios as $lServicio) {
					$lNombre = $lServicio->TipoServicio->Nombre;
					$lNodos = "";
					foreach($lServicio->Nodos as $lNodo) {
						$lNodos .= $lNodo->Hostname."<br>";
					}
					$lPuertos = $lServicio->Puertos;
					$lAccion = HTML::ImageButton("btnEliminar", IMAGENES_SNORT."boton/delete.png", "Eliminar Servicio", 5, "", "evtRemover(".$lNum.")");
					$lNum++;
					$lFila = array($lNum, $lNombre,$lNodos,$lPuertos, $lAccion);
					$lTabla->addRow($lFila);
				}
				
				echo $lTabla;
			?>
			<br>
		</fieldset>
		<?
	}
	
	protected function texto3() {
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla se procederá a configurar la lista de librerías que el Snort utilizará.</p>
		<?
	}
	
	protected function cargarPagina3(){
		?>
		<fieldset>
			<legend>Configuración de Librerías</legend>
			<?
				$lHeader = array("N&deg;","Librería","Tipo","Ruta","");
				$lTabla = new Tabla($lHeader);
				$lNumero = 0;
				foreach ($this->aSnort->Librerias as $lLibreria) {
					$lRuta = $lLibreria->Valor;
					$lAccion = HTML::ImageButton("btnEliminar", IMAGENES_SNORT."boton/delete.png", "Eliminar Librería", $lNumero, "", "evtRemover(".$lNumero.")");
					$lNumero ++;
					$lFila = array($lNumero,$lLibreria->TipoLibreria->Nombre,$lLibreria->TipoValor->Nombre,$lRuta, $lAccion);
					$lTabla->addRow($lFila);
				}
				$lLibrerias = HTML::ComboBox("cmbTipoLibreria", $this->aTipoLibrerias, "ID", "Nombre", 1, 0, "combobox");
				$lValores = HTML::ComboBox("cmbValor", $this->aTipoValores, "ID", "Nombre", 2, 0, "combobox");
				$lRuta = HTML::TextBox("txtRuta", "", 30, 100, 3, "textField");
				$lAccion = HTML::ImageButton("btnAgregar", IMAGENES_SNORT."boton/new.png", "Agregar Librería", $lNumero, "", "evtAgregar()");
				$lFila = array("", $lLibrerias, $lValores, $lRuta, $lAccion);
				$lTabla->addRow($lFila);
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function texto4() {
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla se procederá a configurar los preprocesadores que se utilizarán.</p>
		<?
	}
	
	protected function cargarPagina4(){
		?>
		<fieldset>
			<legend>Configuración de Preprocesadores</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td width="120"><label accesskey="p" for="cmbPreprocesador">Tipo de <u>P</u>reprocesadores:</label></td>
				<td><?=HTML::ComboBox("cmbPreprocesador", $this->aTipoPreprocesadores, "ID", "Nombre", 0, $this->aTipoPreprocesador->ID, "combobox", "evtCargarCombo()");?></td>
			</tr>
			<?php
			$i = 0;
			if (count($this->aParametros) > 0) { ?>
			<tr>
				<td valign="top"><label>Listado de Parámetros:</label></td><td></td>
			</tr>
			<? 
			$lCount = count($this->aParametros);
			for ($i = 0; $i < $lCount; $i++) {
				$lParametro = $this->aParametros[$i];
			?>
			<tr><td style="padding-left: 10px;"><?=$lParametro->Nombre.":&nbsp; "?></td><td><?=HTML::TextBox("txt_".$i, "", 20, 20, $i + 1, "textField")?></td></tr>
			<? }?>
			<? } ?>
			<tr>
				<td colspan="2" align="right"><?=Html::Button("btnAgregar", "Agregar", $i + 1, "button", "evtAgregar()")?></td>
			</tr>
			</table>
			<br>
			<?
				$lHeader = array("N&deg;","Preprocesador","Parametros","");
				$lTabla = new Tabla($lHeader);
				$lNumero = 0;
				foreach ($this->aSnort->Preprocesadores as $lPreprocesador) {
					$lAccion = HTML::ImageButton("btnEliminar", IMAGENES_SNORT."boton/delete.png", "Eliminar Librería", $lNumero + $i + 1, "", "evtRemover(".$lNumero.")");
					$lNumero ++;
					$lParametros = "";
					foreach ($lPreprocesador->Parametros as $lParametro) {
						$lParametros .= $lParametro->Nombre.":&nbsp;".$lParametro->Valor.";&nbsp;";
					}
					$lFila = array($lNumero,$lPreprocesador->TipoPreprocesador->Nombre,$lParametros, $lAccion);
					$lTabla->addRow($lFila);
				}
				echo $lTabla;
			?>
		</fieldset>
		<?
	}
	
	protected function texto5() {
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> En la presente pantalla se procederá a configurar la ruta en donde se hallan las reglas del Snort.</p>
		<?
	}
	
	protected function cargarPagina5(){
		?>
		<fieldset>
			<legend>Configuración del Preprocesadores</legend>
			<table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px solid #003300; background: #669966;">
			<tr>
				<td><label accesskey="r" for="txtRuta">Ruta <u>R</u>eglas:</label></td>
				<td><?=HTML::TextBox("txtRuta", $this->aSnort->RutaReglas, 35, 100, 0, "textField");?></td>
			</tr>
			<tr>
				<td><label>Recursos Limitados:</label></td>
				<td><?=HTML::CheckBox("chkLimitado", 1, $this->aSnort->RecursosLimitados, 0, "checkbox")?>(**)</td>
			</tr>
			<tr>
				<td colspan="2">
				<p align="justify">(**) Marcar esta opción en caso se halle usando un equipo que cuente con pocos recursos de hardware.
				</p>
				</td>
			</tr>
			</table>
		</fieldset>
		<?
	}
	
	protected function texto6() {
		?>
		<p align="justify"><img alt="[Info]" src="<?=IMAGENES?>mensaje/info.png"> La guía para la configuración del Snort ha concluido.  Para guardar los cambios pulse sobre la opcion Guardar.</p>
		<p align="justify">Los cambios serán aplicados una vez se registren nuevas reglas a la configuración generada.</p>
		<?
	}
		
	protected function cargarPagina6(){
		?>
		<br>
		<?
	}
	
			
} // end of VistaAdministrarInterfaz
?>
