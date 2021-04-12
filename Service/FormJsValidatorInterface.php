<?php

namespace AgePartnership\Bundle\FormJsValidationBundle\Service;

interface FormJsValidatorInterface
{
    public function addJsValidation($form, $validationGroup = "Default");
}
