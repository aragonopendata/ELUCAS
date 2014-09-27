<?php

/**
 * getHtmlRow
 * Obtiene el html correspondiente a una fila de resultados a prtir el objeto json
 * 
 * @param object $obj_row
 * @return string
 */
function getHtmlRow($obj_row, $cat){
	$row = '';
	
	switch($cat){
		case 'twitter':
			$row = getHtmlRowTwitter($obj_row);
			break;
		case 'facebook':
			$row = getHtmlRowFacebook($obj_row);
			break;
		case 'video':
			$row = getHtmlRowYoutube($obj_row);
			break;
		case 'imagenes':
			$row = getHtmlRowinstagram($obj_row);
			break;
		case 'prensa':
			$row = getHtmlRowPrensa($obj_row);
			break;
		case 'desarrolladores':
			$row = getHtmlRowDesarrollo($obj_row);
			break;
		default:
			$row = getHtmlRowDefault($obj_row);
			break;
		
	}
	
	return($row);			
}
function getHtmlRowDefault($obj_row){
	
	$row = '';
	$row .= ' <table class="table table-striped table-bordered">
        <tbody>';
	foreach ($obj_row as $name => $value) {
		$row .= '<div id="'.$name.'">'.$name.' : '.$value.'</div>';
	}
	$row .="</tbody>
      </table>";
	return($row);			
	
}
function getHtmlRowTwitter($obj_row){
	$obj_raw = (json_decode($obj_row->raw_data));
	
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
		
	$row = '';
	$row .= ' <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
            <div class="panel-heading">
            <h3 class="panel-title">'.$obj_row->author.' </h3><div id="followers"><span class="likes">Seguidores </span> <span class="badge">'.$obj_raw->user->followers_count.'</span>  </div><div id="retuits"> </div>
            </div>
            <div class="panel-body">'.$profile_image .$obj_row->description.' 

            </div>
             <div class="panel-body">'.$obj_row->published_on.' <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div><a href="'.$obj_row->url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" target="_blank"><button type="button" class="btn btn-sm btn-info">leer más</button></a></div>
          </div>
        </div>
      </div>';
	
	return($row);			
	
}


function getHtmlRowFacebook($obj_row){
	$obj_raw = (json_decode($obj_row->raw_data));
	
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
	
	$row = ' 
	 <div class="row">
        <div class="col-sm-12">
          
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">'.$obj_row->author.'</h3><span class="likes">Me gusta </span> <span class="badge">3</span>
            </div>
            <div class="panel-body">'.$profile_image .' ' .$obj_row->description.'</div>
             <div class="panel-body">
               '.$obj_row->published_on.' <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div><a href="'.$obj_raw->permalink.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'"><button type="button" class="btn btn-sm btn-info">leer más</button></a>
            </div>
          </div>
        </div>

      </div>';
	

	
	return($row);			
	
}


function getHtmlRowYoutube($obj_row){
	//$obj_raw =  new SimpleXMLElement($obj_row->raw_data);
	//print_r($obj_raw);
	/*$obj_raw= XML2Array::createArray($obj_row->raw_data);
print_r($obj_raw);
	die();*/
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
	
	$row = ' 
	 <div class="row">
        <div class="col-sm-12">
          
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">'.$obj_row->title.'</h3><span class="likes"><img src="http://www.enkitechec.com/YOUTUBE2.png" width="25px" height="25px"></span> <span class="badge">'.$obj_raw->countHint.'</span>
            </div>

<div class="panel-body yout">

  

<a href="'.$obj_row->url.'" target="_blank"><img src="'.$obj_row->thumbnail.'"></a>'.$obj_row->description.'





<!--<iframe allowfullscreen="" src="'.$obj_row->url.'?feature=player_detailpage" frameborder="0"></iframe>-->
</div>

             <div class="panel-body">
               '.$obj_row->published_on.' | <strong>'.$obj_row->author.'</strong> <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div>
            </div>
          </div>
        </div>

      </div>';

	
	return($row);			
	
}

function getHtmlRowinstagram($obj_row){
	$obj_raw = (json_decode($obj_row->raw_data));
	/*
	echo "<pre>";
	print_r($obj_raw);
	die();
	 */
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
	
	$row = ' 
	

 <div class="col-sm-3">
         
          <div class="panel panel-warning igerpanel">
            
            <div class="panel-heading">
              <img src="'.$obj_raw->user->profile_picture. '" class="img-circle iger"> <h3 class="panel-title">'.$obj_row->author.' </h3> <span class="likes"><img src="https://cdn3.iconfinder.com/data/icons/rounded-monosign/142/heart-512.png" width="20px" height="20px"></span> <span class="badge">'.$obj_raw->likes->count.'</span>
            </div>
            
            <div class="panel-body igerfoto">
              <img src="'.$obj_raw->images->low_resolution->url.'">
            </div>
            
            <div class="panel-body igerdescription">
             '.$obj_row->description.' 
            </div>

            <div class="panel-body">
             '.$obj_row->published_on.'
             Comentarios:' .$obj_raw->comments->count.' 
             <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div>
              </div>
            </div>

            </div>
         

          
        </div>';

	
	return($row);	
	
	
}

