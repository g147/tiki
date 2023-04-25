<?php

namespace Rubix\ML\NeuralNet\ActivationFunctions;

use Tensor\Matrix;

/**
 * SiLU
 *
 * *Sigmoid-weighted Linear Unit* is a smooth rectified activation function that is not
 * monotonically increasing. Instead, a global minimum functions as an implicit regularizer
 * inhibiting the learning of weights of large magnitudes.
 *
 * References:
 * [1] S. Elwing et al. (2017). Sigmoid-Weighted Linear Units for Neural Network Function
 * Approximation in Reinforcement Learning.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class SiLU implements ActivationFunction
{
    /**
     * The sigmoid activation function.
     *
     * @var \Rubix\ML\NeuralNet\ActivationFunctions\Sigmoid
     */
    protected $sigmoid;

    public function __construct()
    {
        $this->sigmoid = new Sigmoid();
    }

    /**
     * Compute the output value.
     *
     * @param \Tensor\Matrix $z
     * @return \Tensor\Matrix
     */
    public function compute(Matrix $z) : Matrix
    {
        return $this->sigmoid->compute($z)->multiply($z);
    }

    /**
     * Calculate the derivative of the activation function at a given output.
     *
     * @param \Tensor\Matrix $z
     * @param \Tensor\Matrix $computed
     * @return \Tensor\Matrix
     */
    public function differentiate(Matrix $z, Matrix $computed) : Matrix
    {
        $derivative = [];

        foreach ($z->asArray() as $i => $rowZ) {
            $rowComputed = $computed[$i];

            $temp = [];

            foreach ($rowComputed as $j => $valueComputed) {
                $valueZ = $rowZ[$j];

                $temp[] = $valueZ !== 0.0
                    ? $valueComputed / $valueZ * (1.0 - $valueComputed) + $valueComputed
                    : 0.5;
            }

            $derivative[] = $temp;
        }

        return Matrix::quick($derivative);
    }

    /**
     * Return the string representation of the object.
     *
     * @return string
     */
    public function __toString() : string
    {
        return 'SiLU';
    }
}
