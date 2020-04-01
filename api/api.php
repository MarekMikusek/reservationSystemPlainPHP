<?php



        $action = $_POST['action'];

        switch($action)
        {
            case 'addReservation':
                error_log('add');
                echo json_encode(addReservation($_POST['reservation']));
            break;
            case 'getReservations':
                echo json_encode(getReservations($_POST['date']));
            break;
        }
function addReservation($reservation){
        $allowedColumns = ['person_id'=>1, 'place_id' => 1, 'start'=>1, 'end'=>1];
        $newData =[];
        foreach($reservation as $key => $value){
            if(isset($allowedColumns[$key])){
                $newData[$key] = "'".strip_tags($value)."'";
            }
        }
        $insertData = [];
        $columns = implode(',', array_keys($newData));
        $values = implode(',', array_values($newData));
        error_log($columns);
        error_log($values);
        $insertStatment ="INSERT INTO reservations (?) VALUES (?)";
        $ret = safeQuery(false, $insertStatment, [$columns, $values]);
        error_log(gettype($ret));
        return $ret;
}
    function getReservations($date){
    
        $ret['reservations'] = safeQuery(true, "SELECT CONCAT(pe.first_name,' ' ,pe.last_name) as fullname, r.start, r.end, pl.name, r.reservation_id " 
        ."FROM reservations r LEFT JOIN persons pe ON pe.person_id = r.person_id LEFT JOIN places pl ON pl.place_id = r.place_id "
        ."WHERE date(r.start) = :date", ['date'=>$date]);
        $ret['users'] = safeQuery(true,"SELECT person_id, CONCAT(first_name,' ' , last_name) AS fullName FROM persons",[]);
        $ret['places'] = safeQuery(true, "SELECT place_id, name FROM places",[]);
        return $ret;
    }

    function safeQuery(bool $fetch, $statement, $data){
        error_log($statement);
        error_log($fetch);
        error_log(implode(';', $data));
        $dbType= 'mysql';
        $dbHost='localhost:3306';
        $dbUser = 'root';
        $dbPassword ='';
        $dbName = 'reservations_mm';
        $dbCharset = 'utf8';
        try{
            $db = new \PDO("{$dbType}:host={$dbHost};dbname={$dbName};charset={$dbCharset}", $dbUser, $dbPassword,  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $stmt = $db->prepare($statement);
            $stmt->execute($data);
        }catch(PDOException $e){
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }
        if($fetch===true){
            error_log('fetch');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            error_log('no fetch');
            return $stmt;
        }
    }

?>

