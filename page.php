<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>


<?php the_post(); ?>

<!-- 페이지 분기  -->
<?php 
if ($post->ID == 680): get_template_part( 'content-analysis', 'page' );
else: get_template_part( 'content', 'page' ); 
endif;
?>

<?php //comments_template( '', true ); ?>


<?php get_footer(); ?>