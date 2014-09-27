<?php
/**
 * config.inc.php
 * 
 * Configuracion global
 */
 
 
 
 // url api socialdata
$_global['url_api'] = "http://opendata.aragon.es/socialdata/data/socialdata/data?" ;

// array de categorias de fuentes. Par clav/valor, codigo/nombre descriptivo
$_global['v_cfuentes'] = array();

// Twitter
$_global['v_cfuentes'][] = array(
			'categoria'=>'twitter',
			'categoriaN' => 'Twitter', 
			'fuentes'=>array('twitter')
);
// Facebook
$_global['v_cfuentes'][] = array(
			'categoria'=>'facebook', 
			'categoriaN' => 'Facebook',
			'fuentes'=>array('facebook', 'facebook_events')
);

// Imgagenes
$_global['v_cfuentes'][] = array(
			'categoria'=>'imagenes',
			'categoriaN' => 'Imágenes',
			'fuentes'=>array('instagram', 'flickr', 'pinterest')
);
// Video
$_global['v_cfuentes'][] = array(
			'categoria'=>'video', 
			'categoriaN' => 'Vídeo',
			'fuentes'=>array('youtube', 'vimeo')
);

// Desarrolladores
$_global['v_cfuentes'][] = array(
			'categoria'=>'desarrolladores', 
			'categoriaN' => 'Desarrollo',
			'fuentes'=>array('github')
);
// prensa
$_global['v_cfuentes'][] = array(
			'categoria'=>'prensa', 
			'categoriaN' => 'Prensa',
			'fuentes'=>array('heraldodearagon', 'periodicodearagon', 'diariodelaltoaragon', 'diariodeteruel')
);

$_global['cat_default'] = 'twitter';

// activar o no el raw_mode
$_global['raw_mode'] = 'true'; 
// carga el json de una ruta local para poder testeralo
$_global['json_local'] = false; 


//
$_global['class_h2']['twitter'] = 'label-default';
$_global['class_h2']['facebook'] = 'label-primary';
$_global['class_h2']['imagenes'] = 'label-warning';
$_global['class_h2']['video'] = 'label-danger';
$_global['class_h2']['desarrolladores'] = 'label-default';
$_global['class_h2']['prensa'] = 'label-primary';
$_global['debug'] = true; 


define('MAX_RESULT_PAGE', 20);

?>