<?php
    require 'scrum_connection.php';
    require('session.php');
    require "utility.php";

    $conn = getconnection();
    $uid =  getUserEmail();
    $uname = getUserName();
    $entity = getUserEntity();
?>
<html xmlns="http://www.w3.org/1999/html">
    <?php Utility::loadHeader("View meeting", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>
    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">View Meeting</h3>
                    <hr />
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table class="table table-bordered table-striped table-hover" id="tables" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Record</th>
                                    <th>Recipient</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <?php
                                    if($entity == 'tutor'){
                                        echo "<th>Aprove</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM meeting WHERE user_email = '$uid' || recipient_email = '$uid'";
                                    $result = mysqli_query($conn,$sql);
                                    //display data from db in table form
                                    while ($row = mysqli_fetch_array($result)) {
                                        $meetingid = $row['meeting_id'];
                                        $meetingtitle = $row['meeting_name'];
                                        $meetingdate = $row['meeting_date'];
                                        $meetingstart = $row['meeting_start'];
                                        $meetingend = $row['meeting_end'];
                                        $meetingrecord = $row['meeting_record'];
                                        $recipient = $row['recipient_email'];
                                        $status = $row['meeting_status'];

                                        echo "<tr>";
                                        echo "<td>$meetingid</td>";
                                        echo "<td>$meetingtitle</td>";
                                        echo "<td>$meetingdate</td>";
                                        echo "<td>$meetingstart</td>";
                                        echo "<td>$meetingend</td>";
                                        if ($meetingrecord != null){
                                            echo "<td><a href='$meetingrecord'>link</a></td>";
                                        }else{
                                            echo "<td>No Records</td>";
                                        }
                                        echo "<td>$recipient</td>";
                                        echo "<td>$status</td>";
                                        echo "<td><button type='submit' name='edit' id='edit' value='$meetingid' class='btn btn-primary btn-block'>Edit</button></td>";
                                        if($entity == 'tutor' && $status == 'Pending'){
                                            echo "<td><button type='submit' name='aprove' id='aprove' value='$meetingid' class='btn btn-primary btn-block'>Aprove</button></td>";
                                        }
                                        if($entity == 'tutor' && $status != 'Pending'){
                                            echo "<td>Approved</td>";
                                        }
                                    }
                                ?>
                                <?php
                                    if (isset($_POST['edit'])){
                                        $meetingids = $_POST['edit'];
                                        $_SESSION['editmeetingid'] = $meetingids;

                                        echo "<script>window.location.href='editmeeting.php'</script>";
                                    }

                                    if(isset($_POST['aprove'])){
                                        $meetid = $_POST['aprove'];

                                        $sql = "UPDATE meeting SET meeting_status='Approve' WHERE meeting_id = '$meetid'";
                                        mysqli_query($conn, $sql);
                                        echo "<script>window.location.href='viewmeeting.php'</script>";
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>ID</td>
                                    <td>Title</td>
                                    <td>Date</td>
                                    <td>Start</td>
                                    <td>End</td>
                                    <td>Record</td>
                                    <td>Recipient</td>
                                    <th>Status</th>
                                    <td>Edit</td>
                                    <?php
                                    if($entity == 'tutor'){
                                        echo "<th>Aprove</th>";
                                    }
                                    ?>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "popper.js", "jquery.dataTables.min.js")); ?>
        <script>
            $(document).ready( function () {
                $('#tables').dataTable({
                    "scrollX": true
                });
            } );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
