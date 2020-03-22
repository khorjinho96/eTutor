<?php
    require_once "DatabaseConfig.php";
    require_once "UserRepositoryInterface.php";
    require_once "UserRepository.php";
    require_once "EmailService.php";

    class AssignRepository {
        private $databaseConnection = null;        
        private $userRepo = null;

        public function __construct(){
            $this->databaseConnection = new mysqli(DatabaseConfig::HOST, DatabaseConfig::USER, DatabaseConfig::PASSWORD, DatabaseConfig::DATABASE);
            if($this->databaseConnection->connect_error){
                throw new Exception($this->databaseConnection->connect_error);
            }

            $this->userRepo = new UserRepository();            
        }

        public function assign($student = array(), $tutor = array(), $staffId, $reallocate = false) {
            try {
                if(count($student) > 0){
                    $student = $this->userRepo->verifyStudent($student);
                } else {
                    throw new Exception("Student emails cannot be empty.");
                }             

                if(count($tutor) > 0){
                    $tutor = $this->userRepo->verifyTutor($tutor);
                } else {
                    throw new Exception("Tutor emails cannot be empty.");
                }                

                $stmt = mysqli_stmt_init($this->databaseConnection);
                if(mysqli_stmt_prepare($stmt, "INSERT INTO assign (StudentEmail, TutorEmail, DateAssigned, StaffId) VALUES (?,?,?,?)")){
                    mysqli_stmt_bind_param($stmt, "sssd", $studentEmail, $tutorEmail, $date, $staffId);
                    $result = array();
                    $studentList = array(); $tutorList = array();
                    $date = date("Y-m-d H-i-s");
                    $result[200] = array();
                    $result[500] = array();
                    foreach($student as $studentEmail){
                        foreach($tutor as $tutorEmail){                            
                            mysqli_stmt_execute($stmt);
                            if(mysqli_stmt_affected_rows($stmt) === 1) {
                                if(!in_array($studentEmail, $studentList)){
                                    $studentList[] = $studentEmail;
                                }
                                if(!in_array($tutorEmail, $tutorList)){
                                    $tutorList[] = $tutorEmail;
                                }

                                $result[200][] = array(
                                    "status" => 200,
                                    "message" => $studentEmail . " has been " . ($reallocate ? "realloacted" : "allocated") . " allocated tutor " . $tutorEmail . " successfully."
                                );
                            } else {
                                switch(mysqli_stmt_errno($stmt)){
                                    case 1062:
                                        $result[500][] = array(
                                            "status" => 500,
                                            "message" => $studentEmail . " has already been " . ($reallocate ? "realloacted" : "allocated") . " tutor " . $tutorEmail . "."
                                        );
                                        break;

                                    default:
                                        $result[500][] = array(
                                            "status" => 500,
                                            "message" => $studentEmail . " failed to be " . ($reallocate ? "realloacted" : "allocated") . " tutor " . $tutorEmail . ". " . mysqli_stmt_error($stmt)
                                        );
                                        break;
                                }
                            }
                        }
                    }

                    if(count($result[200]) > 0){
                        if($reallocate === true){
                            $emailService = new EmailService("System Notification");
                            $studentStatus = $emailService->notifyStudents($studentList, "You have been reallocated personal tutor(s).");
                            $emailService = new EmailService("System Notification");
                            $tutorStatus = $emailService->notifyTutors($tutorList, "You have been reallocated student(s).");
                        } else {
                            $emailService = new EmailService("System Notification");
                            $studentStatus = $emailService->notifyStudents($studentList, "You have been allocated personal tutor(s).");
                            $emailService = new EmailService("System Notification");
                            $tutorStatus = $emailService->notifyTutors($tutorList, "You have been allocated student(s).");
                        }
                        if($studentStatus === false){
                            $result[200][] = array(
                                "status" => 500,
                                "message" => "Failed to send notification emails to students."
                            );
                        }

                        if($tutorStatus === false) {
                            $result[200][] = array(
                                "status" => 500,
                                "message" => "Failed to send notification emails to tutors."
                            );
                        }
                    }
                    return $result;                    
                    mysqli_stmt_close($stmt);
                }
            }
            catch(Exception $ex){
                throw new Exception($ex->getMessage());
            }           
        }        

        public function reallocate($student = array(), $tutor = array(), $staffId){
            try {
                if(count($student) > 0){
                    $student = $this->userRepo->verifyStudent($student);
                } else {
                    throw new Exception("Student emails cannot be empty.");
                }             

                if(count($tutor) > 0){
                    $tutor = $this->userRepo->verifyTutor($tutor);
                } else {
                    throw new Exception("Tutor emails can be empty.");
                }                

                $stmt = mysqli_stmt_init($this->databaseConnection);
                if(mysqli_stmt_prepare($stmt, "DELETE FROM assign WHERE StudentEmail = ?")){
                    $result = array();
                    $result[200] = array();
                    $resut[500] = array();
                    mysqli_stmt_bind_param($stmt, "s", $studentEmail);
                    foreach($student as $studentEmail){
                        mysqli_stmt_execute($stmt);
                        if(mysqli_stmt_affected_rows($stmt) > 0) {
                            $temp = $this->assign(array($studentEmail), $tutor, $staffId, true);
                            if(array_key_exists(200, $temp)) {
                                $result[200] = array_merge($temp[200], $result[200]);
                            } else if(array_key_exists(500, $temp)) {
                                $result[500] = array_merge($temp[500], $result[500]);
                            }
                        } else {
                            if(mysqli_stmt_errno($stmt) === 0) {
                                $result[500][] = array(
                                    "status" => 500,
                                    "message" => "Failed to reallocate student " . $studentEmail . ". Please confirmed the student has been allocated tutors previously."
                                );
                            } else {
                                $result[500][] = array(
                                    "status" => 500,
                                    "message" => "Failed to reallocate student " . $studentEmail . ". " . mysqli_stmt_error($stmt)
                                );
                            }
                        }
                    }

                    if(count($result) > 0){
                        return $result;
                    } else{
                        throw new Exception("Result not available.");
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            catch(Exception $ex){
                throw new Exception($ex->getMessage());
            }           
        }

        public function getStudent($tutorEmail) {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT StudentEmail FROM assign WHERE TutorEmail = ?")){
                mysqli_stmt_bind_param($stmt, "s", $tutorEmail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 0) {                
                    mysqli_stmt_bind_result($stmt, $studentEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $studentEmail;
                    }
                } else {
                    mysqli_stmt_close($stmt);
                    return $result;
                }
            }
            mysqli_stmt_close($stmt);
            return $this->userRepo->getName($result);
        }       

        public function getTutor($studentEmail) {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT TutorEmail FROM assign WHERE StudentEmail = ?")){
                mysqli_stmt_bind_param($stmt, "s", $studentEmail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 0) {                
                    mysqli_stmt_bind_result($stmt, $tutorEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $tutorEmail;
                    }
                } else {
                    mysqli_stmt_close($stmt);
                    return $result;
                }
            }
            mysqli_stmt_close($stmt);

            return $this->userRepo->getName($result);
        }       

        public function getAllTutorEmail(){
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT DISTINCT TutorEmail FROM assign")){
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $tutorEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $tutorEmail;
                    }
                }
            }
            mysqli_stmt_close($stmt);

            return $result;
        }
        
        public function getAllStudentEmail(){
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT DISTINCT StudentEmail FROM assign")){
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $studentEmail);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = $studentEmail;
                    }
                }
            }
            mysqli_stmt_close($stmt);

            return $result;
        }

        public function getAllocation() {
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT StudentEmail, TutorEmail, DateAssigned FROM assign ORDER BY StudentEmail, TutorEmail, DateAssigned ASC")){
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = array();
                if(mysqli_stmt_num_rows($stmt) > 1) {                
                    mysqli_stmt_bind_result($stmt, $studentEmail, $tutorEmail, $dateAssigned);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = array(
                            "studentEmail" => $studentEmail,
                            "tutorEmail" => $tutorEmail,
                            "dateAssigned" => $dateAssigned
                        );
                    }
                }                   
            }
            mysqli_stmt_close($stmt);

            return $result;
        }        
    }



