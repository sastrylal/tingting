<!DOCTYPE html>
<html>
    <body>
        <section style="width:85%;float:none;margin:10px auto;display:block;border:solid 1px #ddd;font-size: 14px;color: #333;padding: 10px 15px;">
            <p>Dear <?php echo!empty($name) ? $name : ""; ?>,</p><br>
            <p style="text-indent: 25px;">We are happy to inform you that you have been successfully registered in our website.</p>
            <br/>
            <p><b>Username :</b> <?php echo!empty($email) ? $email : ""; ?></p><br/>
            <p><b>Password :</b> <?php echo!empty($pwd) ? $pwd : ""; ?></p><br/>
        </section>
    </body>
</html>