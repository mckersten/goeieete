<?php /* Template Name: Farmers */ ?>

<?php get_header(); ?>

<div class="main_wrap container">

<?php $args = array( 'post_type' =>'farmer', 'posts_per_page' => 5 );

	$myposts = get_posts( $args );
	foreach($myposts as $post)
	{
		/* print_r($post); */
	?>
	<div class="f_row">
	
		<?php 
		the_post_thumbnail( 'single-post-thumbnail' );?> 
		<h1><a href="<?php echo get_permalink($post->id);?>"><?php echo $post->post_title;?></a><?php echo "<br>"?></h1>
		
	</div>

	<?php  } ?>

</div>

<?php get_footer(); ?>