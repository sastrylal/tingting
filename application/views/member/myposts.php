<div class="container">
    <div class="box box-default">        
        <div class="box-header with-border">
            <h3 class="box-title">My Posts</h3>
            <!--div class="box-tools-group col-sm-4">
                <form class="navbar-form navbar-left" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right input-sm" placeholder="Key" name="key" value="<?php echo!empty($_GET['key']) ? $_GET['key'] : ""; ?>" />
                        <div class="input-group-btn"> <button type="submit" class="btn btn-sm btn-primary">Search</button></div>
                    </div>
                </form>            
            </div-->
        </div>  
        <div class="panel panel-default">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Content</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Posted By</th>
                        <th>Expiry</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($posts)) { ?>
                        <?php foreach ($posts as $post) { ?>
                            <tr>
                                <td><?php echo $post['post_id']; ?></td>                                
                                <td><?php echo $post['content']; ?></td>
                                <td><?php echo $post['latitude']; ?></td>
                                <td><?php echo $post['longitude']; ?></td>
                                <td><?php echo $post['posted_by']; ?></td>
                                <td><?php echo dateTimeDB2SHOW($post['expiry_date']); ?></td>
                                <td>
                                    <a href="/member/myposts/?act=del&post_id=<?php echo $post['post_id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a> 
                                </td>
                            </tr>
                        <?php } ?> 
                    <?php } else { ?>
                        <tr>
                            <td colspan="7">No Posts found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo!empty($PAGING) ? $PAGING : ""; ?>
</div>