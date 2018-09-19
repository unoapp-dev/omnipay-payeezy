<?php

namespace Omnipay\Payeezy\Message;

class AuthorizeRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return $this->endpoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
    }

    public function getData()
    {
        $this->validate('amount');

        $data = [
            //'merchant_ref' => 'Astonishing-Sale',
            'transaction_type' => 'authorize',
            'amount' => floatval($this->getAmount()) * 100,
            'currency_code' =>  $this->getCurrency()
        ];

        $paymentMethod = $this->getPaymentMethod();

        switch ($paymentMethod)
        {
            case 'card' :
                break;

            case 'payment_profile' :

                if ($this->getCardReference()) {

                    try {
                        $cardReference = json_decode($this->getCardReference());
                        $token = $cardReference->token;

                        $data['method'] = 'token';
                        $data['token'] = [
                            'token_type'=> $cardReference->type,
                            'token_data'=> [
                                'type'=> $token->type,
                                'value'=> $token->value,
                                'cardholder_name'=> $token->cardholder_name,
                                'exp_date'=> $token->exp_date
                            ]
                        ];
                    }
                    catch (\Exception $e) {
                        throw new InvalidRequestException('Invalid payment profile');
                    }
                }
                break;

            case 'token' :
                break;

            default :
                break;
        }

        return json_encode($data);
    }
}
