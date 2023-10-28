<?php
include '../php/db_connect.php';
/*if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM customers where customer_id= ".$_GET['id']);
$row = $qry->fetch_assoc();
}*/
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM customers where customer_id= " . $_GET['id']);
	//$row = $qry->fetch_assoc();
//$qry = $conn->query("SELECT * FROM customers where id=101");
//echo $_GET['id'];
	foreach ($qry->fetch_array() as $k => $val) {
		$$k = $val;
	}
}
?>

<style>
	#details p {
		margin: unset;
		padding: unset;
		line-height: 1.3rem;
	}

	.order {
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
					<large><b>Details</b></large> <span><a class="btn btn-primary btn-sm " data-dismiss="modal"
							data-id="<?php echo $customer_id ?>" href="javascript:void(0)" id="edit_customer">
							Edit Details
						</a></span>
					<hr>
					<p>Names: <b>
							<?php echo ucwords($fname) . " " . ucwords($onames) . " " . ucwords($lname) ?>
						</b></p>
					<p>Address: <b>
							<?php echo isset($address) ? $address : 'not available' ?>
						</b></p>
					<p>Phone numbers: <b>
							<?php echo isset($phone) ? $phone : 'not available' ?>
						</b></p>
					<p>2nd Phone numbers: <b>
							<?php echo isset($phone2) ? $phone2 : 'not available' ?>
						</b></p>
				</div>
			</div>
			<div class="col-md-8">

				<large><b>Orders</b></large>
				<span class="float-center"><a class="btn btn-primary float-center btn-sm " href="javascript:void(0)"
						id="edit_tenant">
						<i class="fa fa-plus"></i> Create New Order
					</a></span>
				<hr>
				<table class="table table-condensed  table-hover table-bordered">
					<thead>
						<tr>
							<th>Order No</th>
							<th>Items</th>
							<th>Balance</th>
							<th>Dates</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$order = $conn->query("SELECT * FROM orders WHERE customer_id = ".$customer_id);
						while ($row = $order->fetch_assoc()): ?>
							<tr>
								<td>
									<?php echo $row['order_id']; ?>
								</td>
								<td>
									<?php
									$items = $conn->query("SELECT * FROM order_items, products WHERE order_items.product_id = products.product_id AND order_items.order_id = " . $row['order_id']);
									while ($item_row = $items->fetch_assoc()):
										echo "*" . $item_row['name'] . " " . $item_row['description'] . " (" . $item_row['colour'] . ") <br>";
									endwhile ?>
								</td>
								<td class="text-right">
									<?php
									$sum = $conn->query("SELECT sum(price) AS 'sum' FROM order_items WHERE order_id = " . $row['order_id']);
									$items_sum = $sum->fetch_assoc();
									?>
									<button class="btn btn-sm btn-warning view_payment" type="button"
										data-id="<?php echo $row['customer_id'] ?>">Add
										Payment</button>
									<?php echo "R" . $items_sum['sum'] - $row['amount_paid']; ?>
								</td>
								<td>
									<?php
									echo "Order: " . date("d/M/Y", strtotime($row['order_date']));
									if (isset($row['delivery_date']))
										echo '<br>Delivery: ' . date("d/M/Y", strtotime($row['delivery_date']));
									?>
								</td>
								<td class="text-center">
									<button class="btn btn-sm btn-primary view_payment" type="button"
										data-id="<?php echo $row['customer_id'] ?>">Open</button>
									<!--button class="btn btn-sm btn-outline-primary edit_customer" type="button"
												data-id="<?php echo $row['customer_id'] ?>">Print</!--button-->
								</td>
							</tr>
						<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$('#edit_customer').click(function () {
		uni_modal("Edit Customer Details", "modals/edit_customer.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('#manage-tenant').submit(function (e) {
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_customer',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function (resp) {
				if (resp == 1) {
					alert_toast("Customer successfully saved.", 'success')
					setTimeout(function () {
						location.reload()
					}, 1000)
				}
			}
		})
	})
</script>