<?php
header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

// 출판사 받아오기
$the_tags = $wpdb->get_col("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'book_author'" );

// echo json_encode($the_tags);exit();

// 배열에 저장(출판사, 빈도)
$authors = array();
foreach($the_tags as $tag_id) {
	// 태그정보 받아오기
	$post_tag = get_term( $tag_id, 'book_author' );

	// 배열에 저장
	if ($post_tag->count == 0)  continue;
	$author = $post_tag->name;
	$count = (int)$post_tag->count;
	$authors[$author] = $count;
	
	unset($post_tag);
}

// echo json_encode($authors);exit();

// 상위 10개만 표시
$top_authors = array();
arsort($authors);
$i = 0;
foreach ($authors as $key => $value) {
	$top_authors[$key] = $value;
	if (++$i >= 10) break;
}

echo json_encode( $top_authors );

?>

