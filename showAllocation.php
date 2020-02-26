<?php
    require "session.php";
    require "utility.php";
    require "AssignRepository.php";

    checkEntity(array("admin"));
    
    try {
        $assignRepo = new AssignRepository();
        $result = $assignRepo->getAllocation();
    }
    catch(Exception $ex) {
        $errorMessage = array();
        $errorMessage = $ex->getMessage();
    }    
?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Allocation", array("bootstrap.min.css", "jquery.dataTables.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row pt-3">
                <div class="col-md-12 col-sm-12 col-xs-12">                   
                    <h3 class="text-center">Allocation Table</h3>
                    <hr />
                    <?php
                        if(!empty($errorMessage)){
                            Utility::loadError($errorMessage);
                        }
                    ?>
                    <table id="allocation_table" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Student Email</th>
                                <th>Tutor Email</th>
                                <th>Date Allocated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($result)){
                                    if(count($result) > 0){
                                        foreach($result as $value) {
                                            echo "<tr>";
                                            echo "<td>" . $value['studentEmail'] . "</td>";
                                            echo "<td>" . $value['tutorEmail'] . "</td>";
                                            echo "<td>" . $value['dateAssigned'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                            ?>    
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Student Email</td>
                                <td>Tutor Email</td>
                                <td>Date Allocated</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js", "jquery.dataTables.min.js", 'dataTables.buttons.min.js', 'buttons.html5.min.js')); ?>
        <script type="text/javascript">
            $(document).ready(
                function(){
                    $("#allocation_table").dataTable({
                        "scrollX": true,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        dom: 'Bfrtip',
                        buttons: [                    
                            { extend: 'csvHtml5' },
                            { extend: 'excelHtml5' },
                            { extend: 'pageLength' },                        ]
                    });
                }
            );
        </script>                                    
        <?php Utility::loadFooter(); ?>
    </body>
</html>
