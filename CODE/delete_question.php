<?php
// delete_question.php

// Include your database connection logic
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the questionId from the POST request
    $questionId = mysqli_real_escape_string($conn, $_POST['questionId']);

    // Perform the deletion in your database
    $sql = "DELETE FROM allquestion_table WHERE QUESTION_ID = '$questionId'";

    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        $response = "Question deleted successfully.";
        echo $response;
    } else {
        // Error in deletion
        $response = "Error deleting question: " . mysqli_error($conn);
        echo $response;
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    http_response_code(400);
    echo "Invalid request method";
}
?>
