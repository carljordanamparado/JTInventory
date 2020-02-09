<div class="row" id="template">
    <div class="form-group col-md-4">
        <label for="Products"> Products </label>
        <select name="productCode" id="prodCode" class="form-control">
            <option value="" selected> Choose Option</option>
            @foreach($product as $product)
                <option value="{{ $product -> PROD_CODE }}"> {{ $product -> PRODUCT  }}</option>
            @endforeach
        </select>
        <input type="hidden" id="prodName" value="">

    </div>
    <div class="form-group col-md-4">
        <label for="Products"> Product Size </label>
        <select name="prodSize" id="prodSize" class="form-control">
            <option value="" selected> Choose Option</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="Products"> Product Price </label>
        <input type="text" id="prodPrice" name="prodPrice" class="form-control">
    </div>
    <div class="form-group col-md-1">
        <button type="button" class="btn btn-danger form-control" data-role="remove">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
        <button type="button" class="btn btn-primary form-control" data-role="add">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </div>
</div>col-md-2