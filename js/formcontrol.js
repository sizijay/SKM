//bootstrap tool tip
$('[data-toggle="tooltip"]').tooltip();   
var editingrow;
var tiresintable=[];
function validate(){
		x=document.getElementById('brand').value;
		y=document.getElementById('country').value;
		z=document.getElementById('tiresize').value;
		q=document.getElementById('quantity').value;
		if(x=="" || y=="" || z=="" || q=="")
			{
				$('#missingfieldmodal').modal('show');
				 
			}
		else{
			$.ajax({
				type:"post",
				url:"assets/checkavailability.php",
				data:({brand:x,country:y,tiresize:z}),
				success:function(qty){	
				intq=parseInt(q);
				qty=parseInt(qty);
					if(intq>qty){
						document.getElementById('max').innerHTML="Maximum Quantity is "+qty+" units";
						$("#outofstock").modal('show');
					}
					else{
						$.ajax({
							type:"post",
							url:"assets/loadinvoiceitem.php",
							data:({brand:x,country:y,tiresize:z}),
							success:function(data){
							var data = $.parseJSON(data);
							
							if(tiresintable.includes(data['tid'])){
								$('#allreadyin').modal('show');
							}
							else{	
								$('#orderitems').append("<tr class=\"removable\" id=\""+data['tid']+"\"><td>" + x+ "</td><td>" + y + "</td><td>" + z + "</td><td>" + data['up'] + "</td><td name=\""+qty+"\">" + q + "</td><td>" + data['up']*q + "</td><td>Available</td><td onclick=\"removeroderitem(this)\" ><a href=\"#\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove this item\"><i class=\"fa fa-trash \" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td><td onclick=\"showmodal(this);\"><a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit quantity\"><i class=\"fa fa-pencil-square\" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td></tr>");
								validate.sum+=data['up']*q;
								updatedata();
								document.getElementById('brand').selectedIndex=0;
								document.getElementById('country').selectedIndex=0;
								document.getElementById('tiresize').selectedIndex=0;
								document.getElementById('quantity').value="";
								tiresintable.push(data['tid']);	
								}
												}	
							});
						}
					}
			});
			
			
		}
	}
function removeroderitem(element){
	
	validate.sum=validate.sum-parseInt(element.parentElement.getElementsByTagName('td')[5].innerHTML);
	var index = tiresintable.indexOf(element.parentElement.getAttribute('id'));
	if (index > -1) {
    	tiresintable.splice(index, 1);
	}
	element.parentElement.remove();
	updatedata();
}
function showmodal(element){
	$('#newquantity').val("");
	editingrow=element;
	$('#updatequantitymodal').modal('show');
}
function updatequan(){
	//$('#newquantity').val();
	editingrow.parentElement.getElementsByTagName('td')[4].innerHTML=$('#newquantity').val();
	validate.sum=validate.sum-parseInt(editingrow.parentElement.getElementsByTagName('td')[5].innerHTML);
	editingrow.parentElement.getElementsByTagName('td')[5].innerHTML=parseInt($('#newquantity').val())*
	parseInt(editingrow.parentElement.getElementsByTagName('td')[3].innerHTML);	
	validate.sum=validate.sum+parseInt(editingrow.parentElement.getElementsByTagName('td')[5].innerHTML);
	if($('#newquantity').val()>parseInt(editingrow.parentElement.getElementsByTagName('td')[4].getAttribute('name'))){
		editingrow.parentElement.classList.add('bg-danger');
		editingrow.parentElement.getElementsByTagName('td')[6].innerHTML="Unavailable";
	}
	else{
		editingrow.parentElement.classList.remove('bg-danger');
		editingrow.parentElement.getElementsByTagName('td')[6].innerHTML="Available";
	}
	updatedata();
}
function prceedanyway(){
		x=document.getElementById('brand').value;
		y=document.getElementById('country').value;
		z=document.getElementById('tiresize').value;
		q=document.getElementById('quantity').value;
	
		$.ajax({
							type:"post",
							url:"assets/loadinvoiceitem.php",
							data:({brand:x,country:y,tiresize:z}),
							success:function(data){
							var data = $.parseJSON(data);
							if(tiresintable.includes(data['tid'])){
								$('#allreadyin').modal('show');
							}
							else{	
				 			$('#orderitems').append("<tr class=\"removable bg-danger\" id=\""+data['tid']+"\"><td>" + x+ "</td><td>" + y + "</td><td>" + z + "</td><td>" + data['tid'] + "</td><td>" + q + "</td><td>" + data['tid']*q + "</td><td>Unavailable</td><td onclick=\"removeroderitem(this)\"><a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove this item\"><i class=\"fa fa-trash \" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td><td onclick=\"showmodal(this);\"><a href=\"#\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit quantity\"><i class=\"fa fa-pencil-square\" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td></tr>");
							validate.sum+=data['tid']*q;
							updatedata();
							document.getElementById('brand').selectedIndex=0;
							document.getElementById('country').selectedIndex=0;
							document.getElementById('tiresize').selectedIndex=0;
							document.getElementById('quantity').value="";
							tiresintable.push(data['tid']);		
								}
												}	
							});
}

