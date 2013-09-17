
var recommended_books = new Array();
var recommended_books_i;

// HTML을 모두 로딩하고 실행
$(window).load(function() {
	var current_path = $("#current_path").val();

	// 저자별 분석 그래프
	$.get(current_path + "/ajax/get-top-tag-freq.php?tag_name=book_author&num=5", 
		function(data, statues) {
		google.load("visualization", "1", {packages:["corechart"], 
		    callback:function() {
		        draw_chart_author("google-chart-author", data);
		    }
		});
	});

	// 출판사별 분석 그래
	$.get(current_path + "/ajax/get-top-tag-freq.php?tag_name=publisher&num=5", 
		function(data, statues) {
		google.load("visualization", "1", {packages:["corechart"], 
		    callback:function() {
		        draw_chart_publisher("google-chart-publisher", data);
		    }
		});
	});

	// 월별 분석 그래프 
	$.get(current_path + "/ajax/get-month.php", function(data, statues) {
		google.load("visualization", "1", {packages:["corechart"], 
		    callback:function() {
		        draw_chart_month("google-chart-month", data);
		    }
		});
	});

	// 연도별 분석 그래프 
	$.get(current_path + "/ajax/get-year.php", function(data, statues) {
		google.load("visualization", "1", {packages:["corechart"], 
		    callback:function() {
		        draw_chart_year("google-chart-year", data);
		    }
		});
	});

	// 도서추천
	$("#recommend").append('<img src="'+current_path+'/images/loading.gif" />');
	$.get(current_path + "/ajax/get-top-tag-freq.php?tag_name=book_author&num=5", 
		function(data, statues) {
		// 도서추천
		// 상위 5명 저자에 대한 추천도서 계산 및 출력
		var authors = new Array();
		for (key in data) 
			authors.push(key)
		recommend_books(current_path, authors);
	});

	$("#next-recommend-books").click(function(){
		
		console.log(recommended_books_i);
		if (recommended_books_i >= recommended_books.length - 1) return;

		show_recommend_books(recommended_books);
		console.log(recommended_books_i);
	});

	$("#pre-recommend-books").click(function(){
		console.log(recommended_books_i);
		if (recommended_books_i <= 5) return;

		recommended_books_i -= 10;
		show_recommend_books(recommended_books);
		console.log(recommended_books_i);
	});

});

function draw_chart_author(chart_div, data) {
	var google_data = new google.visualization.DataTable();
	google_data.addColumn('string', '지은이');
	google_data.addColumn('number', '독서량');

	for (key in data) {	
		google_data.addRow([key, data[key]]);
	}

	var options = {
		title: '상위 5명의 저자',
		backgroundColor: 'transparent',
		chartArea: {width: '100%', height: '100%'},
		legend: 'none',
		};

	var chart = new google.visualization.PieChart(document.getElementById(chart_div));

	chart.draw(google_data, options);
}	

function draw_chart_publisher(chart_div, data) {
	var google_data = new google.visualization.DataTable();
	google_data.addColumn('string', '출판사');
	google_data.addColumn('number', '독서량');

	for (key in data) {	
		google_data.addRow([key, data[key]]);
	}

	var options = {
		title: '상위 5개의 출판사',
		backgroundColor: 'transparent',
		chartArea: {width: '100%', height: '100%'},
		legend: 'none',
		};		

	var chart = new google.visualization.PieChart(document.getElementById(chart_div));

	chart.draw(google_data, options);
}	


function draw_chart_month(chart_div, data) {
	var google_data = new google.visualization.DataTable();
	google_data.addColumn('string', '월');
	google_data.addColumn('number', '독서량');

	for (key in data) {	
		google_data.addRow([key, data[key]]);
	}

	var options = {
		title: '',
		// width: 700,
		height: 250,
		backgroundColor: 'transparent',
		legend: 'none',
		// colors: ['blue','#004411'],
		hAxis: { textStyle: {color: '#ccc', fontSize:10}, },
		vAxis: { textStyle: {color: '#ccc', fontSize:10}, format:"#"}
		};

	var chart = new google.visualization.ColumnChart(document.getElementById(chart_div));

	chart.draw(google_data, options);
}	

