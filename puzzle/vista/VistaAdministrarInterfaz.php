<?php
/**
 * @package /home/dennis/uml-generated-code/vista/VistaAdministrarInterfaz.php
 * @class vista/VistaAdministrarInterfaz.php
 * @author dennis
 * @version 1.0
 */

require_once BASE.'Vista.php';
require_once 'controlador/ControladorAdministrarInterfaz.php';
require_once LIB.'html.php';
require_once LIB.'tabla.php';


/**
 * class VistaAdministrarInterfaz
 */
class VistaAdministrarInterfaz extends Vista {

	 /*** Attributes: ***/

	/**
	 * Controlador de la pantalla.
	 * @access private
	 */
	private $aControlador = null;
	
	private $aInterfaces = null;

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
		
		$this->aInterfaces = $this->aControlador->listarPorServidor();
	} // end of member function __construct
	
	/**
	 * Muestra el contenido de la pantalla VistaAdministrarInterfaz
	 *
	 * @return 
	 * @access public
	 */
	public function contenido( ) {
	?>
		<? $lCount = count($this->aInterfaces); ?>
		<script type="text/javascript" language="JavaScript">
			<?
				$lFocus = array();
				$lReady = array();
				$lContent = array();
				for ($i = 0; $i < $lCount; $i++) {
					$lIndex = $i + 1;
					$lFocus[] = "'tab".$lIndex."focus'";
					$lReady[] = "'tab".$lIndex."ready'";
					$lContent[] = "'content".$lIndex."'";
				}
			?>
			idlist = new Array(<?=implode(",",$lFocus).",".implode(",",$lReady).",".implode(",",$lContent)?>);
		</script>
		<form id="ActionForm" name="ActionForm" action="index.php?Pagina=AdministrarInterfaz" method="POST">
			<?=HTML::Hidden("Evento","")?>
			<?=HTML::Hidden("SubredID","")?>
			<?=HTML::Hidden("ServidorID",1)?>
			<table id="content" align="center" cellpadding="0" cellspacing="0" >
			<tr><th><h1>Informaci&oacute;n de las Interfaces</h1></th></tr>
			<tr>
				<td>
					<div id="toolbar">
						<a href="index.php?Pagina=AdministrarNodo">
						<img src="<?=IMAGENES?>boton/nodo.png" alt="[Listar Nodos]" title="Listar Nodos">&nbsp;Listar Nodos
						</a>
						&nbsp;
						<a href="index.php?Pagina=Subred">
						<img src="<?=IMAGENES?>boton/net.png" alt="[Nueva Subred]" title="Nueva Subred">&nbsp;Nueva Subred
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset>
					<legend>Valores Generales</legend>
						<table width="590" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<? 
								for ($i = 0; $i < $lCount; $i++) { 
									$lInterfaz = $this->aInterfaces[$i];
							?>
							<td>
								<div id="<?=substr($lFocus[$i],1,strlen($lFocus[$i])-2)?>" class="tab tabfocus" style="display:<?=($i == 0)?"block":"none"?>;">
									<?=$lInterfaz->Nombre?> &nbsp; <a href="index.php?Pagina=Interfaz&ID=<?=$lInterfaz->ID?>"><img src="<?=IMAGENES?>boton/edit.png" alt="[Editar Interfaz]" title="Editar Interfaz"></a>
								</div>
								<div id="<?=substr($lReady[$i],1,strlen($lReady[$i])-2)?>" class="tab tabhold" style="display:<?=($i == 0)?"none":"block"?>;">
									<?
										$lManageDisplayLabel = "";
										for ($j = 0; $j < $lCount; $j++) {
											if (($j) == $i ) {
												$lManageDisplayLabel .= $lFocus[$j].",";
											} else {
												$lManageDisplayLabel .= $lReady[$j].",";
											}
										}
										$lManageDisplayLabel .= $lContent[$i];
									?>
									<span onclick="ManageTabPanelDisplay(<?=$lManageDisplayLabel?>)"><?=$lInterfaz->Nombre?></span>
								</div>
							</td>
							<?
								}
							?>
						</tr>
						<tr>
							<td colspan="<?=$lCount?>">
								<? 
								for ($i = 0; $i < $lCount; $i++) { 
									$lInterfaz = $this->aInterfaces[$i];
								?>
								<div id="<?=substr($lContent[$i],1,strlen($lContent[$i])-2)?>" class="tabcontent" style="display:<?=($i==0)?"block":"none"?>;">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr><td width="120px"><label>Interfaz:</label></td><td><?=$lInterfaz->Nombre ?></td></tr>
									<tr><td width="120px"><label>IP:</label></td><td><?=$lInterfaz->IP ?></td></tr>
									<tr><td width="120px"><label>Mascara:</label></td><td><?=$lInterfaz->Mascara ?></td></tr>
									<tr><td width="120px"><label>MAC:</label></td><td><?=$lInterfaz->MAC ?></td></tr>
									<tr><td><label>Descripci&oacute;n:</label></td><td><?=$lInterfaz->Descripcion ?></td></tr>
									<tr><td><label>Conexión a:</label></td><td><?=($lInterfaz->Internet)?"Internet":"Red local" ?></td></tr>
									</table>
									<br>
									<?
										$lHeader = array("N&deg;","Nombre","IP","M&aacute;scara","Acciones");
										$lTabla = new Tabla($lHeader);
										$lSubredes = $lInterfaz->Subredes;
										$lNum = 0;
										foreach ($lSubredes as $lSubred) {
											$lNum++;
											$lModificar = "<a href=\"index.php?Pagina=Subred&Subred=".$lSubred->ID."\" > <img src=\"".IMAGENES."boton/edit.png\" alt=\"[Editar Subred]\" title=\"Editar Subred\"> </a>";
											$lEliminar = HTML::ImageButton("eliminar",IMAGENES."boton/delete.png","Eliminar Subred",0,"","evtEliminar(".$lSubred->ID.")");
											$lLinea = array($lNum, $lSubred->Nombre, $lSubred->IP, $lSubred->MascaraCorta, $lModificar."&nbsp;".$lEliminar);
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
				</td>
			</tr>
			</table>
			<br>
		</form>
	<?	
	} // end of member function contenido

} // end of VistaAdministrarInterfaz
?>
