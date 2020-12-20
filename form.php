<?php
include "db_config.php";

if(isset($_POST['save'])){

  if(!empty($_FILES) && !empty($_FILES['name'])){
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
  $status = isset($_POST['status']);
  $priority = isset($_POST['priority'])?$_POST['priority']:'';
  $region = isset($_POST['region'])?$_POST['region']:'';
  $due_date = isset($_POST['due_date'])?$_POST['due_date']:'';
  $target_version = isset($_POST['target_version'])?$_POST['target_version']:'';
  $reviewer_comment_ = isset($_POST['reviewer_comment_'])?$_POST['reviewer_comment_']:'';
  $date1 = strtr($due_date, '/', '-');
  $due_date =  date('Y-m-d', strtotime($date1));
 
  $region = is_array($region)?implode(',', $region):$region;

  $issue_id_result = mysqli_query($conn,"select max(id) from issues;");
 
  $isse_id = mysqli_fetch_row($issue_id_result);
  
  $isse_id = $isse_id[0] == null ? 1 :$isse_id[0]+1;
  $isse_id = 'CR00'.$isse_id;

  $sub_result = mysqli_query($conn,"SELECT id FROM issues WHERE subject = '$subject'");
  if($sub_result->num_rows == 0) {
    $sql = "INSERT INTO issues (issue_id, developer_id	, reviewer_id, subject, description, status_id, priority, region, due_date, target_version_id,image, reviewer_comment, is_active	)
    VALUES ('$isse_id', '$dev_id', '$reviewer_id', '$subject', '$description', '$status', '$priority', '".$region."', '".$due_date."' , '".$target_version."', '$image_file', '$reviewer_comment_', '1')";
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
      header('Location:list.php');
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    if(isset($_POST['subject']) && !empty($_POST['subject'])){
      $errorMsg=  "Issue subject already exists!";
      $code= "1" ;
    }
  }
}

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
  <style type="text/css" >
  .errorMsg{border:1px solid red; }
  .message{color: red; font-weight:bold; }
 </style>
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
                      <a href="<?php echo "form.php"; ?>"></a><h2>Add Issue</small></h2></a>
                      <div class="clearfix"></div>
                    </div>
  
                    <div class="x_content">
                        <form action="" id="issue_creation" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">  

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="subject" class="form-control" placeholder="Subject">
                              <?php if (isset($errorMsg)) { echo "<p class='message'>" .$errorMsg. "</p>" ;} ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Status*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <select name="status" class="form-control">
                                  <option value="">Select issue status</option>
                                  <?php $staus_result = mysqli_query($conn,"select * from issue_status;");
                                // fetch data in array format
                                while ($status_row = mysqli_fetch_array($staus_result, MYSQLI_ASSOC)) {  
                                 ?>
                                <option value="<?php echo $status_row['id']; ?>" > <?php echo $status_row['status_name']; ?> </option>";
                                    
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
                                        <input type="radio" class="flat" name="priority" value="High"> High
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" class="flat" name="priority" value="Medium"> Medium
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" class="flat" name="priority" value="Low"> Low
                                      </label>
                                    </div>
                                    <div id="priority-error" class="error" style="display:none">Please select priority.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Affected Regions
                                </label>
        
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="china" class="flat"> China
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="europe" class="flat"> Europe
                                        </label>
                                      </div>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="region[]" value="india" class="flat"> India
                                      </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="japan" class="flat"> Japan
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                          <input type="checkbox" name="region[]" value="singapore" class="flat"> Singapore
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="region[]" class="flat"> US
                                      </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Due Date <span class="required">*</span>
                              </label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" name="due_date" id="duedate" class="form-control" placeholder="Due Date">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Assignee*</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="developer">
                                <option value=""> Please select Assignee</option>
                                <?php
                                $result = mysqli_query($conn,"select * from developers;");
                                // fetch data in array format
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {  
                                 ?>
                                <option value="<?php echo $row['id']; ?>" > <?php echo $row['dev_name']; ?> </option>";
                                    
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
                                <option value="<?php echo $rev_row['id']; ?>" > <?php echo $rev_row['reviewer_name']; ?> </option>";
                                    
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
                                <?php $version_result = mysqli_query($conn,"select * from target_versions;");
                                // fetch data in array format
                                while ($versions_row = mysqli_fetch_array($version_result, MYSQLI_ASSOC)) {  
                                 ?>
                                <option value="<?php echo $versions_row['id']; ?>" > <?php echo $versions_row['target_version']; ?> </option>";
                                    
                                <?php }
                                ?>
                                </select>
                                <div id="version-error" class="error" style="display:none">Please select Target version.</div>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Images*</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="file" name="image" multiple class="form-control" placeholder="Images">
                                </div>
                              </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Reviewer Comments</label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                  <textarea class="form-control" name="reviewer_comment " rows="3" placeholder="Reviwer Comments"></textarea>
                              </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button type="button" class="btn btn-primary">Cancel</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                                <button type="submit" name="save" id="btn-save" value="submit" class="btn btn-success">Submit</button>
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
