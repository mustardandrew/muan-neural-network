<?php

require "vendor/autoload.php";

use NeuralNetwork\Partials\NeuralNetwork;

define('DEBUG', true);

try {

    // Create Neural Network with 3 layers
    // 1 layer (input layer) with 3 neuron
    // 2 layer with 40 neuron
    // 3 layer (output layer) with 1 neuron
    $layers = [3, 40, 1];
    $neuralNetwork = new NeuralNetwork($layers);

    // Data fo train
    $epoch = 10000;
    $learningRate = 0.02;
    $train = [
        [
            'input'  => [0, 0, 1],
            'output' => [1],
        ],
        [
            'input'  => [0, 1, 0],
            'output' => [1],
        ],
        [
            'input'  => [0, 1, 1],
            'output' => [0],
        ],
        [
            'input'  => [1, 0, 0],
            'output' => [1],
        ],
        [
            'input'  => [1, 0, 1],
            'output' => [0],
        ],
        [
            'input'  => [1, 1, 0],
            'output' => [0],
        ],
        [
            'input' => [1, 1, 1],
            'output' => [0],
        ],
    ];

    // Train Neural Network
    $neuralNetwork->train($epoch, $learningRate, $train, DEBUG);

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage(), PHP_EOL;
}


// Print Result

$index = 1;
foreach ($train as $trainItem) {

    $input  = $trainItem['input'];
    $output = $trainItem['output'];
    $result = $neuralNetwork->run($input);

    $inputText  = implode(', ', $input);
    $outputText = implode(', ', $output);
    $resultText = implode(', ', $result);

    $resultRounded = [];
    foreach ($result as $item) {
        $resultRounded[] = round($item);
    }
    $resultRounded = implode(', ', $resultRounded);

    echo "{$index}. [$inputText] => [$outputText] = [$resultText] ($resultRounded)", PHP_EOL;
    ++ $index;
}