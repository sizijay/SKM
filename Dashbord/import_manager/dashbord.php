  <div style="padding: 7px;">
  <section class="content-header">
   <h1>Dashboard</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
          <li class="active"><a href="#"><i class="fa"></i>Dashboard</a></li>
      </ol>
    </section>
     <div class="box">
      	</div>
<!--main menu item goes here-->
<div class=" container col-md-10 col-md-offset-1">
    <div class="col-md-4 col-sm-6 col-xs-12 dashbordsection">
        <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-edit"></i></span>

            <div class="info-box-content">

                <span class="info-box-text">Purchase Requisitions</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <button class="form-control dashbordbtn" onClick="dashbordcontrol('new_requisition');">New Requisition</button>
        <button class="form-control dashbordbtn" onClick="dashbordcontrol('pending_requision');" >Pending Requisition</button>
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12 dashbordsection">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-table"></i></span>

            <div class="info-box-content">

                <span class="info-box-text">Purchase confirmation</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <button class="form-control dashbordbtn" onClick="dashbordcontrol('received_requisition');">Received Requisition</button>
        <button class="form-control dashbordbtn" onClick="dashbordcontrol('confirmed_requisition');"> Confirmed Requisition</button>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 dashbordsection">
        <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-edit"></i></span>

            <div class="info-box-content">

                <span class="info-box-text">Good receive</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <button class="form-control dashbordbtn" onClick="dashbordcontrol('delivered_order');">Delivered orders</button>
    </div>

</div>
<div class="row">
	<!-- Area CHART -->
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title">Purchases Area Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="areaChart1" style="height:250px"></canvas>
              </div>
            </div>
           
          </div>
	</div>

         
</div>
</div>
<script src="../../js/Chart.min.js"></script>
<script>
  $(function () {
      //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas1 = $("#areaChart1").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas1);

    var areaChartData1 = {
      labels: ["January","February","March", "April", "May","June","July","Auguest", "September", "October", "November", "December"],
      datasets: [
        {
          label: "Number of orders",
          fillColor: "green",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: <?php require_once('../../charts/purchasesareachart.php');  
			?>
        }
      ]
    };

    var areaChartOptions1 = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData1, areaChartOptions1);


	 
  });
</script>
