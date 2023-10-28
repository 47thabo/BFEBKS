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
                        <b>List of Orders</b>
                        <!--span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right"
                                href="javascript:void(0)" id="new_tenant">
                                <i class="fa fa-plus"></i> New Order
                            </a></!--span-->
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Order No</th>
                                    <th class="">Name & Phone#</th>
                                    <th class="">Address</th>
                                    <th class="">Items</th>
                                    <th class="">Balance</th>
                                    <th>Dates</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $order = $conn->query("SELECT * FROM orders");
                                while ($row = $order->fetch_assoc()):
                                    $customer = $conn->query("SELECT * FROM customers WHERE customer_id = " . $row['customer_id']);
                                    $customer_row = $customer->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $row['order_id'] ?>
                                        </td>
                                        <td>
                                            <?php echo $customer_row['fname'] . " " . $customer_row['onames'] . " " . $customer_row['lname'] ?>
                                            <button class="btn btn-sm btn-primary view_payment" type="button"
                                                data-id="<?php echo $customer_row['customer_id'] ?>">View Customer</button>
                                            <br>
                                            <?php echo $customer_row['phone'] ?>
                                            <?php
                                            if (isset($customer_row['phone2']))
                                                echo " or " . $customer_row['phone2'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $customer_row['address'] ?>
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
                                <?php endwhile; ?>
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
    $(document).ready(function () {
        $('table').dataTable()
    })

    $('#new_tenant').click(function () {
        uni_modal("New Customer", "modals/add_customer.php", "mid-large")

    })

    $('.view_payment').click(function () {
        view_modal("View Customer", "modals/view_customer.php?id=" + $(this).attr('data-id'), "large")

    })
    $('.edit_customer').click(function () {
        uni_modal("Edit Customer Details", "modals/edit_customer.php?id=" + $(this).attr('data-id'), "mid-large")

    })
    $('.delete_tenant').click(function () {
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
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 1500)

                }
            }
        })
    }
</script>