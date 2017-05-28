<?php get_header(); ?>
<?php global $wp_query; $curauth = $wp_query->get_queried_object(); ?>
<div id="content" class="date-page page-container">
	<div class="datepage-content">
	<div class="post-container wrapper">
	<?php if ( have_posts() ) : ?>
			<?php /* The loop */  $pc=0; ?>
			<?php while ( have_posts() ) : the_post(); $pc++ ?>
            	<div id="post-<?php if($options['blog_tpl']=="Grid") echo $pc; else the_ID(); ?>" <?php if($options['blog_tpl']=="Grid") { post_class("wrapper");echo "style='margin-top:20px'"; }else  post_class(); ?>>
                	<div class="postthumb" style="<?php if($options['blog_tpl']=="SmallImage") echo "float:left"; ?>">
						<?php 
                            if ( has_post_thumbnail() ) {
								the_post_thumbnail('postimage-large');
                            } 
                        ?>
                    </div>
                    <div class="postcontent">
                        <h3><a href="<?php the_permalink(get_the_ID()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
	                    <?php if($options['blog_tpl']=='Grid'){ ?>
	                        <span id="postauthor">By <?php the_author_posts_link(); ?></span>
	                        <span id="postdate">On <?php echo get_the_date(); ?></span>
						<?php }  ?> 
                        <p><?php if(strlen(get_the_content())>300) echo substr(get_the_content(),0,300)." ...<br>"; else echo get_the_content(); ?></p>
                    </div>
                   	<div style="clear:both"></div>
                    <div class="postotherinfo">
                        <span id="postauthor">By <?php the_author_posts_link(); ?></span>
                        <span id="postdate">On <?php echo get_the_date(); ?></span>
                        <span class="sepa">|</span>
                        <span id="postcategory">
                        	<?php 
								$pi=0; $postcategories=get_the_category(); $postcatcount=sizeof($postcategories);
								foreach(get_the_category() as $postcategory){
									echo "<a href='".get_category_link($postcategory->term_id)."' title='".$postcategory->name."'>".$postcategory->name."</a>"; $pi++;
									if($pi<$postcatcount)
										echo ", ";	
								}
							?>
                        </span>
                        <span class="sepa">|</span>
                        <span id="postcomment">
                        	<?php
								comments_popup_link("No comments","1 comment","% comments");
							?>
                        </span>
                        <span id="postreadmore"><a href="<?php the_permalink(get_the_ID()); ?>">Read More &raquo;</a></span>
	                   	<div style="clear:both"></div>
                    </div>
                   </div></div>
			<?php endwhile; ?>

		<?php else : ?>
        	<?php echo "There are no posts"; ?>
		<?php endif; ?>
     </div></div>
     <div id="blogsidebar" class="wrapper" style="<?php echo $blogsidebarcss; ?>">
        <div class="search-wid">
            <form id="searchwid">
                <input type="text" name='search-wid' placeholder="Search"  />
            </form>
        </div>
        <?php the_widget("WP_Widget_Categories"); ?>
        <?php the_widget("WP_Widget_Archives"); ?>
    </div>
<div style="clear:both"></div>
</div>
<?php get_footer(); ?>