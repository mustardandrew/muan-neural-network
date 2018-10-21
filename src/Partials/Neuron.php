<?php

namespace NeuralNetwork\Partials;

/**
 * Class Neuron
 *
 * @package NeuralNetwork\Partials
 */
class Neuron
{
    /**
     * @var float
     */
    private $result;

    /**
     * @var array
     */
    private $weights = [];

    /**
     * @var array
     */
    private $anotherWeights = [];

    /**
     * Neuron constructor.
     */
    public function __construct()
    {
        $this->result = 0.0;
    }

    /**
     * Make weight
     *
     * @param Neuron $neuron
     * @param float $weight
     * @return Weight
     * @throws \Exception
     */
    public function makeWeight(Neuron $neuron, float $weight = 0.0) : Weight
    {
        $this->weights[] = $weight = new Weight($neuron, $weight);
        $neuron->setAnotherWeight($weight);
        return $weight;
    }

    /**
     * Set another weight
     *
     * @param Weight $weight
     */
    public function setAnotherWeight(Weight $weight)
    {
        $this->anotherWeights[] = $weight;
    }

    /**
     * Run
     */
    public function run()
    {
        if (empty($this->weights)) {
            return $this->result;
        }

        $this->result = 0;

        /** @var Weight $weight */
        foreach ($this->weights as $weight) {
            $this->result += $weight->getFromNeuron()->getResult() * $weight->getWeight();
        }

        $this->result = $this->activationFunc($this->result);
    }

    /**
     * Train
     *
     * @param float $error
     * @param float $learningRate
     */
    public function train(float $error, float $learningRate)
    {
        if (empty($this->weights)) {
            return;
        }

        $error = $this->getError($error);
        $deltaWeight = $error * $this->activationDxFunc($this->result);

        /** @var Weight $weight */
        foreach ($this->weights as $weight) {
            $newWeight = $weight->getWeight() - $weight->getFromNeuron()->getResult() * $deltaWeight * $learningRate;
            $weight->setWeight($newWeight);
            $weight->setDeltaWeight($deltaWeight);
        }
    }

    /**
     * Get error
     *
     * @param float $error
     * @return float
     */
    private function getError(float $error) : float
    {
        if (! empty($this->anotherWeights)) {
            $errorSum = 0;
            /** @var Weight $weight */
            foreach ($this->anotherWeights as $weight) {
                $errorSum += $weight->getError();
            }
            $error = $errorSum;
        }

        return $error;
    }

    /**
     * Get result
     *
     * @return float
     */
    public function getResult() : float
    {
        return $this->result;
    }

    /**
     * Set result
     *
     * @param float $result
     */
    public function setResult(float $result)
    {
        $this->result = $result;
    }

    /**
     * Activation Function
     *
     * @param float $x
     * @return float|int
     */
    private function activationFunc(float $x)
    {
        return 1 / (1 + exp(-$x));
    }

    /**
     * @param float $x
     * @return float|int
     */
    private function activationDxFunc(float $x)
    {
        $activationResult = $this->activationFunc($x);
        return $activationResult * (1 - $activationResult);
    }
}