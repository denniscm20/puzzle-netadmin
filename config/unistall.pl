#!/usr/bin/perl -w

use strict;

use constant VALID_USER => "root";
use constant VALID_USER_MSG => "No cuentas con los permisos suficientes para iniciar esta operacion\n";

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

if (valid_user()) {
	print "Iniciando proceso de desinstalación\n";
	`rm -rf /var/www/puzzle`;
	`rm -f /etc/httpd/conf.d/puzzle.conf`;
	print "Proceso de desinstalacion finalizado exitosamente\n\n";
} else {
	print VALID_USER_MSG."\n";
}
exit(0);