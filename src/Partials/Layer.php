<?php

namespace NeuralNetwork\Partials;

use Countable;

/**
 * Class Layer
 *
 * @package NeuralNetwork\Partials
 */
class Layer implements Countable
{
    /**
     * Neurons
     *
     * @var array
     */
    private $neurons = [];

    /**
     * Layer constructor.
     *
     * @param int $count
     */
    public function __construct(int $count)
    {;
        $this->constructNeurons($count);
    }

    /**
     * Construct neurons
     *
     * @param int $count
     */
    private function constructNeurons(int $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->neurons[] = new Neuron();
        }
    }

    /**
     * Run
     */
    public function run()
    {
        foreach ($this->neurons as $neuron) {
            $neuron->run();
        }
    }

    /**
     * Train
     *
     * @param float $error
     * @param float $learningRate
     */
    public function train(float $error, float $learningRate)
    {
        /** @var Neuron $neuron */
        foreach ($this->neurons as $neuron) {
            $neuron->train($error, $learningRate);
        }
    }

    /**
     * Get neuron
     *
     * @param int $index
     * @return Neuron
     */
    public function getNeuron(int $index) : Neuron
    {
        return $this->neurons[$index];
    }

    /**
     * Get count
     *
     * @return int
     */
    public function count()
    {
        return count($this->neurons);
    }
}