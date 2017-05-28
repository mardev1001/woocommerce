<?php
	global $theme;
	
	$options = Hyunmoo::getConfig( 'settings.basic' );
	$advanced = Hyunmoo::getConfig( 'settings.advanced' );
	$adminbar = $advanced['adminbar'];
	if( !$adminbar )
		$adminbar = 'disable';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<title><?php $theme->title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if( $options['favicon'] ): ?>
	<link rel="shortcut icon" href="<?php echo $options['favicon']; ?>" type="image/x-icon" />
<?php endif; ?>

<?php if( $options['iphone'] ): ?>
<!-- For iPhone -->
<link rel="apple-touch-icon-precomposed" href="<?php echo $options['iphone']; ?>">
<?php endif; ?>

<?php if( $options['iphone_retina'] ): ?>
<!-- For iPhone 4 Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $options['iphone_retina']; ?>">
<?php endif; ?>

<?php if( $options['ipad'] ): ?>
<!-- For iPad -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $options['ipad']; ?>">
<?php endif; ?>

<?php if( $options['ipad_retina'] ): ?>
<!-- For iPad Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $options['ipad_retina']; ?>">
<?php endif; ?>
<script type="text/javascript">
	window.root = '<?php echo get_template_directory_uri(); ?>';
	window.atts = new Object;
	window.ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
	window.loadimg = '<?php echo get_template_directory_uri() ?>/images/loading.gif';
	window.template = '<?php echo $theme->getTemplate(); ?>';
<?php
	if( class_exists( 'woocommerce' ) ) :
?>
	window.defaultsearch = 'product';
<?php
	else :
?>
	window.defaultsearch = 'post';
<?php
	endif;
?>
</script>
<?php 
	wp_head();
?>
<link type="text/css" rel="stylesheet" href="<?php echo $theme->get_template_url(); ?>/woocommerce/style.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php $theme->template_style(); ?>" media="all" />
<?php
	$styles = Hyunmoo::getConfig( 'settings.style' );
	$header_font = $styles['header_font'];
	$title_font = $styles['title_font'];
	$content_font = $styles['content_font'];
	$color_primary = $styles['color_primary'];
	$color_secondary = $styles['color_secondary'];
?>
<?php if( $header_font != '' ) : ?>
	<link href='http<?php echo ( is_ssl() )? 's' : ''; ?>://fonts.googleapis.com/css?family=<?php echo urlencode( $header_font ); ?>:300,400,400italic,500,600,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese' rel='stylesheet' type='text/css' />
<?php endif; ?>
<?php if( $title_font != '' ) : ?>
	<link href='http<?php echo ( is_ssl() )? 's' : ''; ?>://fonts.googleapis.com/css?family=<?php echo urlencode( $title_font ); ?>:300,400,400italic,500,600,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese' rel='stylesheet' type='text/css' />
<?php endif; ?>
<?php if( $content_font != '' ) : ?>
	<link href='http<?php echo ( is_ssl() )? 's' : ''; ?>://fonts.googleapis.com/css?family=<?php echo urlencode( $content_font ); ?>:300,400,400italic,500,600,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese' rel='stylesheet' type='text/css' />
<?php endif; ?>
<?php
	if( $header_font != '' )
		$header_font = '"' . $header_font . '", Arial, Helvetica, sans-serif !important';
	else
		$header_font = '"Helvetica Neue", Arial, Helvetica, sans-serif !important';
	if( $title_font != '' )
		$title_font = '"' . $title_font . '", Arial, Helvetica, sans-serif !important';
	else
		$title_font = '"Helvetica Neue", Arial, Helvetica, sans-serif !important';
	if( $content_font != '' )
		$content_font = '"' . $content_font . '", Arial, Helvetica, sans-serif !important';
	else
		$content_font = '"Helvetica Neue", Arial, Helvetica, sans-serif !important';
?>
<style type="text/css">
	body {
		font-family:<?php echo $content_font ?>;
	}
	h1,h2,h3,h4,h5,h6 {
		font-family:<?php echo $title_font ?>;
	}
	.menu, .menu a, .menu span, .menu p {
		font-family:<?php echo $header_font ?>;
	}
