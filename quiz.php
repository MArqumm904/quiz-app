<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .quiz-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .question {
            font-size: 18px;
            margin-bottom: 10px;
            color: #444;
            text-align:left;
        }

        .choices {
            list-style: none;
            padding: 0;
            text-align:left;
        }

        .choices li {
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
            font-size: 20px;
            color: #333;
        }
        .code-block {
        margin: 15px 0;
        background: #1e1e1e;
        border-radius: 6px;
        padding: 1px;
        text-align: left;
    }

    .code-block pre {
        margin: 0;
        padding: 15px;
        overflow-x: auto;
    }

    .code-block code {
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.5;
        color: #d4d4d4;
        display: block;
        background: transparent;
    }

    .question {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .choices {
        list-style: none;
        padding: 0;
    }

    .choices li {
        margin: 10px 0;
    }

    .choices label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .choices input[type="radio"] {
        margin: 0;
    }
    </style>
</head>
<body>

    <div class="quiz-container" id="quiz-container">
        <h1>Quiz</h1>
        <div id="intro-screen">
            <input type="text" id="user-name" placeholder="Enter your name" required>
            <button onclick="startQuiz()">Start Quiz</button>
        </div>
        <form id="quiz-form" style="display: none;"></form>
        <button id="next-button" onclick="nextQuestion()" style="display: none;">Next Question</button>
        <div class="result" id="result"></div>
    </div>

    <script>
        let questions = [];
        let currentQuestionIndex = 0;
        let correctAnswers = 0;
        let userName = '';

        // Fetch questions from the JSON file
        fetch('questions.json')
            .then(response => response.json())
            .then(data => {
                questions = data;
            })
            .catch(error => console.error('Error loading questions:', error));

        // Start the quiz after entering the name
        function startQuiz() {
            const nameInput = document.getElementById('user-name');
            userName = nameInput.value.trim();
            if (userName === '') {
                alert('Please enter your name to start the quiz.');
                return;
            }

            // Hide the intro screen and show the first question
            document.getElementById('intro-screen').style.display = 'none';
            displayQuestion();
            document.getElementById('quiz-form').style.display = 'block';
            document.getElementById('next-button').style.display = 'block';
        }

        // Display the current question
        function displayQuestion() {
    const form = document.getElementById('quiz-form');
    const question = questions[currentQuestionIndex];

    // Split question text and code if exists
    let questionHtml = `<div class="question">${currentQuestionIndex + 1}. ${question.question}</div>`;
    
    // Add code block if exists
    if (question.code) {
        questionHtml += `
            <div class="code-block">
                <pre><code>${escapeHtml(question.code)}</code></pre>
            </div>
        `;
    }

    // Add choices
    questionHtml += `
        <ul class="choices">
            ${question.choices
                .filter(choice => choice !== null && choice.trim() !== '')
                .map((choice, i) => `
                    <li>
                        <label>
                            <input type="radio" name="question${currentQuestionIndex}" value="${escapeHtml(choice)}" required>
                            ${escapeHtml(choice)}
                        </label>
                    </li>
                `).join('')}
        </ul>
    `;

    form.innerHTML = questionHtml;

    // Update the button text based on the current question
    const nextButton = document.getElementById('next-button');
    nextButton.innerText = (currentQuestionIndex === questions.length - 1) ? 'Submit Quiz' : 'Next Question';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}


        // Move to the next question or show the result
        function nextQuestion() {
            const selectedOption = document.querySelector(`input[name="question${currentQuestionIndex}"]:checked`);
            
            // Check if the user selected an answer
            if (!selectedOption) {
                alert('Please select an answer before proceeding.');
                return;
            }

            // Check if the answer is correct
            if (selectedOption.value === questions[currentQuestionIndex].correct_answer) {
                correctAnswers++;
            }

            // Move to the next question or show the result if it's the last question
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                displayQuestion();
            } else {
                showResult();
            }
        }

        // Display the final result
        function showResult() {
            const totalQuestions = questions.length;
            const scorePercentage = (correctAnswers / totalQuestions) * 100;

            document.getElementById('quiz-form').style.display = 'none';
            document.getElementById('next-button').style.display = 'none';

            document.getElementById('result').innerHTML = `
                <div>
                    ${userName}, you scored ${correctAnswers} out of ${totalQuestions} (${scorePercentage.toFixed(2)}%).
                </div>
                <button onclick="restartQuiz()">Start Again</button>
            `;
        }

        // Restart the quiz
        function restartQuiz() {
            currentQuestionIndex = 0;
            correctAnswers = 0;
            userName = '';
            
            // Show the intro screen again
            document.getElementById('intro-screen').style.display = 'block';
            document.getElementById('quiz-form').style.display = 'none';
            document.getElementById('result').innerHTML = '';
            document.getElementById('next-button').style.display = 'none';
            document.getElementById('user-name').value = '';
        }
    </script>

</body>
</html>
