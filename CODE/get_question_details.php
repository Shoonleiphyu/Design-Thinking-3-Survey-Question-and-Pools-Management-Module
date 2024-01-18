<?php
// Include the database connection file
include('connect.php');

if (isset($_GET['questionText'])) {
    $questionText = mysqli_real_escape_string($conn, $_GET['questionText']);

    // Your database query logic goes here
    $sql = "SELECT * FROM allquestion_table WHERE QUESTION_TEXT = '$questionText'";
    $result = $conn->query($sql);

    // Fetch result and store it in an array
    $questionDetails = array();
    if ($row = $result->fetch_assoc()) {
        $questionDetails['questionId'] = $row['QUESTION_ID'];
        $questionDetails['questionType'] = $row['QUESTION_TYPE'];
        $questionDetails['questionCategory'] = $row['QUESTION_CAT'];
        $questionDetails['questionText'] = $row['QUESTION_TEXT'];

        // Fetch answer options from the QUESTION_OPT column
        $answerOptions = explode(',', $row['QUESTION_OPT']);
        $questionDetails['answerOptions'] = $answerOptions;
    }

    // Send the result back to the JavaScript function
    echo json_encode($questionDetails);
}

// Close the database connection
$conn->close();
?>
