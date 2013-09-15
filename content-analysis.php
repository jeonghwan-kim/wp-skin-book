<!-- js를 위해 현재 경로 저장 -->
<input type="hidden" id="current_path" value="<?php echo get_template_directory_uri(); ?>" />

<div class="analysis">

	<div class="row-fluid one-box">
		<div class="span6">
			<h1>저자별 분석</h1>
			<?php wp_tag_cloud(array('taxonomy'=>'book_author','format'=>'flat')); ?>
		</div>
		<div class="span6">
			<div id="google-chart-author"></div>
			<p class="graph-title">상위 5명 저자</p>
		</div> 
	</div>

	<div class="row-fluid  one-box">
		<div class="span6">
			<h1>출판사별 분석</h1>
			<?php wp_tag_cloud(array('taxonomy'=>'publisher','format'=>'flat')); ?>
		</div>
		<div class="span6">
			<div id="google-chart-publisher"></div>
			<p class="graph-title">상위 5개 출판</p>
		</div> 
	</div>

	<div class="one-box">
		<h1 style="float:left;">월간 분석</h1>
		<div style="float:right">
			<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
	  		<option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
			  <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
			</select>
		</div>
		<div id="google-chart-month"></div> 
	</div>

	<div class="one-box">
		<h1 style="float:left;">연도별 분석</h1>
		<div style="float:right">
			<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
	  		<option value=""><?php echo esc_attr( __( 'Select Year' ) ); ?></option> 
			  <?php wp_get_archives( array( 'type' => 'yearly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
			</select>
		</div>				
		<div id="google-chart-year"></div> 
	</div>

	</div>

</div> <!-- analysis -->


<!-- Google chart -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- analysis.js -->
<?php $js_path = get_template_directory_uri() . '/js/analysis.js'; ?>
<script type="text/javascript" src="<?php echo $js_path; ?>"></script>
