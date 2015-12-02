<div class="container">
    <div class="page-header">
        <h1> <small><?php echo!empty($country['country_id']) ? "Edit" : "Add"; ?> Country</small> </h1>
    </div>
    <form id="frm" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="country_id" id="country_id" value="<?php echo!empty($country['country_id']) ? $country['country_id'] : ""; ?>" />
        <div class="form-group">
            <label for="category_code" class="col-sm-2 control-label">Country Code</label>
            <div class="col-sm-3">
                <input type="text" class="form-control required" id="category_code" name="category_code" placeholder="Country Code" value="<?php echo!empty($country['category_code']) ? $country['category_code'] : ""; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label for="category_name" class="col-sm-2 control-label">Country Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control required" id="category_name" name="category_name" placeholder="Country Name" value="<?php echo!empty($country['category_name']) ? $country['category_name'] : ""; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default"><?php echo!empty($country['country_id']) ? "Update" : "Submit"; ?></button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $().ready(function () {
        $("#frm").validate();
    });
</script>
<hr/>