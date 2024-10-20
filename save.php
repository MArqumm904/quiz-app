<?php
$jsonFile = 'questions.json';
$jsonData = file_get_contents($jsonFile);
$questions = json_decode($jsonData, true) ?? [];

$question = $_POST['question'];
$choices = $_POST['choices'];  
$correct_answer = $_POST['correct_answer'];
$code = isset($_POST['code']) ? trim($_POST['code']) : '';  

$filteredChoices = array_filter(array_map('trim', $choices), function($choice) {
    return !empty($choice);
});

if (!empty($filteredChoices)) {
    $newQuestion = [
        'question' => $question,
        'choices' => array_values($filteredChoices),  
        'correct_answer' => $correct_answer
    ];

    if (!empty($code)) {
        $newQuestion['code'] = $code;
    }

    $questions[] = $newQuestion;

    // Save the updated list back to the JSON file with proper formatting
    file_put_contents($jsonFile, json_encode($questions, JSON_PRETTY_PRINT));
}

// Redirect back to index.php
echo "<script>
window.location.href = 'index.php';
</script>";
?>