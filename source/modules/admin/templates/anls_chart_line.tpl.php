<script type="text/javascript">
$(function () {
	$('#container').highcharts({
		<?php
		if(isset($chart_colors)){
		?>
		colors: [<?php echo $chart_colors ?>],
		<?php
		}
		?>
		title: {
			text: '<?php echo $chart_ti ?>',
			x: -20, //center
			style: {
				fontFamily: 'Microsoft YaHei, Arial',
				fontSize: '20px'
			}
		},
		subtitle: {
			text: '', //子标题
			x: -20
		},
		/*chart: {
			defaultSeriesType: 'spline'
		},*/
		xAxis: {
			categories: [<?php echo $chart_xdata ?>],
			plotLines: [{
				value: -1,
				width: 1,
				color: '#ADADAD',
				dashStyle: 'ShortDot'
			}],
			labels: {
				rotation: 0,
				style: {
					fontSize: '12px',
					fontFamily: 'Microsoft YaHei, Arial'/*,
					writingMode:'tb-rl'    //文字竖排样式*/
				}
			}
		},
		yAxis: {
			title: {
				text: '<?php echo $chart_yti ?>'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#ADADAD'
			}],
			min: 0,
			tickInterval: <?php echo $chart_ytick ?>,
			allowDecimals: false
		},
		tooltip: {
			valueSuffix: '<?php echo $chart_dw ?>',
			style: {
				fontFamily: 'Arial',
				fontSize: '12px'
			},
			/*pointFormat: '<span style="color:{series.color};">{series.name}</span>: <b>{point.y}</b>'*/
			formatter: function() {
				//<br/><span style="display:none;"><span style="color:' + this.series.color + ';">' + this.series.name + '</span>: <b>' + this.y + this.series.tooltipOptions.valueSuffix + '</b></span>
				return '<b style="color:' + this.series.color + ';">' + this.x + '</b><br/>' + this.series.options.tips[this.point.x]
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 0,
			itemMarginTop: 2,
			itemMarginBottom: 2
		},
		<?php if(1==1){ ?>
		plotOptions: {
			line: {
				dataLabels: {
					enabled: <?php if($chart_offdatalab==true){ echo 'false'; }else{ echo 'true'; } ?>
				}/*,
				enableMouseTracking: false*/
			},
			series: {
				point: {
					events: {
						mouseOver: function(){
							//if(!/msie/.test(navigator.userAgent.toLowerCase())) { 
								//Highcharts.charts[0].xAxis[0].options.plotLines[0].value=this.x;
								//Highcharts.charts[0].xAxis[0].update(); //UPDATE辅助线很卡
								var xval=this.x;
								Highcharts.charts[0].xAxis[0].removePlotLine('xPlotLine1');
								Highcharts.charts[0].xAxis[0].addPlotLine({
									id: 'xPlotLine1',
									value: xval,
									width: 1,
									color: '#ADADAD',
									dashStyle: 'ShortDot'
								});
							//}
						}
					}
				}
			}
		},
		<?php } ?>
		series: [
				<?php
				$num=0;
				if(is_array($chart_sdatas)){foreach($chart_sdatas as $k=>$chart_sdata){
				?>
				{
					name: '<?php echo $chart_ssets[$num][0] ?>',
					marker: { symbol: 'circle' },
					data: [<?php echo $chart_sdata ?>],
					tips: [<?php echo $chart_stips[$k] ?>],
					visible: <?php echo $chart_ssets[$num][1] ?>,
				},
				<?php
				$num++;
				}}
				?>
		],
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		}
	});
});
</script>