<?php include('php/db_connect.php'); ?>

<div class="container-fluid">

    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Customers</b>
                        <span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenant">
                                <i class="fa fa-plus"></i> New Customer
                            </a></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Name</th>
                                    <th class="">Address</th>
                                    <th class="">Phone Numbers</th>
                                    <th class="">Pending Orders</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $house = $conn->query("SELECT * FROM customers");
                                while($row= $house->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $row['customer_id']?></td>
                                        <td><?php echo ucwords($row['fname']). " ".ucwords($row['onames'])." ".ucwords($row['lname'])  ?></td>
                                        <td><?php echo $row['address'] ?></td>
                                        <td><?php echo $row['phone'] ?> 
                                        <?php 
                                            if(isset($row['phone2'])) 
                                                echo " or ".$row['phone2']; 
                                        ?>
                                        </td>
                                        <td class="text-right">0</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['customer_id'] ?>">View</button>
                                            <button class="btn btn-sm btn-outline-primary edit_customer" type="button" data-id="<?php echo $row['customer_id'] ?>">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="2">Delete</button>
                                        </td>
                                    </tr>
                                    

                                <?php endwhile; ?>

                                <!--tr role="row" class="odd">
                                    <td class="text-center sorting_1">1</td>
                                    <td>
                                        Smith, John C </td>
                                    <td class="">
                                        <p> <b>623</b></p>
                                    </td>
                                    <td class="">
                                        <p> <b>074 510 9986</b></p>
                                    </td>
                                    <td class="text-right">
                                        <p> <b>0</b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="2">View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_tenant" type="button" data-id="2">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="2">Delete</button>
                                    </td>
                                </!--tr>

                                <tr role="row" class="odd">
                                    <td class="text-center sorting_1">1</td>
                                    <td>
                                        Smith, John C </td>
                                    <td class="">
                                        <p> <b>623</b></p>
                                    </td>
                                    <td class="">
                                        <p> <b>074 510 9986</b></p>
                                    </td>
                                    <td class="text-right">
                                        <p> <b>0</b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="2">View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_tenant" type="button" data-id="2">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="2">Delete</button>
                                    </td>
                                </tr>

                                <tr-- role="row" class="odd">
                                    <td class="text-center sorting_1">1</td>
                                    <td>
                                        Smith, John C </td>
                                    <td class="">
                                        <p> <b>623</b></p>
                                    </td>
                                    <td class="">
                                        <p> <b>074 510 9986</b></p>
                                    </td>
                                    <td class="text-right">
                                        <p> <b>0</b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_customer" type="button" data-id="2">View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_customer" type="button" data-id="2">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="2">Delete</button>
                                    </td>
                                </tr-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>

</div>
<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset
    }

    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>
<script>
    $(document).ready(function() {
        $('table').dataTable()
    })

    $('#new_tenant').click(function() {
        uni_modal("New Customer", "modals/add_customer.php", "mid-large")

    })

    $('.view_payment').click(function() {
        view_modal("View Customer", "modals/view_customer.php?id=" + $(this).attr('data-id'), "large")

    })
    $('.edit_customer').click(function() {
        uni_modal("Edit Customer Details", "modals/edit_customer.php?id=" + $(this).attr('data-id'), "mid-large")

    })
    $('.delete_tenant').click(function() {
        _conf("Are you sure to delete this Tenant?", "delete_tenant", [$(this).attr('data-id')])
    })

    function delete_tenant($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_tenant',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)

                }
            }
        })
    }
</script>