validate.sum=0;

function updatedata(){
				$("#subtotal").html(validate.sum);
				/*var discount=validate.sum*document.getElementById('discount').value;	
				$("#dis").html(discount);
				var netamount=validate.sum-discount;
				$("#net").html(netamount);	*/
	}
	
function removeall(){

		validate.sum=0;
		$(".table-bordered  .removable").remove();
		updatedata();
	}

/*function removeselected(){
	var rows = document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
	for(var i=0;i<rows;i++){
		var targetelement=document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[i].getElementsByTagName('td')[0].firstChild;
		var checkstatus=targetelement.checked;
		var remtot=targetelement.parentElement.parentElement.getElementsByTagName('td')[4].innerHTML;
		validate.sum=validate.sum-remtot;
		if(checkstatus){
			document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[i].remove();
		}
		updatedata();
	}
}*/
function placeorder(){
	//$('#maininvoiceform').on('submit',function(){
	
		var tot=document.getElementById('subtotal').textContent;
		var shopname=document.getElementById('shopname').value;
		var sordno=$("#sordnodisplay").val();
		var guestname=$('#guestname').val();
		var rows = document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
		if(shopname==""){
			$('#missingfieldmodal').modal('show');
		}
		else if(shopname=="guest" && guestname==""){
			$('#missingfieldmodal').modal('show');
		}
		else if(rows==0){
			
			$('#modal-noowner').modal('show');
		}
		else{
	  $.ajax({
		  type:"post",
		  url:"controler/cusordercontroler.php",
		  data:({total:tot,shopname:shopname,comname:shopname,sordno:sordno,guestname:guestname}),
		  success:function(data){
			
		
		  }
	  });
			var rowarray=document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
			for(var i=0;i<rows;i++){
				brand=rowarray[i].getElementsByTagName('td')[0].innerHTML;
				country=rowarray[i].getElementsByTagName('td')[1].innerHTML;
				tiresize=rowarray[i].getElementsByTagName('td')[2].innerHTML;
				qty=rowarray[i].getElementsByTagName('td')[4].innerHTML;
				status=rowarray[i].getElementsByTagName('td')[6].innerHTML;
			$.ajax({
				  type:"post",
				  url:"controler/cusorderitemcontroler.php",
				  data:({brand:brand,country:country,tiresize:tiresize,qty:qty,status:status,sordno:sordno}),
				  success:function(data){
					   document.getElementById('message1').innerHTML="Your order successfully placed"
					   $('#modal-success').modal('show');
					   $(".table-bordered  .removable").remove();
					   document.getElementById("shopname").selectedIndex =0;
					   validate.sum=0;
					   $("#sordnodisplay").val(parseInt($("#sordnodisplay").val())+1);
					   updatedata();
			 
		  							}
	  });
				
			}
		}
	}//);
	
$('#discount').on('change',function(){
		updatedata();
	});	


$('#companyname').on('change',function(){
if($('#companyname').value!=""){
	document.getElementById("shopname").selectedIndex = "0";	
}	
		});

