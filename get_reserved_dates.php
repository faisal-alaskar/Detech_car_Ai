<?php
include 'db.php';

$car_id = $_GET['car_id'];
$query = $conn->prepare("SELECT reservation_date, return_date FROM reservations WHERE car_id = ?");
$query->bind_param("i", $car_id);
$query->execute();
$result = $query->get_result();

$reserved_dates = [];
while ($row = $result->fetch_assoc()) {
    $start = new DateTime($row['reservation_date']);
    $end = new DateTime($row['return_date']);

    while ($start <= $end) {
        $reserved_dates[] = $start->format('Y-m-d');
        $start->modify('+1 day');
    }
}
echo json_encode($reserved_dates);
?>
