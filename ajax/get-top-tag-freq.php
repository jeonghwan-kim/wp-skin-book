<?php
/**
 * 해당 태그명의 상위 리스트를 반환한다.
 * Input: 태그명, 리턴 갯수(num)
 * Output: 상위 num개의 태그 값 리스트
 * @since 2013. 9. 15. 
 * @author jeonghwan
 */

header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

if ( !isset($_GET['tag_name']) || !isset($_GET['num']) ) exit();

// 파라메터 받기 
$tag_name = $_GET['tag_name'];
$num = $_GET['num'];

// 저자 목록 받아오기
$query = "SELECT term_id FROM $wpdb->term_taxonomy " .
		 "WHERE taxonomy = '" . $tag_name . "'"; 
$the_tags = $wpdb->get_col($query);

// echo $query; exit();
// 배열에 저장(태그값, 빈도)
$tag_freq = array();
foreach($the_tags as $tag_id) {
	// 태그정보 받아오기
	$post_tag = get_term( $tag_id, $tag_name );

	// 배열에 저장
	if ($post_tag->count == 0)  continue;
	$tag_value = $post_tag->name;
	$count = (int)$post_tag->count;
	$tag_freq[$tag_value] = $count;
	
	unset($post_tag);
}

// 상위 num 개만 리턴 
$top_tag_freq = array();
arsort($tag_freq);
$i = 0;
foreach ($tag_freq as $key => $value) {
	$top_tag_freq[$key] = $value;
	if (++$i >= $num) break;
}

echo json_encode( $top_tag_freq );

?>

