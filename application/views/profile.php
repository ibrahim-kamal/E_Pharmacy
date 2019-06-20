<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>SB Admin 2 - Bootstrap Admin Theme</title>

<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo base_url()."style/"?>admin/dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?php echo base_url()."style/"?>admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?php echo base_url()."style/"?>css/setting.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Blog Post - Start Bootstrap Template</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url().'style/article/'?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo base_url().'style/article/'?>css/blog-post.css" rel="stylesheet">

<style>
  .Cancel{
    margin: 0px 10px 0px 10px;
  }
  textarea{
    resize: none;
  }
  input{
        margin: 10px 0;
        width: 100%;
        padding: 2px;
  }
  body{
    background:#DDD;
  }
  *,p.lead,textarea.form-control{
      font-size: 14px;
  }
  .divcomment{
    background: #FFF;
    padding: 20px 20px 20px 5px;
  }
.divimg{
  margin-bottom:10px; 
}
.AcceptMed,.RemoveMed
{
  margin-bottom: 3px;
  height: 32px;
  font-size: 16px;
  font-weight: 500;
}


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

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-9">
      <?php if (isset($Pharmacy_Name)) {?>
        <h3><?php echo $Pharmacy_Name; ?></h3>
      <?php }?>
      <?php if (isset($company_Name)) {?>
        <h3><?php echo $company_Name; ?></h3>
      <?php }?>
      <?php if (isset($UserName)) {?>
        <h3><?php echo $UserName; ?></h3>
      <?php }?>
      <hr>
      <div class="col-lg-12">
        <table class="table table-striped table-dark">
          <tbody>
            <?php if (isset($Pharmacy_Name)) {?>
            <tr>
              <td>phone</td>
              <td><?php echo $pharmacyphone; ?></td>
            </tr>
            <tr>
              <td>address</td>
              <td><?php echo $pharmacyaddress; ?></td>
            </tr>
            <tr>
              <td>country</td>
              <td><?php echo $pharmacycountry; ?></td>
            </tr>
            <tr>
              <td>city</td>
              <td><?php echo $pharmacycity; ?></td>
            </tr>
            <tr>
              <td>neighborhood</td>
              <td><?php echo $pharmacyneighborhood; ?></td>
            </tr>
            <?php }?>
            <?php if (isset($UserName)) {?>
            <tr>
              <td>phone</td>
              <td><?php echo $phone; ?></td>
            </tr>
            <tr>
              <td>address</td>
              <td><?php echo $address; ?></td>
            </tr>
            <tr>
              <td>country</td>
              <td><?php echo $country; ?></td>
            </tr>
            <tr>
              <td>city</td>
              <td><?php echo $city; ?></td>
            </tr>
            <tr>
              <td>neighborhood</td>
              <td><?php echo $nightborhood; ?></td>
            </tr>
            <?php }?>
            <?php if (isset($company_Name)) {?>
            <tr>
              <td>phone</td>
              <td><?php echo $companyphone; ?></td>
            </tr>
            <tr>
              <td>address</td>
              <td><?php echo $companyaddress; ?></td>
            </tr>
            <tr>
              <td>country</td>
              <td><?php echo $companycountry; ?></td>
            </tr>
            <tr>
              <td>city</td>
              <td><?php echo $companycity; ?></td>
            </tr>
            <tr>
              <td>neighborhood</td>
              <td><?php echo $companyneighborhood; ?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>      
      </div>
    </div>
    <div class="col-md-3">
      <?php if(isset($report)){?> 
          <a href="<?php echo $report_url?>">
            <button class="col-lg-push-2 col-lg-8 Report btn btn-primary">
              Report
            </button>
        </a>
      <?php }?> 
    </div>
  </div>
</div>
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()."style/js/article.js"?>"></script>
   
 