<?php

namespace ACSEO\Bundle\FormJsValidationBundle\Service;

use ACSEO\Bundle\FormJsValidationBundle\Service\AbstractFormJsValidation;
use ACSEO\Bundle\FormJsValidationBundle\Service\FormJsValidatorInterface;

class ParsleyFormValidator extends AbstractFormJsValidation implements FormJsValidatorInterface
{
    protected function getMapping()
    {
        // https://parsleyjs.org/doc/index.html#validators
        $mapping = [
            // Basic Constraints
            "NotBlank" => function ($constraint, $translator) {
                return array(
                    'data-parsley-required',
                    'data-parsley-required-message' => $translator->trans($constraint->message),
                );
            },
            // "Type" => TODO

            // String Constraints
            "Email" => function ($constraint, $translator) {
                return array(
                    'data-parsley-type' => 'email',
                    'data-msg-email' => $translator->trans($constraint->message),
                );
            },
            "Length" => function ($constraint, $translator) {
                if ($constraint->min && !$constraint->max) {
                    // Min length only
                    return array(
                        "data-parsley-minlength" => $constraint->min,
                        "data-msg-minlength" => $translator->trans($constraint->minMessage),
                    );
                } elseif (!$constraint->min && $constraint->max) {
                    // Max length only
                    return array(
                        "data-parsley-maxlength" => $constraint->max,
                        "data-msg-maxlength" => $translator->trans($constraint->maxMessage),
                    );
                } elseif ($constraint->min && $constraint->max) {
                    // Length range
                    return array(
                        "data-parsley-length" => sprintf('[%d, %d]', $constraint->min, $constraint->max),
                        "data-msg-rangelength" => $translator->trans($constraint->minMessage).". ".$translator->trans($constraint->maxMessage),
                    );
                }
            },
            "Url" => function ($constraint, $translator) {
                return array(
                    'data-parsley-type' => 'url',
                    'data-msg-url' => $translator->trans($constraint->message),
                );
            },
            "Regex" => function ($constraint, $translator) {
                return array(
                    'data-parsley-pattern' => $constraint->htmlPattern, //TODO Confirm correct pattern attribute for parsley
                    'data-msg-url' => $translator->trans($constraint->message),
                );
            },

            // Number Constraints
            "PositiveOrZero" => function ($constraint, $translator) {
                return array(
                    'data-parsley-min' => "0",
                    'data-msg-url' => $translator->trans($constraint->message),
                );
            },
            "NegativeOrZero" => function ($constraint, $translator) {
                return array(
                    'data-parsley-max' => "0",
                    'data-msg-url' => $translator->trans($constraint->message),
                );
            },

            // Comparison Constraints
            "LessThanOrEqual" => function ($constraint, $translator) {
                return array(
                    "data-parsley-max" => $constraint->value,
                    "data-msg-min" => $translator->trans($constraint->message),
                );
            },
            "GreaterThanOrEqual" => function ($constraint, $translator) {
                return array(
                    "data-parsley-max" => $constraint->value,
                    "data-msg-min" => $translator->trans($constraint->message),
                );
            },
            "Range" => function ($constraint, $translator) {
                return array(
                    "data-parsley-range" => sprintf('[%d, %d]', $constraint->min, $constraint->max),
                    "data-msg-min" => $translator->trans($constraint->message),
                );
            },
        ];

        return $mapping;
    }

    protected function addEqualToConstraint($field, $attrOptions)
    {
        $parentOptions = $field->getParent()->getConfig()->getOptions();

        $attrOptions['data-parsley-equalTo'] = '#'.$this->getFieldId($field->getParent()->get('first'));
        $attrOptions['data-msg-equalTo'] = $this->translator->trans(isset($parentOptions['invalid_message']) ? $parentOptions['invalid_message'] : 'Les deux champs doivent être identiques.');

        return $attrOptions;
    }
}
