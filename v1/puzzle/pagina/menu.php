<?php

/**
 * @package /lib/
 * @class Menu
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */
function Menu($pAdministrador = false) {
?>
		<div style="float: left" id="my_menu" class="sdmenu">
		<div class="collapsed">
		<span>M&oacute;dulo Central</span>
		<a href="/index.php?Pagina=PanelControl">Accesos R&aacute;pidos</a>
		<a href="/index.php?Pagina=Servidor">Datos del Servidor</a>
		<? if ($pAdministrador) { ?>
		<a href="/index.php?Pagina=AdministrarInterfaz">Administrar Zonas</a>
		<? } ?>
		<a href="/index.php?Pagina=AdministrarCuenta">Administrar Cuenta</a>
		</div>
		<div class="collapsed">
		<span>Iptables</span>
		<? if ($pAdministrador) { ?>
		<a href="/index.php?Pagina=Iptables&amp;Modulo=Iptables">Configuraci&oacute;n Iptables</a>
		<? } ?>
		<a href="/index.php?Pagina=ReglaIptables&amp;Modulo=Iptables">Reglas Cortafuegos</a>
		<a href="/index.php?Pagina=NatIptables&amp;Modulo=Iptables">Reglas NAT</a>
		<a href="/index.php?Pagina=HistoricoIptables&amp;Modulo=Iptables">Registro Histórico</a>
		<a href="/index.php?Pagina=ReporteIptables&amp;Modulo=Iptables">Reportes</a>
		</div>
		<div class="collapsed">
		<span>Squid</span>
		<? if ($pAdministrador) { ?>
		<a href="/index.php?Pagina=Squid&amp;Modulo=Squid">Configuraci&oacute;n Squid</a>
		<? } ?>
		<a href="/index.php?Pagina=ReglaSquid&amp;Modulo=Squid">Reglas Proxy-Caché</a>
		<a href="/index.php?Pagina=HistoricoSquid&amp;Modulo=Squid">Registro Hist&oacute;rico</a>
		<a href="/index.php?Pagina=ReporteSquid&amp;Modulo=Squid">Reportes</a>
		</div>
		<div class="collapsed">
		<span>Snort</span>
		<? if ($pAdministrador) { ?>
		<a href="/index.php?Pagina=Snort&amp;Modulo=Snort">Configuraci&oacute;n</a>
		<? } ?>
		<a href="/index.php?Pagina=ReglaSnort&amp;Modulo=Snort">Reglas</a>
		<a href="/index.php?Pagina=HistoricoSnort&amp;Modulo=Snort">Registro Hist&oacute;rico</a>
		<a href="/index.php?Pagina=ReporteSnort&amp;Modulo=Snort">Reportes</a>
		</div>
		</div>
<?php
}

?>