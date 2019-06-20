
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
</style>
<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Title -->
      <h1 class="mt-4"><?php echo $data['Question_title']?></h1>

      <!-- Author -->
      <p class="lead">
        by
        <a style="color: #007bff"><?php echo $data['writer']?></a>
      </p>

      <hr>

      <!-- Date/Time -->
      <p>Posted on <?php echo $data['time']?></p>

      <hr>

      <!-- Preview Image -->
      <img class="img-fluid rounded" width="900" height="300" src="<?php echo base_url()."style/images/".$data['img']?>" alt="">

      <!-- Post Content -->
      <p class="lead"><?php echo $data['Question_subject']?></p>

      <hr>

      <?php if($Allowcomment){?>
      <!-- Comments Form -->
      <div class="com-form card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
          <div class="error"></div>
          <form id="com-form" class="addComment">
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
    <div class="col-md-4">

    </div>

  </div>
  <!-- /.row -->

</div>


<!-- jQuery -->
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()."style/js/article.js"?>"></script>
<script>
  $(document).ready(function(){
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
    var title   = $('.title').val();
    var Comment = $('.comment').val();
    var titleelement   = $('.title');
    var Commentelement = $('.comment');
    var link = "<?php echo base_url().'Questioncont/addComment'?>" ;
    // if(title.length > 4 && Comment.length > 4){
      $.ajax({
            url: link,

            type: "POST",

            data: {title:title,comment:Comment,id:"<?php echo $data['Question_ID']?>"},

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
    var link = "<?php echo base_url().'Questioncont/removecomment'?>" ;
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
    var inputtitle   = $('.title');
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
      var inputtitle   = $('.title');
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
   });

   $('body').on('click','.EditComment',function(e){
    e.preventDefault();
    var title   = $('.title').val();
    var Comment = $('.comment').val();
    var titleelement   = $('.title');
    var Commentelement = $('.comment');
    var link = "<?php echo base_url().'Questioncont/editComment'?>" ;
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
