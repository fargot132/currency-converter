<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CurrencyConverter;

class ApiConvertController extends ApiController
{
    /**
     * @Route("/api/convert/{amount}", name="convert", methods="GET")
     */
    public function apiConvert($amount)
    {
        if (is_numeric($amount)) {
            $converter = new CurrencyConverter('PLN', 'EUR');
            $converter->setAmountFrom($amount);
            if ($converter->convert()) {
                return $this->respond($converter->apiTransform());
            } else {
                return $this->respondServerError();
            }
        } else {
            return $this->respondValidationError();
        }
    }
}
