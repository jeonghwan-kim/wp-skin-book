<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<div class="post-note">

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php book_meta($post->ID); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</div>

<div class="below-line-note">
	<footer class="entry-meta">
		<!-- 편집 버튼 -->
		<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</div>


<?php
/**
 * 저자, 작성일 표시하는 html 반환한다.
 *
 * @since 2013. 9. 15. 
 */
function book_meta($postID) {
	printf( __( '지은이 : %3$s / '.
		'출판사 : %4$s / ' .
		'<span class="sep">작성일 : </span><time class="entry-date">%1$s</time>'.
		' / 작성자 : <span class="author vcard">%2$s</span>'),
		esc_html( get_the_date() ),
		esc_html( get_the_author() ),
		get_book_author($postID),
		get_book_publisher($postID)
	);
}

?>