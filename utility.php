<?php
    class Utility {
        public static function loadError($errorMessages = array()){
            if(count($errorMessages) > 0){
                echo "<div class='alert alert-danger'>";
                foreach($errorMessages as $key => $error){
                    echo "<p class='text-jusitfy'>" . $error . "</p>";
                }
                echo "</div>";
            }
        }

        public static function loadSuccess($successMessage = ""){
            echo "<div class='alert alert-success mt-2' id='success'>" . $successMessage . "</div>";
        }


        public static function loadCss($cssFiles = array()){
            if(count($cssFiles) > 0){
                foreach($cssFiles as $file){
                    echo "<link rel='stylesheet' href='assets/css/" . $file . "'>";		
                }
            }
        }

        public static function loadJs($jsFiles = array()){
            if(count($jsFiles) > 0){
                foreach($jsFiles as $file){
                    echo "<script src='assets/js/" . $file . "'></script>";
                }
            }
        }

        public static function loadHeader($title = "", $cssFiles = array()){
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
            echo '<title>' . $title . '</title>';

            self::loadCss($cssFiles);
            echo '</head>';
        }

             
        public static function loadNavBar(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $entity = !empty($_SESSION['Entity']) ? $_SESSION['Entity'] : null;
            switch($entity) {
                case "tutor":
                    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
                    echo "<div class='container'>";
                    echo '<a class="navbar-brand" href="#">eTutor</a>';
                    echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
                    echo '<span class="navbar-toggler-icon"></span>';
                    echo '</button>';
                        
                    echo '<ul class="navbar-nav mr-auto">';		
                    echo '<li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Blogging</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Material Discussion</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Messaging</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Meeting</a></li>';

                    //echo '<li class="nav-item dropdown">';
                    //echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Branches</a>';
                    //echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    //echo '<a class="dropdown-item" href="mgmt_create_branch.php">Create Branch</a>';
                    //echo '<a class="dropdown-item" href="mgmt_view_branches.php">View Branches</a>';
                    //echo '</div>';
                    //echo '</li>';
                    echo '</ul>';

                    echo '<ul class="navbar-nav ml-auto">';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    echo '</ul>';
                    echo "</div>";
                    echo '</nav>';
                break;

                case "student":
                    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
                    echo "<div class='container'>";
                    echo '<a class="navbar-brand" href="#">eTutor</a>';
                    echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
                    echo '<span class="navbar-toggler-icon"></span>';
                    echo '</button>';
                        
                    echo '<ul class="navbar-nav mr-auto">';		
                    echo '<li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Blogging</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Material Discussion</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Messaging</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="#">Meeting</a></li>';

                    //echo '<li class="nav-item dropdown">';
                    //echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Branches</a>';
                    //echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    //echo '<a class="dropdown-item" href="mgmt_create_branch.php">Create Branch</a>';
                    //echo '<a class="dropdown-item" href="mgmt_view_branches.php">View Branches</a>';
                    //echo '</div>';
                    //echo '</li>';
                    echo '</ul>';

                    echo '<ul class="navbar-nav ml-auto">';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    echo '</ul>';
                    echo "</div>";
                    echo '</nav>';
                break;

                default:
                    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
                    echo "<div class='container'>";
                    echo '<a class="navbar-brand" href="#">eTutor</a>';
                    echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
                    echo '<span class="navbar-toggler-icon"></span>';
                    echo '</button>';
                    echo "</div>";
                    echo '</nav>';
                    break;
            }

        }

        public static function loadFooter(){
            echo '<div style="height:100px"></div><footer class="py-3 bg-dark" style="position:fixed;bottom: 0;width: 100%;"><div class="container"><p class="m-0 text-center text-white">Built by &copy; Team Nasi Lemak</p></div></footer>';
        }
    }
