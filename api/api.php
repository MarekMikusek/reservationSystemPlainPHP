<?php

        error_log('readty');
        
        $action = $_POST['action'];
        switch($action)
        {
            case 'getReservations':
                echo json_encode(getReservations($_POST['date']));
            break;
        }

    function getReservations($dateRaw){
        $dateArray = explode('-',$dateRaw);
        if(count($dateArray)==3 && checkdate($dateArray[1], $dateArray[2], $dateArray[0])){
            return query("SELECT CONCAT(pe.first_name,' ' ,pe.last_name), r.start, r.end, pl.name " 
            ."FROM reservations r NATURAL JOIN persons pe LEFT JOIN places pl ON pl.place_id = r.place_id WHERE date(r.start) = '{$dateRaw}'");
        }else{
            return [];
        }
    }

    function query($query){
        $mysqlHost='http://localhost:3306';
        $mysqlUser = 'root';
        $mysqlPassword ='';
        $mysqlDbName = 'reservations_mm';
        $mySqlConn = new mysqli('localhost', $mysqlUser, $mysqlPassword, $mysqlDbName);
        $result = $mySqlConn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
?>

