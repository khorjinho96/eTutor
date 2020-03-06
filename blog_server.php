<?php
    require 'scrum_connection.php';
    require('session.php');
    require "utility.php";

    $conn = getconnection();
    $uid =  getUserEmail();
    $uname = getUserName();

//variable declaration and get
    if (isset($_REQUEST['id'])) {
        $id = filter_var($_REQUEST['id'],FILTER_SANITIZE_STRING);
        $id = mysqli_escape_string($conn,$_REQUEST['id']);
        $target=filter_var($_REQUEST['id'],FILTER_SANITIZE_STRING);
        $target = mysqli_escape_string($conn,$_REQUEST['id']);

    }

    if (isset($_REQUEST['action'])) {
        $action = filter_var($_REQUEST['action'],FILTER_SANITIZE_STRING);
        $action = mysqli_escape_string($conn,$_REQUEST['action']);
    }

    switch ($action){
        case "add":
            $error= -0;
            if (isset($_REQUEST['blog_title'])) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_title'])||empty(trim($_REQUEST['blog_title'])) ){
                    $error++;
                    $_SESSION['BlogTitleErr'] = "Invalid Input";
                }else{
                    $blog_title =filter_var($_REQUEST['blog_title'],FILTER_SANITIZE_STRING);
                    $blog_title =mysqli_escape_string($conn,$_REQUEST['blog_title']);
                }
            }

            if (isset($_REQUEST['blog_category'] )) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_category'])||empty(trim($_REQUEST['blog_category'])) ) {
                    $error++;
                    $_SESSION['BlogCategoryErr'] = "Invalid Input";
                }else{
                    $blog_category = filter_var($_REQUEST['blog_category'],FILTER_SANITIZE_STRING);
                    $blog_category = mysqli_escape_string($conn,$_REQUEST['blog_category']);
                }
            }

            if (isset($_REQUEST['blog_description'])) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_description'])||empty(trim($_REQUEST['blog_description'])) ) {
                    $error++;
                    $_SESSION['BlogDescriptionErr'] = "Invalid Input";
                }else{
                    $blog_description = filter_var($_REQUEST['blog_description'],FILTER_SANITIZE_STRING);
                    $blog_description = mysqli_escape_string($conn,$_REQUEST['blog_description']);
                }
            }

            if (isset($_REQUEST['blog_content']))  {
                if(preg_match("/^\W+$/", $_REQUEST['blog_content'])||empty(trim($_REQUEST['blog_content'])) ) {
                    $error++;
                    $_SESSION['BlogContentErr'] = "Invalid Input";
                }else{
                    $blog_content = filter_var($_REQUEST['blog_content'],FILTER_SANITIZE_STRING);
                    $blog_content = mysqli_escape_string($conn,$_REQUEST['blog_content']);
                }
            }

                // configuration for upload operation
            $AllowedFileTypes = array('png','jpg','gif','jpeg');
            $Directory = "uploads/";
            if(isset($_FILES['ImagesUpload']) && !empty($_FILES['ImagesUpload'])) {
                $uploadedImagesName="";
                foreach ($_FILES['ImagesUpload']['name'] as $key => $val) {
                        // path for file upload directory
                        $FileName = basename($_FILES['ImagesUpload']['name'][$key]);
                        $FilePath = $Directory . $FileName;
                        // validating file type
                        $CheckFileType = pathinfo($FilePath, PATHINFO_EXTENSION);
                        if (in_array($CheckFileType, $AllowedFileTypes)) {
                            //move uploaded file to target directory
                            if (move_uploaded_file($_FILES["ImagesUpload"]["tmp_name"][$key], $FilePath)) {
                                // saving uploaded file name
                                $uploadedImagesName .= $FileName.",";
                            } else {
                                $_SESSION["ImagesUploadErr"] ="There is a problem with file uploading";
                                $error++;
                            }
                        } else {
                            $_SESSION["ImagesUploadErr"] ="Invalid File Type";
                            $error++;
                        }
                    }
                }
                if($error==0) {
                    if (!empty($uploadedImagesName)) {
                        $insert = "INSERT INTO blog ( blog_title, blog_category,blog_description, blog_content,blog_img, blog_author, blog_created ,blog_updated)
                VALUES ('$blog_title','$blog_category','$blog_description','$blog_content','$uploadedImagesName','".$uname."',NOW(),NOW())";
                    } else {
                        $insert = "INSERT INTO blog ( blog_title, blog_category,blog_description, blog_content,blog_author, blog_created ,blog_updated)
                VALUES ('$blog_title','$blog_category','$blog_description','$blog_content','" . $uname . "',NOW(),NOW())";
                    }

                    if (mysqli_query($conn, $insert)) {
                        echo "Added Successfully !";
                    }else{
                        echo 'Error: ' . '<br>' . $conn->error;
                    }
                }else{
                    echo "Check Your Input and Try Again!";
                }
            break;

        //return value to edit form
        case "select":
            if (isset($id)) {
                $select_query = "SELECT * FROM `blog` WHERE blog_id = '" . $id . "'";
                if (mysqli_query($conn, $select_query)) {
                    $result = mysqli_query($conn, $select_query);
                    $row = mysqli_fetch_array($result);
                    echo json_encode($row);
                } else {
                    echo 'Error: ' . '<br>' . $conn->error;
                }
            }
            break;

        case "edit":
            $error= 0;
            if (isset($_REQUEST['blog_title'])) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_title'])||empty(trim($_REQUEST['blog_title'])) ){
                    $error++;
    //                $_SESSION['EditBlogTitleErr'] = "Invalid Input";
                }else{
                    $blog_title =filter_var($_REQUEST['blog_title'],FILTER_SANITIZE_STRING);
                    $blog_title =mysqli_escape_string($conn,$_REQUEST['blog_title']);
                }
            }

            if ( !empty(trim($_REQUEST['blog_category']))) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_category']) ||empty(trim($_REQUEST['blog_category'])) ) {
                    $error++;
    //                $_SESSION['EditBlogCategoryErr'] = "Invalid Input";
                }else{
                    $blog_category = filter_var($_REQUEST['blog_category'],FILTER_SANITIZE_STRING);
                    $blog_category = mysqli_escape_string($conn,$_REQUEST['blog_category']);
                }
            }

            if (isset($_REQUEST['blog_description'])) {
                if(preg_match("/^\W+$/", $_REQUEST['blog_description'])||empty(trim($_REQUEST['blog_description'])) ) {
                    $error++;
    //                $_SESSION['EditBlogDescriptionErr'] = "Invalid Input";
                }else{
                    $blog_description = filter_var($_REQUEST['blog_description'],FILTER_SANITIZE_STRING);
                    $blog_description = mysqli_escape_string($conn,$_REQUEST['blog_description']);
                }
            }

            if (isset($_REQUEST['blog_content']))  {
                if(preg_match("/^\W+$/", $_REQUEST['blog_content'])||empty(trim($_REQUEST['blog_content'])) ) {
                    $error++;
    //                $_SESSION['EditBlogContentErr'] = "Invalid Input";
                }else{
                    $blog_content = filter_var($_REQUEST['blog_content'],FILTER_SANITIZE_STRING);
                    $blog_content = mysqli_escape_string($conn,$_REQUEST['blog_content']);
                }
            }

            if(isset($_FILES['files']) && !empty($_FILES['files'])) {
                $uploadedImagesName="";
                // configuration for upload operation
                $AllowedFileTypes = array('png','jpg','gif','jpeg');
                $Directory = "uploads/";
                if(!empty(array_filter($_FILES['files']['name']))) {
                    foreach ($_FILES['files']['name'] as $key => $val) {
                        // path for file upload directory
                        $FileName = basename($_FILES['files']['name'][$key]);
                        $FilePath = $Directory . $FileName;
                        // validating file type
                        $CheckFileType = pathinfo($FilePath, PATHINFO_EXTENSION);
                        if (in_array($CheckFileType, $AllowedFileTypes)) {
                            //move uploaded file to target directory
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $FilePath)) {
                                // saving uploaded file name
                                $uploadedImagesName .= $FileName.",";
                            } else {
                               echo"There Is a Problem With File Uploading";
                                $error++;
                            }
                        } else {
                            echo  "Invalid File Type";

                            $error++;
                        }
                    }
                }
            }

            if($error==0) {
                if(!empty($uploadedImagesName)){
    //                        $insertValuesSQL = trim($insertValuesSQL,',');
                    // Insert image file name into database
                    $update_query = "UPDATE `blog` SET
                        blog_title= '$blog_title',
                        blog_category= '$blog_category',
                        blog_description= '$blog_description',
                        blog_content='$blog_content',
                        blog_img = '$uploadedImagesName',
                        blog_updated = NOW()
                        WHERE 
                        blog_id = '$id'";
                }else{
                    $update_query = "UPDATE `blog` SET
                        blog_title= '$blog_title',
                        blog_category= '$blog_category',
                        blog_description= '$blog_description',
                        blog_content='$blog_content',
                        blog_updated = NOW()
                        WHERE 
                        blog_id = '$id'";
                }

                if (mysqli_query($conn, $update_query)) {
                    echo "Updated Successfully !";
                }
            }else{
                echo "Check Your Input and Try Again!";
            }
            break;


        case "delete":
            if (isset($id)) {
                $delete_blog = "DELETE FROM blog WHERE blog_id = '$id'";
                if(mysqli_query($conn,$delete_blog)){
                    echo " Deleted Successfully !";
                }else{
                    echo 'Error: ' . '<br>' . $conn->error;
                }
            }
            break;
    }

