<section class="container">
    <article class="form-box">
        <ol class="breadcrumb">
            <li><a href="/admin/">Home</a></li>
            <li class="active">My Profile</li>
        </ol>
        <div class="clearfix"></div>
        <div><?php getMessage(); ?></div>
        <div class="clearfix"></div>
        <form id="frm" class="form-horizontal" role="form" method="post">
            <input type="hidden" name="frm_profile" id="frm_profile" value="true"/>
            <input type="hidden" name="admin_id" id="admin_id"
                   value="<?php echo!empty($admin['admin_id']) ? $admin['admin_id'] : ""; ?>"/>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="<?php echo!empty($admin['name']) ? $admin['name'] : ""; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control required" id="last_name" name="email" placeholder="Email" value="<?php echo!empty($admin['email']) ? $admin['email'] : ""; ?>"/>
                </div>
            </div>            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default"><?php echo!empty($admin['admin_id']) ? "Update" : "Submit"; ?></button>
                </div>
            </div>
        </form>
    </article>
    <article class="form-box">
        <ol class="breadcrumb">
            <li><a href="/admin/">Home</a></li>
            <li class="active">Change Password</li>
        </ol>
        <form id="pwdfrm" class="form-horizontal" role="form" method="post">
            <input type="hidden" name="frm_pwd" id="frm_pwd" value="true"/>
            <input type="hidden" name="admin_id" id="admin_id"
                   value="<?php echo!empty($admin['admin_id']) ? $admin['admin_id'] : ""; ?>"/>
            <div class="form-group">
                <label for="pwd" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control required" id="pwd" name="pwd" value=""/>
                </div>
            </div>
            <div class="form-group">
                <label for="cnfpwd" class="col-sm-2 control-label">Re-Password</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control required" id="cnfpwd" name="cnfpwd" value=""/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default"><?php echo!empty($admin['admin_id']) ? "Update" : "Submit"; ?></button>
                </div>
            </div>
        </form>
        <div class="clear"></div>
    </article>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $("#frm").validate({
            rules: {
                name: {required: true},
                email: {required: true, email: true}
            },
            messages: {
                name: {required: "Please Enter your Name"},
                email: {required: "Please Enter your Email"}
            }
        });
        $("#pwdfrm").validate({
            rules: {
                pwd: {required: true},
                cnfpwd: {required: true, equalTo: "#pwd"}
            },
            messages: {
                pwd: {required: "Please Enter Password"},
                cnfpwd: {required: "Please Enter Re-Password"}
            }
        });
    });
</script>
