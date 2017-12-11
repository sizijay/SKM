
<script type="text/javascript" src="chiefmgr.js"></script>

<script type="text/javascript" >
	function openTab(url){
		window.open(url, '_blank');
	}
	
	function openTabMonth(url, ele){ //url and element id
		var datm=document.getElementById(ele).value;
		var datmsplit=datm.split('-');
		var phpM = datmsplit[1]; // month
		var phpY = datmsplit[0]; // year
		
		url=url+"?yr="+phpY+"&mnth="+phpM;
		//alert(url);
		
		window.open(url, '_blank');
	}
	
	function viewMonthReport(url, ele){ //url and element id
		var datm=document.getElementById(ele).value;
		var datmsplit=datm.split('-');
		var phpM = datmsplit[1]; // month
		var phpY = datmsplit[0]; // year
		
		url=url+"?yr="+phpY+"&mnth="+phpM;
		//alert(url);
		document.getElementsByName('frm2')[0].src = url;
		//return url;
		//window.open(url, '_blank');
	}
</script>

<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-edit"></i></span>

            <div class="info-box-content">
            
              <span class="info-box-text">General reports</span>
            </div>
            <!-- /.info-box-content -->
          </div>
			<a href="report2.php" target="frm2"><button class="form-control dashbordbtn" >Current stock</button></a>
			
			<a href="report5.php" target="frm2" name="findorder"><button class="form-control dashbordbtn" >Low stock</button></a>
			
			
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-table"></i></span>

            <div class="info-box-content">
        
              <span class="info-box-text">Monthly reports</span>
            </div>
            <!-- /.info-box-content -->
			
          </div>
		  
		  Month: <input type="month" id="monthg" onchange="checkCur(this.id)" />
		  
		  <a href="#"><button onclick="viewMonthReport('report4.php','monthg')" id="repbtn1" class="form-control dashbordbtn" ></i>Monthly sales</button></a>
		  
		  <a href="#"><button onclick="viewMonthReport('report3.php','monthg')" id="repbtn2" class="form-control dashbordbtn" >Monthly quantity</button></a>
		  
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
</div>
	  
	  
	  <iframe name="frm2"  width=600 height=400 style="" >
	  </iframe>