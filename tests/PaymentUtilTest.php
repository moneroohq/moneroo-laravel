<?php

namespace AxaZara\Moneroo\Tests;

use AxaZara\Moneroo\Utils\PayoutUtil;

class PaymentUtilTest extends TestCase
{
    /**
     * PaymentUtil::getMethods() should return an array of payment methods with the correct structure.
     *
     * @test
     */
    public function payment_methods_are_correctly_structured(): void
    {
        $methods = PayoutUtil::getMethods();

        foreach ($methods as $methodName => $methodAttributes) {
            $this->assertIsArray($methodAttributes, "Method '{$methodName}' is not an array.");

            $this->assertArrayHasKey('currency', $methodAttributes, "Missing 'currency' attribute in method '{$methodName}'.");
            $this->assertArrayHasKey('countries', $methodAttributes, "Missing 'countries' attribute in method '{$methodName}'.");
            $this->assertArrayHasKey('min_amount', $methodAttributes, "Missing 'min_amount' attribute in method '{$methodName}'.");
            $this->assertArrayHasKey('max_amount', $methodAttributes, "Missing 'max_amount' attribute in method '{$methodName}'.");

            $this->assertIsArray($methodAttributes['countries'], "Attribute 'countries' in method '{$methodName}' should be an array.");

            $this->assertIsNumeric($methodAttributes['min_amount'], "Attribute 'min_amount' in method '{$methodName}' should be numeric.");
            $this->assertIsNumeric($methodAttributes['max_amount'], "Attribute 'max_amount' in method '{$methodName}' should be numeric.");
            $this->assertLessThanOrEqual($methodAttributes['max_amount'], $methodAttributes['min_amount'], "Attribute 'min_amount' should be less than or equal to 'max_amount'.");
        }
    }
}