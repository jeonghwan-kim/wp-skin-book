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