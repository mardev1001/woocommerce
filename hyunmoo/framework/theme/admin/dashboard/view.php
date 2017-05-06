<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'module.php' );

class AdminDashboard extends HyunmooModule {
	public $pageTitle;
	public $menuTitle;
	
	public function __construct() {
		$this->xmlconfig = dirname( __FILE__ ) . DS . 'config.xml';
		$this->pageTitle = 'Hyunmoo Baby Dashboard';
		$this->menuTitle = 'Dashboard';
		
		parent::__construct();
		
		add_action( 'before-hyunmoo-module', array( $this, 'add_tricks' ) );
		$this->add_modules();
	}
	public function addDecorations() {
		$path = get_template_directory_uri();
		
		wp_enqueue_style( 'hyunmoo-admin-style', $path . '/css/admin.css' );
		wp_enqueue_style( 'hyunmoo-module-style', $path . '/css/admin-module.css' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-flot', $path . '/js/jquery.flot.js' );
		wp_enqueue_script( 'jquery-flot-time', $path . '/js/jquery.flot.time.js' );
		wp_enqueue_script( 'jquery-flot-resize', $path . '/js/jquery.flot.resize.js' );
	}
	public function add_tricks() {
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('div.handlediv').click(function() {
			$(this).parent().toggleClass('closed');
		});
	});
</script>
<?php
	}
	public function add_modules() {
		add_action( 'hyunmoo-module-top-siteinfo', array( $this, 'siteinfo_box' ) );
		add_action( 'hyunmoo-module-left-shop', array( $this, 'shop_box' ) );
		add_action( 'hyunmoo-module-left-records', array( $this, 'records_box' ) );
		add_action( 'hyunmoo-module-right-users', array( $this, 'users_box' ) );
		add_action( 'hyunmoo-module-right-blog', array( $this, 'blog_box' ) );
		add_action( 'hyunmoo-module-bottom-support', array( $this, 'support_box' ) );
	}
	public function siteinfo_box() {
		global $hyunmoo;
		
		$options = Hyunmoo::getConfig( 'settings.basic' );
?>
<div class="dash-left">
	<img src="<?php echo $options['brand'] ?>" style="max-width:95%;height:auto;" />
</div>
<div class="dash-right">
	<ul>
		<li><?php bloginfo( 'name' ) ?>: <i><a href="<?php echo home_url(); ?>"><?php echo home_url(); ?></a></i></li>
		<li>Wordpress Version: <i><?php bloginfo( 'version' ); ?></i></li>
		<li>Theme Framework: <i>Hyunmoo</i></li>
		<li>Theme Version: <i><?php echo $hyunmoo['version']; ?></i></li>
		<li>Theme Style: <i>Responsive, Retina-ready, Mobile-ready</i></li>
		<li>Description: <i><?php bloginfo( 'description' ) ?></i></li>
		<li>Owner E-Mail: <i><?php echo get_option( 'admin_email' ) ?></i></li>
	</ul>
</div>
<div style="clear:both;"></div>
<?php
	}
	public function shop_box() {
		if( !class_exists( 'woocommerce' ) ) {
			echo '<p>This box module is for WooCommerce only.</p>';
			return;
		}
		global $woocommerce, $wpdb;
		
		$pdt_count = wp_count_posts( 'product' );
		$link = add_query_arg( array( 'post_type' => 'product' ), get_admin_url( null, 'edit.php' ) );
		echo '<div class="dash-left">';
		echo '<p>WooCommerce Version: <i>' . $woocommerce->version . '</i></p>';
		echo '<p>Products: <a href="' . $link . '"><i>' . $pdt_count->publish . '</i></a></p>';
		$category_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'product_cat'");
		$link = add_query_arg( array( 'taxonomy' => 'product_cat', 'post_type' => 'product' ), get_admin_url( null, 'edit-tags.php' ) );
		echo '<p>Categories: <a href="' . $link . '"><i>' . $category_count . '</i></a></p>';
		echo '</div>';
	//Total sales	Total orders
		$order_totals = apply_filters( 'woocommerce_reports_sales_overview_order_totals', $wpdb->get_row( "
			SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts

			LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
			LEFT JOIN {$wpdb->term_relationships} AS rel ON posts.ID=rel.object_ID
			LEFT JOIN {$wpdb->term_taxonomy} AS tax USING( term_taxonomy_id )
			LEFT JOIN {$wpdb->terms} AS term USING( term_id )

			WHERE 	meta.meta_key 		= '_order_total'
			AND 	posts.post_type 	= 'shop_order'
			AND 	posts.post_status 	= 'publish'
			AND 	tax.taxonomy		= 'shop_order_status'
			AND		term.slug			IN ('" . implode( "','", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "')
		" ) );
	//Total order items
		$order_items = apply_filters( 'woocommerce_reports_sales_overview_order_items', absint( $wpdb->get_var( "
			SELECT SUM( order_item_meta.meta_value )
			FROM {$wpdb->prefix}woocommerce_order_items as order_items
			LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
			LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
			LEFT JOIN {$wpdb->term_relationships} AS rel ON posts.ID = rel.object_ID
			LEFT JOIN {$wpdb->term_taxonomy} AS tax USING( term_taxonomy_id )
			LEFT JOIN {$wpdb->terms} AS term USING( term_id )
			WHERE 	term.slug IN ('" . implode( "','", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "')
			AND 	posts.post_status 	= 'publish'
			AND 	tax.taxonomy		= 'shop_order_status'
			AND 	order_items.order_item_type = 'line_item'
			AND 	order_item_meta.meta_key = '_qty'
		" ) ) );
		
		$currency = get_woocommerce_currency();
		$symbol = get_woocommerce_currency_symbol( $currency );
		echo '<div class="dash-right">';
		echo '<p>Total Sales: <strong>' . $symbol . $order_totals->total_sales . '</strong></p>';
		echo '<p>Total Orders: <strong>' . $order_totals->total_orders . ' order(s)</strong></p>';
		echo '<p>Order Items: <strong>' . $order_items . ' item(s)</strong></p>';
		echo '</div>';
		echo '<div style="clear:both;"></div>';
	//Up to 3 best sellers during last 100 days
		global $woocommerce;
		
		$args = array();
		$args['posts_per_page'] = 3;
		$args['post_type'] = 'product';
		$args['no_found_rows'] = 1;
		$args['post_status'] = 'publish';
		$args['meta_key'] = 'total_sales';
		$args['order'] = 'DESC';
		$args['orderby'] = 'meta_value_num';
		$query = new WP_Query( $args );
		$items = array();
		
		if ( $query->have_posts() ) :
			// The Loop
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$items[$post->ID] = $post->post_title;
			}
		endif;
		$order_items = apply_filters( 'woocommerce_reports_top_earners_order_items', $wpdb->get_results( "
			SELECT order_item_meta_2.meta_value as product_id, SUM( order_item_meta.meta_value ) as line_total, posts.post_date as date FROM {$wpdb->prefix}woocommerce_order_items as order_items

			LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
			LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_2 ON order_items.order_item_id = order_item_meta_2.order_item_id
			LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
			LEFT JOIN {$wpdb->term_relationships} AS rel ON posts.ID = rel.object_ID
			LEFT JOIN {$wpdb->term_taxonomy} AS tax USING( term_taxonomy_id )
			LEFT JOIN {$wpdb->terms} AS term USING( term_id )

			WHERE 	posts.post_type 	= 'shop_order'
			AND 	posts.post_status 	= 'publish'
			AND 	tax.taxonomy		= 'shop_order_status'
			AND		term.slug			IN ('" . implode( "','", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "')
			AND 	order_items.order_item_type = 'line_item'
			AND 	order_item_meta.meta_key = '_line_total'
			AND 	order_item_meta_2.meta_key = '_product_id'
			GROUP BY posts.post_date, order_item_meta_2.meta_value
		" ));
		
		foreach( $order_items as $key => $order ) {
			if( !in_array( $order->product_id, array_keys( $items ) ) )
				unset( $order_items[$key] );
		}
		$days = array();
		$today = date( 'Y-m-d' );
		for( $i = 0 ; $i < 11 ; $i ++ ) {
			$day = date( 'Y-m-d', strtotime( '-' . $i * 10 . ' days' ) );
			$days[] = $day;
		}
		
		$listings = array();
		foreach( $order_items as $order ) {
			$product = $order->product_id;
			$linetotal = $order->line_total;
			$date = $order->date;
			$time = strtotime( $date );
			if( !isset( $listings[$product] ) || !is_array( $listings[$product] ) || empty( $listings[$product] ) ) {
				$listings[$product] = array();
				foreach( $days as $day )
					$listings[$product][$day] = 0;
			}
			foreach( $days as $day ) {
				$time1 = strtotime( $day );
				if( $time <= $time1 )
					$listings[$product][$day] += $linetotal;
			}
		}
?>
<br>
<h3 style="background: #fff;border: 1px solid #777;">Have a look at your <strong>HOT</strong> products during last 100 days</h3>
<script type="text/javascript">
jQuery(document).ready(function($) {
<?php foreach( $listings as $product => $sales ) : ?>
	var item<?php echo $product ?> = [];
	<?php foreach( $sales as $day => $sale ) : ?>
	item<?php echo $product ?>.push([<?php echo strtotime( $day ) * 1000 ?>,<?php echo $sale ?>]);
	<?php endforeach; ?>
<?php endforeach; ?>
	function weekendAreas(axes) {
	
		var markings = [],
			d = new Date(axes.xaxis.min);

		// go to the first Saturday

		d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
		d.setUTCSeconds(0);
		d.setUTCMinutes(0);
		d.setUTCHours(0);

		var i = d.getTime();

		// when we don't set yaxis, the rectangle automatically
		// extends to infinity upwards and downwards

		do {
			markings.push({ xaxis: { from: i, to: i } });
			i += 5 * 24 * 60 * 60 * 1000;
		} while (i < axes.xaxis.max);

		return markings;
	}
	var options = {
		xaxis: {
			mode: "time",
			timeformat: "%m/%d",
			tickLength: 5
		},
		yaxis: { min: 0, tickFormatter: function (v, axis) { return "<?php echo $symbol ?>" + v.toFixed(axis.tickDecimals) }},
		y2axis: { min: 0, tickFormatter: function (v, axis) { return "<?php echo $symbol ?>" + v.toFixed(axis.tickDecimals) }},
		y3axis: { min: 0, tickFormatter: function (v, axis) { return "<?php echo $symbol ?>" + v.toFixed(axis.tickDecimals) }},
		legend: { position: 'nw' },
		series: {
			lines: {
				show: true
			},
			points: {
				show: true
			}
		},
		grid: {
			markings: weekendAreas,
			hoverable: true,
			clickable: true,
			tickColor:'#f4f4f4',
			borderColor: '#f4f4f4',
			backgroundColor:'#FFFFFF'
		}
	};
	var plot = $.plot("#placeholder", 
		[
		<?php foreach( $listings as $product => $sales ) : ?>
			{
				data: item<?php echo $product ?>,
				label: "<?php echo $items[$product] ?>",
				symbol: "<?php echo $symbol ?>"
			},
		<?php endforeach; ?>
		], 
		options
	);
	$('#placeholder').resize();
	function showChartTooltip(x, y, contents) {
		jQuery('<div id="charttooltip">' + contents + '</div>').css( {
		position: 'absolute',
		display: 'none',
		top: y + 5,
		left: x + 5,
		padding: "5px",
		border: "1px solid #dad7d7",
		"background-color": "#efefef",
		"border-radius": "5px",
		opacity: 1
		}).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;
	jQuery("#placeholder").bind("plothover", function (event, pos, item) {
		jQuery("#x").text(pos.x.toFixed(2));
		jQuery("#y").text(pos.y.toFixed(2));
		if (item) {
			if (previousPoint != item.datapoint) {
                previousPoint = item.datapoint;

				jQuery("#charttooltip").remove();
				var x = new Date(item.datapoint[0]), y = item.datapoint[1];
				var xday = x.getDate(), xmonth = x.getMonth()+1; // jan = 0 so we need to offset month
				showChartTooltip(item.pageX, item.pageY, xmonth + "/" + xday + " - <b>" + item.series.symbol + y + "</b> " + item.series.label);
			}
		} else {
			jQuery("#charttooltip").remove();
			previousPoint = null;
		}
	});

	$("#placeholder").bind("plotclick", function (event, pos, item) {
		if (item) {
			$("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
			plot.highlight(item.series, item.datapoint);
		}
	});
});
</script>
<div id="placeholder" style="width:100%; height:300px; position:relative;"></div>
<p>
	<span id="hoverdata"></span>
	<span id="clickdata"></span>
</p>
<?php
	}
	public function records_box() {
		global $wpdb;
		
		$sql = "SELECT COUNT(*) as count, type FROM {$wpdb->prefix}hyunmoo_records GROUP BY type";
		$results = $wpdb->get_results( $sql );
		if( empty( $results ) ) {
			echo '<p>No theme assets found.</p>';
			return;
		}
		foreach( (array)$results as $result ) {
			$type = $result->type;
			$count = $result->count;
			echo '<p>' . ucfirst( $type ) . ': <i>' . $count . '</i></p>';
		}
	}
	public function users_box() {
		global $wpdb;
		
		$result = count_users();
		$link = get_admin_url( null, 'users.php' );
		echo '<p><strong>There are <a href="' . $link . '">' . $result['total_users'], '</a> total users</strong></p>';
		echo '<ul style="padding-left: 15px">';
		foreach($result['avail_roles'] as $role => $count) {
			$link = add_query_arg( array( 'role' => $role ), get_admin_url( null, 'users.php' ) );
			echo '<li><i>' . ucfirst( $role ) . ': <a href="' . $link . '">' . $count, '</a></i></li>';
		}
		echo '</ul>';
		
		$firstdaymonth = strtotime( date( '01-m-Y' ) );
		$sql = "SELECT `user_registered` FROM {$wpdb->prefix}users WHERE 1";
		$results = $wpdb->get_results( $sql );
		$newusers = 0;
		if( !empty( $results ) ) {
			foreach( $results as $user ) {
				$registered = strtotime( get_date_from_gmt( $user->user_registered ) );
				if( $registered >= $firstdaymonth )
					$newusers ++;
			}
		}
		echo '<p>New users this month : <strong>' . $newusers . ' user(s)</strong></p>';
	}
	public function blog_box() {
		global $wpdb;
		
		$posts = wp_count_posts();
		$link = get_admin_url( null, 'edit.php' );
		echo '<p>Posts: <a href="' . $link . '"><i>' . $posts->publish . '</i></a></p>';
		$category_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'category'");
		$link = add_query_arg( array( 'taxonomy' => 'category' ), get_admin_url( null, 'edit-tags.php' ) );
		echo '<p>Categories: <a href="' . $link . '"><i>' . $category_count . '</i></a></p>';
		$pages = wp_count_posts( 'page' );
		$link = add_query_arg( array( 'post_type' => 'page' ), get_admin_url( null, 'edit.php' ) );
		echo '<p>Pages: <a href="' . $link . '"><i>' . $pages->publish . '</i></a></p>';
	}
	public function support_box() {
		echo '<p>Here are what people say about our theme</p>';
		echo '<p>For more information, please visit our site<p>';
		echo '<p><a style="color:red" href="http://hyunmoo.samcholi.com"><i>- Visit US! -</i></a></p>';
	}
}
?>