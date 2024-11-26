<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Lugares_model extends CI_Model
{
	function guardarLugares($lugares)
	{
		$dom = new DOMDocument();
		$dom->formatOutput = true;
		$node = $dom->createElement('markers');
		$parnode = $dom->appendChild($node);
		
		foreach ($lugares as $lugar) {
			// Add to XML document node
			$node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("nombre",$lugar->nombre);
			$newnode->setAttribute("imei", $lugar->imei);
			$arr_coords = explode(',',$lugar->coordenadas);
			$newnode->setAttribute("lat", $arr_coords[0]);
			$newnode->setAttribute("lng", $arr_coords[1]);
			$newnode->setAttribute("fecha", $lugar->fecha);
		}
		$path = $_SERVER["DOCUMENT_ROOT"].'/locations/lugares.xml';
		unlink($path);
		$dom->save($path);
	}
}