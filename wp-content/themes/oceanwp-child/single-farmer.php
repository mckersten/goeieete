 <?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package OceanWP WordPress theme
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	if(has_post_thumbnail())
	{
				 $featuredimg = get_the_post_thumbnail_url();?>
				<img src="<?php echo $featuredimg;?>" width="100%" height="30px">	
<?php } 
else
	{
				$image = get_field('farmer_image');?>
				<img src="<?php echo $image;?>" width="100%" height="30px">	<?php echo "</br>"?>
<?php }?>
		
			<div id="content-wrap" class="container clr">
				<?php echo  $value = get_field( "farmer_title" );?><?php echo "</br>"?>
				<?php echo  $value = get_field( "farmer_subtitle" );?><?php echo "</br>"?>
				<?php echo $content = get_the_content();?><?php echo "<br>"?>
					 <h3>We believe in the combination 
					of quality and conscious food.</h3>
					<button><a href="<?php echo site_url("/bestellen/");?>">BESTEL NU</button>
					
			<div id="primary" class="content-area clr">
			<div id="content" class="site-content clr">
			</div>
			</div>
			</div>

	<?php endwhile;
else :
	echo wpautop( 'Sorry, no posts were found' );
endif;
 ?>



<?php get_footer(); ?>
