<?php
/**
 * 입력: 저자 리스트
 * 출력: 저자의 읽은 도서 리스트
 */
header('Access-Control-Allow-Origin: *');
header ("Content-Type: application/json");

// 순서에 주의. 이 코드는 반드시 wp-load.php 삽입전에 선언해야한다.
$authors = json_decode($_POST['list']);

require_once('../../../../wp-load.php' );


// 저자이름의 term 슬러그를 얻는다.
$temp = array();
foreach ($authors as $author) {
	$slug = get_term_by("name", $author, 'book_author')->slug;
	array_push($temp, array('author'=>$author, 'slug'=>$slug));
}
$authors = $temp;


// 저자의 도서를 얻는다. (슬러그로 조회)
$read_books = array();
foreach ($authors as $author) {
	$posts = query_posts('nopaging=true&book_author=' . $author['slug']);
	$books = array();
	foreach ($posts as $post) {
		array_push($books, $post->post_title);
	}
	array_push($read_books, array("author"=>$author['author'], "read_books"=>$books));	
}

echo json_encode($read_books); 


?>

