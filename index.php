<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

<div class="bookshelf" role="main">

<?php $i = 0; // 5번째 이미지 체크 변수 ?>
<?php if ( have_posts() ) : ?>

	<?php //twentyeleven_content_nav( 'nav-above' ); ?>

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php if (++$i % 5 == 0) : ?>
		<?php get_template_part( 'content-fifth-book', get_post_format() ); ?>
		<?php else : ?>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endif; ?>


	<?php endwhile; ?>

	<?php my_nav(); ?>
	<?php //twentyeleven_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

<?php endif; ?>

</div><!-- bookshelf -->

<?php get_footer(); ?>