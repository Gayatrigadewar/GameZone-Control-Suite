<?php
include('conf/config.php');

// Fetch all systems from the database
$query = "SELECT * FROM iB_systems";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Display systems in a table
echo '<table id="example1" class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>System Name</th>
                <th>Price per Hour</th>
                <th>Price per Minute</th>
                <th>Room No.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

$cnt = 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>
            <td>' . $cnt . '</td>
            <td>' . $row['system_name'] . '</td>
            <td>' . $row['price_per_hour'] . '</td>
            <td>' . $row['price_per_minute'] . '</td>
            <td>' . $row['room_no'] . '</td>
            <td>
                <input type="checkbox" class="toggle-status" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" ';

    // Check if 'status' key exists in the $row array
    if (isset($row['status'])) {
        echo $row['status'] == 1 ? 'checked' : '';
        echo ' data-system-id="' . $row['system_id'] . '" data-system-status="' . $row['status'] . '" ';
    }

    echo '>
            </td>
          </tr>';
    $cnt++;
}

echo '</tbody>
      </table>';
?>
