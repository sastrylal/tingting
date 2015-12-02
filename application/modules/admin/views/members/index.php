<div class="container">
    <div class="box box-default">        
        <div class="box-header with-border">
            <h3 class="box-title">Members</h3>
            <!--div class="box-tools-group col-sm-4">
                <form class="navbar-form navbar-left" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right input-sm" placeholder="Key" name="key" value="<?php echo!empty($_GET['key']) ? $_GET['key'] : ""; ?>" />
                        <div class="input-group-btn"> <button type="submit" class="btn btn-sm btn-primary">Search</button></div>
                    </div>
                </form>            
            </div-->
            <!--a href="/admin/members/add/" class="btn btn-sm btn-info">Add Country</a-->
        </div>  
        <div class="panel panel-default">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Token</th>
                        <th>Mobile</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($members)) { ?>
                        <?php foreach ($members as $member) { ?>
                            <tr>
                                <td><?php echo $member['member_id']; ?></td>
                                <td><?php echo $member['name']; ?></td>
                                <td><?php echo $member['email']; ?></td>
                                <td><?php echo $member['auth_token']; ?></td>
                                <td><?php echo $member['mobile']; ?></td>
                                <td> 
                                    <a href="/admin/members/?act=status&member_id=<?php echo $member['member_id']; ?>&sta=<?php echo ($member['is_active'] == "1") ? "0" : "1"; ?>" title='<?php echo ($member['is_active'] == "1") ? "Active" : "Inactive"; ?>'><i class="glyphicon glyphicon-star <?php echo ($member['is_active'] == "1") ? "" : "grey"; ?>"></i></a> 
                                    <a href="/admin/members/?act=del&member_id=<?php echo $member['member_id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a> 
                                </td>
                            </tr>
                        <?php } ?> 
                    <?php } else { ?>
                        <tr>
                            <td colspan="5">No Members found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo!empty($PAGING) ? $PAGING : ""; ?>
</div>