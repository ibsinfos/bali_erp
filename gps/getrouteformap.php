<?php
    include 'dbconnect.php';
    
    $sessionid   = isset($_GET['sessionid']) ? $_GET['sessionid'] : '0';

    switch ($dbType) {
        case DB_MYSQL:
            $stmt = $pdo->prepare('CALL prcGetRouteForMap(:sessionID)');     
            break;
        case DB_POSTGRESQL:
        case DB_SQLITE3:
            $stmt = $pdo->prepare("select * from v_GetRouteForMap where sessionID = :sessionID");
            break;
    }

    $stmt->execute(array(':sessionID' => $sessionid));

    @session_start();
    $parent_id = $_SESSION['parent_id'];
    if($parent_id!=0){
        $con=mysqli_connect("localhost",$dbuser,$dbpass,$dbname);

        $sql = "select b.bus_unique_key from bus as b left join student_bus_allocation as sba ON sba.bus_id = b. bus_id left join student as s ON s.student_id = sba.student_id WHERE s.parent_id = ".$parent_id;

        $query = mysqli_query($con, $sql);

        $MyChildBus = array();

        while ($rows = mysqli_fetch_array($query)) {
           $MyChildBus[] = str_replace(' ', '-', strtolower(trim($rows['bus_unique_key'])));
        }

        $json = '{ "locations": [';
        foreach ($stmt as $row) {

            $jsonStr=$row['json'];
            $jsonStrArr=json_decode($jsonStr);
            $BusNo = strtolower(trim($jsonStrArr->userName));
            
            if(in_array($BusNo, $MyChildBus)){            
                $json .= $row['json'];
                $json .= ',';    
            }
        }
       
        $json = rtrim($json, ",");
        $json .= '] }';
    }else{
    
        $json = '{ "locations": [';

        foreach ($stmt as $row) {
            $json .= $row['json'];
            $json .= ',';
        }

        $json = rtrim($json, ",");
        $json .= '] }';
    }

    header('Content-Type: application/json');
    echo $json;

?>