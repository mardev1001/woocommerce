<?php
	# Insert Featured Products

	function hyunmoo_shortcode_product_categories_slider( $atts, $content = '' )
	{	
		$default_atts = array(
			'number'	=> '-1',
			'per_column'	=> '4',
			'parent'	=> '',
			'displayitem' => 'false'
		);

		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		if($parent == "")
			$parent = 0;
		else {
			$category = get_term_by( 'slug', $parent, 'product_cat' );
			$parent = $category->term_id;
		}
				
		$hm_categories = get_terms( 'product_cat','parent='.$parent.'&orderby=count&hide_empty=0' );
		
		if ($hm_categories) : 
		$output= '<div class="hmprodcats_slider hmprodcats wrapper">';
		$output.='<input type="hidden" id="catspercolumn" value="'.$per_column.'">';
        $output.= '<h2>Product Categories</h2>';
        $output.= '<ul class="categories">';
			foreach($hm_categories as $hm_category){
				$output.= '<li class="product_cat item">';
                $output.= '<div class="catimg" align="center">';
				$image = wp_get_attachment_image( get_woocommerce_term_meta( $hm_category->term_id, 'thumbnail_id', true ), 'classic-small' );
               	$output.=$image."</div>";
                $output.= '<h3><a href="'.get_term_link($hm_category->slug, 'product_cat').'">';
				$output.=$hm_category->name;
				if($displayitem == "true")
					$output.='<span> ('.$hm_category->count.')</span>';
				$output.="</a></h3>";
				$output.="</li>";
			}
		$output.="</ul></div>";
		endif;		
		# Prepare Output
		
		return $output;
	} 
	add_shortcode( 'hm_product_categories_slider', 'hyunmoo_shortcode_product_categories_slider' );
	
	function hyunmoo_shortcode_product_categories_list( $atts, $content = '' )
	{	
		$default_atts = array(
			'number'	=> '-1',
			'per_column'	=> '4',
			'parent'	=> '',
			'displayitem' => 'false'
		);

		# Shortcode the content inside
		$content = do_shortcode( $content );
		
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract( $atts );
		
		if($parent == "")
			$parent = 0;
		else {
			$category = get_term_by( 'slug', $parent, 'product_cat' );
			$parent = $category->term_id;
		}
				
		$hm_categories = get_terms( 'product_cat','parent='.$parent.'&orderby=count&hide_empty=0' );
		
		if ($hm_categories) : 
		$output= '<div class="hmprodcats_list hmprodcats">';
		$output.='<input type="hidden" id="catspercolumn" value="'.$per_column.'">';
        $output.= '<h3>Product Categories</h3>';
        $output.= '<ul class="categories">';
			foreach($hm_categories as $hm_category){
				$output.= '<li class="product_cat item">';
                $output.= '<div class="catimg" align="center">';
				$image = wp_get_attachment_image( get_woocommerce_term_meta( $hm_category->term_id, 'thumbnail_id', true ), 'postimage-small' );
               	$output.=$image."</div>";
                $output.= '<h3><a href="'.get_term_link($hm_category->slug, 'product_cat').'">';
				$output.=$hm_category->name;
				if($displayitem == "true")
					$output.='<span> ('.$hm_category->count.')</span>';
				$output.="</a></h3>";
				$output.="</li>";
			}
		$output.="<div class='clear'></div></ul></div>";
		endif;		
		# Prepare Output
		
		return $output;
	} 
	add_shortcode( 'hm_product_categories_list', 'hyunmoo_shortcode_product_categories_list' );
?>