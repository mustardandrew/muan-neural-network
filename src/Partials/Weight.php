<?php

namespace NeuralNetwork\Partials;

/**
 * Class Weight
 *
 * @package NeuralNetwork\Partials
 */
class Weight
{
    /**
     * @var float
     */
    private $weight;

    /**
     * @var float
     */
    private $deltaWeight;

    /**
     * @var Neuron
     */
    private $fromNeuron;

    /**
     * Weight constructor.
     *
     * @param Neuron $fromNeuron
     * @param float $weight
     * @throws \Exception
     */
    public function __construct(Neuron $fromNeuron, float $weight = 0.0)
    {
        $this->fromNeuron = $fromNeuron;
        $this->weight = empty($weight) ? random_int(1, 100) / 100 : $weight;
        $this->deltaWeight = 0.0;
    }

    /**
     * Get from Neuron
     *
     * @return Neuron
     */
    public function getFromNeuron() : Neuron
    {
        return $this->fromNeuron;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight() : float
    {
        return $this->weight;
    }

    /**
     * Set weight
     *
     * @param float $weight
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }

    /**
     * Get delta weight
     *
     * @return float
     */
    public function getDeltaWeight() : float
    {
        return $this->deltaWeight;
    }

    /**
     * Set delta weight
     *
     * @param float $deltaWeight
     */
    public function setDeltaWeight(float $deltaWeight)
    {
        $this->deltaWeight = $deltaWeight;
    }

    /**
     * Get error
     *
     * @return float
     */
    public function getError() : float
    {
        return $this->weight * $this->deltaWeight;
    }
}