function showsize(){//auto loading tire sizes
	$('#tiresize').children('option:not(:first)').remove();
	var b=document.getElementById('brand').value;
	var c=document.getElementById('country').value;
	$.ajax({
				type:"post",
				url:"assets/loadsize.php",
				data:({brand:b,country:c}),
				success:function(data){	
					var result=data.split(" ");
					for(i in result){	
					$('#tiresize').append("<option value=\""+result[i]+"\">"+result[i]+"</option>");
					}
				}
					
			});
}
$('#brand').on('change',showsize);
$('#country').on('change',showsize);

function customerplaceorder(){
	
		var tot=document.getElementById('subtotal').textContent;
	    var sordno=('#sordno').val();
		var rows = document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
		if(rows==0){
			
			$('#modal-noowner').modal('show');
		}
		else{
	  $.ajax({
		  type:"post",
		  url:"controler/cusorderbycuscontroler.php",
		  data:({total:tot,sordno:sordno}),
		  success:function(data){
			 
			 
		  }
	  });
			var rowarray=document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
			for(var i=0;i<rows;i++){
				brand=rowarray[i].getElementsByTagName('td')[1].innerHTML;
				country=rowarray[i].getElementsByTagName('td')[2].innerHTML;
				tiresize=rowarray[i].getElementsByTagName('td')[3].innerHTML;
				qty=rowarray[i].getElementsByTagName('td')[5].innerHTML;
				status=rowarray[i].getElementsByTagName('td')[7].innerHTML;
			$.ajax({
				  type:"post",
				  url:"controler/cusorderbycusitemcontroler.php",
				  data:({sordno:sordno,brand:brand,country:country,tiresize:tiresize,qty:qty,status:status}),
				  success:function(data){
					 
					  alert(data);
			 
		  							}
	  });
				
			}
			 			$('#modal-success').modal('show');
					   $(".table-bordered  .removable").remove();
					   document.getElementById("shopname").selectedIndex = "0";
					   document.getElementById("companyname").selectedIndex = "0";
					   document.getElementById('brand').selectedIndex=0;
					   document.getElementById('country').selectedIndex=0;
					   document.getElementById('tiresize').selectedIndex=0;
					   document.getElementById('quantity').value="";
					   validate.sum=0;
					   updatedata();
		}
	
}

function validatequotation(){
		x=document.getElementById('brand').value;
		y=document.getElementById('country').value;
		z=document.getElementById('tiresize').value;
		q=document.getElementById('quantity').value;
		if(x=="" ||y==""||z==""||q=="")
			{
				$('#missingfieldmodal').modal('show');
				 
			}
		else{
			$('#orderitems').append("<tr class=\"removable\"><td><input type=checkbox></td><td>" + x+ "</td><td>" + y + "</td><td>" + z + "</td><td>" + q + "</td><td onclick=\"removeroderitem(this)\" ><a href=\"#\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove this item\"><i class=\"fa fa-trash \" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td><td onclick=\"showmodal(this);\"><a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit quantity\"><i class=\"fa fa-pencil-square\" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a></td></tr>");

		}
	}

function sendRequesition(){//this handls the new quotation request data insertion
		var note = document.getElementById('qnote').value;
		
		var rows = document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
		if(rows==0){
			
			$('#modal-noowner').modal('show');
		}
		else{
	  $.ajax({
		  type:"post",
		  url:"controler/quotationheadercontroler.php",
		  data:({note:note}),
		  success:function(data1){
			var rowarray=document.getElementById('orderitems').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
			for(var i=0;i<rows;i++){
				
				brand=rowarray[0].getElementsByTagName('td')[1].innerHTML;
				country=rowarray[0].getElementsByTagName('td')[2].innerHTML;
				tiresize=rowarray[0].getElementsByTagName('td')[3].innerHTML;
				qty=rowarray[0].getElementsByTagName('td')[4].innerHTML;
				rowarray[0].remove();
			$.ajax({
				  type:"post",
				  url:"controler/quotationdetailcontroler.php",
				  data:({brand:brand,country:country,tiresize:tiresize,qty:qty}),
				  success:function(data){
					  // alert(data);
			 
		  							}
	  			});
				
			}
			 
		  }
	  });
						document.getElementById('message1').innerHTML="Your Quotation request successfully sent. Our agent will reply you soon";
					   $('#modal-success').modal('show');
					   //$(".table-bordered  .removable").remove();
					   document.getElementById('brand').selectedIndex=0;
					   document.getElementById('country').selectedIndex=0;
					   document.getElementById('tiresize').selectedIndex=0;
					   document.getElementById('quantity').value="";
					   document.getElementById('qnote').value="";
		}
}

