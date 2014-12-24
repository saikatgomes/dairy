
<script type="text/javascript" src="https://www.google.com/jsapi"></script>


<script src="noUISlider/jquery.nouislider.js"></script>

<link href="noUISlider/jquery.nouislider.css" rel="stylesheet">

<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var dispData = [];
	var xAxis = '<?php echo $tableColHr1?>';
	var yAxis = '<?php echo $tableColHr2?>';
	var xMax = 0;
	var yMax = 0;
	var yMultiplier =1.5;
	dispData.push([xAxis, yAxis]);
	<?php foreach ($tableData as $aPoint) : ?>
		var x = <?php echo $aPoint[0]?>;
		var y = <?php echo $aPoint[1]?>;
		y=y*yMultiplier;
		if (x > xMax){
			xMax = x;
		}
		if (y > yMax){
			yMax = y;
		}
   		dispData.push([x,y]);
   	<?php endforeach; ?>
    var data = google.visualization.arrayToDataTable(dispData);

    var options = {
      title: xAxis.concat(" vs. ",yAxis),
      hAxis: {title: xAxis, minValue: 0, maxValue: xMax},
      vAxis: {title: yAxis, minValue: 0, maxValue: yMax},
      legend: 'none'
    };
	// Instantiate and draw our chart, passing in some options.
    function resize () {
    	var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
    	chart.draw(data, options);
    }
	window.onload = resize();
    window.onresize = resize;

    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }


</script>

<div class="slider"></div>
<div id="chart_div"></div>

