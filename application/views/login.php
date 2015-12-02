<div class="panel panel-info loginbox center-block">
    <div class="panel-heading">Login</div>
    <div class="panel-body">
        <form class="form-horizontal" name="frm" id="frm" method="post">
            <div class="form-group">
                <label for="email" class="control-label col-lg-4">Email</label>
                <div class="col-lg-8">
                    <input type="email" id="email" name="email" class="form-control email required" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="pwd" class="control-label col-lg-4">Password</label>
                <div class="col-lg-8">
                    <input type="password" id="pwd" name="pwd" class="form-control required" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#frm").validate();
    });
</script>