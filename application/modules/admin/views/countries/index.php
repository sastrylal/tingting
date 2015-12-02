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
            <!--a href="/admin/countries/add/" class="btn btn-sm btn-info">Add Country</a-->
        </div>       
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Country Code</th>
                    <th>Country Name</th>
                    <th style="width: 80px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($countries)) { ?>
                    <?php foreach ($countries as $country) { ?>
                        <tr>
                            <td><?php echo $country['country_id']; ?></td>
                            <td><?php echo $country['country_code']; ?></td>
                            <td><?php echo $country['country_name']; ?></td>
                            <td>
                                <!--a href="/admin/countries/edit/?country_id=<?php echo $country['country_id']; ?>" title='Edit'><i class="glyphicon glyphicon-edit"></i></a-->
                                <a href="/admin/countries/?act=status&country_id=<?php echo $country['country_id']; ?>&sta=<?php echo ($country['is_active'] == "1") ? "0" : "1"; ?>" title='<?php echo ($country['is_active'] == "1") ? "Active" : "Inactive"; ?>'><i class="glyphicon glyphicon-star <?php echo ($country['is_active'] == "1") ? "" : "grey"; ?>"></i></a>
                                <!--a href="/admin/countries/?act=del&country_id=<?php echo $country['country_id']; ?>" title='Delete' onclick="return window.confirm('Do You Want to Delete?');" ><i class="glyphicon glyphicon-trash"></i></a-->
                            </td>
                        </tr>
                    <?php } ?> 
                <?php } else { ?>
                    <tr>
                        <td colspan="3">No Members found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php echo!empty($PAGING) ? $PAGING : ""; ?>
</div>







