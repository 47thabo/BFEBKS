<?php 
include '../php/db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM customers where customer_id= ".$_GET['id']);
$row = $qry->fetch_assoc();
}
?>

<style>
    #details p{
        margin: unset;
        padding: unset;
        line-height: 1.3rem;
    }   
    .order{
        display: flex;
    }
    /*td, th {
        padding: 3px !important;
    }*/
</style>

<div class="container-fluid">
<div class="col-lg-12">
		<div class="row">
			<div class="col-md-4">
				<div id="details">
					<large><b>Details</b></large> <span><a class="btn btn-primary btn-sm " data-dismiss="modal" data-id="<?php echo $row['customer_id'] ?>" href="javascript:void(0)" id="edit_customer">
                                 Edit Details
                            </a></span>
					<hr>
					<p>Names: <b><?php echo $row['fname']." ".$row['onames']." ".$row['lname'] ?></b></p>
					<p>Address: <b><?php echo $row['address'] ?></b></p>
					<p>Phone numbers: <b><?php echo $row['phone'] ?></b></p>
					<p>2nd Phone numbers: <b>n/a</b></p>
				</div>
			</div>
			<div class="col-md-8">

				<large><b>Orders</b></large>
                <span class="float-center"><a class="btn btn-primary float-center btn-sm " href="javascript:void(0)" id="edit_tenant">
                <i class="fa fa-plus"></i> Create New Order
                            </a></span>
					<hr>
				<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
											<tr>
						<td>Oct 26, 2020</td>
						<td>123456</td>
						<td class="text-right">2,500.00</td>
					</tr>
										<tr>
						<td>Oct 26, 2020</td>
						<td>136654</td>
						<td class="text-right">7,500.00</td>
					</tr>
															</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$('#edit_customer').click(function() {
        uni_modal("Edit Customer Details", "modals/edit_customer.php?id=" + $(this).attr('data-id'), "mid-large")

    })
	$('#manage-tenant').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_customer',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Customer successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}
			}
		})
	})
</script>