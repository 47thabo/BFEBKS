<?php
include '../php/db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM customers WHERE customer_id = " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="save-order">
        <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
                <tr>
                    <td>
                        <select class="form-select" name="product[]" id="inputGroupSelect01 inputGroup-sizing-sm">
                            <option selected>Choose product...</option>
                            <?php
                            $sql = "SELECT name, product_id FROM products";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $p_name = $row['name'];
                                $p_id = $row['product_id'];
                                echo '<option value="' . $p_id . '">' . $p_name . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                        <input type="text" name="desc[]" class="form-control"
                            aria-label="Text input with dropdown button" placeholder="Description...">
                    </td>
                    <td>
                        <input type="text" name="colour[]" class="form-control"
                            aria-label="Text input with dropdown button" placeholder="Colour...">
                    </td>
                    <td>
                        <div class="input-group mb3">
                            <span class="input-group-text">Price: R</span>
                            <input type="number" name="price[]" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)">
                        </div>
                    </td>
                    <td>
                        <button type="button" name="add" id="add" class="btn btn-success">Add Another
                            Product</button>
                    </td>
                </tr>
            </table>

        </div>
        <div class="form-group">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Delivery Date</span>
                <input type="date" id="ddate" name="ddate" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Deposit/Cash amount: R</span>
                <input type="number" name="amt_paid" class="form-control"
                    aria-label="Dollar amount (with dot and two decimal places)">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" name="comments" id="inputGroup-sizing-sm">Comments</span>
                <input type="text" id="comments" name="comments" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-sm">
            </div>
        </div>
    </form>
</div>

<script>
    $('#save-order').submit(function (e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'php/ajax.php?action=save_order',
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

<script>
    $(document).ready(function () {
        var i = 1;
        p_names = ["p1", "p2", "p3", "p4"];
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><select class="form-select" name="product[] onclick="populate(this.id)" id="inputGroupSelec01 inputGroup-sizing-sm"><option selected>Choose product...</option><option value="1">Chest of drawer</option><option value="20">Wardrobe</option></select></td><td><input type="text" name="colour[]" class="form-control" aria-label="Text input with dropdown button" placeholder="Colour..."><td><input type="text" name="desc[]" class="form-control" aria-label="Text input with dropdown button" placeholder="Description..."></td></td><td><div class="input-group mb3"><span class="input-group-text">Price: R</span><input type="number" name="price[]" class="form-control" aria-label="Dollar amount (with dot and two decimal places)"></div></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');

            //populate(document.getElementById(inputGroupSelec01));
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
</script>