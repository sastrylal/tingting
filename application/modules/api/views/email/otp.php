<!DOCTYPE html>
<html>
    <body>
        <section style="width:85%;float:none;margin:10px auto;display:block;border:solid 1px #ddd;font-size: 14px;color: #333;padding: 10px 15px;">
            <p>Dear <?php echo!empty($name) ? $name : ""; ?>,</p><br>
            <p style="text-indent: 25px;"> OTP : <?php echo $otp_code; ?>.</p>
            <br/>            
        </section>
    </body>
</html>