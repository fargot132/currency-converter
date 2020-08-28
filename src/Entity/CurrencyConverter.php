<?php

namespace App\Entity;

use App\Api\Client\CurrencyClient;

class CurrencyConverter
{
    protected $currencyCodeFrom;
    protected $currencyCodeTo;
    protected $amountFrom;
    protected $amountTo;
    protected $exchangeRate;
    protected $exchangeDate;

    /*
     * @param $currencyCodeFrom - three letters currency code to convert from
     * @param $currencyCodeTo - three letters currency code to convert to
     */
    public function __construct(string $currencyCodeFrom, string $currencyCodeTo)
    {
        $this->currencyCodeFrom = $currencyCodeFrom;
        $this->currencyCodeTo = $currencyCodeTo;
        $this->amountFrom = 0.0;
        $this->amountTo = 0.0;
        $this->exchangeRate = 0.0;
        $this->exchangeDate = '';
    }
    
    public function setAmountFrom($amount)
    {
        $this->amountFrom = $amount;
    }
    
    public function getAmountFrom()
    {
        return $this->amountFrom;
    }
    
    public function getAmountTo()
    {
        return $this->amountTo;
    }
    
    public function setAmountTo($amount)
    {
        return;
    }
    
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
    
    public function setExchangeRate($rate)
    {
        return;
    }
    
    public function getExchangeDate()
    {
        return $this->exchangeDate;
    }
    
    public function setExchangeDate($date)
    {
        return;
    }
    
    /*
     * Get exchange rate from API and convert currency
     */
    public function convert()
    {
        $client = new CurrencyClient($this->currencyCodeFrom, $this->currencyCodeTo);
        if ($client->getExchangeRatesFromApi()) {
            $this->exchangeRate = $client->getExchangeRate();
            $this->exchangeDate = $client->getExchangeDate();
            $this->amountTo = $this->amountFrom * $this->exchangeRate;
            $this->amountTo = round($this->amountTo, 2);
            return true;
        }
        return false;
    }
    
    /*
     * Transform data to API
     *
     * @returns array of transformed data
     */
    public function apiTransform()
    {
        return [
            'amount' => $this->getAmountTo(),
            'rate' => $this->getExchangeRate(),
            'date' => $this->getExchangeDate(),
        ];
    }
}
