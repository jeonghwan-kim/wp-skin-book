<?php
/**
 * 최대 15개의 추천도서 목록을 랜덤으로 반환한다.
 *     기준: 저자가 1명당 최대 5개의 추천도서를 찾는다.
 *     자자가 3명일 경우 최대 15개의 추천도서를 찾는다.
 *
 * 입력: 읽은 도서 목록(저자/도서명)
 * 출력: 추천도서목록
 */

header ("Content-Type: application/json");

if (!isset($_POST['read_books'])) exit();
$read_books = json_decode($_POST['read_books']);

require_once ('api-key.php');

// 저자별로 도서목록를 가져온다.
$result = array();
foreach ($read_books as $the_read_books) {
	$temp = get_the_author_books($the_read_books, $daum_api_key);
	$result = array_merge($result, $temp);
}

// 도서목록을 랜덤으로 섞는다.
shuffle($result);

// 결과 반환 
echo json_encode($result);




// 불필요 문자 제거 
function trim_string($str)
{
	$str = str_replace('&lt;b&gt;', '', $str);
	$str = str_replace('&lt;/b&gt;', '', $str);
	return $str;
}


// 한명 저자의 도서목록 가져온다. (최대 5개)
// 이미 읽은 도서는 제외한다.
function get_the_author_books($the_read_books, $daum_api_key) {
	// echo json_encode($the_read_books);exit();
	$pageno = 1;
	$total_pages = 1;
	$result_per_page = 20;
	$result = array();
	$author = $the_read_books->author;

	while($pageno <= $total_pages) { 
		$request = 'http://apis.daum.net/search/book?apikey='.$daum_api_key.
			   '&q='.urlencode($author).
			   '&output=json'. 
			   '&sorting=popular'. // 판매량순
			   '&searchType=all'.
			   '&pageno='. $pageno .
			   '&result='. $result_per_page;

		$response = file_get_contents($request);
		$book_info = json_decode($response, true); 

		// 총 결과수 저장 및 총 페이지 계산
		if (!isset($book_info['channel'])) continue;
		$total_count = $book_info['channel']['totalCount'];
		$total_pages = floor($total_count / $result_per_page + 1);

		// 결과 저장 
		foreach ($book_info['channel']['item'] as $key => $value) {
			if ($value['title'] == "") continue;
			if ($value['cover_l_url'] == "") continue;

			// 정보가져오기 
			$title = trim_string($value['title']);
			$book_author = trim_string($value['author']);
			$publisher = trim_string($value['pub_nm']);
			$pic_url = trim_string($value['cover_l_url']);
			$pub_date = trim_string($value['pub_date']);

			// 필터를 통과하지 못하면 저장하지 않음. 
			if (!filter($the_read_books, $title, $book_author, $result)) continue;
			
			// 배열에 저장
			array_push($result, 
				array('title'=>$title,
				'author'=>$book_author,
				'publisher'=>$publisher,
				'pic_url'=>$pic_url,
				'pub_date'=>$pub_date));

			// 최대 갯수만큼 저장하면 결과 즉산 반환 
			if (count($result) == 5) return $result;
		}

	    $pageno++;
	} // end while

	return $result;
} 


/**
 * 도서검색결과 필터 함수
 *
 */
function filter($read_books, $title, $author, $saved_books) 
{
	// 비교 문자의 빈칸 삭제
	$author = str_replace(' ', '', $author);
	$title = str_replace(' ', '', $title);

	// 1. 저가가 다르면 제외 (api parameter미지원 때문 )
	if (str_replace(' ', '', $read_books->author) != $author) return false;

	// 2. 이미 저장된 도서이면 제외
	foreach ($saved_books as $the_book) 
		if (str_replace(' ', '', $the_book['title']) == $title) return false;

	// 이미 읽은 도서이면 제외
	foreach ($read_books->read_books as $book)
		if (str_replace(' ', '', $book) == $title) return false;

	return true;
}
?>

