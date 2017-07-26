<?php
/****
* @PHPVER4.0
*
* @author	emnu
* @ver	--
* @date	12/08/08
*
* use this class to convert from mutidimensional array to xml.
* see example.php file on howto use this class
*
*/

class array2xml
{
	var $array = array();
	var $xml = '';

	function array2xml($array)
	{
		$this->array = $array;
		
		if(is_array($array) && count($array) > 0)
		{
			$this->struct_xml($array);
		}
		else
		{
			$this->xml .= "no data";
		}
	}

	function struct_xml($array)
	{
		foreach($array as $k=>$v)
		{
			if(is_array($v))
			{
				$numero = ereg_replace("[^0-9]", "", $k);				
				$texto = (!empty($numero)) ? ereg_replace($numero, "", $k) : $k; 				
				$tag = ereg_replace($k,$texto,$k);
				if (!empty($v)) {
					$this->xml .= "<$tag>";
					$this->struct_xml($v);
					$this->xml .= "</$tag>";
				}
			}
			else
			{			
				if ($k == 'apikey') {
					break;
				}				
				$tag = $k;
				if (!empty($v)) {
					$this->xml .= "<$tag>$v</$tag>";
				}
			}
		}
	}
	
	function get_xml($root = 'data')
	{
		$header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><$root>";
		$footer = "</$root>";
		
		$retorno = $header;
		$retorno .= $this->xml;
		$retorno .= $footer;
		return $retorno;
	}
}
?>