function getHtmlRowPrensa($obj_row){
	$obj_raw = (json_decode($obj_row->raw_data));
	
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
	
	$row = ' 
	 <div class="row">
        <div class="col-sm-12">
          
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">'.$obj_row->title.'</h3> <span class="badge">'.$obj_row->source.'</span>
            </div>
            <div class="panel-body">'.$profile_image .' ' .$obj_row->description.'</div>
             <div class="panel-body">
               '.$obj_row->published_on.' <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div><a href="'.$obj_row->url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" target="_blank"><button type="button" class="btn btn-sm btn-info">leer más</button></a>
            </div>
          </div>
        </div>

      </div>';
	

	
	return($row);			
	
}



function getHtmlRowDesarrollo($obj_row){
	$obj_raw = (json_decode($obj_row->raw_data));
	
	$profile_image ='';
	if ($obj_raw->user->profile_image_url){
		$profile_image = '<img src="'.$obj_raw->user->profile_image_url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" class="img-circle">';
	}
	
	$row = ' 
	 <div class="row">
        <div class="col-sm-12">
          
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">'.$obj_row->title.'</h3> <span class="badge">'.$obj_row->source.'</span>
            </div>
            <div class="panel-body">'.$profile_image .' ' .$obj_row->description.'</div>
             <div class="panel-body">
               '.$obj_row->published_on.' <div id="compartir">'.getHtmlSocialMedia ($obj_row).'</div><a href="'.$obj_row->url.'" title="'.$obj_row->author.'" alt="'.$obj_row->author.'" target="_blank"><button type="button" class="btn btn-sm btn-info">leer más</button></a>
            </div>
          </div>
        </div>

      </div>';
	

	
	return($row);			
	
}
/**
 * dibujaResultados
 * Pinta los resultados a partir del array
 * 
 * @param array $v_result
 * @param string $cat
 * @return string
 */
function getHtmlResultados($v_result, $cat, $catN){	
	$tot = count($v_result);
	// incializa el resultado		
	$html = '';
	if ($tot > 0){
		$html = '
		<div class="page-header">
        	<h1>Resultados</h1>
        	<h2><span class="label '.$GLOBALS['_global']['class_h2'][$cat].'">'.$catN.'</span></h2>
      	</div>';
		
		// recorre los resultados		
		foreach($v_result as $clave => $valor){
		//for($i = 0;$i<$tot;$i++){
			$html .= getHtmlRow($valor, $cat);
		}
	}else{
		$html = 'No se encontraron resultados para en esta categor&iacute;a';
	}
		
	return($html);
}

function getHtmlTabs($v_cat, $cat, $q){
	$html = '';
	foreach($v_cat as $n => $v){
		$html .= '<li><a href="./resultados_ajax.php?q='.$q.'&cat='.$n.'" data-target="#'.$n.'" class="media_node active span" id="'.$n.'_tab" data-toggle="tabajax" rel="tooltip"> '.$v.' </a></li>'; 
	}
	return($html);
}
/**
 * 
 */
function getHtmlPaginador($url_base, $pagina=false){
	if (! $pagina){
		$pagina = 1;
		$pagina_ant = false;
	}
	$pagina_sig = $pagina +1 ;
	
	// pagina anterior
	if ($pagina_ant)
		$html .='<li><a href="#">Anterior</a></li>';
	// pagina actual
	$html .='<li><a href="#">Anterior</a></li>';
	
	// pagina sigiente:
	if ($pagina_siguiente)
		$html .='<li><a href="#">Siguiente</a></li>';
	
	$html = '<ul class="pager">
  	<li class="previous disabled"><a href="#">&larr; Anterior</a></li>
  	<li class="next"><a href="#">Siguiente &rarr;</a></li>
	</ul>';
	return($html);
	
}
function getHtmlCapasResultados($v_categorias, $cat_activa, $html_content){
	$html = '';
	foreach($v_categorias as $nombre => $valor){
		$html .=  '<div class="tab-pane" id="'.$nombre.'">';
		if ($nombre == $cat_activa){
				$html .=   $html_content;
		}
		$html .=  '</div>';
	}
	
	return($html);
}
/**
 * getHtmlTime
 * Obtiene el tiempo de ejecucion del script
 * 
 * @return string
 */
function getHtmlTime(){
	return('P&aacute;gina generada en <b>'.(time() - $_SERVER['REQUEST_TIME']) .'</b> segundos');
}

function getHtmlSocialMedia($row){
    
    $html = '    
   	 <ul>
    <li>
    <a rel="facebook" class="external" title="Facebook" href="http://www.facebook.com/share.php?t='.$row->title.'&amp;u='.$row->url.'">
    <img alt="Facebook" title="Facebook" src="http://www.aragon.es/aragon/img/compartir/facebook.png"/>
    </a>
    </li>
    <li xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" class="noBackground">
    <a rel="twitter" class="external" title="Twitter" href="http://www.twitter.com/home/?status='.$row->url.'">
    <img alt="Twitter" title="Twitter" src="http://www.aragon.es/aragon/img/compartir/twitter.png"/>
    </a>
    </li>
    <li class="noBackground">
    <a rel="delicious" class="external" title="Delicious" href="http://del.icio.us/post?url='.$row->url.'&amp;title="'.$row->title.'>
    <img alt="Delicious" title="Delicious" src="http://www.aragon.es/aragon/img/compartir/delicious.png"/>
    </a>
    </li>
    <li>
   	 <a rel="meneame" class="external" title="Menéame" href="http://www.meneame.net/submit.php?url='.$row->url.'">
   	 <img alt="Menéame" title="Menéame" src="http://www.aragon.es/aragon/img/compartir/meneame.png"/>
    </a>
    </li>
    </ul>';
    return $html;
    
}

?>