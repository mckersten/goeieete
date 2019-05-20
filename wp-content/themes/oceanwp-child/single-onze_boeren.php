 <?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package OceanWP WordPress theme
 */

get_header();?>
<div class="container f_img">
<?php 
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	if(has_post_thumbnail())
	{
				 $featuredimg = get_the_post_thumbnail_url();?>
				<img src="<?php echo $featuredimg;?>" width="100%" height="20px">	
<?php }   
the_content();
?>		

	<?php endwhile;
else :
	echo wpautop( 'Sorry, no posts were found' );
endif;
 ?>

</div>

<?php get_footer(); ?>
