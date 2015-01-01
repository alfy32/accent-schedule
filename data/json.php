<?php

define(DB_SERVER, $_ENV['OPENSHIFT_MYSQL_DB_HOST']);
define(DB_USER, $_ENV['OPENSHIFT_MYSQL_DB_USERNAME']);
define(DB_PASSWORD, $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']);
define(DB_NAME, $_ENV['OPENSHIFT_APP_NAME']);

header('Content-Type: application/json');

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

if($conn->connect_error) {
    die("<h3>Database Error: $conn->connect_error</h3>");
}


$start = filter_input(INPUT_GET, 'start');

if(!preg_match('/\d{4}-\d{2}-\d{2}/', $start)) {
    $result = array();

    $result['success'] = false;
    $result['error'] = "Invalid start date: $start";

    die(json_encode($result));
}

$end = filter_input(INPUT_GET, 'end');

if(!preg_match('/\d{4}-\d{2}-\d{2}/', $end)) {
    $result = array();

    $result['success'] = false;
    $result['error'] = "Invalid end date: $end";

    die(json_encode($result));
}

if($start > $end) {
    $result = array();

    $result['success'] = false;
    $result['error'] = "Start date must be before the end date: $start !< $end";

    die(json_encode($result));
}

$employee = filter_input(INPUT_GET, 'employee');

if($employee) {
    $employee = " AND firstName = '$employee' ";
} else {
    $employee = '';
}

$result = $conn->query("
    SELECT date, startTime, endTime, client, firstName employee
    FROM appointment
    JOIN employee
    ON appointment.employeeId = employee.id
    WHERE date >= '$start' AND
          date <= '$end'
          $employee

");

$rows = array();

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

$response = array();

$response['success'] = true;
$response['appointments'] = $rows;


print_r(json_encode($response));
