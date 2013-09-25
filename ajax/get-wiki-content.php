<?php
// header('Access-Control-Allow-Origin: *');
// header ("Content-Type: application/json");

require_once('../../../../wp-load.php' );

echo get_wiki_content($_GET['keyword']);

/**
 * 위키api호출
 * 입력: 위키 키워드
 *      option: article
 * 출력: 위키 본문 (설명만)
 */
function get_wiki_content($keyword) {
	$keyword = urlencode($keyword);
	$query = "http://ko.wikipedia.org/w/api.php?action=parse&page=$keyword&format=json";
	$result = "";

	// api 호출
	$wiki = json_decode( file_get_contents($query) );

	// 에러처리
	if (isset($wiki->error)) return $result;

	// html 얻기
	$html = "";
	$wiki = $wiki->parse->text;
	foreach ($wiki as $key => $value) {
		if ($key == "*") {
			$html = $value;
			break;
		}
	}
	if ($html == "") return $result;

	// <p> 태그만 추출
	require_once ('simple_html_dom.php');
	$html = str_get_html($html);
	if ($html == false) return $result;
	/**
	 * 김대중으로 요청하면 돔객체 생성에 실패한다. 
	 * 대안: 직접 <p>태그 추출 함수를 작성한다.
	 */
	foreach ($html->find('p') as $elem) {
		// var_dump($elem);
		$result = $result . ' ' . $elem->innertext;
	}
	if ($result == "") return $result;

	// html 태그 제거 
	$result = strip_tags($result);

	// 결과 길이 제한
	$result = cut_text($result, 430);

	return $result;
}

function cut_text($text, $count, $more = "...") {
	$length = mb_strlen($text, "UTF-8");

	if($length <= $count) 
		return $text; 
	else 
		return mb_substr($text, 0, $count, "UTF-8") . " " . $more; 
}

?>