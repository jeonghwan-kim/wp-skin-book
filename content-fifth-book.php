<?php
/**
 * The default template for displaying content
 * indext 화면 표시
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<!-- 포스트 -->
<?php if ( 'post' == get_post_type() ) : ?>
	
	<!-- 이미지 url 가져오기 -->
	<?php $book_img_url = get_post_meta($post->ID, 'book_img_url', 1); ?>
	<!-- 저자정보 -->
	<?php $author = strip_tags(get_book_author($post->ID)); ?>
	<!-- 포스팅 링크 가져오기 -->
	<?php $post_link = get_permalink($post->ID); ?>
	<!-- 책 제목 얻기 -->
	<?php $title = get_the_title($post->ID); ?>
	<!-- tooltip string -->
	<?php $tooltip_msg = $title . ' / ' . $author; ?>
	
	<div class="the-fifth-book"  data-original-title="<?php echo $tooltip_msg; ?>" >

          <!-- 이미지가 있는경우 -->
          <?php if ($book_img_url) :?>
               <a href="<?php echo $post_link; ?>" >
                    <img src="<?php echo $book_img_url; ?>" />
               </a>

           <!-- 이미지가 없는 경우 -->
          <?php else : ?>
               <!-- 기본 이미지 로딩 -->
               <?php $book_img_url = wp_get_attachment_image_src(659, 'full')[0]; ?>
               <a href="<?php echo $post_link; ?>" >
                    <img src="<?php echo $book_img_url; ?>" />
               </a>
               <a href="<?php echo $post_link; ?>" class="layered-title">
                    <span ><?php echo $title; ?></span></a>
                   
          <?php endif; ?>
	</div>

<!-- 페이지 -->
<?php else: ?>
	
	<?php $page_link = get_permalink($page->ID); ?>
	<!-- 페이지 제목 얻기 -->
	<?php $title = get_the_title($page->ID); ?>
	<!-- tooltip string -->
	<?php $tooltip_msg = $title; ?>
		
	<div class="the-fifth-book"  data-original-title="<?php echo $tooltip_msg; ?>" >

		<!-- 기본 이미지 로딩 -->
		<?php $book_img_url = wp_get_attachment_image_src(659, 'full')[0]; ?>
		<a href="<?php echo $page_link; ?>" >
		    <img src="<?php echo $book_img_url; ?>" />
		</a>
		<a href="<?php echo $page_link; ?>" class="layered-title">
		    <span ><?php echo $title; ?></span></a>
                   
	</div>

<?php endif; ?>

<script type="text/javascript">
	$(".the-fifth-book").tooltip({placement: 'top'});
</script>
	
