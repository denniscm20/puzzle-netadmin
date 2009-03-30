<?php

/**
 * @package /lib/
 * @class Tabla
 * @author Dennis Stephen Cohn Muroy
 * @version 1.0
 */


	class Tabla {
	
		private $aRows = null;
		private $aHeader = null;
		private $aScroll = false;
		
		public function __construct ($pHeader = array(), $pScroll = false) {
			$this->aRows = array();
			$this->aHeader = $pHeader;
			$this->aScroll = $pScroll;
		}
		
		public function __destruct() {
			foreach ($this->aHeader as $lHead) {
				unset($lHead);
			}
			unset($this->aHeader);
			
			foreach ($this->aRows as $lRow) {
				foreach ($lRow as $lValue) {
					unset($lValue);
				}
				unset($lRow);
			}
			unset($this->aRows);
		}
		
		public function __toString() {
			$lTable = "<table id=\"my_table\" border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\">";
		
			$lRows = count($this->aRows);
			$lColumns = count($this->aHeader);
			
			$lTable .= "<thead><tr>";
			for ($i = 0; $i < $lColumns; $i++) {
				$lTable .= "<th align=\"center\">".$this->aHeader[$i]."</th>";
			}
			$lTable .= ($this->aScroll) && ($lRows > 9)?"<th width=\"12\">&nbsp;</th>":"";
			
			$lTable .= "</tr></thead>";
			
			if ($lRows == 0) {
				$lTable .= "<tbody><tr>";
				$lTable .= "<td align=\"center\" colspan=\"".$lColumns."\">No existen elementos registrados</td>";
				$lTable .= "</tr></tbody>";
			} else {
				$lTable .= ($this->aScroll) && ($lRows > 9)?"<tbody class=\"scroll\">":"<tbody>";
				for ($i = 0; $i < $lRows; $i++) {
					$lTable .= "<tr>";
					for ($j = 0; $j < $lColumns; $j++) {
						$lTable .= "<td align=\"center\">".$this->aRows[$i][$j]."</td>";
					}
					$lTable .= ($this->aScroll) && ($lRows > 9)?"<td width=\"12\">&nbsp;</td>":"";
					$lTable .= "</tr>";
				}
				$lTable .= "</tbody>";
			}
			$lTable .= "</table>";	
			return $lTable;
		}
		
		public function addRow($pRow) {
			// ($this->aRows)[] = $pRow;
			array_push($this->aRows,$pRow);
		}
		
		public function setHeader($pHeader) {
			$this->aHeader = $pHeader;
		}
		
	}

?>
