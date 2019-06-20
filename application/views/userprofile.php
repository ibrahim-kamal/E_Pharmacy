<style>
  .div-question
  {
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
    z-index: 99999999999999999999;
    top: 0;
    left: 0;
    position: fixed;
  }
  .question
  {
    padding-bottom: 20px;
    background: #CCC;
    padding-left: 40px;
    width: 500px;
    border-radius: 20px;
    margin-bottom: 2px;
    margin: auto;
    position: relative; 
    top: 130px; 
  }
  .message-header
  {
    padding: 10px 0 10px 20px;
    background-color: #FFF;
    border: 1px solid #000;
    border-radius: 20px;
    margin-left: -40px; 
  }
  .Message
  {
    padding: 10px 0 10px 40px;  
  }
</style>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url().'style/js/userprofile.js';?>"></script>
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/userprofile.css';?>">

<div class="container-fluid panel-footer">
    <?php if($Request){?>
    <a data-original-title="Broadcast Message" data-Aid="<?php echo $Aid?>" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary add"><i class="glyphicon glyphicon-user"></i> Accept user</a>
    <?php }?>
    <a data-toggle="tooltip" type="button" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-remove"></i> Remove user </a>
</div>  
<div class="container-fluid"  style="margin-left: -350px">
  <div class="row">
    <div class="col-lg-12">
      
      <!-- user info -->
      <div class="col-lg-4" style="margin-left: 20px">
        <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">user info</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo base_url()."style/images/profile.png"?>" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 "> 
                          <table class="table table-user-information">
                            <tbody>

                              <tr>
                                <td>name:</td>
                                <td><?php echo $UserName;?></td>
                              </tr>
                              <tr>
                                <td>Role:</td>
                                <td><?php echo $Role;?></td>
                              </tr>
                              <tr>
                                <td>SSN:</td>
                                <td><?php echo $SSN;?></td>
                              </tr>
                              <tr>
                                <td>ImageSSN:</td>
                                <td><img src="<?php echo base_url()."style/images/".$SSNImageName ?>" width="230px" height="300px"></td>
                              </tr>
                              <tr>
                                <td>Phone:</td>
                                <td><?php echo $phone;?></td>
                              </tr>
                              <tr>
                                <td>Email</td>
                                <td><a href="<?php echo $Email;?>"><?php echo $Email;?></a></td>
                              </tr>
                              <tr>
                                <td>address:</td>
                                <td><?php echo $address;?></td>
                              </tr>
                              <tr>
                                <td>city:</td>
                                <td><?php echo $city;?></td>
                              </tr>
                              <tr>
                                <td>country:</td>
                                <td><?php echo $country;?></td>
                              </tr>
                              <tr>
                                <td>nightborhood:</td>
                                <td><?php echo $nightborhood;?></td>
                              </tr>
                              <tr>
                                <td>barthday:</td>
                                <td><?php echo $barthday;?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
        </div>
      </div>
      

      <!--  company info    -->

      <?php if(isset($company_Name)){?>
      <div class="col-lg-push-1 col-lg-4" style="margin-left: -50px">
        <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">company info</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo base_url()."style/images/profile.png"?>" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 "> 
                          <table class="table table-user-information">
                            <tbody>
                              <tr>
                                <td>company_Name:</td>
                                <td><?php echo $company_Name;?></td>
                              </tr>
                              <tr>
                                <td>company_permission:</td>
                                <td><?php echo $company_permission;?></td>
                              </tr>
                              <tr>
                                <td>permission:</td>
                                <td><img src="<?php echo base_url()."style/images/".$photo_company_permission_Name ?>" width="230px" height="300px"></td>
                              </tr>
                              <tr>
                                  <td>phone:</td>
                                  <td><?php echo $companyphone;?></td>
                                </tr>
                                <tr>
                                  <td>address:</td>
                                  <td><?php echo $companyaddress;?></td>
                                </tr>
                                <tr>
                                  <td>country:</td>
                                  <td><?php echo $companycountry;?></td>
                                </tr>
                                <tr>
                                  <td>city:</td>
                                  <td><?php echo $companycity;?></td>
                                </tr>
                                <tr>
                                  <td>nightborhood:</td>
                                  <td><?php echo $companyneighborhood;?></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
        </div>
      </div>
      <?php }?>

      <!--  user info    -->
      <?php if(isset($Pharmacy_Name)){?>
      <div class="col-lg-push-1 col-lg-4" style="margin-left: -50px">
        <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">pharmacy info</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo base_url()."style/images/profile.png"?>" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 "> 
                          <table class="table table-user-information">
                            <tbody>
                              <tr>
                                <td>Pharmacy_Name:</td>
                                <td><?php echo $Pharmacy_Name;?></td>
                              </tr>
                              <tr>
                                <td>state:</td>
                                <td><?php echo $Pharmacy_state;?></td>
                              </tr>
                              <tr>
                                <td>memberShip:</td>
                                <td><?php echo $Pharmacy_memberShip;?></td>
                              </tr>
                              <tr>
                                <td>memberShip Img:</td>
                                <td><img src="<?php echo base_url()."style/images/".$Pharmacy_Photo_memberShip_Name ?>" width="230px" height="300px"></td>
                              </tr>
                              <tr>
                                <td>permission:</td>
                                <td><?php echo $Pharmacy_Permission;?></td>
                              </tr>
                              <tr>
                                <td>permission Img:</td>
                                <td><img src="<?php echo base_url()."style/images/".$Pharmacy_Photo_Permission_Name ?>" width="230px" height="300px"></td>
                              </tr>
                              <tr>
                                  <td>phone:</td>
                                  <td><?php echo $pharmacyphone;?></td>
                                </tr>
                                <tr>
                                  <td>address:</td>
                                  <td><?php echo $pharmacyaddress;?></td>
                                </tr>
                                <tr>
                                  <td>country:</td>
                                  <td><?php echo $pharmacycountry;?></td>
                                </tr>
                                <tr>
                                  <td>city:</td>
                                  <td><?php echo $pharmacycity;?></td>
                                </tr>
                                <tr>
                                  <td>nightborhood:</td>
                                  <td><?php echo $pharmacyneighborhood;?></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
        </div>
      </div>
      <?php }?>

      <!--  doctor info    -->

      <?php if(isset($doc_memberShip)){?>
      <div class="col-lg-push-1 col-lg-4" style="margin-left: -50px">
        <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">doctor info</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo base_url()."style/images/profile.png"?>" class="img-circle img-responsive"> </div>
                        <div class=" col-md-9 col-lg-9 "> 
                          <table class="table table-user-information">
                            <tbody>
                              <tr>
                                <td>doc_memberShip:</td>
                                <td><?php echo $doc_memberShip;?></td>
                              </tr>
                              <tr>
                                <td>memberShip:</td>
                                <td><img src="<?php echo base_url()."style/images/".$photo_Doc_memberShip_Name ?>" width="230px" height="300px"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
        </div>
      </div>
      <?php }?>
    
    </div>
  </div>  
