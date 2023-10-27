<?php 
include '../php/db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM tenants where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="save-customer">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">First Name (only)</label>
				<input type="text" class="form-control" name="fname"  value="<?php echo isset($firstname) ? $firstname :'' ?>" required>
			</div>
            <div class="col-md-4">
				<label for="" class="control-label">Surname</label>
				<input type="text" class="form-control" name="lname"  value="<?php echo isset($lastname) ? $lastname :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Other Names (optional)</label>
				<input type="text" class="form-control" name="onames"  value="<?php echo isset($middlename) ? $middlename :'' ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-8">
				<label for="" class="control-label">Address</label>
				<input type="text" class="form-control" name="address"  value="<?php echo isset($email) ? $email :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Phone number</label>
				<input type="text" class="form-control" name="phone"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
			</div>
			
		</div>
	</form>
</div>
<script>
	
	$('#save-customer').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'php/ajax.php?action=save_customer',
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