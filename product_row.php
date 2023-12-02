<tr id="row' + i + '">
    <td><select class="form-select" name="product[]
            id="inputGroupSelec01 inputGroup-sizing-sm">
            <option selected>Choose product...</option>
        </select></td>
    <td><input type="text" name="colour[]" class="form-control" aria-label="Text input with dropdown button"
            placeholder="Colour...">
    <td><input type="text" name="desc[]" class="form-control" aria-label="Text input with dropdown button"
            placeholder="Description..."></td>
    </td>
    <td>
        <div class="input-group mb3"><span class="input-group-text">Price: R</span><input type="number" name="price[]"
                class="form-control" aria-label="Dollar amount (with dot and two decimal places)"></div>
    </td>
    <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td>
</tr>