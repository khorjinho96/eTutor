<?php
    session_start();
require "session.php";
                                        require "AssignRepository.php";
                                        $assignRepo = new AssignRepository();
                                                echo getUserEmail();                   
                                                $recipient = $assignRepo->getStudent(getUserEmail());
                                                print_r($recipient);
