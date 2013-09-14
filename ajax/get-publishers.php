<?php
header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

// 출판사 받아오기
$the_tags = $wpdb->get_col("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'publisher'" );

// 배열에 저장(출판사, 빈도)
$publisher_list = array();
foreach($the_tags as $tag_id) {
	// 태그정보 받아오기
	unset($post_tag);
	$post_tag = get_term( $tag_id, 'publisher' );

	// 배열에 저장
	if ($post_tag->count == 0)  continue;
	
	$publisher = $post_tag->name;
	$count = (int)$post_tag->count;
	$publisher_list[$publisher] = $count;
}

// 상위 10개만 표시
$top_publisher_list = array();
arsort($publisher_list);
$i = 0;
foreach ($publisher_list as $key => $value) {
	$top_publisher_list[$key] = $value;
	if (++$i >= 10) break;
}

echo json_encode( $top_publisher_list );

?>

