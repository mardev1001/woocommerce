	<div id="primary" class="site-content">
		<div id="defaultcontent" role="main" class="search-page">

			<header class="page-header wrapper">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'hyunmoo' ), get_search_query() ); ?></h1>
                <div class="search-tabs">
					<ul class="tabs">
					<?php if( class_exists( 'woocommerce' ) ) : ?>
						<li><a class="skin-primary-border-top" href="?s=p&for=product" rel="product">Product</a></li>
						<li><a href="?s=p&for=post" rel="post">Post</a></li>
					<?php else : ?>
                     	<li><a class='skin-primary-border-top' href="?s=p&for=post" rel="post">Post</a></li>
					<?php endif; ?>
                     	<li><a href="?s=p&for=page" rel="page">Page</a></li>
						<li><a href="?s=p&for=user" rel="user">User</a></li>                     	
                   </ul>
                </div>
                <div class="clear"></div>
			</header>

			<div class="search-content">
			<div class="trailer"></div>
            </div>

		</div><!-- #content -->
	</div><!-- #primary -->