
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	yMultiplier = (typeof yMultiplier === "undefined") ? 1 : yMultiplier;
	var dispData = [];
	var xAxis = '<?php echo $tableColHr1?>';
	var yAxis = '<?php echo $tableColHr2?>';
	var xMax = 0;
	var yMax = 0;
	//var yMultiplier =1.5;
	dispData.push([xAxis, yAxis]);
	<?php foreach ($tableData as $aPoint) : ?>
		var x = <?php echo $aPoint[0]?>;
		var y = <?php echo $aPoint[1]?>;
		if (x > xMax){
			xMax = x;
		}
		if (y > yMax){
			yMax = y;
		}
		y=y*yMultiplier;
   		dispData.push([x,y]);
   	<?php endforeach; ?>
    var data = google.visualization.arrayToDataTable(dispData);

    var options = {
      title: xAxis.concat(" vs. ",yAxis),
      hAxis: {title: xAxis, minValue: 0, maxValue: xMax},
      vAxis: {title: yAxis, minValue: 0, maxValue: yMax*2},
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

<script>
function onSlide(){ 
	yMultiplier = Number($("#slider-value").text());
	drawChart();
};

$(function() {                        
   $('#slider').noUiSlider({
		start: 1 ,
		step: 0.1,
		range: {
			'min': 0,
			'max': 2
		}
	});
	$('#slider').Link('lower').to($('#slider-value'));
	$('#slider').on('slide', onSlide);
	$('#slider').on('set', onSlide);
});

 </script>  
<div class="well">
	<div class="row">
		<div class="col-md-12">
			<center>
			<div id="chart_div"></div>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-8">
			<br>
			<div class="well well-sm">
				<div id="slider"></div>	
			</div>		
			<div>
				Muliplier: 
				<span class="example-val" id="slider-value"></span>
			</div>
		</div>	
		<div class="col-md-2">&nbsp;</div>
	</div>
</div>



