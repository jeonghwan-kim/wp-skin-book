<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

</div><!-- my_container -->

<div class="footer-bar"></div>

<div id="site-generator">
	<div class="btn-group">
		<a class="btn" href="#modal" data-toggle="modal">독서계획</a>
		<!-- <a class="btn" href="http://localhost/daum-api/index.html" target="blank">도서이미지 찾기</a> -->
		<a class="btn" href="<?php echo get_page(680)->guid; ?>">통계</a>
		<a class="btn" href="http://www.facebook.com/jeonghwan.kim1">Facebook</a>
		<a class="btn" href="mailto:ej88ej@gmail.com">Email</a>
	</div>

	<!-- Modal -->
	<div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<h3 id="myModalLabel" class="modal-title">연도별 독서계획</h3>
  		</div>

	  	<div class="modal-body">
	  		<!-- 독서계획 page 만 표시한다 -->
	  		<!-- 2009독서계획: 244 -->
	  		<!-- 2010독서계획: 240 -->
	  		<!-- 2011독서계획: 175 -->
	  		<!-- 2012독서계획: 2 -->
	  		<!-- 2013독서계획: 487 -->
    		<?php wp_list_pages('sort_column=created_date&title_li=&'.
    		'link_before=<span class="btn btn-primary btn-large btn-block">&'.
    		'link_after=</span>&include=244,240,175,2,487'); ?>
  		</div>
  		<div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">닫기</button>
		</div>
  	</div>
</div>


<?php wp_footer(); ?>

</body>
</html>