</div>

<div class="container-fluid ask hidden">
  <div class="div-question">
    <div class="question">
        <div class="message-header">
          <h3 class="header3">
            Remove Account
          </h3>
        </div>
        <div class="Message col-lg-12">
          <h4>
            Are you sure ?
          </h4>
        </div>
        <div class="Answer row">
          <div class="col-lg-push-5 col-lg-3">
            <button data-Aid="<?php echo $Aid?>" type="button" class="col-lg-12 Answer-yes btn btn-danger">yes</button>
          </div>
          <div class="col-lg-push-5 col-lg-3">
            <button type="button" class="col-lg-12 Answer-No btn btn-primary">No</button>
          </div>
        </div>
    </div>
  </div>  
</div>
<script>
  $(document).ready(function(){
    $('body').on("click",".add",function(){
        element = $(this); 
        link = "<?php echo base_url()."admincont/AcceptUser";?>";
        AccountId = $(this).attr('data-aid');
        $.ajax({

                    url: link,

                    type: "POST",

                    data: {Aid:AccountId},

                    success: function (page)
                    {
                      console.log(page);
                      element.remove();
                    }

                });
    });

    $('body').on("click",".delete",function(){
        $('.ask').removeClass('hidden');
    });

    $('body').on("click",".Answer-No",function(e){
        $('.ask').addClass('hidden');
    });

    $('body').on("click",".Answer-yes",function(e){
        link = "<?php echo base_url()."admincont/removeUser";?>";
        AccountId = $(this).attr('data-aid');
        $.ajax({

                    url: link,

                    type: "POST",

                    data: {Aid:AccountId},

                    success: function (page)
                    {
                      location.href = "<?php echo base_url().'admincont';?>";
                    }

                });
    });



  });
</script>