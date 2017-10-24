<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Dashboard</a>
				</li>
			</ul>
			<!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<?php if ($_SESSION['branch'] == 1) { ?>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="widget-box">
						<div class="widget-body">
							<div class="widget-main loader-container text-center">
								<div id="container-1" style="width:100%; height:auto;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="space-6"></div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="widget-box">
						<div class="widget-body">
							<div class="widget-main loader-container text-center">
								<div id="container-2" style="width:100%; height:auto;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="widget-box">
						<div class="widget-body">
							<div class="widget-main loader-container text-center">
								<div id="container-3" style="width:100%; height:auto;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- /.main-content -->
</div>
<script type="text/javascript">
function encode(obj) {
	$.map(obj, function(el) { return el });
}

function show_chart(currency) {
	$('#container-1').html('');
	$('#container-2').html('');
	
	if (currency == '1') {
		currSym = 'IDR';
		nextCur = '2';
	}
	else {
		currSym = 'USD';
		nextCur = '1';
	}

	// show chart by BRANCH
	$.get('chart-ajax/' + currency + '/branch', function(res) {
		var data = JSON.parse(res);

		if (data.label.length > 0) {
			Highcharts.chart('container-1', {
				chart: {
					type: 'column',
					style: {
						fontFamily: 'Open Sans'
					}
				},
				credits: {
					enabled: false
				},
				title: {
					text: 'Submission by Branch'
				},
				xAxis: {
					categories: data['label'],
					crosshair: true
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Values (IDR)'
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px; text-transform: uppercase;">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:&nbsp;</td>' +
						'<td style="padding:0"><b>' + currSym + ' {point.y:,.2f}</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
				series: [{
					name: 'Verified',
					color: '#16a085',
					data: data['verified']
				}, {
					name: 'Rejected',
					color: '#c0392b',
					data: data['rejected']
				}, {
					name: 'Ongoing',
					color: '#f1c40f',
					data: data['ongoing']
				}]
			});

		} else {
			$('#container-1').html("<span class='alert alert-default'>No data to display</span>");
		}
	});

	// show chart by MONTH
	$.get('chart-ajax/' + currency + '/month', function(res) {
		var data = JSON.parse(res);

		if (data.label.length > 0) {

			months = [];
			data.label.forEach(function(label, key) {
				switch (label) {
					case '1':
						label = 'January';
						break;
					case '2':
						label = 'February';
						break;
					case '3':
						label = 'March';
						break;
					case '4':
						label = 'April';
						break;
					case '5':
						label = 'May';
						break;
					case '6':
						label = 'June';
						break;
					case '7':
						label = 'July';
						break;
					case '8':
						label = 'August';
						break;
					case '9':
						label = 'September';
						break;
					case '10':
						label = 'October';
						break;
					case '11':
						label = 'November';
						break;
					default:
						label = 'December';
						break;
				}

				months.push(label)
			});

			Highcharts.chart('container-2', {
				chart: {
					type: 'line',
					style: {
						fontFamily: 'Open Sans'
					}
				},
				credits: {
					enabled: false
				},
				title: {
					text: 'Submission by Month'
				},
				subtitle: {
					text: 'on last 3 months'
				},
				xAxis: {
					categories: months
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Values (IDR)'
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px;">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:&nbsp;</td>' +
						'<td style="padding:0"><b>' + currSym + ' {point.y:,.2f}</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				series: [{
					name: 'Verified',
					color: '#16a085',
					data: data['verified']
				}, {
					name: 'Rejected',
					color: '#c0392b',
					data: data['rejected']
				}, {
					name: 'Ongoing',
					color: '#f1c40f',
					data: data['ongoing']
				}]
			});

		} else {
			$('#container-2').html("<span class='alert alert-default'>No data to display</span>");
		}
	});

	// show chart by EXPENSE TYPE
	$.get('chart-ajax/' + currency + '/type', function(res) {
		var data = JSON.parse(res);

		if (data.length > 0) {
			Highcharts.chart('container-3', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie',
					style: {
						fontFamily: 'Open Sans'
					}
				},
				credits: {
					enabled: false
				},
				title: {
					text: 'Submission by Expense Type'
				},
				tooltip: {
					pointFormat: currSym + ' {point.y:,.2f} ({point.percentage:.1f}%)'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [{
					name: 'Expense',
					colorByPoint: true,
					data: data
				}]
			});

		} else {
			$('#container-3').html("<span class='alert alert-default'>No data to display</span>");
		}
	});

	$('.currency-text').text(currSym);
	$('.currency-selector').html('<a href="#" onclick="show_chart(' + nextCur + ')">Show USD</a>');
}

show_chart('1'); // show the IDR first!

</script>