<?php get_header(); ?>
<?php
	$theme_option = flagship_sub_get_global_options();
	if ( false === ( $slider_query = get_transient( 'slider_query' ) ) ) {
		$slider_query = new WP_Query(array(
			'post_type' => 'slider',
			'posts_per_page' => '10',
			'orderby' => 'menu_order',
			'order' => 'ASC'));
		set_transient( 'slider_query', $slider_query, 2592000 );
	}
	if ( $slider_query->have_posts() ) :
?>
<div class="row hide-for-small-only">
<div class="slideshow-wrapper">
  <div class="preloader"></div>
<ul id="slider" data-orbit data-options="animation: fade; animation_speed:2000; timer:true; timer_speed:3000; navigation_arrows:false; bullets:false; slide_number:false;">
<?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
<li><a href="<?php echo get_post_meta($post->ID, 'ecpt_urldestination', true); ?>">
<div class="slide">
	<img src="<?php echo get_post_meta($post->ID, 'ecpt_slideimage', true); ?>" class="radius-top" />
		<div class="orbit-caption">
			<?php if($theme_option['flagship_sub_slider_style'] == "vertical") {
				 	locate_template('parts-vertical-slider.php', true, false);
				 	}
			 elseif($theme_option['flagship_sub_slider_style'] == "horizontal") {
			 		locate_template('parts-horizontal-slider.php', true, false);
			  } ?>
		</div>
</div>
</a>
</li>
<?php endwhile; ?>

</ul>
</div>
</div>

<?php endif; ?>

<div class="row sidebar_bg radius10 <?php if($theme_option['flagship_sub_slider_style'] == "vertical") { ?> <?php } ?>">
	<div class="small-12 large-8 columns wrapper <?php if($theme_option['flagship_sub_slider_style'] == "vertical") { ?>offset-top <?php } ?>toplayer">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<section>
				<?php the_content(); ?>
			</section>
		<?php endwhile; endif; ?>

		<?php
	/********NEWS QUERY**************/
		$news_query_cond = $theme_option['flagship_sub_news_query_cond'];
		$news_quantity = $theme_option['flagship_sub_news_quantity'];
			if ( false === ( $news_query = get_transient( 'news_mainpage_query' ) ) ) {
				if ($news_query_cond === 1) {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => array( 'books' ),
								'operator' => 'NOT IN'
							)
						),
						'posts_per_page' => $news_quantity));
				} else {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'posts_per_page' => $news_quantity));
				}
			set_transient( 'news_mainpage_query', $news_query, 2 );
			} 	
			if ( $news_query->have_posts() ) :
		?>
		<h4><?php echo $theme_option['flagship_sub_feed_name']; ?></h4>
		<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
		<div class="row">
		<section class="small-12 columns">
				<a href="<?php the_permalink(); ?>">
					<h6><?php the_date(); ?></h6>
					<h5 class="black"><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?>
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php the_excerpt(); ?>
				</a>
				<hr>
		</section>
		</div>

		<?php endwhile; ?>
		<div class="row">
		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><h5 class="black">View <?php echo $theme_option['flagship_sub_feed_name']; ?> Archive</h5></a>
		</div>
		<?php endif; ?>



	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>
