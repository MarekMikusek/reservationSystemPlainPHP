<?php

$action = $_POST['action'];
include('./dbCredentials.inc');

switch ($action) {
    case 'addEquipment':
        echo json_encode(addEquipment((array) $_POST['equipment']));
        break;
    case 'addPerson':
        echo json_encode(addPerson((array) $_POST['person']));
        break;
    case 'addPlace':
        echo json_encode(addPlace((array) $_POST['place']));
        break;
    case 'addReservation':
        echo json_encode(addReservation($_POST['reservation']));
        break;
    case 'getEquipment':
        echo json_encode(getEquipment());
        break;
    case 'getEquipmentPlaces':
        echo json_encode(getEquipmentPlaces($_POST['equipmentId']));
        break;
    case 'getPersons':
        echo json_encode(getPersons());
        break;
    case 'getPlaces':
        echo json_encode(getPlaces());
        break;
    case 'getReservations':
        echo json_encode(getReservations((string) $_POST['date']));
        break;
    case 'removeItem':
        echo json_encode(removeItem((array) $_POST['item']));
        break;
    case 'saveEquipmentNewPlace':
        echo json_encode(saveEquipmentNewPlace((array) $_POST['new_place']));
        break;
}

function addEquipment($equipment) {
    return safeQuery("INSERT INTO equipment (type, model, mark, purchase_year, value, description, place_id) VALUES (:type, :model, :mark, :purchase_year, :value, :description, :place_id)",
            stripTags($equipment), false);
}

function addPerson($person) {
    return safeQuery("INSERT INTO persons (first_name, last_name, phone, email, `description`) VALUES (:first_name, :last_name, :phone, :email, :description)",
            stripTags($person), false);
}

function addPlace($place) {
    return safeQuery("INSERT INTO places (name, description) VALUES (:name, :description)", stripTags($place), false);
}

function addReservation($reservation) {
    $checkCollision = safeQuery("SELECT count(*) FROM reservations WHERE person_id != :person_id AND place_id = :place_id AND ( CAST(:start AS DATETIME) <= end AND CAST(:end AS DATETIME) >= start ) ",
            $reservation, true);
    if ($checkCollision[0]['count(*)'] == 0) {
        safeQuery('INSERT INTO reservations (person_id, place_id, start, end) VALUES (:person_id, :place_id, :start, :end)', stripTags($reservation), false);
        return 1;
    }
    return -1;
}

function getEquipment() {
    $statment = "SELECT equipment_id, type, model, mark, purchase_year, value, e.description, p.name "
            . "FROM `equipment` e LEFT JOIN places p ON p.place_id = e.place_id";
    return ['equipment' => safeQuery($statment, [], true),
        'places' => getPlaces()];
}

function getEquipmentPlaces($equipmentId) {
    return [
        'equipment' => safeQuery("SELECT mark, place_id, equipment_id FROM equipment WHERE equipment_id = :equipment_id", ['equipment_id' => $equipmentId], true),
        'places' => getPlaces()
    ];
}

function getPersons() {
    $statment = "SELECT `person_id`, `first_name`, `last_name`, `phone`, `email`, `description` FROM `persons`";
    return safeQuery($statment, [], true);
}

function getPlaces() {
    $places = safeQuery("SELECT place_id, name, description FROM places", [], true);
    $equipmentList = safeQuery("SELECT equipment_id, place_id, mark FROM equipment", [], true);
    $placesEquipment = [];
    foreach ($equipmentList as $equipment) {
        if (!isset($placesEquipment[$equipment['place_id']])) {
            $placesEquipment[$equipment['place_id']] = [];
        }
        $placesEquipment[$equipment['place_id']][] = $equipment['mark'];
    }
    foreach ($places as &$place) {
        $place['equipment'] = '';
        if (isset($placesEquipment[$place['place_id']])) {
            $place['equipment'] = implode(', ', $placesEquipment[$place['place_id']]);
        }
    }
    return $places;
}

function getReservations($date) {
    $ret['reservations'] = safeQuery("SELECT CONCAT(pe.first_name,' ' ,pe.last_name) as fullname, r.start, r.end, r.place_id, r.reservation_id "
            . "FROM reservations r LEFT JOIN persons pe ON pe.person_id = r.person_id "
            . "WHERE date(r.start) = :date", ['date' => $date], true);
    $ret['persons'] = safeQuery("SELECT person_id, CONCAT(first_name,' ' , last_name) AS fullName FROM persons", [], true);
    $ret['places'] = getPlaces();
    return $ret;
}

function removeItem($item) {
    $tables = ['persons' => 'person_id', 'reservations' => 'reservation_id', 'places' => 'place_id', 'equipment' => 'equipment_id'];
    if (isset($tables[$item['table']])) {
        global $dbCredentials;
        try {
            $id = intval($item['id']);
            $mysqli = new mysqli($dbCredentials['dbHost'], $dbCredentials['dbUser'], $dbCredentials['dbPassword'], $dbCredentials['dbName'], $dbCredentials['dbPort']);
            $mysqli->query("DELETE FROM {$item['table']} WHERE {$tables[$item['table']]} = {$id}");
            return true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    return false;
}

function safeQuery($statement, $data, bool $fetch = false) {
    $text = '';
    foreach ($data as $key => $value) {
        $text .= "key: {$key}, value: {$value};   ";
    }
    global $dbCredentials;

    try {
        $db = new \PDO("{$dbCredentials['dbType']}:host={$dbCredentials['dbHost']};dbname={$dbCredentials['dbName']};charset={$dbCredentials['dbCharset']}", $dbCredentials['dbUser'], $dbCredentials['dbPassword']);
    } catch (PDOException $e) {
        die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
    }
    $stmt = $db->prepare($statement);
    $resp = $stmt->execute($data);

    if ($fetch === true) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return $resp;
    }
}

function saveEquipmentNewPlace($newPlace) {
    return safeQuery("UPDATE equipment SET place_id= :place_id  WHERE equipment_id = :equipment_id", $newPlace, false);
}

function stripTags($array) {
    foreach ($array as $key => &$value) {
        $value = strip_tags($value);
    }
    unset($value);
    return $array;
}

?>
