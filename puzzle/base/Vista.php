<?php

abstract class Vista {
	
	protected $aRestringido = false;
	
	public function restringido() {
		return $this->aRestringido;
	}
	
	abstract function contenido();
}

?>