<div class="container">
    <h2>Welcome</h2>
    <div id="demo"></div>
</div>
<script type="text/javascript">
    
    function setPosition(position) {
        var postData = {
            "auth_token": "<?php echo $_SESSION['auth_token']; ?>",
            "latitude": position.coords.latitude,
            "longitude": position.coords.longitude,
            "is_online": "1"
        };
        $.ajax({
            url: 'http://web.tingtingapp.com/api/member_geo/',
            async: true,
            type: "POST",
            crossDomain: true,
            data: JSON.stringify(postData),
            dataType: "json",
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                
            }
        });
        return false;
    }

    $(function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(setPosition);
        } else {
            //x.innerHTML = "Geolocation is not supported by this browser.";
        }
    });

</script>