<?php

namespace Omnipay\Payeezy\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint =  $this->getTestMode() ? $this->testHost : $this->host;
        
        try {
            $transactionReference =  json_decode($this->getTransactionReference());
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        return $endPoint . '/' . $transactionReference->transaction_id;
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');
    
        try {
            $transactionReference = json_decode($this->getTransactionReference());
            $tokenData = $transactionReference->token->token_data;
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        $data = [
            //'merchant_ref' => 'Astonishing-Sale',
            'transaction_type' => 'refund',
            'method' => 'token',
            'amount' => floatval($this->getAmount()) * 100,
            'currency_code' => $transactionReference->currency,
            'token' => [
                'token_type' => $transactionReference->token->token_type,
                'token_data' => [
                    'type' => $tokenData->type,
                    'value' => $tokenData->value,
                    'cardholder_name' => $tokenData->cardholder_name,
                    'exp_date' => $tokenData->exp_date
                ]
            ]
        ];

        return json_encode($data);
    }
}
