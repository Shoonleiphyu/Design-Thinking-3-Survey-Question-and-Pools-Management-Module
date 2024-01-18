<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'connect.php';

// Check if the form data is received through POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log received data to help with debugging
    error_log('Received POST request with data: ' . print_r($_POST, true));

    // Get data from the POST request
    $questionType = $_POST['questionType'];
    $questionCategory = $_POST['questionCategory'];
    $questionText = $_POST['questionText'];
    $numAnswerChoices = $_POST['numAnswerChoices'];

    // Get answer options from answer container and concatenate with commas
    $options = '';

    // Check if the question type is not 'text' before processing answer options
    if ($questionType !== 'text') {
        // Get answer options from the JavaScript object
        $options = implode(",", $_POST['answerOptions']);
    }


    // Add additional validation if necessary

    // Insert data into the database
    $sql = "INSERT INTO allquestion_table (QUESTION_TEXT, QUESTION_TYPE, QUESTION_OPT, QUESTION_CAT) 
            VALUES ('$questionText', '$questionType', '$options', '$questionCategory')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully";
    } else {
        // Log the error or handle it appropriately
        error_log("Error: " . $sql . "\n" . $conn->error);
        error_log("Received POST request.");
        echo "An error occurred while saving data. Please try again later.";
    }
} else {
    // If the request method is not POST, display an error
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
?>
