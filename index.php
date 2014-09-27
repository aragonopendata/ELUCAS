<?php
	require_once('./config.inc.php');
	require_once('./include/lib.inc.php');
	require_once('./include/libHtml.inc.php');
	require_once('./include/XML2Array.class.php');
	require_once("./include/GoogleMap.php");
	require_once("./include/JSMin.php");
	
	$html = '';
	//$v_fuentes =  array('twitter', 'facebook', 'facebook_events','youtube', 'instagram' );
	$v_categorias = getCategorias($_global['v_cfuentes']);
	/*
	$fuente = 'twitter';
	if ($_REQUEST['fuente'] != '')
		$fuente = $_REQUEST['fuente'];
	*/
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
			
			$obj_result = getResultadoFromApi($_global['url_api'], $q, $fuente, $pag);
			
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
		
		// pintamos los resultados.
		$html = getHtmlResultados($v_result, $cat, $v_categorias[$cat]);
		

	}

?>

<html>
<head>
<meta charset="UTF-8">
<title>Social data</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


 
<script type='text/javascript'>
$( document ).ready(function() {
	$('#mytabs a:first').tab('show');
	
	$('[data-toggle="tabajax"]').click(function(e) {
		
		if($(this).parent('li').hasClass('active')){
		        $( $(this).attr('href') ).hide();
	    	}
		e.preventDefault();    
		var $this = $(this),
	    loadurl = $this.attr('href'),
	    targ = $this.attr('data-target');
	 	
	    $.get(loadurl, function(data) {
	        $(targ).html(data);
	    });
	    
	    $this.tab('show');
	    return false;
	});
	

});
 
</script> 
 <link rel="stylesheet" type="text/css" href="./css/elucas.css">
<?php 
if (isset($MAP_OBJECT)){
	echo $MAP_OBJECT->getHeaderJS();
	echo $MAP_OBJECT->getMapJS();
	echo $MAP_OBJECT->printOnLoad();
}
?>
</head>
<!-- CONTENEDOR-->
  <body role="document">

      <div class="container">
<div class="jumbotron">
	<img src="http://opendata.aragon.es/aragopedia/Aragopedia/images/mapaComarcas.png">
            <h1>ARAGON OPEN EVENTS</h1>
            <p>Mide lo que está pasando en las distintas redes sociales en los eventos de aragón y descubre quién tiene mayor repercusión.</p>
          </div>

<!-- FIN CONTENEDOR-->     	
<form method="post" id="fbusqueda" action="<?php echo $_SERVER['PHP_SELF'];?>">
<INPUT TYPE="text" name="q" value="" class="form-control">
<input type="submit" id="enviar" name="enviar" value="buscar" class="btn btn-lg btn-primary btn-block">
</form>

<ul class="nav nav-tabs tabs-up" id="mytabs">
	<?php 
		if ($_REQUEST['q'])
			echo getHtmlTabs($v_categorias,$cat,  $_REQUEST['q']);
	?>
</ul> 
 <!-- DIV COL IZDA-->
<div class="row">
        <div class="col-md-8">
 <!-- FIN DIV COL IZDA-->
<div class="tab-content"> 
<?php
		echo getHtmlCapasResultados($v_categorias, $cat,$html);

?>

</div>
<?php
if ($_REQUEST['q']){
?>	
<ul class="pager">
  	<li class="previous disabled"><a href="#" id="prev">&larr; Anterior</a></li>
  	<li class="next disabled"><a href="#" id="sig">Siguiente &rarr;</a></li>
</ul>

<?php		
}
?>
</div>

<!-- MAPA-->
        <div class="col-md-4 mapa" id="mapa">
<?php
if (isset($MAP_OBJECT)){
	echo $MAP_OBJECT->printMap();
}
?>
</div>
      </div>

</div>
</body>
</html>