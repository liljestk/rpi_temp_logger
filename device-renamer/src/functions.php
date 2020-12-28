<?php 
require_once("db.php");

$newId = $link->real_escape_string($_POST['new_id']);
$oldId = $link->real_escape_string($_POST['old_id']);

$sql = "UPDATE device SET device_name = ? WHERE device_name = ?";

$stmt = $link->prepare($sql);
$stmt->bind_param("ss", $newId, $oldId);

if ( !$stmt->execute() ) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    mysqli_close($link);
} else {
    mysqli_close($link);
    echo "Device id/name updated.";
}
?>