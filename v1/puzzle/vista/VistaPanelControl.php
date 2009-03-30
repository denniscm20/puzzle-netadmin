<?php
	
	require_once(LIB."html.php");
	require_once(BASE."Vista.php");
	
	class VistaPanelControl extends Vista {
		
		private $aControlador;
		
		public function __construct($pControlador) {
			$this->aControlador = $pControlador;
		}
		
		public function contenido() {
?>
		<table id="content" align="center" cellpadding="0" cellspacing="0">
		<tr><th><h1>Accesos R&aacute;pidos</h1></th></tr>
		<tr>
			<td>
				<div id="cpanel">
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=Servidor">
							<img src="<?=IMAGENES?>boton/server_info.png" alt="[Informacion del Servidor]" align="middle" border="0" > <span>Informaci&oacute;n Servidor</span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=Modulo">
							<img src="<?=IMAGENES?>boton/modulo.png"  alt="[Modulos]" align="middle" border="0" ><span>M&oacute;dulos Registrados</span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=RegistroHistorico">
							<img src="<?=IMAGENES?>boton/historico.png"  alt="[Registro Historico]" align="middle" border="0" ><span>Registro Hist&oacute;rico</span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=Servicio">
							<img src="<?=IMAGENES?>boton/servidor.png"  alt="[Servicios]" align="middle" border="0" ><span>Administrar Servicios</span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=AdministrarInterfaz">
							<img src="<?=IMAGENES?>boton/zona_nodo.png"  alt="[Administrar Zonas y Nodos]" align="middle" border="0" > <span>Administrar Zonas</span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="?Pagina=AdministrarUsuario">
							<img src="<?=IMAGENES?>boton/usuario.png"  alt="[Administrar Usuarios]" align="middle" border="0" > <span>Administrar Usuarios</span>
							</a>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		</table>
<? 		}
	}?>