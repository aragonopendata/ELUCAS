<?php
/**
 * lib.inc.php
 */
 
/**
 * getResultadoFromApi
 * Devuelve el objeto con los datos obtenidos de la invocacion a la API.
 * El obteto tiene tres propiedades:
 * status -> codigo resultado de la invocacion. OK o KO
 * on_this_page -> no. de resultados de la pagina
 * results -> array con los resultados.
 * 
 * @param string $url_api
 * @param string $q
 * @param string $fuente
 * @return object
 */
function getResultadoFromApi($url_api, $q, $fuente, $pag){
	$q = urlencode($q);
	$v_params = array();
	$v_params['query']=	$q;
	$v_params['source']=$fuente;
	
	if ($page)
		$v_params['page']=$pag;
	
	$url = getUrlApi($url_api, $v_params);
	
	if ($GLOBALS['_global']['json_local'] ){
		$json = file_get_contents('./tmp/data_'.$fuente.'.txt');
	}else{
		$json = getRemoteContent($url);	
	}
	$obj = json_decode($json);
	
	return($obj);
}

function getRemoteContent($url){
	//$json = file_get_contents($url);
		
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$data = curl_exec($curl);
	curl_close($curl);
	return($data);
}

function getCategorias($v){
	$tot = count($v);
	$r = false;
	for($i = 0;$i < $tot ;$i ++){
		$row = $v[$i];	
		$r[$row['categoria']] = $row['categoriaN'];
	}
	return $r;
}
function getFuentesFromCategoria($v, $cat){
	$tot = count($v);
	$r = false;
	for($i = 0;$i < $tot ;$i ++){
		$row = $v[$i];	
		if ($row['categoria'] == $cat){
			$r = $row['fuentes'];
			break;
		}
	}
	return $r;
}

/**
 * getArrayAsocResultados
 * Devuelve un array asociativo por ID a partir del array de resultados.
 * - Necesario para ordenar en caso de fuentes multiples.-
 * 
 * @param array $v_resultados
 * @return array
 */
function getArrayAsocResultados($v_resultados){
	$tot = count($v_resultados);
	$r = array();
	for($i = 0;$i < $tot ;$i ++){
		$row = $v_resultados[$i];	
		$r[$row->id] = $row;
		setGeoMark($row);	
	}
	return $r;
}
function setGeoMark($row){
	//print_r($row);die();
	if ( ($row->lng != '') && ($row->lat != '') ){
		$GLOBALS['MAP_OBJECT']->addMarkerByCoords($row->lng,$row->lat, htmlspecialchars($row->title),
		'<h4>'.htmlspecialchars($row->author).'</h4>'. htmlspecialchars($row->description));
		//$GLOBALS['MAP_OBJECT']->addMarkerByCoords($row->lng,$row->lat, 'aaa','ssss');
	}
}

/**
 * getUrlApi
 * Devuelve la url a invocar a partir de la url base y los parametros pasados en array asociativo
 * 
 * @param string $url
 * @param array $v
 * @return string
 */
function getUrlApi($url, $v){
	$r = $url;
	foreach($v as $name=>$value){
		$r .= $name.'='.$value.'&';
	}
	$r .= 'raw_mode='.$GLOBALS['_global']['raw_mode'];
	
	return $r;
}

/**
 * getUrlApiPag
 * 
 */
function getUrlApiPag($url, $q, $fuente, $p){
	
	$v_params = array();
	$v_params['query']=	$q;
	$v_params['source']=$fuente;
	
	if ($p)
		$v_params['page']=$p;
	$r = getUrlApi($url, $v_params);	
	return $r;
}



function debugHtml($obj){
	echo "<pre>";
	print_r($obj);
	echo "</pre>";	
	
}




?>