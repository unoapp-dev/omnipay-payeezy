<?php

namespace Omnipay\Payeezy\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

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
        try {
            $transactionReference = json_decode($this->getTransactionReference());
            $tokenData = $transactionReference->token->token_data;
        }
        catch (\Exception $e) {
            throw new InvalidRequestException('Invalid transaction reference');
        }

        $data = [
            //'merchant_ref' => 'Astonishing-Sale',
            'transaction_type' => 'capture',
            'method' => 'token',
            'amount' => $transactionReference->amount,
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
