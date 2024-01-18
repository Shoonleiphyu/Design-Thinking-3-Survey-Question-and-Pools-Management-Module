<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <title>Survey Questions and Pool Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Kreon;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            background-color: #eaeaea;
        }

        .container {
            display: flex;
            width: 95%;
            margin-top: 20px;
        }

        .left-panel,
        .right-panel {
            flex: 1;
            margin: 10px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .left-panel {
            background-color: #fff;
            color: #333;
        }

        .right-panel {
            background-color: #fff;
            color: #333;
        }

        input,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #fff;
        }

        button {
            display: inline-block;
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .pushBtncontainer{
            float: left;
        }

        .editBtncontainer{
            float: right;
        }
        
        button.create {
            background-color: #5cb85c;
            color: white;
            border: none;
        }

        button.add {
            background-color: #ffa500;
            color: white;
            border: none;
        }
        button.modify {
            background-color: #337ab7;
            color: white;
            border: none;
        }
        button.delete {
            background-color: #FF0000;
            color: white;
            border: none;
        }


        button.create:hover {
            background-color: #4cae4c;
        }

        button.add:hover {
            background-color: #ed9121;
        }
        button.modify:hover {
            background-color: #286090;
        }
        button.delete:hover {
            background-color: #C41E3A;
        }

        .answer-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .answer-option input[type="checkbox"] {
            margin-right: 10px;
        }

        .num-answer-choices {
            display: block;
        }

        .num-answer-choices.hide {
            display: none;
        }
        .search-container {
            position: relative;
        }
        .clear-icon {
            position: absolute;
            color: #5a5a5a;
            top: 35%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            display: none; /* Initially hide the clear button */
        }

        /* Show the clear button when the search input is not empty */
        #search:not(:placeholder-shown) + .clear-icon {
            display: block;
        }

        .search-results-list {
            color: #333;
            background-color: white;
        list-style-type: none;
        padding: 0;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
        max-height: 150px;
        overflow-y: auto;
        width: calc(100% - 22px); /* Adjust for padding and borders */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .resultItem {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .resultItem:hover {
        background-color: #5a5a5a;
    }

    .hovered {
        background-color: #5a5a5a;
    }
    </style>
</head>

<body>
    <main class="container">
        <section class="left-panel">
            <h2>Search Questions</h2>
            <form id="searchForm">
                <div class="search-container">
                    <input type="text" id="search" name="search" autocomplete="off">
                    <span id="clearSearch" class="clear-icon">&times;</span>
                </div>
                <div id="searchResults"></div>
            </form>
            <br>

            <h2>Create Questions</h2>

            <form id="createQuestionForm">
                <select id="questionType" onchange="changeAnswerInputType()">
                    <option value="" disabled selected>Question Types</option>
                    <option value="text">Text</option>
                    <option value="multipleChoice">Multiple Choice</option>
                    <option value="scaleRating">Scale Rating</option>
                    <option value="checkbox">Checkbox</option>
                </select>
                
                <!-- This hidden input field will store the questionId -->
                <input type="hidden" id="questionId" name="questionId" value="">

                <input type="text" placeholder="Type Question Category" name="questionCategory">
                <input type="text" placeholder="Type your Question" name="questionText">

                <label id="answerLabel" for="numAnswerChoices" class="num-answer-choices">Number of Answer Choices</label>
                <input type="number" id="numAnswerChoices" min="1" placeholder="Enter number of choices" oninput="updateAnswerChoices()" class="num-answer-choices">
                <div id="answerContainer">
                    <!-- Answer options will be dynamically added here -->
                </div>
                
                <div class="pushBtncontainer">
                    <button class="create" onclick="createQuestion(event)">Create</button>
                    <button class="add" onclick="addQuestion(event)">Add</button>
                </div>

                <div class="editBtncontainer">
                    <!-- Add the following button after the search bar -->
                    <button class="modify" onclick="modifySelectedQuestion()">Modify</button>
                    <button class="delete" onclick="deleteSelectedQuestion()">Delete</button>
                </div>
            </form>
        </section>


        <section class="right-panel">
            <h2>Survey</h2>
            <div id="surveyQuestions">
                <!-- Dynamically added questions will go here -->
            </div>
        </section>
    </main>

    <script>
        $(document).ready(function() {
        $('#search').on('input', function() {
            var searchInput = $(this).val();

            if (searchInput.length >= 1) {
                // Call a function to send an AJAX request to the server with the search input
                // and update the searchResults div with the response.
                $.ajax({
                    type: 'GET',
                    url: 'search.php',
                    data: { search: searchInput },
                    success: function(data) {
                        // Update the search results
                        updateSearchResults(JSON.parse(data));
                    },
                    error: function() {
                        console.error('Error in AJAX request');
                    }
                });
            } else {
                // Clear the search results if the input is empty
                $('#searchResults').empty();
            }
        });

        $('#clearSearch').on('click', function() {
        $('#search').val('').focus();
        $('#searchResults').empty();
        });

        function updateSearchResults(results) {
            var resultsContainer = $('#searchResults');
            resultsContainer.empty();

            // Display each result as a list item
            var resultList = $('<ul class="search-results-list"></ul>');
            for (var i = 0; i < results.length; i++) {
                var resultItem = $('<li class="resultItem">' + results[i] + '</li>');
                resultList.append(resultItem);
            }

            // Append the list to the container
            resultsContainer.append(resultList);

            // Add hover effect for list items
            resultList.on('mouseenter', 'li', function() {
                $(this).addClass('hovered');
            }).on('mouseleave', 'li', function() {
                $(this).removeClass('hovered');
            });

            // Add click event handler for result items
            resultList.on('click', 'li', function() {
                var selectedResult = $(this).text();
                selectResult(selectedResult);

            // Append a delete button to the selected result
            var deleteButton = $('<button class="deleteButton">Delete</button>');
            deleteButton.data('question-id', questionDetails.questionId);
            $(this).append(deleteButton);
            });
        }

        function selectResult(selectedResult) {
    // Fetch the details of the selected question
    $.ajax({
        type: 'GET',
        url: 'get_question_details.php',
        data: { questionText: selectedResult },
        success: function (data) {
            var questionDetails = JSON.parse(data);
            $("#questionId").val(questionDetails.questionId);
        // Populate the form fields with the loaded question details
        $("#questionType").val(questionDetails.questionType);
        $("input[name='questionCategory']").val(questionDetails.questionCategory);
        $("input[name='questionText']").val(questionDetails.questionText);

        // Update the number of answer choices and answer options
        $("#numAnswerChoices").val(questionDetails.answerOptions.length);
        updateAnswerChoices(); // Trigger the function to generate answer options based on the updated number

        // Populate the answer options in the form
        $(".answerOptionInput").each(function(index, element) {
            $(element).val(questionDetails.answerOptions[index]);
        });

        // Ensure that the selected questionText is set in the search input
        $("#search").val(selectedResult);
    },
    error: function(error) {
        console.error('Error in AJAX request:', error);
    }
});
}

    function populateForm(questionDetails) {
        // Populate the form fields based on the fetched data
        $("#questionType").val(questionDetails.questionType);
        $("input[name='questionCategory']").val(questionDetails.questionCategory);
        $("input[name='questionText']").val(questionDetails.questionText);
        $("#numAnswerChoices").val(questionDetails.numAnswerChoices);

        // Clear previous answer options
        $("#answerContainer").empty();

        // Populate answer options if available
        if (questionDetails.answerOptions) {
            questionDetails.answerOptions.forEach(function (option, index) {
                var optionContainer = $("<div class='answerOption'></div>");
                var input = $("<input type='text' class='answerOptionInput' placeholder='Option " + (index + 1) + "'>").val(option);
                optionContainer.append(input);
                $("#answerContainer").append(optionContainer);
            });
        }
    }
});

        function changeAnswerInputType() {
            var questionType = document.getElementById("questionType").value;
            var answerContainer = document.getElementById("answerContainer");
            var answerLabel = document.getElementById("answerLabel");
            var numAnswerChoicesInput = document.getElementById("numAnswerChoices");
    
            // Clear previous answer options
            answerContainer.innerHTML = "";

            // Change label and input type based on the selected question type
            if (questionType === "multipleChoice" || questionType === "scaleRating" || questionType === "checkbox") {
                answerLabel.textContent = "Number of Answer Choices";
                numAnswerChoicesInput.classList.remove("hide");
            } else if (questionType === "text") {
                answerLabel.textContent = ""; // Remove the label
                numAnswerChoicesInput.classList.add("hide");
            }
    
            // If "Multiple Choice," "Scale," or "Checkbox" is selected, add answer options with checkboxes
            if (questionType === "multipleChoice" || questionType === "scaleRating" || questionType === "checkbox") {
                var numAnswerChoices = document.getElementById("numAnswerChoices").value;
                numAnswerChoices = parseInt(numAnswerChoices) || 1; // Ensure it's a positive integer
    
                for (var i = 1; i <= numAnswerChoices; i++) {
                    var optionContainer = document.createElement("div");
                    optionContainer.className = "answerOption";
    
                    var input = document.createElement("input");
                    input.type = "text";
                    input.placeholder = "Option " + i;
                    input.className = "answerOptionInput"
    
                    optionContainer.appendChild(input);
    
                    answerContainer.appendChild(optionContainer);
                }
            } 
        }
    
    function updateAnswerChoices() {
        // Call the changeAnswerInputType function to update answer choices
        changeAnswerInputType();
        }
        
    function createQuestion() {
        event.preventDefault();
        console.log("Create button clicked!");

        // Collect data from the form including answer options
        var formData = {
            questionType: $("#questionType").val(),
            questionCategory: $("input[name='questionCategory']").val(),
            questionText: $("input[name='questionText']").val(),
            numAnswerChoices: $("#numAnswerChoices").val(),
            answerOptions: getAnswerOptions()
        };

        // Log the form data to the console for debugging
        console.log('Form Data:', formData);

        // Make an AJAX request to the server to save the data
        $.ajax({
            type: 'POST',
            url: 'submit_question_to_database.php',
            data: formData,
            success: function(response) {
            // Handle the response from the server (e.g., display a success message)
            console.log('Data saved successfully:', response);

            // Display a success message to the user
            alert('Question created successfully!');

        },
        error: function(error) {
            // Handle the error (e.g., display an error message)
            console.error('Error in AJAX request:', error);
        }
        });
    }

    // Helper function to get answer options from the answerContainer
    function getAnswerOptions() {
        var answerOptions = [];
        $(".answerOptionInput").each(function() {
            answerOptions.push($(this).val());
        });

        return answerOptions;
    }
    
    function addQuestion() {
        event.preventDefault();
    var questionType = document.getElementById("questionType").value;
    var questionText = document.querySelector(".left-panel input[name='questionText']").value.trim();
    var numAnswerChoices = document.getElementById("numAnswerChoices").value;

    // Check if the question text is non-empty
    if (questionText !== "") {
        var questionElement = document.createElement("div");
        questionElement.className = "question";
        questionElement.innerHTML = "<h3>" + questionText + "</h3>";

        if (questionType === "multipleChoice" || questionType === "scaleRating" || questionType === "checkbox") {
            // If the question type allows multiple choices, create options
            numAnswerChoices = parseInt(numAnswerChoices) || 1;

            for (var i = 1; i <= numAnswerChoices; i++) {
                var optionText = document.querySelector(".answerOptionInput[placeholder='Option " + i + "']").value;
                if (optionText !== "") {
                    var optionElement = document.createElement("div");
                    optionElement.textContent = optionText;
                    questionElement.appendChild(optionElement);
                }
            }
        }

        // Append the question element to the survey section
        document.getElementById("surveyQuestions").appendChild(questionElement);

        // Clear the input fields after creating the question
        document.querySelector(".left-panel input[name='questionText']").value = "";
        document.querySelectorAll(".answerOptionInput").forEach(function(input) {
    input.value = "";
});

    }
}

function addQuestionToSurvey() {
    // Function to add the last created question to the survey section
    addQuestion();
}

function modifySelectedQuestion() {
    console.log('questionId:', $("#questionId").val());

    // Collect data from the form including answer options
    var formData = {
        //questionId: $("#questionId").val(),
        questionType: $("#questionType").val(),
        questionCategory: $("input[name='questionCategory']").val(),
        questionText: $("input[name='questionText']").val(),
        numAnswerChoices: $("#numAnswerChoices").val(),
        answerOptions: getAnswerOptions()
    };

    // Get the questionId from the hidden input field
    var questionId = $("#questionId").val();

    // Log the form data to the console for debugging
    console.log('Form Data:', formData);

    // Make an AJAX request to the server to update the data
    $.ajax({
        type: 'POST',
        //url: 'update_question_in_database.php', // Adjust the URL to your server endpoint
        url: 'update_question_in_database.php?questionId=' + questionId,
        data: formData,
        success: function(response) {
            // Handle the response from the server (e.g., display a success message)
            console.log('Data updated successfully:', response);

            // Display a success message to the user
            alert('Question updated successfully!');
        },
        error: function(error) {
            // Handle the error (e.g., display an error message)
            console.error('Error in AJAX request:', error.responseText);
        }
    });
}

function deleteSelectedQuestion() {
    var questionIdToDelete = $("#questionId").val();

    if (questionIdToDelete) {
        // Show a confirmation dialog before proceeding
        if (confirm("Are you sure you want to delete this question?")) {
            // User clicked OK in the confirmation dialog
            deleteQuestion(questionIdToDelete);
        } else {
            // User clicked Cancel in the confirmation dialog
            console.log("Deletion canceled by user.");
        }
    } else {
        console.error("No question selected to delete.");
        // Optionally, you can provide feedback to the user that no question is selected.
    }
}

// Function to delete the question
function deleteQuestion(questionId) {
    // Make an AJAX request to the server to delete the question
    $.ajax({
        type: 'POST',
        url: 'delete_question.php', // Adjust the URL to your server endpoint
        data: { questionId: questionId },
        success: function(response) {
            // Handle the response from the server (e.g., display a success message)
            console.log('Question deleted successfully:', response);

            // Show a success message to the user
            alert('Question deleted successfully!');

            // Optionally, update the search results after deletion
            updateSearchResults(); // You need to implement this function
        },
        error: function(error) {
            // Handle the error (e.g., display an error message)
            console.error('Error in AJAX request:', error);

            // Show an error message to the user
            alert('Error deleting question. Please try again.');
        }
    });
}



    </script>
    
</body>

</html>
