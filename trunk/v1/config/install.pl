#!/usr/bin/perl -w

use strict;

use constant PACKAGES_RECOMMENDED_MSG => "Se recomienda la instalación de los siguientes paquetes:\n";
use constant PACKAGES_MSG => "Se ha interrumpido el proceso de instalación debido a que los siguientes programas no se hallan instalados:\n";
use constant VALID_USER_MSG => "No cuentas con los permisos suficientes para iniciar esta operacion\n";
use constant URL_MSG => "Acceda a esta URL para obtener acceso a la aplicacion";
use constant VALID_OS_MSG => "Tu Sistema Operativo no es valido. Esta apliacion esta diseñada para trabajar sobre las siguientes distribuciones GNU/Linux: Fedora, CentOS, Redhat.";
use constant SUDO_MSG => "Comente la siguiente línea del archivo sudoers:\nDefaults    requiretty\n\nAgregue las siguientes instrucciones al final del archivo sudoers:\nUser_Alias PUZZLE = apache\nCmnd_Alias SEGURIDAD = /bin/cat, /sbin/iptables-save, /sbin/iptables-restore, /usr/sbin/squid, /usr/sbin/snort, /sbin/sysctl, /usr/bin/tee, /usr/bin/grep, /proc/sys/net/ipv4/ip_forward, /etc/init.d/squid\nPUZZLE  ALL=NOPASSWD:SEGURIDAD\n\n";

use constant APPLICATION => "puzzle";
use constant APPLICATION_TAR => "puzzle.tar.gz";
use constant DIR_DESTINO => "/var/www/puzzle";
use constant DIR_SCRIPTS => "./sql/";
use constant DIR_CONFIG => "./config/";
use constant VALID_USER => "root";
use constant PORT => 9870;

sub trim {
	my ($string) = @_;
	$string =~ s/^\s+//;
	$string =~ s/\s+$//;
	return $string;
}

sub valid_user() {
	my $user = `whoami`;
	$user = trim($user);
	return ($user eq VALID_USER);
}

sub valid_packages() {
	my $lExito = 1;
	my @Obligatorios = ();
	my @Opcionales = ();
	my $lItem = "";
	my $lOutput = `rpm -q httpd`;
	if (index($lOutput,"installed") > -1) {
		push(@Obligatorios, "httpd");
		$lExito = 0;
	}
	$lOutput = `rpm -q sqlite3`;
	if (index($lOutput,"installed") > -1) {
		push(@Obligatorios, "sqlite3");
		$lExito = 0;
	}
	$lOutput = `rpm -q php`;
	if (index($lOutput,"installed") > -1) {
		push(@Obligatorios, "php");
		$lExito = 0;
	}
	$lOutput = `rpm -q iptables`;
	if (index($lOutput,"installed") > -1) {
		push(@Opcionales, "iptables");
	}
	$lOutput = `rpm -q squid`;
	if (index($lOutput,"installed") > -1) {
		push(@Opcionales, "squid");
	}
	$lOutput = `rpm -q snort`;
	if (index($lOutput,"installed") > -1) {
		push(@Opcionales, "snort");
	}
	if (!$lExito) {
		print PACKAGES_MSG;
		foreach $lItem (@Obligatorios) {
			print "-\t".$lItem."\n";
		}
		print "\n";
	}
	my $lSize = @Opcionales;
	if ($lSize) {
		print PACKAGES_RECOMMENDED_MSG;
		foreach $lItem (@Opcionales) {
			print "-\t".$lItem."\n";
		}
		print "\n";
	}
	return $lExito;
}

sub crear_host() {
	my $lCommand = "cp ".DIR_CONFIG."* /etc/httpd/conf.d/";
	`$lCommand`;
}

sub desempaquetar() {
	my $lCommand = "tar -zxf ".APPLICATION_TAR;
	`$lCommand`;
	$lCommand = "mv ".APPLICATION." /var/www/";
	`$lCommand`;
}

sub inicializar_bd() {
	my $lCommand = "sqlite3 puzzle.db < ".DIR_SCRIPTS."puzzle.sql";
	`$lCommand`;
	$lCommand = "sqlite3 iptables.db < ".DIR_SCRIPTS."iptables.sql";
	`$lCommand`;
	$lCommand = "sqlite3 squid.db < ".DIR_SCRIPTS."squid.sql";
	`$lCommand`;
	$lCommand = "sqlite3 snort.db < ".DIR_SCRIPTS."snort.sql";
	`$lCommand`;
}

sub otorgar_permisos() {
	my $lUser = `cat /etc/httpd/conf/httpd.conf | grep -v '#' | grep -e 'User '`;
	my $lCommand = "chown -R ".trim(substr($lUser,length("User ")))." ". DIR_DESTINO;
	`$lCommand`;
}

sub agregar_ip_valida() {
	my $lSSH = "";
	if (defined($ENV{SSH_CLIENT})) {
		$lSSH = $ENV{SSH_CLIENT};
	}
	my $lCommand = "";
	if ($lSSH ne "") {
		my $lQuery = "INSERT INTO IPv4Valida VALUES(1,1,'".$lSSH."')";
		my $lCommand = "sqlite3 puzzle.db \"".$lQuery."\"";
		`$lCommand`;
	}
	$lCommand = "mv *.db ".DIR_DESTINO."/archivo/";
	`$lCommand`;
}

sub reiniciar_apache() {
	`/etc/init.d/httpd restart`;
}

sub valid_OS() {
	my @ValidOS = ("Fedora", "Redhat", "CentOS");
	my @Issue = `cat /etc/issue`;
	foreach (@Issue) {
		my $lLinea = $_;
		for (my $i = 0; $i < 3; $i ++) {
			my $lExiste = index($lLinea, $ValidOS[$i]);
			if ($lExiste > -1) {
				return 1;
			}
		}
	}
	return 0;
}

sub imprimir_url() {
	print ("El proceso de instalacion ha concluido.\n");
	my @lURLs = `ifconfig | grep -e "inet addr"`;
	my $lURL = "";
	
	foreach (@lURLs) {
		my @Linea = split(/ /, trim($_));
		$lURL = trim(substr($Linea[1],length("addr:")));
		if ($lURL ne "127.0.0.1") {
			last;
		}
	}
	print SUDO_MSG;
	printf ("%s: http://%s:%d\n",URL_MSG,$lURL,PORT);
}

# Cuerpo principal de programa

sub Main() {
	if (valid_user()) {
		if (valid_OS()) {
			if (valid_packages()) {
				crear_host();
				desempaquetar();
				inicializar_bd();
				agregar_ip_valida();
				otorgar_permisos();
				reiniciar_apache();
				imprimir_url();
			}
		} else {
			print VALID_OS_MSG;
		}
	} else {
		print VALID_USER_MSG;
	}
}

Main();
exit(0);