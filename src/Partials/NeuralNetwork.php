<?php

namespace NeuralNetwork\Partials;

use Countable;
use Exception;

/**
 * Class NeuralNetwork
 *
 * @package NeuralNetwork\Partials
 */
class NeuralNetwork implements Countable
{
    /**
     * Layers
     *
     * @var array
     */
    private $layers = [];

    /**
     * NeuralNetwork constructor.
     *
     * @param array $layers Must be at least 2 layers
     * @throws Exception
     */
    public function __construct(array $layers)
    {
        if (empty($layers)) {
            throw new Exception("Layers is empty!");
        }

        if (count($layers) < 2) {
            throw new Exception("Must be at least 2 layers!");
        }

        $this->constructLayers($layers);
        $this->constructWeight();
    }

    /**
     * Train Neural Network
     *
     * @param int $epoch
     * @param float $learningRate
     * @param array $train
     * @param bool $debug
     * @throws Exception
     */
    public function train(int $epoch, float $learningRate, array $train, bool $debug = false)
    {
        if ($debug) {
            echo "Start training", PHP_EOL;
        }

        for ($i = 0; $i < $epoch; ++ $i) {

            shuffle($train);

            foreach ($train as $trainItem) {
                $input = $trainItem['input'];
                $output = $trainItem['output'];

                $result = $this->run($input);

                $errors = [];

                for ($j = 0; $j < count($result); ++ $j) {
                    $error = $result[0] - $output[0];
                    $errors[] = abs($error);

                    for ($k = count($this->layers) - 1; $k > 0; -- $k) {
                        /** @var Layer $layer */
                        $layer = $this->layers[$k];
                        $layer->train($error, $learningRate);
                    }
                }

                $errorsText = implode(', ', $errors);

                if ($debug) {
                    $index = $i + 1;
                    echo "\rEpoch {$index}, Errors: [{$errorsText}]", str_repeat(' ', 6);
                }
            }
        }

        if ($debug) {
            echo PHP_EOL, "End training", PHP_EOL;
        }
    }

    /**
     * Run
     *
     * @param array $input
     * @return array
     * @throws Exception
     */
    public function run(array $input) : array
    {
        /** @var Layer $layer */
        $layer = $this->layers[0];

        if (count($input) != $layer->count()) {
            throw new Exception("Array must have {$layer->count()} length.");
        }

        for ($i = 0; $i < $layer->count(); ++ $i) {
            $neuron = $layer->getNeuron($i);
            $neuron->setResult($input[$i]);
        }

        foreach ($this->layers as $layer) {
            $layer->run();
        }

        $output = [];

        $layer = $this->layers[count($this->layers) - 1];

        for ($i = 0; $i < count($layer); ++ $i) {
            $output[] = $layer->getNeuron($i)->getResult();
        }

        return $output;
    }

    /**
     * Construct Layers
     *
     * @param array $layers
     */
    private function constructLayers(array $layers)
    {
        foreach ($layers as $layer) {
            $this->layers[] = new Layer($layer);
        }
    }

    /**
     * Construct weight
     *
     * @throws Exception
     */
    private function constructWeight()
    {
        for ($i = 1; $i < count($this->layers); ++ $i) {
            /** @var Layer $layer */
            $layer = $this->layers[$i];
            /** @var Layer $layer */
            $prevLayer = $this->layers[$i - 1];

            for ($j = 0; $j < count($layer); ++ $j) {
                /** @var Neuron $neuron */
                $neuron = $layer->getNeuron($j);

                for ($k = 0; $k < count($prevLayer); ++ $k) {
                    /** @var Neuron $prevNeuron */
                    $prevNeuron = $prevLayer->getNeuron($k);
                    $neuron->makeWeight($prevNeuron);
                }
            }
        }
    }

    /**
     * Return Count of layers
     *
     * @return int
     */
    public function count()
    {
        return count($this->layers);
    }
}