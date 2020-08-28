<?php

namespace App\Api\Client;

use Symfony\Component\HttpClient\HttpClient;

class CurrencyClient
{
    protected $baseCurrency;
    protected $currency;
    protected $url;
    protected $response;
    
    /*
     * @param string $baseCurrency - three letters base currency code
     * @param string $currency - three letters conversion currency code
     */
    public function __construct(string $baseCurrency, string $currency)
    {
        $this->baseCurrency = $baseCurrency;
        $this->currency = $currency;
        $this->url = "https://api.exchangeratesapi.io/latest?base=" .
                $baseCurrency . "&symbols=" . $currency;
        $this->response = array();
    }
    
    /*
     * @returns true on success, false on error
     */
    public function getExchangeRatesFromApi()
    {
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $this->url, ['timeout' => 10]);
            $contentType = $response->getHeaders()['content-type'][0];
            if ($contentType == 'application/json') {
                $this->response = $response->toArray();
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
    
    public function getExchangeRate()
    {
        if ($this->response) {
            return $this->response['rates'][$this->currency];
        }
        return false;
    }
    
    public function getExchangeDate()
    {
        if ($this->response) {
            return $this->response['date'];
        }
        return false;
    }
}
