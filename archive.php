<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

<?php $i = 0; // 5번째 이미지 체크 변수 ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<!-- <h1 class="page-title"> -->
		<h1>
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: %s', 'twentyeleven' ), '<span>' . get_the_date() . '</span>' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
			<?php elseif ( is_tax('book_author') ) : ?>
				<?php  echo '내가 읽은 <span class="white_font">' . 
				strip_tags(get_book_author($post->ID)) . '</span>의 도서'; ?>
			<?php elseif ( is_tax('publisher') ) : ?>
				<?php  echo '내가 읽은 <span class="white_font">' . 
				strip_tags(get_book_publisher($post->ID)) . '</span>의 도서'; ?>
			<?php else : ?>
			<?php endif; ?>
		</h1>
	</header>

	<?php /* Start the Loop */ ?>
	
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */

			if (++$i % 5 == 0) :
				get_template_part( 'content-fifth-book', get_post_format() );
			else :
				get_template_part( 'content', get_post_format() );
			endif;


		?>

	<?php endwhile; ?>

	<?php my_nav(); ?>

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


<?php get_sidebar(); ?>
<?php get_footer(); ?>