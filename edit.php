<?php
include "db_config.php";

// var_dump($_REQUEST['issue_id']); exit;
if(isset($_REQUEST['issue_id'])){
    $req_issue_id = $_REQUEST['issue_id'];
    $result = mysqli_query($conn,"SELECT iss.`developer_id`, iss.`reviewer_id`,  rev.id, iss.`id`,iss.`issue_id`, iss.`subject`, iss.`description`, iss.`status_id`, iss.`priority`, iss.`region`, iss.`due_date`, iss.`target_version_id`, iss.`image`, 
    iss.`reviewer_comment`, dev.dev_name, rev.reviewer_name, iss_st.status_name, tar_ver.target_version FROM `issues` as iss
    inner JOIN developers as dev on iss.`developer_id` = dev.id 
    inner JOIN reviewer as rev on iss.`reviewer_id` = rev.id
    inner JOIN issue_status as iss_st on iss.status_id = iss_st.id
    inner JOIN target_versions as tar_ver on iss.target_version_id = tar_ver.id 
    where iss.is_active='1' AND iss.id= '$req_issue_id'" );
 
 if(!empty($_FILES) && !empty($_FILES['image']['name'])){
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
      $target_dir = dirname(__FILE__)."/assets/uploads/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    } else {
      echo "File is not an image.";
    }
  }
// var_dump($_POST); exit;
  $image_file = isset($_FILES["image"]["name"])?$_FILES["image"]["name"]:'';
  $dev_id = isset($_POST['developer'])?$_POST['developer']:'';
  $reviewer_id = isset($_POST['reviewer'])?$_POST['reviewer']:'';
  $subject = isset($_POST['subject'])?$_POST['subject']:'';
  $description = isset($_POST['description'])?$_POST['description']:'';
  $status = isset($_POST['status'])?$_POST['status']:'';
  $priority = isset($_POST['priority'])?$_POST['priority']:'';
  $region = isset($_POST['region'])?$_POST['region']:'';
  $due_date = isset($_POST['due_date'])?$_POST['due_date']:'';
  $target_version = isset($_POST['target_version'])?$_POST['target_version']:'';
  $reviewer_comment_ = isset($_POST['reviewer_comment_'])?$_POST['reviewer_comment_']:'';
  $date1 = strtr($due_date, '/', '-');
  $due_date =  date('Y-m-d', strtotime($date1));
  $region = is_array($region)?implode(',', $region):$region;

  if(isset($_POST['update'])){
    $sql = "UPDATE issues SET 
       developer_id	= '$dev_id', 
       reviewer_id = '$reviewer_id', 
       subject = '$subject', 
       description = '$description',
       status_id = '$status', 
       priority = '$priority', 
       region = '".$region."', 
       due_date = '".$due_date."',
       target_version_id = '".$target_version."',
       image = '$image_file',
       reviewer_comment = '$reviewer_comment_' WHERE id = '$req_issue_id'";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header('Location:list.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
  }
  

}

?>


