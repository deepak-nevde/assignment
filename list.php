<?php
include "db_config.php";

$result = mysqli_query($conn,"SELECT iss.`id`,iss.`issue_id`, iss.`subject`, iss.`description`, iss.`status_id`, iss.`priority`, iss.`region`, iss.`due_date`, iss.`target_version_id`, iss.`image`, 
iss.`reviewer_comment`, dev.dev_name, rev.reviewer_name, iss_st.status_name, tar_ver.target_version FROM `issues` as iss
 inner JOIN developers as dev on iss.`developer_id` = dev.id 
 inner JOIN reviewer as rev on iss.`reviewer_id` = rev.id
 inner JOIN issue_status as iss_st on iss.status_id = iss_st.id
 inner JOIN target_versions as tar_ver on iss.target_version_id = tar_ver.id 
 where iss.is_active='1'" );
// fetch data in array format
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
                    <img src="images/img.jpg" alt="">John Doe
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
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Issues</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo 'form.php'; ?>" class="close-add"><i class="fa fa-plus"></i> Add</a>
                        <li><a class="close-add" onclick="delete_issue()"><i class="fa fa-remove"></i> Delete</a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
  
                    <div class="x_content">
  
                      <div class="table-responsive">
                        <table class="table table-striped jambo_table">
                          <thead>
                            <tr class="headings">
                              <th>
                                <input type="checkbox" id="check-all" class="flat">
                              </th>
                              <th class="column-title">Issue Id </th>
                              <th class="column-title">Subject </th>
                              <th class="column-title">Status </th>
                              <th class="column-title">Priority </th>
                              <th class="column-title">Due Date </th>
                              <th class="column-title">Assignee </th>
                              <th class="column-title">Reviewer</th>
                              <th class="column-title">Target Version</th>
                            </tr>
                          </thead>
  
                          <tbody>
                          <form action="edit.php" method="post" >  
                          <?php
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 
// var_dump($result); exit;
                                  ?>
                            <tr class="even pointer" id="issue_row_<?php echo $row['id']; ?>">
                              <td class="a-center ">
                                <input type="checkbox" class="flat" name="table_records" id="<?php echo $row['id']; ?>">
                              </td>
                              <td class=" "><a type="submit" href="edit.php?issue_id=<?php echo $row['id']; ?>" value="update" style="text-decoration:underline"><?php echo $row['issue_id']; ?></a></td>
                              <td class=" "><?php echo $row['subject']; ?></td>
                              <td class=" "><?php echo $row['status_name']; ?></td>
                              <td class=" "><?php echo $row['priority']; ?></td>
                              <td class=" "><?php echo $row['due_date']; ?></td>
                              <td class=" "><?php echo $row['dev_name']; ?></td>
                              <td class=" "><?php echo $row['reviewer_name']; ?></td>
                              <td class=" last"> <?php echo $row['target_version']; ?></td>
                              </tr>
                              <?php } 
                              ?>
                              <!-- <button type="submit" name="save" class="btn btn-success">Submit</button> -->
                            </form>
                          </tbody>
                        </table>
                      </div>
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
