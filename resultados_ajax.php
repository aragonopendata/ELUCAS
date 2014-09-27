<?php
	require_once('./config.inc.php');
	require_once('./include/lib.inc.php');
	require_once('./include/libHtml.inc.php');
	require_once('./include/XML2Array.class.php');
	require_once("./include/GoogleMap.php");
	require_once("./include/JSMin.php");
	
	$v_categorias = getCategorias($_global['v_cfuentes']);
	if ( trim($_REQUEST['q']) != ""){
		$q = urlencode(trim($_REQUEST['q']));
		
		// obtenemos la categoria
		if (trim($_REQUEST['cat']) != ""){
			$cat = trim($_REQUEST['cat']);
			// comprobamos que es una categoria valida..
		}else{
			$cat = $_global['cat_default'] ;
		}	
		// inicializamos mapa
		$MAP_OBJECT = new GoogleMapAPI(); 
		$MAP_OBJECT->_minify_js = FALSE;
		// obtenemos las fuentes de la categoria:
		$v_fuentes = getFuentesFromCategoria($_global['v_cfuentes'], $cat);	
		// para cada fuente, obtenemos los resultados
		$tot = count($v_fuentes);
		
		$v_result = array();
		for($i = 0;$i < $tot;$i++){
			$fuente = $v_fuentes[$i];
			// obtenemos el 
			$obj_result = getResultadoFromApi($_global['url_api'], $q, $fuente);
			if ( ($obj_result->status == 'OK') && !empty($obj_result->results) )  {
				if (!empty($v_result) ){
					array_merge( $v_result, getArrayAsocResultados($obj_result->results) ) ;	
				}else{
					$v_result = getArrayAsocResultados($obj_result->results);
				}	
			}
		}
	
		// ordenamos el array
		ksort($v_result);
		
		// pintamos los resultados y el mapa
		$html = getHtmlResultados($v_result, $cat, $v_categorias[$cat]);
		if (empty($MAP_OBJECT->_markers)){
			$html .= "<script>$('#map').hide();</script>";
		}else{
			$html .= $MAP_OBJECT->getMapJS2();
			$html .= "<script>$('#map').show().empty();loadmap()</script>";
		}
		echo $html;
		
	}else{
		echo "Formato de par&aacute;metro no v&aacute;lido.";
	}

?>