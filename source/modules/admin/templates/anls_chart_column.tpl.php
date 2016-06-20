<script type="text/javascript">
$(function () {
	$('#container').highcharts({
		chart: {
			type: 'column'
		},
		colors: [<?php echo $chart_colors ?>],
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
			labels: {
				/*rotation: 35,*/
				style: {
					fontSize: '12px',
					fontFamily: 'Arial'/*,
					writingMode:'tb-rl'//文字竖排样式*/
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
				color: '#808080'
			}],
			min: 0,
			tickInterval: <?php echo $chart_ytick ?>,
			allowDecimals:false
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
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				}/*,
				enableMouseTracking: false*/
			},
			column: {
				pointWidth: 27,
				dataLabels: {
					enabled: true
				}
			}
		},
		series: [
				<?php
				$num=0;
				if(is_array($chart_sdatas)){foreach($chart_sdatas as $k=>$chart_sdata){
				?>
				{
					name: '<?php echo $chart_ssets[$num][0] ?>',
					data: [<?php echo $chart_sdata ?>],
					tips: [<?php echo $chart_stips[$k] ?>],
				},
				<?php
				$num++;
				}}
				?>
		],
		exporting: {
			enabled:false
		},
		credits: {
			enabled: false
		}
	});
});
</script>