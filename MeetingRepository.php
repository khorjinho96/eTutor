<?php
    require_once "DatabaseConfig.php";

    class MeetingRepository {
        private $databaseConnection = null;

        public function __construct(){
            $this->databaseConnection = new mysqli(DatabaseConfig::HOST, DatabaseConfig::USER, DatabaseConfig::PASSWORD, DatabaseConfig::DATABASE);
            if($this->databaseConnection->connect_error){
                throw new Exception($this->databaseConnection->connect_error);
            }
        }

        public function __destruct(){
            mysqli_close($this->databaseConnection);
        }

        public function getMeetingByEmail($email) {
            $result = array();
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT recipient_email, DATE(meeting_date), COUNT(meeting_id) AS TotalMeeting FROM meeting WHERE user_email = ? GROUP BY recipient_email, DATE(meeting_date) ORDER BY meeting_date ASC")){
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    mysqli_stmt_bind_result($stmt, $recipientEmail, $dateSend, $totalMeeting);
                    while(mysqli_stmt_fetch($stmt)){
                        if(array_key_exists($recipientEmail, $result)) {
                            $result[$recipientEmail][$dateSend] = $totalMeeting; 
                        } else {
                            $result[$recipientEmail] = array(
                                $dateSend => $totalMeeting
                            );
                        }
                    }                    
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
            $meeting = array();
            $meeting['tutor2@gmail.com'] = array(
                "2020-02-15" => 11,
                "2020-02-12" => 2 
            );

            return $meeting;
        }

        public function getMeetingByDay($email = array(), $dayNum, $tutorEmail){
            $result = array();
            $today = new DateTime("now");
            $today = $today->format("Y-m-d");
            $lastDay = new DateTime("now");
            $lastDay->sub(new DateInterval('P' . $dayNum. 'D'));
            $lastDay = $lastDay->format("Y-m-d");
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, 
                "SELECT 
                    COUNT(meeting_id) AS TotalMeeting 
                 FROM 
                    meeting 
                WHERE 
                    ((user_email = ? AND recipient_email = ?) OR (user_email = ? AND recipient_email = ?))
                AND 
                    DATE(meeting_date) > ?")){
                mysqli_stmt_bind_param($stmt, "sssss", $email, $tutorEmail, $tutorEmail, $email, $lastDay);
                mysqli_stmt_bind_result($stmt, $totalMessage);
                foreach($email as $value){
                    $email = $value['email'];
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) === 1){
                        mysqli_stmt_fetch($stmt);
                        $result[$email] = $totalMessage;
                    }
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }

        public function getMeetingLast28($email = array()) {
            $result = array();
            $today = new DateTime("now");
            $today = $today->format("Y-m-d");
            $lastDay = new DateTime("now");
            $lastDay->sub(new DateInterval('P28D'));
            $lastDay = $lastDay->format("Y-m-d");
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT COUNT(meeting_id) AS TotalMeeting FROM meeting WHERE (user_email = ? OR recipient_email = ?) AND DATE(meeting_date) <= ? AND DATE(meeting_date) > ?")){
                mysqli_stmt_bind_param($stmt, "ssss", $value, $value, $today, $lastDay);
                mysqli_stmt_bind_result($stmt, $totalMessage);
                foreach($email as $value){
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) === 1){
                        mysqli_stmt_fetch($stmt);
                        $result[$value] = $totalMessage;
                    }
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }

        public function getMeetingLast7($email = array()) {
            $result = array();
            $today = new DateTime("now");
            $today = $today->format("Y-m-d");
            $lastDay = new DateTime("now");
            $lastDay->sub(new DateInterval('P7D'));
            $lastDay = $lastDay->format("Y-m-d");
            $stmt = mysqli_stmt_init($this->databaseConnection);
            if(mysqli_stmt_prepare($stmt, "SELECT COUNT(meeting_id) AS TotalMeeting FROM meeting WHERE (user_email = ? OR recipient_email = ?) AND DATE(meeting_date) <= ? AND DATE(meeting_date) > ?")){
                mysqli_stmt_bind_param($stmt, "ssss", $value, $value, $today, $lastDay);
                mysqli_stmt_bind_result($stmt, $totalMessage);
                foreach($email as $value){
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) === 1){
                        mysqli_stmt_fetch($stmt);
                        $result[$value] = $totalMessage;
                    }
                }
                mysqli_stmt_close($stmt);
                return $result;
            }
        }
    }



