<?php
/*
Plugin Name: ICPS Charts
Description: Making animated HTML5 charts in WordPress. (line, bar, pie, and doughnut types) this add on use chart.js script : http://www.chartjs.org/.
Version: 0.1
Author: kpimba_boy
Author URI: http://github.com/kpimbaboy
*/

/**
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 */


// Support IE pour HTML5 et canvas

function charts_html5_support () {
    echo '<!--[if lte IE 8]>';
    echo '<script src="'.plugins_url( '/js/excanvas.compiled.js', __FILE__ ).'"></script>';
    echo '<![endif]-->';
    echo '	<style>
    			/*charts_js responsive canvas CSS override*/
    			.icps_charts_canvas {
    				width:100%!important;
    				max-width:100%;
    			}

    			@media screen and (max-width:480px) {
    				div.icps-chart-wrap {
    					width:100%!important;
    					float: none!important;
						margin-left: auto!important;
						margin-right: auto!important;
						text-align: center;
    				}
    			}
    		</style>';
}

// chargement des Script

function charts_load_scripts() {

	if ( !is_Admin() ) {

		wp_enqueue_script( 'jquery' );

		wp_register_script( 'charts-js', plugins_url('/js/Chart.min.js', __FILE__) );
		wp_register_script( 'icps-charts-functions', plugins_url('/js/functions.js', __FILE__),'jquery','', true );

		wp_enqueue_script( 'charts-js' );
		wp_enqueue_script( 'icps-charts-functions' );
	}

}

// verifier le nombre de couleurs dans la variable

if ( !function_exists('charts_compare_colonbr') ) {
	function charts_compare_color_nbr(&$measure,&$colonbr) {
		// only if the two arrays don't hold the same number of elements
		if (count($measure) != count($colonbr)) {
		    while (count($colonbr) < count($measure) ) {
		        $colonbr = array_merge( $colonbr, array_values($colonbr) );
		    }
		    $colonbr = array_slice($colonbr, 0, count($measure));
		}
	}
}

// fonction pour convertir les formats de couleur

if (!function_exists( "charts_hex2rgb" )) {
	function charts_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }

	   $rgb = array($r, $g, $b);
	   return implode(",", $rgb); // retourne les valeurs rvb separées par une virgule
	}
}

// pour Javascript sous IE (ne pas toucher)

if (!function_exists('charts_trailing_comma')) {
	function charts_trailing_comma($incrementeur, $count, &$subject) {
		$stopper = $count - 1;
		if ($incrementeur !== $stopper) {
			return $subject .= ',';
		}
	}
}

//  Shortcode de base avec toutes ses options