function draw_chart_year(chart_div, data) {
	var google_data = new google.visualization.DataTable();
	google_data.addColumn('string', '년도');
	google_data.addColumn('number', '독서량');

	for (key in data) {	
		google_data.addRow([key, data[key]]);
	}

	var options = {
		title: '',
		// width: 700,
		height: 250,
		backgroundColor: 'transparent',
		legend: 'none',
		// colors: ['blue','#004411'],
		hAxis: { textStyle: {color: '#ccc', fontSize:10}, },
		vAxis: { textStyle: {color: '#ccc', fontSize:10}, format:"#"}
		};

	var chart = new google.visualization.ColumnChart(document.getElementById(chart_div));

	chart.draw(google_data, options);
}	

/**
 * author에 대한 추천 도서를 가져옴 (daum book 검색 api)
 */
function recommend_books(current_path, authors) {
	// 페이지 네비게이션 감추기
	$("#pre-recommend-books").css("display", "none");
	$("#next-recommend-books").css("display", "none");

	// json object -> json string
	authors = JSON.stringify(authors);

	// 저자의 읽은 도서 정보를 가져온다.
	$.post(current_path + "/ajax/get-read-books-by-author.php", {list: authors},
		function(data, statues) {
			console.log(data);

			// json object -> json string
			var read_books = JSON.stringify(data);
			console.log(read_books);

			// 추천도서를 가져온다.
			$.post(current_path + "/ajax/get-recommended-books.php", {read_books: read_books},
				function(data, statues) {
					console.log(data);

					for (key in data) {
						var title = data[key].title;
						var author = data[key].author;
						var publisher = data[key].publisher;
						var pic_url = data[key].pic_url;
						recommended_books.push(new Array(title, author, publisher, pic_url));
					}
					
					// 로딩중 이미지 삭제
					$("#recommend img").remove();

					// 결과를 화면에 뿌린다.
					recommended_books_i = 0;
					show_recommend_books();
				});
		});
}

/**
 * 추천도서목록(data)에서 5개를 출력함.
 */
function show_recommend_books() {
	$("#recommend").text("");

	for (var i=0; i<5 && 
		recommended_books_i + i < recommended_books.length; i++) {
		var title = recommended_books[recommended_books_i + i][0];
		var author = recommended_books[recommended_books_i + i][1];
		var publisher = recommended_books[recommended_books_i + i][2];
		var pic_url = recommended_books[recommended_books_i + i][3];
	
		// 5번째 이미지 별도 적용
		if (i == 4) var html = '<div class="the-fifth-book" ';
		else var html = '<div class="the-book" ';
		
		// 툴팁 메세지
		var tooltip_msg = title+' / '+author+' / '+publisher;
		html += 'data-original-title="' + tooltip_msg + '" >';

		// 링크설정
		html += '<a href=""><img src="' + pic_url + '" /></a></div>';
		console.log(html);

		// body메 붙이기
		$("#recommend").append(html);
	}

	recommended_books_i = recommended_books_i + i;

	// 이미지의 툴팁 메세지를 설정한다.
	$(".the-book").tooltip({placement: 'top'});
	$(".the-fifth-book").tooltip({placement: 'top'});

	// 페이지 네비게이션 설정
	console.log(recommended_books_i);
	console.log(recommended_books.length);
	if (recommended_books_i + 5 <= recommended_books.length) 
		$("#next-recommend-books").css("display", "block");
	else
		$("#next-recommend-books").css("display", "none");
	if (recommended_books_i - 5 == 0) 
		$("#pre-recommend-books").css("display", "none");
	else
		$("#pre-recommend-books").css("display", "block");
}

