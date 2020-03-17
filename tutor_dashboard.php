<?php
    require_once "session.php";
    require_once "utility.php";
    require_once "AssignRepository.php";
    require_once "MessageRepository.php";    
    require_once "MeetingRepository.php";    

    checkEntity(array("tutor", "admin"));

    if(!empty($_POST['submit'])){
        if($_POST['submit'] === 'Search'){
            try {
                $email = getUserEmail();

                if(getUserEntity() === 'admin'){
                    if(!empty($_GET['tutor'])){
                        if (filter_var(filter_var($_GET['tutor'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
                            $email = $_GET['tutor'];
                        } else {
                            throw new Exception("Invalid email.");
                        }                        
                    } else {
                        throw new Exception("Invalid email.");
                    }
                }

                $assignRepo = new AssignRepository();
                $student = $assignRepo->getStudent($email);       

                $messageRepo = new MessageRepository();
                $message = $messageRepo->getMessageSentByDay($student, $_POST['dayNum'], $email);

                $meetingRepo = new MeetingRepository();
                $meeting = $meetingRepo->getMeetingByDay($student, $_POST['dayNum'], $email);        
            }
            catch(Exception $ex){
                $errorMessage = $ex->getMessage();
            }
        }
    }
?>


<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Dashboard", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <h3 class="text-center">Personal Dashboard</h3>
                    <hr /> 
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group row">
                            <div class="col-md-10 col-xs-12 col-sm-12">
                                <span>Student who does not interact with me more than</span>
                                <input type="number" id="dayNum" name="dayNum" value="0" required />
                                <span>days</span>
                            </div>
                            <div class="col-md-2 col-xs-12 col-sm-12">
                                <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block" />
                            </div>
                        </div>
                    </form>
                    <br />
                    <table id="tutee_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tutee Email</th>
                                <th>Tutee Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($errorMessage)){
                                    echo "<div class='alert alert-danger'>" . $errorMessage . "</div>";
                                } else {
                                    if(!empty($student)){
                                        if(count($student) > 0){
                                            foreach($student as $value){
                                                if($message[$value['email']] === 0 && $meeting[$value['email']] === 0){
                                                    echo "<tr>";
                                                    echo "<td>" . $value['email'] . "</td>";
                                                    echo "<td>" . $value['name'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        } else {
                                            echo "<div class='alert alert-info'>Tutor <strong>" . $email . "</strong> currently do not have any tutees.</div>";
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Tutee Email</td>
                                <td>Tutee Name</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "jquery.dataTables.min.js")); ?>
        <script type="text/javascript">
            $(document).ready(
                function() {
                    $("#tutee_table").DataTable({
                                
                    });
                    <?php
                        if(!empty($_POST['dayNum'])){
                            echo '$("#dayNum").val(' . $_POST['dayNum'] . ');';
                        }
                    ?>
                }
            );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