function charts_shortcode( $atts ) {

	// Attribut par défauts pour les Shortcodes
	
	extract( shortcode_atts(
		array(
			'type'             => 'pie',
			'title'            => 'chart',
			'canvaswidth'      => '250',
			'canvasheight'     => '250',
			'width'			   => '100%',
			'height'		   => 'auto',
			'margin'		   => '',
			'relativewidth'	   => '1',
			'align'            => '',
			'class'			   => '',
			'labels'           => '',
			'data'             => '30,50,100',
			'datasets'         => '30,50,100 next 20,90,75',
			'colors'           => '#69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264',
			'fillopacity'      => '0.7',
			'pointstrokecolor' => '#FFFFFF',
			'animation'		   => 'true',
			'scalefontsize'    => '12',
			'scalefontcolor'   => '#666',
			'scaleoverride'    => 'false',
			'scalesteps' 	   => 'null',
			'scalestepwidth'   => 'null',
			'scalestartvalue'  => 'null'
		), $atts )
	);

	// preparer la sauce
	
	$title    = str_replace(' ', '', $title);
	$data     = explode(',', str_replace(' ', '', $data));
	$datasets = explode("next", str_replace(' ', '', $datasets));

	// checker les couleurs

	if ($colors != "") {
		$colors   = explode(',', str_replace(' ','',$colors));
	} else {
		$colors = array('#69D2E7','#E0E4CC','#F38630','#96CE7F','#CEBC17','#CE4264');
	}

	(strpos($type, 'lar') !== false ) ? $type = 'PolarArea' : $type = ucwords($type);
	
	$currentchart = '<div class="'.$align.' '.$class.' icps-chart-wrap" style="width:'.$width.'; height:'.$height.';margin:'.$margin.';" data-proportion="'.$relativewidth.'">';
	$currentchart .= '<canvas id="'.$title.'" height="'.$canvasheight.'" width="'.$canvaswidth.'" class="icps_charts_canvas" data-proportion="'.$relativewidth.'"></canvas></div>
	<script>';
	$currentchart .= 'var '.$title.'Ops = {
		animation: '.$animation.',';

	if ($type == 'Line' || $type == 'Radar' || $type == 'Bar' || $type == 'PolarArea') {
		$currentchart .=	'scaleFontSize: '.$scalefontsize.',';
		$currentchart .=	'scaleFontColor: "'.$scalefontcolor.'",';
		$currentchart .=    'scaleOverride:'   .$scaleoverride.',';
		$currentchart .=    'scaleSteps:' 	   .$scalesteps.',';
		$currentchart .=    'scaleStepWidth:'  .$scalestepwidth.',';
		$currentchart .=    'scaleStartValue:' .$scalestartvalue;
	}

	$currentchart .= '}; ';

	// demarrer la bonne variable selon le type
	if ($type == 'Line' || $type == 'Radar' || $type == 'Bar' ) {

		charts_compare_color_nbr($datasets, $colors);
		$total    = count($datasets);

		// labels

		$currentchart .= 'var '.$title.'Data = {';
		$currentchart .= 'labels : [';
		$labelstrings = explode(',',$labels);
		for ($j = 0; $j < count($labelstrings); $j++ ) {
			$currentchart .= '"'.$labelstrings[$j].'"';
			charts_trailing_comma($j, count($labelstrings), $currentchart);
		}
		$currentchart .= 	'],';
		$currentchart .= 'datasets : [';
	} else {
		charts_compare_color_nbr($data, $colors);
		$total = count($data);
		$currentchart .= 'var '.$title.'Data = [';
	}

		// creer une variable Javascript en fonction du type de chart demandé

		for ($i = 0; $i < $total; $i++) {

			if ($type === 'Pie' || $type === 'Doughnut' || $type === 'PolarArea') {
				$currentchart .= '{
					value 	: '. $data[$i] .',
					color 	: '.'"'. $colors[$i].'"'.'
				}';

			} else if ($type === 'Bar') {
				$currentchart .= '{
					fillColor 	: "rgba('. charts_hex2rgb( $colors[$i] ) .','.$colonbropacity.')",
					strokeColor : "rgba('. charts_hex2rgb( $colors[$i] ) .',1)",
					data 		: ['.$datasets[$i].']
				}';

			} else if ($type === 'Line' || $type === 'Radar') {
				$currentchart .= '{
					fillColor 	: "rgba('. charts_hex2rgb( $colors[$i] ) .','.$colonbropacity.')",
					strokeColor : "rgba('. charts_hex2rgb( $colors[$i] ) .',1)",
					pointColor 	: "rgba('. charts_hex2rgb( $colors[$i] ) .',1)",
					pointStrokeColor : "'.$pointstrokecolor.'",
					data 		: ['.$datasets[$i].']
				}';

			}  // fin des conditions de type

			charts_trailing_comma($i, $total, $currentchart);
		}

		// fin des variables JS en foncton du type

		if ($type == 'Line' || $type == 'Radar' || $type == 'Bar') {
			$currentchart .=	']};';
		} else {
			$currentchart .=	'];';
		}

		$currentchart .= 'var wpChart'.$title.$type.' = new Chart(document.getElementById("'.$title.'").getContext("2d")).'.$type.'('.$title.'Data,'.$title.'Ops);
	</script>';

	// et on affiche le résultat final youhou !! \o/
	
	return $currentchart;
}

function charts_start() {
	add_action( "wp_enqueue_scripts", "charts_load_scripts" );
	add_action('wp_head', 'charts_html5_support');
	add_shortcode( 'charts', 'charts_shortcode' );	
}

add_action('init', 'charts_start');