//filter orders by name and date range 
$('#searchord').click(function(){

	var dcname=document.getElementById('shopname').value;
	var tbody1=document.getElementById('foundorders').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
	var dateFrom = $('#fromdate').val();
	var dateTo = $('#todate').val();
	$('#foundorders tbody tr').show();
	
	if(dateFrom!=""){
		var d1 = dateFrom.split("/");
		
		var from = new Date(d1[2], parseInt(d1[0])-1, d1[1]);  // -1 because months are from 0 to 1
		
		for(var i=0;i<tbody1.length;i++){
		var dateCheck = tbody1[i].getElementsByTagName('td')[2].innerHTML;
	    dateCheck = dateCheck.trim();	
		var c = dateCheck.split("-");
		var check = new Date(c[0], parseInt(c[1])-1, c[2]);
		if(check >= from){
			continue;
		}
		tbody1[i].style.display = "none";
	}

	}
	if(dateTo!=""){
		var d2 = dateTo.split("/");
		
		var to = new Date(d2[2], parseInt(d2[0])-1, d2[1]);  // -1 because months are from 0 to 1
		
		for(var i=0;i<tbody1.length;i++){
		var dateCheck = tbody1[i].getElementsByTagName('td')[2].innerHTML;
		var c = dateCheck.split("-");
		var check = new Date(c[0], parseInt(c[1])-1, c[2]);

		if(check <= to){
			continue;
		}
		tbody1[i].style.display = "none";
	}

	}
	if(dcname!=""){
	for(var i=0;i<tbody1.length;i++){
		
		if(tbody1[i].getElementsByTagName('td')[1].innerHTML==dcname){
			continue;
		}
		tbody1[i].style.display = "none";
	}
	}
	
	
});

function togalbutton(){
	var dcname=document.getElementById('shopname').value;
	var tbody1=document.getElementById('foundorders').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
	var dateFrom = $('#fromdate').val();
	var dateTo = $('#todate').val();
	$('#foundorders tbody tr').show();
	
	if(dateFrom!=""){
		var d1 = dateFrom.split("/");
		
		var from = new Date(d1[2], parseInt(d1[0])-1, d1[1]);  // -1 because months are from 0 to 1
		
		for(var i=0;i<tbody1.length;i++){
		var dateCheck = tbody1[i].getElementsByTagName('td')[2].innerHTML;
	    dateCheck = dateCheck.trim();	
		var c = dateCheck.split("-");
		var check = new Date(c[0], parseInt(c[1])-1, c[2]);
		if(check >= from){
			continue;
		}
		tbody1[i].style.display = "none";
	}

	}
	if(dateTo!=""){
		var d2 = dateTo.split("/");
		
		var to = new Date(d2[2], parseInt(d2[0])-1, d2[1]);  // -1 because months are from 0 to 1
		
		for(var i=0;i<tbody1.length;i++){
		var dateCheck = tbody1[i].getElementsByTagName('td')[2].innerHTML;
		var c = dateCheck.split("-");
		var check = new Date(c[0], parseInt(c[1])-1, c[2]);

		if(check <= to){
			continue;
		}
		tbody1[i].style.display = "none";
	}

	}
	if(dcname!=""){
	for(var i=0;i<tbody1.length;i++){
		
		if(tbody1[i].getElementsByTagName('td')[1].innerHTML==dcname){
			continue;
		}
		tbody1[i].style.display = "none";
	}
	}
	
	
	if(!($('#completed'). prop("checked"))){
		
		for(var i=0;i<tbody1.length;i++){	
		
		if(tbody1[i].getElementsByTagName('td')[4].innerHTML=='incomplete'){
			continue;
		}
		tbody1[i].style.display = "none";
	}
	}
	if(!($('#pending'). prop("checked"))){
		for(var i=0;i<tbody1.length;i++){
		
		if(tbody1[i].getElementsByTagName('td')[4].innerHTML=='Completed'){
			continue;
		}
		tbody1[i].style.display = "none";
	}
	}
		
	}