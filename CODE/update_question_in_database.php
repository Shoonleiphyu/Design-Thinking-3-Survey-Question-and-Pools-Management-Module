<?php
// Include the database connection file
include('connect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data from the POST request
$questionType = mysqli_real_escape_string($conn, $_POST['questionType']);
$questionCategory = mysqli_real_escape_string($conn, $_POST['questionCategory']);
$questionText = mysqli_real_escape_string($conn, $_POST['questionText']);
$answerOptions = isset($_POST['answerOptions']) ? $_POST['answerOptions'] : [];

// Retrieve the questionId from the GET request
$questionId = mysqli_real_escape_string($conn, $_GET['questionId']);

// Convert the answer options array to a comma-separated string
$answerOptionsString = implode(",", $answerOptions);

// Your update query logic goes here
$sql = "UPDATE allquestion_table SET
QUESTION_TEXT = '$questionText',
QUESTION_TYPE = '$questionType',
QUESTION_OPT = '$answerOptionsString',
QUESTION_CAT = '$questionCategory'
WHERE QUESTION_ID = '$questionId'";

echo "SQL Query: $sql";

if ($conn->query($sql) === TRUE) {
    echo "Data updated successfully";
} else {
    if ($conn->errno == 1452) {
        echo "Error: The provided QUESTION_ID does not exist in the database.";
    } else {
        echo "Error updating data: " . $conn->error;
    }
}
}


// Close the database connection
$conn->close();
?>