<?php


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Assignment</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- iCheck -->
    <link href="assets/iCheck/skins/flat/green.css" rel="stylesheet">

    <link href="assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/css/custom.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><span>Assignment</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="<?php echo 'list.php'; ?>"><i class="fa fa-table"></i> Issues </a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    John Doe
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
  
              <div class="clearfix"></div>
  
              <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <a href="<?php echo "form.php"; ?>"></a><h2>Edit Issue</small></h2></a>
                      <div class="clearfix"></div>
                    </div>
  
                    <div class="x_content">
                        <form action="" id="issue_creation" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">  
                        <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 
                            // var_dump($row); exit;
                            ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="subject" value="<?php echo $row['subject']; ?>" class="form-control" placeholder="Subject">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <textarea class="form-control"  name="description" rows="3" placeholder="Description"><?php echo $row['description']; ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Status*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <select name="status" class="form-control">
                                  <option value="">Select issue status</option>
                                    <?php
                                        // var_dump($row); exit;
                                        $result_status = mysqli_query($conn,"select * from issue_status;");
                                        // fetch data in array format
                                        while ($row_status = mysqli_fetch_array($result_status, MYSQLI_ASSOC)) {
                                        ?>
                                        <option value="<?php echo $row_status['id']; ?>" <?php if($row_status['id']==$row['status_id']){ echo 'selected="selected"';} ?> > <?php echo $row_status['status_name']; ?> </option>";
                                        
                                    <?php }
                                    ?>
                                  </select>
                                  <div id="status-error" class="error" style="display:none">Please select Issue status.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Priority*
                                </label>
        
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="radio">
                                      <label>
                                      <?php
                                        // var_dump($row['priority']); exit;
                                      ?>
                                        <input type="radio" class="flat" name="priority" value="High" <?php echo ($row['priority']== 'High') ?  "checked" : "" ;  ?> > High
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" class="flat" name="priority" value="Medium" <?php echo ($row['priority']== 'Medium') ?  "checked" : "" ;  ?> > Medium
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" class="flat" name="priority" value="Low" <?php echo ($row['priority']== 'Low') ?  "checked" : "" ;  ?>> Low
                                      </label>
                                    </div>
                                    <div id="priority-error" class="error" style="display:none">Please select priority.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Affected Regions
                                </label>
                                <?php //var_dump(); exit;?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="china" 
                                          <?php

                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'china') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> China
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="europe" 
                                          <?php 
                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'europe') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> Europe
                                        </label>
                                      </div>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="region[]" value="india" 
                                        <?php 
                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'india') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> India
                                      </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="japan" 
                                          <?php 
                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'japan') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> Japan
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="singapore" <?php 
                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'singapore') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> Singapore
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="region[]" value ="us" <?php 
                                            if(isset($row['region'])){
                                                $region_arr = explode(',', $row['region']);
                                                foreach($region_arr as $region){
                                                    if($region == 'us') {
                                                        echo "checked";
                                                    }else{
                                                        echo"";
                                                    } 
                                                }
                                            }  ?> class="flat"> US
                                      </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Due Date <span class="required">*</span>
                              </label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                              <?php
                              $date=date_create($row['due_date']);
                              ?>
                                  <input type="text" value="<?php echo date_format($date,"d/m/Y"); ?>" name="due_date" id="duedate" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Assignee*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="developer">
                                <option value=""> Please select Assignee</option>
                                <?php
                                // var_dump($row); exit;
                                $result = mysqli_query($conn,"select * from developers;");
                                // fetch data in array format
                                while ($row_all = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                 ?>
                                <option value="<?php echo $row_all['id']; ?>" <?php if($row_all['id']==$row['developer_id']){ echo 'selected="selected"';} ?> > <?php echo $row_all['dev_name']; ?> </option>";
                                    
                                <?php }
                                ?>
                                </select>
                                <div id="assignee-error" class="error" style="display:none">Please select Assignee.</div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Reviewer*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="reviewer">
                                <option value=""> Please select Reviewer</option>
                                <?php
                                $rev_result = mysqli_query($conn,"select * from reviewer;");
                                // fetch data in array format
                                while ($rev_row = mysqli_fetch_array($rev_result, MYSQLI_ASSOC)) {  
                                 ?>
                                <option value="<?php echo $rev_row['id']; ?>" <?php if($rev_row['id']==$row['reviewer_id']){ echo 'selected="selected"';} ?> > <?php echo $rev_row['reviewer_name']; ?> </option>";  
                                <?php }
                                ?>
                                </select>
                                <div id="reviwer-error" class="error" style="display:none">Please select Reviwer.</div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Target Version*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="target_version">
                                <option value=""> Please select target version.</option>
                                <?php
                                $version_result = mysqli_query($conn,"select * from target_versions ;");
                                // fetch data in array format
                                while ($ver_row = mysqli_fetch_array($version_result, MYSQLI_ASSOC)) {  
                                 ?>
                                <option value="<?php echo $ver_row['id']; ?>" <?php if($ver_row['id']==$row['target_version_id']){ echo 'selected="selected"';} ?> > <?php echo $ver_row['target_version']; ?> </option>";  
                                <?php }
                                ?>
                                </select>
                                <div id="version-error" class="error" style="display:none">Please select Target version.</div>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Images*</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="file" name="image" value="<?php echo $row['image']; ?>" multiple class="form-control" placeholder="Images">
                                </div>
                              </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Reviewer Comments</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <textarea class="form-control" name="reviewer_comment " rows="3" placeholder="Reviwer Comments"><?php echo $row['reviewer_comment'];?></textarea>
                              </div>
                            </div>
                            <?php } ?>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button type="button" class="btn btn-primary">Cancel</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                                <button type="submit" id="btn-save" name="update" class="btn btn-success">Submit</button>
                              </div>
                            </div>
                          </form>              
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <style>
        .error {
        color: red;
        }
    </style>
    <!-- jQuery -->
    <script src="assets/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="assets/fastclick/lib/fastclick.js"></script>
    <!-- iCheck -->
    <script src="assets/iCheck/icheck.min.js"></script>
    <!-- DateJS -->
    <script src="assets/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="assets/moment/min/moment.min.js"></script>

    <script src="assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Autosize -->
    <script src="assets/autosize/dist/autosize.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>		
  </body>
</html>