</style>
<?php if( $color_primary != '' ) : ?>
<style type="text/css">
	h1,h2,h3,mark {
		color:#<?php echo $color_primary ?>;
	}
</style>
<?php endif; ?>
<?php if( $color_secondary != '' ) : ?>
<style type="text/css">
	body,.post-container p,.box-title {
		color:#<?php echo $color_secondary ?>;
	}
</style>
<?php endif; ?>
<?php
	$options = Hyunmoo::getConfig( 'settings.advanced' );
	echo $options['trackcode'];
?>
</head>
<body <?php body_class(); ?>>
<div id="searchresultbox"><div id="searchresults"></div></div>
<div id="backgroundPopup"></div>
	
	<div class="mainpart">
  	    <input type="hidden" id="template" value="<?php echo $theme->getTemplate(); ?>" />
       	<div class="menu" id="topmenu" <?php if( $adminbar == "enable") echo 'style="top:28px"'; ?>>
			<div id="logo">
			<?php
				$options = Hyunmoo::getConfig( 'settings.basic' );
				$logo = $options['logo'];
				if ( isValidUrl( $logo ) ) {
					echo '<a href="' . home_url() . '"><img src="' . $logo . '" height="30px" align="middle" /></a>';
				}
				else {
					echo '<a href="' . home_url() . '">' . $logo . '</a>';
				}
			?>
			</div>
   		<?php
			wp_nav_menu( array( 'theme_location' => 'primary-mobile', 'items_wrap' => '<ul>%3$s</ul>', 'container_class' => 'mainmenu', 'fallback_cb' => 'hyunmoo_nomenu' ) );
		?></div>

		<?php
			if( !class_exists( 'woocommerce' ) || ( !is_shop() && !is_product_category() && !is_product_tag() ) ) :
		?>
		<div class="menu" id="bottommenu">
			<i class="fa fa-list" id="menuicon"></i>
			<i class="fa fa-envelope" id="contacticon"></i>
			<i class="fa fa-search" id="searchicon"></i>
			<?php
				if( class_exists( 'woocommerce' ) ) : 
					global $woocommerce;
			?>
			<i style="margin-right: 11% !important;" onclick="window.location.href='<?php echo $woocommerce->cart->get_cart_url(); ?>'" class="fa fa-shopping-cart"></i>
			<?php endif; ?>
		</div>
		<?php
			else :
				global $woocommerce;
		?>
		<div class="menu" id="bottommenu">
			<i style="margin-right: 11% !important;" class="fa fa-list" id="menuicon"></i>
			<i style="margin-right: 11% !important;" class="fa fa-envelope" id="contacticon"></i>
			<i style="margin-right: 11% !important;" class="fa fa-search" id="searchicon"></i>
			<i style="margin-right: 11% !important;" class="fa fa-filter" id="filtericon"></i>
			<i style="margin-right: 11% !important;" onclick="window.location.href='<?php echo $woocommerce->cart->get_cart_url(); ?>'" class="fa fa-shopping-cart"></i>
		</div>
		<?php
			endif;
		?>
        <div id="searchpopup" class="popupdialog">
			<div class="title">Search<div class="pclose">&times;</div></div>
			<div class="pmain">
			<form method='get' class='searchform' action='<?php echo home_url( '/' ) ?>'>
				<input type="text" name="s" autocomplete='off' placeholder="Search" id="search" />
			</form>
			</div>
        </div>
        <div id="contactpopup" class="popupdialog">
			<div class="title">Contact Us!<div class="pclose">&times;</div></div>
			<div class="pmain">
				<?php the_widget( 'HyunmooContactWidget' ); ?>
			</div>
        </div>
		<?php
			if( class_exists( 'woocommerce' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) :
		?>
		<div id="filterpopup" class="popupdialog">
			<div class="title">Products Filter<div class="pclose">&times;</div></div>
			<div class="pmain">
			<?php
				if( is_active_sidebar( 'hyunmoo-toolbox' ) )
					dynamic_sidebar( 'hyunmoo-toolbox' );
			?>
			</div>
		</div>
		<?php
			endif;
		?>