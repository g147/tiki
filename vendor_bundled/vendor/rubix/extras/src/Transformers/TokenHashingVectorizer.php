<?php

namespace Rubix\ML\Transformers;

use Rubix\ML\DataType;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Other\Tokenizers\Word;
use Rubix\ML\Other\Tokenizers\Tokenizer;
use Rubix\ML\Exceptions\InvalidArgumentException;

use function count;
use function is_string;

/**
 * Token Hashing Vectorizer
 *
 * Token Hashing Vectorizer builds token count vectors on the fly by employing a *hashing
 * trick*. It is a stateless transformer that uses the CRC32 (Cyclic Redundancy Check)
 * hashing algorithm to assign token occurrences to a bucket in a vector of user-defined
 * dimensionality. The advantage of hashing over a fixed vocabulary is that there is no
 * memory footprint however there is a chance that certain tokens will collide with other
 * tokens especially in lower-dimensional vector spaces.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class TokenHashingVectorizer implements Transformer
{
    /**
     * The maximum number of dimensions supported.
     *
     * @var int
     */
    protected const MAX_DIMENSIONS = 4294967295;

    /**
     * The dimensionality of the vector space.
     *
     * @var int
     */
    protected $dimensions;

    /**
     * The tokenizer used to extract tokens from blobs of text.
     *
     * @var \Rubix\ML\Other\Tokenizers\Tokenizer
     */
    protected $tokenizer;

    /**
     * @param int $dimensions
     * @param \Rubix\ML\Other\Tokenizers\Tokenizer|null $tokenizer
     * @throws \Rubix\ML\Exceptions\InvalidArgumentException
     */
    public function __construct(int $dimensions, ?Tokenizer $tokenizer = null)
    {
        if ($dimensions < 1 or $dimensions > self::MAX_DIMENSIONS) {
            throw new InvalidArgumentException('Dimensions must be'
                . ' between 0 and ' . self::MAX_DIMENSIONS
                . ", $dimensions given.");
        }

        $this->dimensions = $dimensions;
        $this->tokenizer = $tokenizer ?? new Word();
    }

    /**
     * Return the data types that this transformer is compatible with.
     *
     * @return \Rubix\ML\DataType[]
     */
    public function compatibility() : array
    {
        return DataType::all();
    }

    /**
     * Transform the dataset in place.
     *
     * @param array[] $samples
     */
    public function transform(array &$samples) : void
    {
        $scale = $this->dimensions / self::MAX_DIMENSIONS;

        foreach ($samples as &$sample) {
            $vectors = [];

            foreach ($sample as $column => $value) {
                if (is_string($value)) {
                    $template = array_fill(0, $this->dimensions, 0);

                    $tokens = $this->tokenizer->tokenize($value);

                    $counts = array_count_values($tokens);

                    foreach ($counts as $token => $count) {
                        $offset = (int) floor(crc32($token) * $scale);

                        $template[$offset] += $count;
                    }

                    $vectors[] = $template;

                    unset($sample[$column]);
                }
            }

            $sample = array_merge($sample, ...$vectors);
        }
    }

    /**
     * Return the string representation of the object.
     *
     * @return string
     */
    public function __toString() : string
    {
        return "Token Hashing Vectorizer (dimensions: {$this->dimensions},"
            . " tokenizer: {$this->tokenizer})";
    }
}
