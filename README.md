### wp-skin-book

The wordpress skin like a book shelf.

Example: http://54.250.223.230/book/

### New posts with daum book api

While writing a new post, you can search book information by using daum book api.

http://dna.daum.net/apis/search/ref#book

If you want to write with it, you shold follow below steps.

step 1. Add new file in wp-admin folder (new filename: search-book-api.php)

You have to recieve the api key form the daum site.

```php
<?php
header ("Content-Type: application/json");

if ( !isset($_GET['keyword']) ) exit();

$keyword = $_GET['keyword'];

$key = '[daum api key]';
$q_pageno = 1;
$q_result_per_page = 20;

$request = 'http://apis.daum.net/search/book?apikey='.$key.
		   '&q='.urlencode($keyword).  
		   '&output=json'. 
		   '&pageno='. $q_pageno .
		   '&result='. $q_result_per_page;

$response = file_get_contents($request);
$book_info = json_decode($response, true); 

$total_count = $book_info['channel']['totalCount'];
$total_pages = floor($total_count / $q_result_per_page + 1);

$result = array();
do {
	foreach ($book_info['channel']['item'] as $key => $value) {
		if ($value['title'] == "") continue;
		if ($value['cover_l_url'] == "") continue;

		$title = trim_string($value['title']);
		$author = trim_string($value['author']);
		$publisher = trim_string($value['pub_nm']);
		$pic_url = trim_string($value['cover_l_url']);
		$pub_date = trim_string($value['pub_date']);

		array_push($result, array('title'=>$title,
			'author'=>$author,
			'publisher'=>$publisher,
			'pic_url'=>$pic_url,
			'pub_date'=>$pub_date));
	}

	 $q_pageno++;
} while ($q_pageno <= $total_pages);

echo json_encode($result);


function trim_string($str)
{
	$str = str_replace('&lt;b&gt;', '', $str);
	$str = str_replace('&lt;/b&gt;', '', $str);
	return $str;
}
?>
```

step 2. Add new file in wp-admin folder (new filename: search-book-widget.php)

```php
<div class="postbox">
	<div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle"><span>도서 검색</span></h3>
	<div class="inside">
		
		<input type="text" id="keyword" class="newtag form-input-tip" />
		<input type="button" value="검색" id="search-btn" class="button tagaad "/>
		
		<p class="howto" id="howto-msg" >도서정보를 입력하여 검색합니다.</p>
		
		<div id="result" style="padding-left:12px;"></div>
		
		<div id="nav">
			<div style="float:left"><a href="#" id="pre-books" style="display:none;">이전</a></div>
			<div style="float:right"><a href="#" id="next-books" style="display:none;">다음</a></div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

var books; 
var books_i; 

$("#search-btn").click(function() {
	var keyword = $("#keyword").val();
	if ("" == keyword) return;
	
	$("#result").text("");

	$.get("search-book-api.php?keyword="+encodeURI(keyword), function(data, status) {
		if ('' == data) {
			search_error_msg();
			return;
		}

		books = data;
		books_i = 0;

		show_two_books("+2");
	});
});

$("#next-books").click(function() {
	if ('' == books) return;
	show_two_books("+2");
});

$("#pre-books").click(function() {
	if ('' == books) return;
	show_two_books("-2");
});

function show_two_books(num)
{
	$("#result").text("");

	if ("-2" == num) books_i = books_i - 4;

	for (var i = 0; i < 2 && books_i < books.length; i++) 
	{
		var title = books[books_i].title;
		var author = books[books_i].author;
		var pic_url = books[books_i].pic_url;
		var publisher = books[books_i].publisher;

		var html = '<div style="float:left; margin:0 10px 10px 0;" id="' + books_i + '" >' +
				   '<a href="#"><img src="'+pic_url+'" /></a></div>';
		$("#result").append(html);

		$("#"+books_i).click(function() { add_handler($(this).attr("id")); });

		books_i++;
	} 

	if (books_i < books.length - 1) $("#next-books").css("display", "block"); 
	else $("#next-books").css("display", "none"); 

	if (books_i > 2) $("#pre-books").css("display", "block"); 
	else $("#pre-books").css("display", "none"); 
}

function add_handler(id) 
{
	var title = books[id].title;
	var author = books[id].author;
	var pic_url = books[id].pic_url;
	var publisher = books[id].publisher;

	$("#title").val(title);
	$("#new-tag-book_author").val(author);
	$("#new-tag-publisher").val(publisher);
	$("#metakeyselect").val("book_img_url");
	$("#metavalue").val(pic_url);
}

function search_error_msg()
{
	$("#howto-msg").text("검색 결과가 없습니다. 다른 검색어를 입력해 보세요.");
}
</script>
```


step 3. Open wp-admin/edit-form-advanced.php and add the below codes

```php
<?php

if ( 'page' == $post_type )
	do_action('submitpage_box', $post);
else
	do_action('submitpost_box', $post);

// You have to add a below line be for do_meta_boxes() function.
require_once ('search-book-widget.php');

do_meta_boxes($post_type, 'side', $post); 
?>
```
