<?php
	
	
	function showseparator() {
		
    	return '<span class="break shortcode-break"></span><br/><br/>';	
	}
	add_shortcode('separator', 'showseparator');
        
	function showbreak() {
            return '<div class="clear-both break"></div>';	
	}
	add_shortcode('break', 'showbreak');
	

	function showQuote($atts, $content = null){
		return '<div class="quote-content"><div class="quote-img-holder"><img title="images" alt="images" src="'.get_template_directory_uri().'/style/img/quote-img.png"></div><div class="quote-text-holder">'.do_shortcode($content).'</div></div>';
	}
	add_shortcode('quote','showQuote');




   function showCallToAction($atts, $content = null){
         extract(shortcode_atts(array(
				'link' => '',
				'buttontext' => ''
		), $atts));
			return '<div class="about-box"><div class="about-content">'.do_shortcode($content).'</div><a href="'.$link.'"><div class="shortcode-button-default button-right"><div class="button-default-left"></div><div class="button-default-center margin-correction">'.$buttontext.'</div><div class="button-default-right"></div></a></div></div>';


	}
	add_shortcode('calltoaction','showCallToAction');
	


	function showfullwidth($atts,$content = null){
		return '<div id="fullwidth-box">'.do_shortcode($content).'</div>';		
	}
	add_shortcode('fullwidth','showfullwidth');


	function showthreecolumns($atts, $content = null ) {
		
    	return '<div id="three-columns">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('three-columns', 'showthreecolumns');	


	function showtwocolumns($atts, $content = null ) {
		
    	return '<div id="two-columns">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('two-columns', 'showtwocolumns');	
	
	
	function showonecell($atts, $content = null ) {
	    return '<div class="one_cell">'.do_shortcode($content).'</div>';	
	}
	
	add_shortcode('one_cell', 'showonecell');	
	
		
	function showonecelllast($atts, $content = null ) {
	    return '<div class="one_cell" style="margin: 0pt!important;">'.do_shortcode($content).'</div>';	
	}
	
	add_shortcode('one_cell_last', 'showonecelllast');	
	
	
	
	
	function celltextshortcode($atts, $content = null ) {
	    return '<div class="cell_text">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('cell_text', 'celltextshortcode');
		

	
	
	function showtitles($atts,$content = null){
		return '<div class="titles">'.do_shortcode($content).'</div>';
	}
	add_shortcode('titles', 'showtitles');
	
	
	
	
	function celltitle($atts,$content = null){
                return '<div class="cell_title"><h2>'.do_shortcode($content).'</h2></div>';
	}
	add_shortcode('cell_title', 'celltitle');
	
	
	
	
	function cellsubtitle($atts,$content = null){
		return '<div class="cell_subtitle">'.do_shortcode($content).'</div>';
	}
	add_shortcode('cell_subtitle', 'cellsubtitle');
	
	
	


	function callline($atts,$content = null){
		
		return '<div id="horizontal-line"></div>';
		
	}
	add_shortcode('line', 'callline');
	
	
	function showBox($atts, $content = null ) {
		
			extract(shortcode_atts(array(
				'width' => '100',
				'align'=>'left',
		), $atts));
		
		$new_width = $width - 3;
		$new_width .= "%";
		if ($width==50) {
			$new_width = "47%;";
		}
		if ($new_width==30) {
			$new_width = "30.2%;";
		}
		
		if ($width == 100){
			$new_width = "961px";
		}
		
		
    	return '<div class="shortcode-box" id="box" style="width:'.$new_width.';">'.do_shortcode($content).'</div>';	
	}
	add_shortcode('box', 'showBox');
	
	
	
	
	function showButton($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'margin'=>'',
				'align'=>'left',
				'color' => 'red'
		), $atts));
		
		$margin = str_replace('px','',$margin);
		if(!empty($color)) {$new_color ="-".$color;}


		return 	'<div class="shortcode-button'.$new_color.'" style="float:'.$align.'!important;margin-left:'.$margin.'px;">
					<a href="'.$url.'"><div class="button'.$new_color.'-left"></div>
						<div class="button'.$new_color.'-center">
							<div class="button'.$new_color.'-content">'.$content.'</div>
						</div>
					<div class="button'.$new_color.'-right"></div></a>
				</div>';

	}
	add_shortcode('button', 'showButton'); 
	
	
	function showonethird($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left',
				'from'=>''
		), $atts));
		
		

		return '<span class="onethird '.$from.'">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('onethird', 'showonethird');

	function showonethirdlast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left',
				'from'=>''
		), $atts));
		
		

		return '<span class="onethird last '.$from.'">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('onethird_last', 'showonethirdlast');

	function showtwothird($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));
		
		

		return '<span class="twothird">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('twothird', 'showtwothird');

	function showtwothirdlast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));
		
		

		return '<span class="twothird last">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('twothird_last', 'showtwothirdlast'); 

	function showonehalf($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));
		
		

		return '<span class="onehalf">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('onehalf', 'showonehalf'); 
	
	function showonehalflast($atts, $content= null ) {
		
			extract(shortcode_atts(array(
				'url' => '',
				'color'=>'',
				'margin'=>'',
				'align'=>'left'
		), $atts));
		
		

		return '<span class="onehalf last">'.do_shortcode($content).'</span>';
		

	}
	add_shortcode('onehalf_last', 'showonehalflast'); 

	function showH1($atts, $content = null ) {

    	return '<h1>'.$content.'</h1>';
	}
	add_shortcode('h1', 'showH1');




	function showH2($atts, $content = null ) {

    	return '<h2 class="shorcode-h2">'.$content.'</h2>';
	}
	add_shortcode('h2', 'showH2');


        function showHeading($atts,$content = null){
            extract(shortcode_atts(array(
				'type'=>'h1'
		), $atts));
            return '<'.$type.'>'.$content.'</'.$type.'>';
        }
        add_shortcode('heading','showHeading');
        
	

	
	
	

?>