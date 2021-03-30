<?php
namespace AgePartnership\Bundle\FormJsValidationBundle\Tests;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * TestEntity
 *
 * Entity class for testing validators
 *
 */
class TestEntity
{
    /**
     * @var string
     */
    public $variable1;

    /**
     * @var string
     */
    public $variable2;

    /**
     * @var string
     */
    public $variable3;

    /**
     * @var string
     */
    public $variable4;

    /**
     * @var string
     */
    public $variable5;

    /**
     * @var string
     */
    public $variable6;

    /**
     * @var string
     */
    public $variable7;

    /**
     * @var string
     */
    public $variable8;

    /**
     * loadValidatorMetadata
     *
     * adds constraints to form fields e.g. password
     *
     * @param ClassMetadata $metadata
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('variable1', new Constraints\Length([
            'min' => 8,
            'minMessage' => 'variable1 must be at least 8 characters long'
        ]))
        ->addPropertyConstraint('variable1', new Constraints\NotBlank())
        ->addPropertyConstraint('variable1', new Constraints\Email([
            'message' => 'variable1 must be an email'
        ]))
        ->addPropertyConstraint('variable2', new Constraints\Length([
            'min' => 3,
            'max' => 10,
            'minMessage' => 'variable2 must be at least 3 characters long',
            'maxMessage' => 'variable2 must be less than 10 characters long'
        ]))
        ->addPropertyConstraint('variable2', new Constraints\Url([
            'message' => 'variable2 must be a URL'
        ]))
        ->addPropertyConstraint('variable3', new Constraints\Regex([
            'pattern' => '/\d/',
            'htmlPattern' => '\d',
            'message' => 'variable3 must be numeric'
        ]))
        ->addPropertyConstraint('variable4', new Constraints\PositiveOrZero([
            'message' => 'variable4 must be positive or zero'
        ]));
    }
}
