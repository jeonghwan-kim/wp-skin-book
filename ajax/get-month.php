<?php
header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

// 최근 12개월 구독수
$result = array();
$m = date('Ym');
for ($i=1; $i<=12; $i++)
{
	// 요청
	$posts = query_posts('post_status=publish&m='.$m);
	
	// 저장
	$result[$m] = count($posts);
	
	// 이전달 구하기
	$offset = 31 * $i;
	$m = date('Ym', strtotime('-'.$offset.' days'));
}

echo json_encode($result);

?>

