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


<!-- Page Content -->
<div class="container-fluid ask hidden">
  <div class="div-question">
    <div class="question">
        <div class="message-header">
          <h3 class="header3">
            ERROR MESSAGE
          </h3>
        </div>
        <div class="Message col-lg-12">
          <h4>
            
          </h4>
        </div>
        <div class=" clear Answer row">
          <div class="col-lg-push-8 col-lg-3">
            <button type="button" class="col-lg-12 buttonOK btn btn-danger">
              OK
            </button>
          </div>
        </div>
    </div>
  </div>  
</div>
<div class="container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-9">
      <h3><?php echo $data['nameEng']; ?> <?php echo $data['nameAr']; ?></h3>
      <hr>
      <div class="col-lg-12">
        <div class="divimg col-lg-4">
            <img src="<?php echo $data['img'];?>" width="250" height="300">
        </div>
        <table class="table table-striped table-dark">
          <tbody>
            <tr>
              <td>Reqest</td>
              <td><?php echo $data['req']; ?></td>
            </tr>
            <tr>
              <td>Company Name</td>
              <td><?php echo $data['MedCompanyname']; ?></td>
            </tr>
            <tr>
              <td>Permission</td>
              <td><?php echo $data['permission']; ?></td>
            </tr>
            <tr>
              <td>contraceptive</td>
              <td><?php echo $medicine['contraceptive_AR']; ?></td>
            </tr>
            <tr>
              <td>contraceptive</td>
              <td><?php echo $medicine['contraceptive_EN']; ?></td>
            </tr>
            <tr>
              <td>اuses</td>
              <td><?php echo $medicine['uses_AR']; ?></td>
            </tr>
            <tr>
              <td>uses</td>
              <td><?php echo $medicine['uses_EN']; ?></td>
            </tr>
            <tr>
              <td>sideEffect_EN</td>
              <td><?php echo $medicine['sideEffect_AR']; ?></td>
            </tr>
            <tr>
              <td>sideEffect_EN</td>
              <td><?php echo $medicine['sideEffect_EN']; ?></td>
            </tr>
            <?php if (isset($data['price'])) { ?>
            <tr>
              <td>price</td>
              <td><?php echo $data['price']; ?></td>
            </tr>
            <tr>
              <td>quantity</td>
              <td><?php echo $data['quantity']; ?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>      
      </div>
      

      <?php if($Allowcomment){?>
      <!-- Comments Form -->
      <div class="com-form card my-4" style="clear: both;">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
          <div class="error"></div>
          <form id="com-form"class="addComment">
            <div class="form-group">
              <input placeholder="title" class="title" type="text">
              <textarea placeholder="comment" class="comment form-control" rows="5"></textarea>
            </div>
            <button type="submit" class="add btn btn-primary">Comment</button>
          </form>
        </div>
      </div>
    <?php }?>
      <!-- Single Comment -->
      
      <?php
        if(isset($comment['com_title']))
        {
          for ($i=0; $i <count($comment['com_title']) ; $i++) 
          {
      ?>
            <div class="divcomment media mb-4">
              <img class="d-flex mr-3 rounded-circle" src="<?php echo $comment['img'][$i]?>"  width='50' height="50" alt="">
              <div class="media-body">
                <h5 class="mt-0"><?php echo $comment['writer'][$i]?></h5>
                <h3 class="commenttitle"><?php echo $comment['com_title'][$i]?></h3>
                <span><?php echo $comment['com_subject'][$i]?></span>
              </div>
              <div>
                <?php if ($comment['edit'][$i]) {?>  
                  <a href="#com-form"><span><i title="edit comment" data-id="<?php echo $comment['com_ID'][$i];?>" class="edit glyphicon glyphicon-edit"></i></span></a>
                <?php  }?>  
                <?php if ($comment['delete'][$i]) {?>
                  <span><i title="remove comment" data-id="<?php echo $comment['com_ID'][$i];?>" class="remove glyphicon glyphicon-remove"></i></span>
                <?php  }?>
              </div>              
            </div>
      <?php
        }
      }

      ?>

    </div>

    <!-- Sidebar Widgets Column -->
    <div class="col-md-3">
      <?php if(isset($isadmin) && $data['req'] == 'pending'){?> 
          <button class="col-lg-push-2 col-lg-8 AcceptMed btn btn-primary">Accept</button>
      <?php }?>
      <?php if( isset($isadmin) || $data['remove']){?> 
        <button class="clear col-lg-push-2 col-lg-8 RemoveMed btn btn-primary">
          Remove
        </button> 
      <?php }?>   
      <?php if (isset($data['price'])) { ?>
        <div class="clear panel panel-default">
          <div class="panel-heading Editheader" style="background-color:#337ab7;">
              Change price
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="Errorpassword">
                      
                  </div>
                  <div class="col-lg-6">
                      <form role="form">
                          <div class="form-group">
                              <label>new price</label>
                              <input class="price form-control" value="<?php echo $data['price']; ?>" type="number" min="0" step="0.5">
                          </div>
                          <div class="form-group">
                              <button class="change-price btn btn-primary">change price</button>
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
              Add quantity
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="Errorpassword">
                      
                  </div>
                  <div class="col-lg-6">
                      <form role="form">
                          <div class="form-group">
                              <label>quantity</label>
                              <input class="quantity form-control" type="number" step="3" min="0">
                          </div>
                          <div class="form-group">
                              <button class="change-quantity btn btn-primary">Add quantity</button>
                          </div>
                      </form>
                  </div>

              </div>
              <!-- /.row (nested) -->
          </div>
          <!-- /.panel-body -->
        </div>
      <?php }?>
    </div>

  </div>
  <!-- /.row -->

</div>


<!-- jQuery -->
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()."style/js/article.js"?>"></script>
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
</script>
<script>   
  $(document).ready(function(){
  var formlocation = location.href+"#addComment";
  var commentid;
  var comtitle;
  var comsubject;
  var comimg;
  var comname;
  $('body').on('submit','.addComment',function(e){
    e.preventDefault();
  });
  $('body').on('click','.add',function(e){
    e.preventDefault();
    var title   = $('input.title').val();
    var Comment = $('.comment').val();
    var titleelement   = $('input.title');
    var Commentelement = $('.comment');
    var link = "<?php echo base_url().'medicinecont/addComment'?>" ;
    // if(title.length > 4 && Comment.length > 4){
      $.ajax({
            url: link,

            type: "POST",

            data: {title:title,comment:Comment,id:"<?php echo $data['medID']?>"},

            success: function (result)
            {
                if(result.split(' && ').length > 1){
                  var name = result.split(' && ')[1];
                  var img = result.split(' && ')[0];
                  var Defcomment = result.split(' && ')[2];
                  var ele = ''; 
                  ele += '<div class="divcomment media mb-4">';
                  ele += '<img class="d-flex mr-3 rounded-circle" src="'+img+'" height="50" width="50" alt="">';
                  ele += '<div class="media-body">';
                  ele += '<h5 class="mt-0">'+name+'</h5>';
                  ele += '<h3 class="commenttitle">'+title+'</h3>';
                  ele += '<span>'+Comment+'</span>';
                  ele += '</div>';
                  ele += '<div>'
                  ele += '<a href="#com-form"><span><i title="edit comment" data-id="'+Defcomment+'" class="edit glyphicon glyphicon-edit"></i></span></a>'
                  ele += '<span><i title="remove comment" data-id="'+Defcomment+'" class="remove glyphicon glyphicon-remove"></i></span>'
                  ele += '</div>'
                  ele += '</div>';
                  // $('.divcomment').first().before(ele);
                  $('.com-form').after(ele);
                  ele = "";
                  titleelement.val('');
                  Commentelement.val('');
                }
                else if(result.split(' | ').length > 1){
                  var errortitle = result.split(' | ')[1];
                  var errorcomment = result.split(' | ')[0];
                  error = errortitle + errorcomment;
                  $('.error').html(error);
                }
            }

        });
    // }
  });

   $('body').on('click','.remove',function(e){
    var element = $(this).parents('.divcomment');
    var data_id = $(this).attr('data-id');
    var link = "<?php echo base_url().'medicinecont/removecomment'?>" ;
     $.ajax({
            url: link,

            type: "POST",

            data: {id:data_id},

            success: function (result)
            {
              if(result.trim() == "deleted"){
                element.remove();
              }
              else{

              }
            }

        });
   });

   $('body').on('click','.edit',function(e){
    $('.Cancel').click();
    var inputtitle   = $('input.title');
    var inputsubject = $('.comment');
    var cancelbutton = '<button type="submit" class="Cancel btn btn-primary">Cancel</button>';
    var element = $(this).parents('div.divcomment');
    commentid = $(this).attr('data-id');
    comtitle = element.children('div').children('.commenttitle').text();
    comsubject = element.children('div').children(':last-child').text();
    comimg  = element.children('img').attr('src');
    comname = element.children('div').children('h5').text();
    inputtitle.val(comtitle);
    inputsubject.val(comsubject);
    $('.add').addClass('EditComment').removeClass('add').text('Edit Comment').after(cancelbutton);
    element.remove();
   });

   $('body').on('click','.Cancel',function(e){
      cancelevent();
   });

   function cancelevent(){
      var inputtitle   = $('input.title');
      var inputsubject = $('.comment');
      inputtitle.val('');
      inputsubject.val('');
      $('.EditComment').addClass('add').removeClass('EditComment').text('Comment');
      $('.Cancel').remove();
      var ele = ''; 
      ele += '<div class="divcomment media mb-4">';
      ele += '<img class="d-flex mr-3 rounded-circle" src="'+comimg+'" height="50" width="50" alt="">';
      ele += '<div class="media-body">';
      ele += '<h5 class="mt-0">'+comname+'</h5>';
      ele += '<h3 class="commenttitle">'+comtitle+'</h3>';
      ele += '<span>'+comsubject+'</span>';
      ele += '</div>';
      ele += '<div>'
      ele += '<a href="#com-form"><span><i title="edit comment" data-id="'+commentid+'" class="edit glyphicon glyphicon-edit"></i></span></a>'
      ele += '<span><i title="remove comment" data-id="'+commentid+'" class="remove glyphicon glyphicon-remove"></i></span>'
      ele += '</div>'
      ele += '</div>';
      // $('.divcomment').first().before(ele);
      $('.com-form').after(ele);
   }

   $('body').on('click','.EditComment',function(e){
    e.preventDefault();
    var title   = $('input.title').val();
    var Comment = $('.comment').val();
    var titleelement   = $('input.title');
    var Commentelement = $('.comment');
    var link = "<?php echo base_url().'medicinecont/editComment'?>" ;
    // if(title.length > 4 && Comment.length > 4){
      $.ajax({
            url: link,

            type: "POST",

            data: {title:title,comment:Comment,id:commentid},

            success: function (result)
            {
                if(result.split(' && ').length > 1){
                  var name = result.split(' && ')[1];
                  var img = result.split(' && ')[0];
                  var Defcomment = result.split(' && ')[2];
                  var ele = ''; 
                  ele += '<div class="divcomment media mb-4">';
                  ele += '<img class="d-flex mr-3 rounded-circle" src="'+img+'" height="50" width="50" alt="">';
                  ele += '<div class="media-body">';
                  ele += '<h5 class="mt-0">'+name+'</h5>';
                  ele += '<h3 class="commenttitle">'+title+'</h3>';
                  ele += '<span>'+Comment+'</span>';
                  ele += '</div>';
                  ele += '<div>'
                  ele += '<a href="#com-form"><span><i title="edit comment" data-id="'+Defcomment+'" class="edit glyphicon glyphicon-edit"></i></span></a>'
                  ele += '<span><i title="remove comment" data-id="'+Defcomment+'" class="remove glyphicon glyphicon-remove"></i></span>'
                  ele += '</div>'
                  ele += '</div>';
                  // $('.divcomment').first().before(ele);
                  $('.com-form').after(ele);
                  ele = "";
                  titleelement.val('');
                  Commentelement.val('');
                  $('.Cancel').remove();
                }
                else if(result.split(' | ').length > 1){
                  var errortitle = result.split(' | ')[1];
                  var errorcomment = result.split(' | ')[0];
                  error = errortitle + errorcomment;
                  $('.error').html(error);
                }
            }

        });
    // }
  });



});
</script>
<?php if(isset($isadmin) && $data['req'] == 'pending'){?> 
    <script>
      $('body').on('click','.AcceptMed',function(e){
          $ele = $(this);
          var link = "<?php echo base_url().'admincont/AcceptMedicine'?>" ;
          $.ajax({
            url: link,
            type: "POST",
            data: {MedID:"<?php echo $data['medID'];?>"},
            success: function (result)
            {
                if(result.trim() == 'Accept'){
                    $ele.remove();
                }
                else{
                  location.href = '<?php base_url().'Errorcont'?>';
                }
            }
          });
      })
  </script>
<?php }?>

<?php if( isset($isadmin) || $data['remove']){?> 
    <script>
      $('body').on('click','.RemoveMed',function(e){
          $ele = $(this);
          var link = "<?php echo base_url().$controller.'/RemoveMedicine'?>" ;
          $.ajax({
            url: link,
            type: "POST",
            data: {MedID:"<?php echo $data['medID'];?>"},
            success: function (result)
            {
                if(result.trim() == 'Accept'){
                    location.reload();
                }
                else{
                  location.href = '<?php base_url().'Errorcont'?>';
                }
            }
          });
      })
  </script>
<?php }?>   
<?php if (isset($data['price'])) { ?> 
  <script>
        $('body').on('click','.buttonOK',function(){
          $('.ask').addClass('hidden');
        });
        $('body').on('click','.change-price',function(e){
            $ele = $(this);
            var link = "<?php echo base_url().$controller.'/changeprice'?>" ;
            var price = $('.price').val();
            $.ajax({
              url: link,
              type: "POST",
              data: {MedPrice:price,MedID:"<?php echo $data['medID'];?>"},
              success: function (result)
              {
                  console.log(result);
                  if(result.trim() == 'Accept'){
                      location.reload();
                  }
                  else if(result.split('|')[0]){
                    $('.Message h4').html(result.split('|')[1]);
                    $('.ask').removeClass('hidden');
                  }
                  else{
                    location.href = '<?php base_url().'Errorcont'?>';
                  }
              }
            });
        });
        $('body').on('click','.change-quantity',function(e){
            $ele = $(this);
            var link = "<?php echo base_url().$controller.'/changequantity'?>" ;
            var quantity = $('.quantity').val();
            $.ajax({
              url: link,
              type: "POST",
              data: {MedQua:quantity,MedID:"<?php echo $data['medID'];?>"},
              success: function (result)
              {
                  if(result.trim() == 'Accept'){
                      location.reload();
                  }
                  else if(result.split('|')[0]){
                    $('.Message h4').html(result.split('|')[1]);
                    $('.ask').removeClass('hidden');
                  }
                  else{
                    location.href = '<?php base_url().'Errorcont'?>';
                  }
              }
            });
        });
    </script>
<?php }?>   