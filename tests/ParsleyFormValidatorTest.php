<?php

namespace AgePartnership\Bundle\FormJsValidationBundle\Tests;

use AgePartnership\Bundle\FormJsValidationBundle\Service\FormJsValidator;
use AgePartnership\Bundle\FormJsValidationBundle\Service\ParsleyFormValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

/**
 * ParsleyFormValidatorTest
 *
 * Tests that going through validator gives form object correct attributes
 *
 */
class ParsleyFormValidatorTest extends TestCase
{
    public function testAddJsValidation() {
        $symfonyValidator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $symfonyTranslator = new Translator('en_GB');
        $parsleyInterface = new ParsleyFormValidator($symfonyValidator, $symfonyTranslator);
        $formJsValidator = new FormJsValidator($parsleyInterface);

        $testEntity = new TestEntity();
        $formFactory = Forms::createFormFactory();
        $testForm = $formFactory->create(TestFormType::class, $testEntity);

        $testForm = $formJsValidator->addJsValidation($testForm);

        $metadata = $symfonyValidator->getMetadataFor($testForm->getConfig()->getDataClass());

        foreach($testForm->all() as $field) {
            $name = $field->getConfig()->getName();
            switch ($name) {
                case 'variable1':
                    $fieldOptions = $field->getConfig()->getOptions();
                    $fieldAttributes = $fieldOptions['attr'];

                    $this->assertEquals($fieldAttributes["data-parsley-minlength"], 8);
                    $this->assertEquals($fieldAttributes["data-parsley-minlength-message"], "variable1 must be at least 8 characters long");

                    $this->assertContains("data-parsley-required", $fieldAttributes);
                    $this->assertEquals($fieldAttributes["data-parsley-required-message"], "This value should not be blank.");

                    $this->assertEquals($fieldAttributes["data-parsley-type"], "email");
                    $this->assertEquals($fieldAttributes["data-parsley-type-message"], "variable1 must be an email");

                    break;
                case 'variable2':
                    $fieldOptions = $field->getConfig()->getOptions();
                    $fieldAttributes = $fieldOptions['attr'];

                    $this->assertEquals($fieldAttributes["data-parsley-length"], "[3, 10]");
                    $this->assertEquals($fieldAttributes["data-parsley-length-message"], "variable2 must be at least 3 characters long. variable2 must be less than 10 characters long");
                    break;
                case 'variable3':
                    $fieldOptions = $field->getConfig()->getOptions();
                    $fieldAttributes = $fieldOptions['attr'];

                    $this->assertEquals($fieldAttributes["data-parsley-pattern"], "\d");
                    $this->assertEquals($fieldAttributes["data-parsley-pattern-message"], "variable3 must be numeric");
                    break;
                case 'variable4':
                    $fieldOptions = $field->getConfig()->getOptions();
                    $fieldAttributes = $fieldOptions['attr'];

                    $this->assertEquals($fieldAttributes["data-parsley-min"], "0");
                    $this->assertEquals($fieldAttributes["data-parsley-min-message"], "variable4 must be positive or zero");

                    $this->assertEquals($fieldAttributes["data-parsley-type"], "number");
                    break;
                default:
                    break;
            }
        }
    }
}

