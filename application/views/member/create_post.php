<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<div class="container">    
    <div class="panel panel-info loginbox center-block">
        <div class="panel-heading">New Post</div>
        <div class="panel-body">
            <form class="form-horizontal" id="frm" name="frm" method="post" onsubmit="return createPost();">
                <input type="hidden" name="auth_token" id="auth_token" value="<?php echo!empty($_SESSION['auth_token']) ? $_SESSION['auth_token'] : ""; ?>" />
                <div class="form-group">
                    <label for="latitude" class="control-label col-lg-4">Latitude</label>
                    <div class="col-lg-8">
                        <input type="text" id="latitude" name="latitude" class="form-control required" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="longitude" class="control-label col-lg-4">Longitude</label>
                    <div class="col-lg-8">
                        <input type="text" id="longitude" name="longitude" class="form-control required" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="pwd" class="control-label col-lg-4">Post</label>
                    <div class="col-lg-8">
                        <input type="text" id="content" name="content" class="form-control required" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary" id="postnow">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--div id="topbar">
        <input type="text" class="sample" id="latitude" />
        <input type="text" class="sample" id="longitude" />
        <button class="btn" id="createMarkers">Submit</button>
    </div-->
    <div id="map_canvas" style="position:absolute; top:380px; left:10px; height:100%; width:98%;overflow:hidden;"></div>
</div>
<script type="text/javascript">
    function createPost() {
        var postData = {
            "auth_token": $("#auth_token").val(),
            "latitude": $("#latitude").val(),
            "longitude": $("#longitude").val(),
            "content": $("#content").val()
        };
        $.ajax({
            url: 'http://web.tingtingapp.com/api/create_post/',
            async: true,
            type: "POST",
            crossDomain: true,
            data: JSON.stringify(postData),
            dataType: "json",
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                if(data.response == 'true'){
                    alert(data.message);
                    window.location.href = '/member/myposts/';
                }else{
                    alert("Invalid data");
                }
            }
        });
        return false;
    }
</script>
<script src="/js/randomlocation.js"></script>