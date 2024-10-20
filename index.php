<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz Questions</title>
    <link rel="icon" href="assets/logo.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            color: #333;
        }
        h1{
            display: inline;
        }

        .login-container {
            display: none;
        }

        .error {
            color: red;
            text-align: center;
        }

        .delete-icon {
            color: #f44336;
            cursor: pointer;
            margin-left: 10px;
            font-size: 20px;
            vertical-align: middle;
        }

        .delete-icon:hover {
            color: #d32f2f;
        }
        .btnn{
            color: white;
            background-color: #d32f2f;
            width: 200px;
            height: 40px;
            display: inline;
            &:hover{
                background-color: #d94f2f;
            }
        }
        .hea{
            text-align: center;
            display: flex;
            justify-content: space-around;
            align-items: center;
            
        }
        .code-section {
            display: none;
            margin-top: 20px;
        }

        .toggle-container {
            display: flex;
            align-items: center;
            margin: 15px 0;
            gap: 10px;
        }

        /* Toggle button styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        textarea.code-input {
            width: 100%;
            min-height: 200px;
            font-family: monospace;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }
        .code-block {
        margin: 15px 0;
        background: #1e1e1e;
        border-radius: 6px;
        padding: 1px;
        position: relative;
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

    .question-container {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .question-title {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .choices-list {
        margin: 10px 0;
        color: #555;
    }

    .correct-answer {
        color: #2196F3;
        font-weight: 500;
    }
    </style>
    <!-- Font Awesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="container login-container" id="login-container">
    <h1>Login</h1>
    <form id="login-form">
        <label>Username:</label>
        <input type="text" id="username" required>

        <label>Password:</label>
        <input type="password" id="password" required>

        <button type="submit">Login</button>
        <p class="error" id="error-message"></p>
    </form>
</div>

<div class="container" id="quiz-container" style="display: none;">
    <div class="hea">
        <h1>Add a Question</h1>
        <button class="btnn" onclick="logout()">Logout</button>
    </div>
    <form action="save.php" method="POST">
        <label>Question:</label>
        <input type="text" name="question" required>

        <div class="toggle-container">
            <label>Include Code?</label>
            <label class="switch">
                <input type="checkbox" id="codeToggle" onchange="toggleCodeSection()">
                <span class="slider"></span>
            </label>
        </div>

        <div id="codeSection" class="code-section">
            <label>Code:</label>
            <textarea name="code" class="code-input" id="codeInput"></textarea>
        </div>

        <label>Choice 1:</label>
        <input type="text" name="choices[]" required>

        <label>Choice 2:</label>
        <input type="text" name="choices[]" required>

        <label>Choice 3:</label>
        <input type="text" name="choices[]" >

        <label>Choice 4:</label>
        <input type="text" name="choices[]" >

        <label>Correct Answer:</label>
        <input type="text" name="correct_answer" required>

        <button type="submit">Save</button>
    </form>

    <h2>Current Questions</h2>
    <div id="questions-list">
        <?php
        $jsonData = file_get_contents('questions.json');
        $questions = json_decode($jsonData, true);

        if (!empty($questions)) {
            foreach ($questions as $index => $q) {
                echo "<div class='question-container' id='question-$index'>";
                
                // Question title with delete icon
                echo "<div class='question-title'>";
                echo "<span><b>Question " . ($index + 1) . ":</b> " . htmlspecialchars($q['question']) . "</span>";
                echo "<i class='fas fa-trash-alt delete-icon' onclick='deleteQuestion($index)'></i>";
                echo "</div>";
                
                // Code block if exists
                if (!empty($q['code'])) {
                    echo "<div class='code-block'>";
                    echo "<pre><code>" . htmlspecialchars($q['code']) . "</code></pre>";
                    echo "</div>";
                }
                
                // Choices
                echo "<div class='choices-list'>";
                echo "<b>Choices:</b> " . implode(", ", $q['choices']);
                echo "</div>";
                
                // Correct Answer
                echo "<div class='correct-answer'>";
                echo "<b>Correct Answer:</b> " . htmlspecialchars($q['correct_answer']);
                echo "</div>";
                
                echo "</div>"; // End question-container
            }
        } else {
            echo "<p>No questions added yet!</p>";
        }
        ?>
    </div>
</div>

<script>
   const loginForm = document.getElementById('login-form');
    const loginContainer = document.getElementById('login-container');
    const quizContainer = document.getElementById('quiz-container');
    const errorMessage = document.getElementById('error-message');

    // Hardcoded credentials
    const correctUsername = 'admin';
    const correctPassword = 'admin';

    // Check session storage on page load
    window.onload = function() {
        const isLoggedIn = sessionStorage.getItem('isLoggedIn');
        
        if (isLoggedIn === 'true') {
            // User is already logged in
            loginContainer.style.display = 'none';
            quizContainer.style.display = 'block';
        } else {
            // User needs to login
            loginContainer.style.display = 'block';
            quizContainer.style.display = 'none';
        }
    };

    // Handle login form submission
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (username === correctUsername && password === correctPassword) {
            // Store login state in session storage
            sessionStorage.setItem('isLoggedIn', 'true');
            
            loginContainer.style.display = 'none';
            quizContainer.style.display = 'block';
        } else {
            errorMessage.textContent = 'Invalid credentials. Please try again.';
        }
    });

    // Add logout functionality
    function logout() {
        sessionStorage.removeItem('isLoggedIn');
        loginContainer.style.display = 'block';
        quizContainer.style.display = 'none';
    }

    // Function to delete a question
    function deleteQuestion(index) {
        if (confirm('Are you sure you want to delete this question?')) {
            fetch('delete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`question-${index}`).remove();
                } else {
                    alert('Error deleting question. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    function toggleCodeSection() {
        const codeSection = document.getElementById('codeSection');
        const codeToggle = document.getElementById('codeToggle');
        codeSection.style.display = codeToggle.checked ? 'block' : 'none';
    }
</script>

</body>
</html>
