<?php
// Include the database connection file
include('connect.php');

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);

    // Your database query logic goes here
    $sql = "SELECT DISTINCT QUESTION_TEXT FROM allquestion_table WHERE QUESTION_TEXT LIKE '%$searchTerm%' OR QUESTION_CAT LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch results and store them in an array
        $results = array();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row['QUESTION_TEXT'];
        }

        // Send the results back to the JavaScript function
        echo json_encode($results);
    } else {
        // Handle the case where the query fails
        echo json_encode(array('error' => 'Query failed'));
    }
}
// Close the database connection
$conn->close();
?>
