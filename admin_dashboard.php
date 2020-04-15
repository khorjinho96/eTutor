<?php
    require "session.php";
    require "utility.php";   
    require "UserRepositoryInterface.php";
    require "UserRepository.php";
    require "AssignRepository.php";
    require "MessageRepository.php";
    require "MeetingRepository.php";

    checkEntity(array("admin"));

    $errorMessages = array();

    if(!empty($_POST['submit'])){
        if($_POST['submit'] === 'Search'){
            switch($_POST['entity']){
                case 'tutee':
                    try {
                        $userRepo = new UserRepository();
                        $tutee = $userRepo->verifyStudent(array($_POST['email']));
                        if(count($tutee) === 1){
                            $_SESSION['StudentEmail'] = $_POST['email'];
                            header("Location: student_dashboard.php");
                        }
                    }
                    catch(Exception $ex) {
                        $errorMessages[] = $ex->getMessage(); 
                    }
                    break;

                case 'tutor':
                    try {
                        $userRepo = new UserRepository();
                        $tutor = $userRepo->verifyTutor(array($_POST['email']));
                        if(count($tutor) === 1){
                            $_SESSION['TutorEmail'] = $_POST['email'];
                            header("Location: tutor_dashboard.php");
                        }
                    }
                    catch(Exception $ex) {
                        $errorMessages[] = $ex->getMessage(); 
                    }
                    break;

                default:
                    break;
            }                    
        }
    }

    try {
        $userRepo = new UserRepository();

        $assignRepo = new AssignRepository();
        $students = $assignRepo->getAllStudentEmail();
        $tutors = $userRepo->getAllTutor();
       
        $messageRepo = new MessageRepository();
        $message7 = $messageRepo->getMessageSentLast7($students);
        $message28 = $messageRepo->getMessageSentLast28($students);
        $messageTotal7 = $messageRepo->getMessageSentLast7($tutors);
        $messageAll = $messageRepo->getMessageSentLastAll($tutors);

        $meetingRepo = new MeetingRepository();
        $meeting7 = $meetingRepo->getMeetingLast7($students);
        $meeting28 = $meetingRepo->getMeetingLast28($students);

        $studentNoTutor = $userRepo->getStudentWithoutTutor($students);
    }
    catch(Exception $ex) {
        $errorMessages[] = $ex->getMessage(); 
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
                    <h3 class="text-center">Admin Dashboard</h3>
                    <hr /> 
                    <?php
                        if(!empty($errorMessages)) {
                            if(count($errorMessages) > 0) {
                                Utility::loadError($errorMessages);
                            }
                        }
                    ?>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            Dashboard Access
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row">
                                <div class="form-group col-md-8 col-sm-12 col-xs-12">
                                <input type="email" id="email" name="email" class="form-control" placeholder="User email" <?php if(!empty($_POST['email'])){ echo "value='" . $_POST['email'] . "'"; } ?> required />
                                </div>
                                <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                    <select id="entity" name="entity" class="form-control">
                                        <option value="tutee">Tutee</option>
                                        <option value="tutor">Tutor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                    <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block" />
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            Statistics Report
                        </div>
                        <div class="card-body">
                            <div clas="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Number of messages in last 7 days for tutors</h5>
                                    <?php
                                        if(!empty($messageTotal7)){
                                            if(count($messageTotal7) > 0){
                                                echo "<ul>";
                                                foreach($messageTotal7 as $key => $value) {
                                                    echo "<li>" . $key . " has " . $value . " message(s) in total.</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<ul><li>No tutor available.</li></ul>";
                                            }
                                        } else {
                                            echo "<ul><li>No data available.</li></ul>";
                                        }
                                    ?>    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Average number of messages for tutors</h5>
                                    <?php
                                        if(!empty($messageAll)){
                                            $tutorCount = count($messageAll);
                                            if($tutorCount > 0){
                                                echo "<ul>";
                                                echo "<li>Tutor count: " . $tutorCount . "</li>";
                                                echo "<li>Average messsage count: " . number_format((array_sum($messageAll) / $tutorCount), 2, ".", "") . "</li>";
                                            }
                                        } else {
                                            echo "<ul><li>No data available.</li></ul>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            Exception Report
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student without personal tutors</h5>
                                    <?php
                                        if(!empty($studentNoTutor)){
                                            if(count($studentNoTutor) > 0){
                                                echo "<ul>";
                                                foreach($studentNoTutor as $value) {
                                                    echo "<li>" . $value['email'] . "</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<ul><li>No student matched.</li></ul>";
                                            }
                                        } else {
                                            echo "<ul><li>No data available.</li></ul>";
                                        }
                                    ?>    
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student do not interact with tutors for 7 days</h5>
                                    <?php
                                        if(!empty($students)){
                                            echo "<ul>";
                                            $count7 = 0;
                                            foreach($students as $value){
                                                if(!array_key_exists($value, $message7) && !array_key_exists($value, $meeting7)){
                                                    $count7++;
                                                    echo "<li>" . $value . "</li>";
                                                } else if(array_key_exists($value, $message7) && array_key_exists($value, $meeting7)) {
                                                    if($message7[$value] === 0 && $meeting7[$value] === 0){
                                                        $count7++;
                                                        echo "<li>" . $value . "</li>";
                                                    } 
                                                }
                                            }
                                            if($count7 === 0){
                                                echo "<li>No student matched.</li>";
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "<ul><li>No data available.</li></ul>";
                                        }
                                    ?>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>Student do not interact with tutors for 28 days</h5>
                                    <?php
                                        if(!empty($students)){
                                            echo "<ul>";
                                            $count28 = 0;
                                            foreach($students as $value){
                                                if(!array_key_exists($value, $message28) && !array_key_exists($value, $meeting28)){
                                                    $count28++;
                                                    echo "<li>" . $value . "</li>";
                                                } else if(array_key_exists($value, $message28) && array_key_exists($value, $meeting28)) {
                                                    if($message28[$value] === 0 && $meeting28[$value] === 0){
                                                        $count28++;
                                                        echo "<li>" . $value . "</li>";
                                                    } 
                                                }
                                            }
                                            if($count28 === 0){
                                                echo "<li>No student matched.</li>";
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "<ul><li>No data available.</li></ul>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "popper.js", "bootstrap.min.js")); ?>
        <script type="text/javascript">
            $(document).ready(
                function() {
                    <?php
                        if(!empty($_POST['entity'])){
                            echo '$("#entity").val("' . $_POST['entity'] . '");';
                        }
                    ?>
                }
            );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
