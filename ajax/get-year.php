<?php
header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

$args = array( 'type' => 'yearly','show_post_count' => 1, 'echo'=>0 );
$archives = wp_get_archives($args);
$archives = explode( '</li>' , $archives );

$result = array();
foreach ($archives as $link) {
	// 년도명 찾기
	$year_name = strpos($link, "title");
	$year_name = substr($link, $year_name+7, 4);

	// 포스트 갯수 찾기
	$count_p1 = strpos($link, "</a>") + 11;
	$temp = substr($link, $count_p1);
	$count_p2 = strpos($temp, ")");
	$count = (int)substr($temp, 0, $count_p2);

	// 배열에 저장하기
	if (!$year_name) break;
	$result[$year_name] = $count;
}

echo json_encode($result);



?>