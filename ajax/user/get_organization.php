<?php
if (logged_in()) {
    $sql = " SELECT * FROM giftbox.organization WHERE id = (SELECT organization_id FROM giftbox.user WHERE id = ".$_SESSION['user_id'].");";
    $results = execute_query($sql);
    $response = $results->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($response);
}
