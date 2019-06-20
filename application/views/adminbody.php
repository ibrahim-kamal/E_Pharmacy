<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/css/body.css"?>">
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>New Comments!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>New Tasks!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>New Orders!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Support Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Users
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>SSN</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if(isset($new['Email'])) for ($i=0; $i <count($new['Email']) ; $i++) { ?>
                                <tr class="gradeA" data-id="<?php echo $new['Aid'][$i];?>">
                                    <th><?php echo $new['UserName'][$i];?></th>
                                    <th><?php echo $new['Email'][$i];?></th>
                                    <th><?php echo $new['Role'][$i];?></th>
                                    <th><?php echo $new['SSN'][$i];?></th>
                                    <th><?php echo $new['phone'][$i];?></th>
                                    <th><?php echo $new['address'][$i];?></th>
                                    <th>Delete</th>
                                </tr> 
                            <?php }?>
                            
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->  
                </div>

                <!-- /.panel-body -->
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="all_user">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>SSN</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($all['Email'])) for ($i=0; $i <count($all['Email']) ; $i++) { ?>
                                <tr class="gradeA" data-id="<?php echo $all['Aid'][$i];?>">
                                    <th><?php echo $all['UserName'][$i];?></th>
                                    <th><?php echo $all['Email'][$i];?></th>
                                    <th><?php echo $all['Role'][$i];?></th>
                                    <th><?php echo $all['SSN'][$i];?></th>
                                    <th><?php echo $all['phone'][$i];?></th>
                                    <th><?php echo $all['address'][$i];?></th>
                                    <th>Delete</th>
                                </tr> 
                            <?php }?>
                            
                            
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->  
                </div>

                <!-- /.panel-body -->
            </div>

            <!-- /.row -->
        </div>
        
        <script>
            $('.gradeA').click(function(){
                var id = $(this).attr('data-id');
                var link = "<?php echo base_url().'admincont/profile/'?>" + id;
                $.ajax({

                    url: link,

                    type: "POST",

                    data: {},

                    success: function (page)
                    {
                        // console.log(page);
                        $('#page-wrapper').html(page);
                        // $('body').append(page);
                    }

                });
            });
        </script>