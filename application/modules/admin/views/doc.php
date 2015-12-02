<div class="container Main_container">
    <div class="col-md-3">        
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li> <a href="#SingUp">Signup</a> </li>
                <li> <a href="#Login">Login</a> </li>
                <li> <a href="#Profile_view">Profile View</a> </li>
                <li> <a href="#Profile">Profile</a> </li>
                <li> <a href="#countries">List of Countries</a> </li>
                <li> <a href="#otp_confirm">OTP Confirm</a> </li>
                <li> <a href="#otp_resent">OTP Resent</a> </li>
                <li> <a href="#change_password">Change Password</a> </li>
                <li> <a href="#reset_password">Reset Password</a> </li>
                <li> <a href="#change_password_with_otp">Change Password With OTP</a> </li>
                <li> <a href="#rating">Member Rating</a> </li>
                <li> <a href="#review">Member Review</a> </li>
                <li> <a href="#member_geo">Update Member GEO Location </a> </li>
                <li> <a href="#create_post">Create Post</a> </li>
                <li> <a href="#myposts">My Posts</a> </li>
            </ul>
        </div>        
    </div>
    <a name="SingUp" style="padding-top:60px;"></a>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Signup</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p></p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/signup/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>
                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>name </td>
                        <td>(String|optional) Name of member</td>
                    </tr>
                    <tr>
                        <td>email </td>
                        <td>(String|Required) Email ID</td>
                    </tr>
                    <tr>
                        <td>pwd </td>
                        <td>(String|optional) Login password. If you sent as empty string, system will generate randam password</td>
                    </tr>
                    <tr>
                        <td>gender </td>
                        <td>(String) Male|Female|Other</td>
                    </tr>
                    <tr>
                        <td>birth_date </td>
                        <td>yyyy-mm-dd</td>
                    </tr>
                    <tr>
                        <td>mobile </td>
                        <td>(String) Mobile number</td>
                    </tr>                    
                    <tr>
                        <td>location </td>
                        <td>(String) Location</td>
                    </tr>
                    <tr>
                        <td>zip_code </td>
                        <td>(String) Zip code</td>
                    </tr>
                    <tr>
                        <td>country_id </td>
                        <td>(String) Country. Eg: IN, US...</td>
                    </tr>
                    <tr>
                        <td>disability </td>
                        <td>(String) Disability</td>
                    </tr>
                    <tr>
                        <td>tag_line </td>
                        <td>(String) Tag Line</td>
                    </tr>
                </table>
                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response</td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message</td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                    <tr>
                        <td>errors</td>
                        <td>(Array) list of errors Eg: {'name':'Please enter valid name', 'email': 'Please enter valid email'}</td>
                    </tr>
                    <tr>
                        <td>data</td>
                        <td>(Array) {"auth_token":"12342aw45w5", "member_id":"123"}</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="Login" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Login</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p></p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/login/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>                
                    <tr>
                        <td>email </td>
                        <td>(String) Email ID</td>
                    </tr>
                    <tr>
                        <td>pwd </td>
                        <td>(String) Login password</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                    <tr>
                        <td>error </td>
                        <td>(String) Send back error message.</td>
                    </tr>                
                    <tr>
                        <td>data</td>
                        <td>(Array) return data. {'member_id': '123', 'token': '12345566'}</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="Profile_view" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Profile View</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>get member profile data</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/profile_view/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>                    
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>                    
                    <tr>
                        <td>errors </td>
                        <td>(Array) list of errors Eg: {'name':'Please enter valid name', 'email': 'Please enter valid email'}</td>
                    </tr>
                    <tr>
                        <td>data</td>
                        <td>(Array) return data. {'member': {....}, 'token': '12345566'}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <a name="Profile" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Profile</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Update profile data</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/profile/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>name </td>
                        <td>(String|Required) Name of member</td>
                    </tr>
                    <tr>
                        <td>email </td>
                        <td>(String|Required) Email ID</td>
                    </tr>
                    <tr>
                        <td>pwd </td>
                        <td>(String) Login password. If you sent as empty string, system will generate randam password</td>
                    </tr>
                    <tr>
                        <td>gender </td>
                        <td>(String|Required) Male|Female:Other</td>
                    </tr>
                    <tr>
                        <td>birth_date </td>
                        <td>(Required)yyyy-mm-dd</td>
                    </tr>
                    <tr>
                        <td>mobile </td>
                        <td>(String) Mobile number</td>
                    </tr>                    
                    <tr>
                        <td>location </td>
                        <td>(String) Location</td>
                    </tr>
                    <tr>
                        <td>zip_code </td>
                        <td>(String|Required) Zip code</td>
                    </tr>
                    <tr>
                        <td>country_id </td>
                        <td>(String|Required) Country. Eg: IN, US...</td>
                    </tr>
                    <tr>
                        <td>disability </td>
                        <td>(String) Disability</td>
                    </tr>
                    <tr>
                        <td>tag_line </td>
                        <td>(String) Tag Line</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                    <tr>
                        <td>errors </td>
                        <td>(Array) list of errors Eg: {'name':'Please enter valid name', 'email': 'Please enter valid email'}</td>
                    </tr>
                    <tr>
                        <td>data</td>
                        <td>(Array) return data. {'member_id': '123', 'token': '12345566'}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <a name="countries" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Countries</h3>
            </div>
            <div class="panel-body">                
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/countries/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>                
                    <tr>
                        <td> </td>
                        <td>None</td>
                    </tr>                   
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>                                 
                    <tr>
                        <td>data</td>
                        <td>{
    "data": {
        "countries": [
            {
                "country_id": "1",
                "country_code": "US",
                "country_name": "United States"
            },...</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="otp_confirm" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">OTP Confirm</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>OTP confirm</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/otp_confirm/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String|Required) Auth token</td>
                    </tr>
                    <tr>
                        <td>otp_code </td>
                        <td>(String|Required) OTP code</td>
                    </tr>                        
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>                      

                </table>
            </div>
        </div>

        <a name="otp_resent" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">OTP Resent</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>OTP confirm</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/otp_resent/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>                                                   
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="change_password" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Change Password</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Change Password</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/change_password/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String|Required) Auth token</td>
                    </tr>
                    <tr>
                        <td>pwd </td>
                        <td>(String|Required) Old Password</td>
                    </tr>
                    <tr>
                        <td>newpwd </td>
                        <td>(String|Required) New Password</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="reset_password" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Change Password</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Reset Password</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/reset_password/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>                    
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="change_password_with_otp" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Change Password With OTP</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Change Password</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/change_password/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>otp_code </td>
                        <td>(String) OTP Code</td>
                    </tr>
                    <tr>
                        <td>newpwd </td>
                        <td>(String) New Password</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="rating" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Rating</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Add member Rating.</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/rating/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>member_id </td>
                        <td>(int) Rating to whom</td>
                    </tr>
                    <tr>
                        <td>rating </td>
                        <td>(int) Rating value between 1 to 5</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="review" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Review</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Add member review</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/review/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>member_id </td>
                        <td>(int) Review to whom</td>
                    </tr>
                    <tr>
                        <td>review </td>
                        <td>(String) Review(Max 200 chars)</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="member_geo" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Update Member GEO location</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p></p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/member_geo/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>latitude </td>
                        <td>(Float) Latitude</td>
                    </tr>
                    <tr>
                        <td>longitude </td>
                        <td>(Float) Longitude</td>
                    </tr>
                    <tr>
                        <td>is_online </td>
                        <td>(int) member is online or not.(1-online, 0-offline)</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                </table>
            </div>
        </div>

        <a name="create_post" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">Posts</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Add member posts</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/create_post/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                    <tr>
                        <td>content </td>
                        <td>(String) Post content</td>
                    </tr>
                    <tr>
                        <td>latitude </td>
                        <td>(Float) Post latitude</td>
                    </tr>
                    <tr>
                        <td>longitude </td>
                        <td>(Float) Post longitude</td>
                    </tr>
                    <tr>
                        <td>expiry_date </td>
                        <td>(String) Expiry Date(YYYY-MM-DD 00:00:00)</td>
                    </tr>
                    <tr>
                        <td>is_active </td>
                        <td>(Integer) Post status(0-draft, 1-active)</td>
                    </tr>
                </table>

                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                    <tr>
                        <td>data </td>
                        <td>{"post_id": "123"}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        
        <a name="myposts" style="padding-top:60px;"></a>
        <div class="panel panel-primary">       
            <div class="panel-heading">
                <h3 class="panel-title">My Posts</h3>
            </div>
            <div class="panel-body">
                <div class="content-header">
                    <h2>Summary</h2>
                    <p>Get my posts</p>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>URL :</td>
                        <td>http://web.tingtingapp.com/api/myposts/</td>
                    </tr>
                    <tr>
                        <td>Method :</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Encode :</td>
                        <td>JSON</td>
                    </tr>
                </table>

                <h2>Request</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>auth_token </td>
                        <td>(String) Auth token</td>
                    </tr>
                </table>
                <h2>Response</h2>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Parameters</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>(String) Success|Failed</td>
                    </tr>
                    <tr>
                        <td>response </td>
                        <td>(boolean) true|false</td>
                    </tr>
                    <tr>
                        <td>message </td>
                        <td>(String) Send back any message if success.</td>
                    </tr>
                    <tr>
                        <td>data </td>
                        <td>{"posts": [...]}</td>
                    </tr>
                </table>
            </div>
        </div>
        

    </div>
</div>