<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $index = $input['index'];

    $jsonData = file_get_contents('questions.json');
    $questions = json_decode($jsonData, true);

    if (isset($questions[$index])) {
        // Remove the question
        array_splice($questions, $index, 1);

        // Save the updated list back to the JSON file
        file_put_contents('questions.json', json_encode($questions));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
