<?php
require_once '_db.php';

$stmt = $db->prepare('SELECT * FROM events WHERE NOT ((end <= :start) OR (start >= :end))');

$stmt->bindParam(':start', $_GET['start']);
$stmt->bindParam(':end', $_GET['end']);

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['id'];
  $e->text = $row['name'];
  $e->start = $row['start'];
  $e->end = $row['end'];
  $events[] = $e;
}

header('Content-Type: application/json');
//pr($events);die('qwe');
echo ('[{"id":"2","text":"Event","start":"2018-09-23T10:00:00","end":"2018-09-23T10:30:00"},{"id":"3","text":"ccrrrcrcrcrc","start":"2018-09-23T10:00:00","end":"2018-09-23T10:30:00"},{"id":"4","text":"Eventrvrevrevrevevrevevrev","start":"2018-09-23T10:00:00","end":"2018-09-23T10:30:00"},{"id":"5","text":"fgdfgdgfgdf","start":"2018-09-28T12:00:00","end":"2018-09-28T15:00:00"},{"id":"6","text":"Event","start":"2018-09-24T10:00:00","end":"2018-09-24T10:30:00"},{"id":"7","text":"Event","start":"2018-09-24T13:30:00","end":"2018-09-24T14:00:00"},{"id":"8","text":"Event","start":"2018-09-23T16:00:00","end":"2018-09-23T16:30:00"},{"id":"9","text":"Avalable","start":"2018-09-24T16:00:00","end":"2018-09-24T16:30:00"},{"id":"10","text":"Avalable","start":"2018-09-24T14:00:00","end":"2018-09-24T14:30:00"},{"id":"11","text":"Avalable","start":"2018-09-25T11:00:00","end":"2018-09-25T11:30:00"}]');
//die('Qws');
?>
