
<?php
/**
 * Created by PhpStorm.
 * User: Isuru Jayasinghe
 * Date: 12/8/2017
 * Time: 10:02 AM
 */
require_once('../../php/dbcon.php');
$pr_no=$_POST['pr_no'];
$pr_item_tbl_quary="SELECT tire_t_id,qty,supplierble_qty,supplierble_unitprice FROM pr_item WHERE purchase_requisition_pr_no=$pr_no";
$pr_item_result=mysqli_query($conn,$pr_item_tbl_quary);
while($pr_item_row=mysqli_fetch_row($pr_item_result)){
    echo("<tr><td>$pr_item_row[0]</td><td>$pr_item_row[1]</td><td>$pr_item_row[2]</td><td>$pr_item_row[3]</td><td><button class=\"btn btn-success confirmbtn\">Confirm</button><button class=\"btn btn-danger confirmbtn\">Delete</button></td></tr>");

}
?>
