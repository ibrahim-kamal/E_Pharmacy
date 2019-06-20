<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Account</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading Editheader" style="background-color:#337ab7;">
                    change password
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="Errorpassword">
                            
                        </div>
                        <div class="col-lg-6">
                            <form role="form">
                                <div class="form-group">
                                    <label>new password</label>
                                    <input class="password form-control" type="password">
                                </div>
                                <div class="form-group">
                                    <label>new password</label>
                                    <input class="repassword form-control" type="password">
                                </div>
                                <div class="form-group">
                                    <label>old password</label>
                                    <input class="oldpassword form-control" type="password">
                                </div>
                                <div class="form-group">
                                    <button class="change-password btn btn-primary">change password</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-heading Editheader" style="background-color:#337ab7;">
                    change Email
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="ErrorEmail">
                            
                        </div>
                        <div class="col-lg-6">
                            <form role="form">
                                <div class="form-group">
                                    <label>new Email</label>
                                    <input class="email form-control" type="Email">
                                </div>
                                <div class="form-group">
                                    <label>password</label>
                                    <input class="e-password form-control" type="password">
                                </div>                                
                                <div class="form-group">
                                    <button class="change-email btn btn-primary">change Email</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-heading Editheader" style="background-color:#337ab7;">
                    change phone
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="ErrorPhone">
                            
                        </div>
                        <div class="col-lg-6">
                            <form role="form">
                                <div class="form-group">
                                    <label>new phone</label>
                                    <input class="phone form-control" type="string">
                                </div>                                
                                <div class="form-group">
                                    <button class="change-phone btn btn-primary">change phone</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-heading Editheader" style="background-color:#337ab7;">
                    change address
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="ErrorAddress">
                            
                        </div>
                        <div class="col-lg-6">
                            <form role="form">
                                <div class="form-group">
                                    <label>address</label>
                                    <input class="address form-control" type="string">
                                </div>
                                <div class="form-group">
                                    <label>country</label>
                                    <input class="country form-control" type="string">
                                </div>
                                <div class="form-group">
                                    <label>city</label>
                                    <input class="city form-control" type="string">
                                </div>
                                <div class="form-group">
                                    <label>nightborhood</label>
                                    <input class="nightborhood form-control" type="string">
                                </div>
                                <div class="form-group">
                                    <button class="change-address btn btn-primary">change address</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<script>
    $('.Editheader').next('.panel-body').hide();
    $('.Editheader').click(function(){
        var show = 0;
        if($(this).next('.panel-body').css('display') == 'none'){
           show = 1; 
        }
        $('.Editheader').next('.panel-body').hide();
        if(show == 1){
            $(this).next('.panel-body').show();   
        }
    });
    $('form').submit(function(e){
        e.preventDefault();
    });

    $('.change-password').click(function(){
        var link     = "<?php echo base_url()."Settingcont/changePassword";?>";
        var pass     =  $('.password').val();
        var re_pass  =  $('.repassword').val();
        var old_pass =  $('.oldpassword').val();   
        $.ajax({
            url: link,

            type: "POST",

            data: {newpassword:pass,renewpassword:re_pass,oldpassword:old_pass},

            success: function (result)
            {
              res = result.split("|");
              if(res.length > 1){
                error = result.replace("|", " ");
                error = error.replace("|", " ");
                $('.Errorpassword').html(error);
              }
              else if(result == 0){
                 $('.Errorpassword').html('the old password is wrong');
              }
              else{
                location.href = "<?php echo base_url()."Settingcont/";?>";
              }
            }

        });
    });

    $('.change-email').click(function(){
        var link     = "<?php echo base_url()."Settingcont/changeEmail";?>";
        var email     =  $('.email').val();
        var pass  =  $('.e-password').val();  
        console.log(email+" "+pass); 
        $.ajax({
            url: link,

            type: "POST",

            data: {Email:email,password:pass},

            success: function (result)
            {
              res = result.split("|");
              if(res.length > 1){
                error = result.replace("|", " ");
                $('.ErrorEmail').html(error);
              }
              else if(result == 0){
                 $('.ErrorEmail').html('the password is wrong or Email is Exisit in system');
              }
              else{
                location.href = "<?php echo base_url()."Settingcont/";?>";
              }
            }

        });
    });

    $('.change-phone').click(function(){
        var link     = "<?php echo base_url()."Settingcont/changePhone";?>";
        var phone     =  $('.phone').val(); 
        $.ajax({
            url: link,

            type: "POST",

            data: {Phone:phone},

            success: function (result)
            {
              res = result.split("|");
              if(result == 0){
                 $('.ErrorPhone').html('phone is exist');
              }
              else if (result == 1){
                location.href = "<?php echo base_url()."Settingcont/";?>";
              }
              else{
                error = result.replace("|", " ");
                $('.ErrorPhone').html(error);
              }
            }

        });
    });

    ErrorAddress

    // $('.change-address').click(function(){
    //     var link     = "<?php echo base_url()."Settingcont/changePhone";?>";
    //     var address     =  $('.address').val(); 
    //     var country     =  $('.country').val(); 
    //     var city     =  $('.city').val(); 
    //     var nightborhood     =  $('.nightborhood').val(); 
    //     $.ajax({
    //         url: link,

    //         type: "POST",

    //         data: {address:address,country:country,city:city,nightborhood:nightborhood},

    //         success: function (result)
    //         {
    //           if (result == 1){
    //             location.href = "<?php echo base_url()."Settingcont/";?>";
    //           }
    //           else{
    //             $('.ErrorAddress').html(result);
    //           }
    //         }

    //     });
    // });
</script>
