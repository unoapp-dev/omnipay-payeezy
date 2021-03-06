<?php

namespace Omnipay\Payeezy;

use Omnipay\Common\AbstractGateway;

/**
 * Payeezy Gateway
 * @link https://developer.payeezy.com/docs-sandbox
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Payeezy';
    }

    public function getDefaultParameters()
    {
        return [
            'productionEndPoint' => '',
            'sandboxEndPoint' => '',
            'apiKey' => '',
            'apiSecret' => '',
            'merchantToken' => ''
        ];
    }

    public function getSandboxEndPoint()
    {
        return $this->getParameter('sandboxEndPoint');
    }

    public function setSandboxEndPoint($value)
    {
        return $this->setParameter('sandboxEndPoint', $value);
    }

    public function getProductionEndPoint()
    {
        return $this->getParameter('productionEndPoint');
    }

    public function setProductionEndPoint($value)
    {
        return $this->setParameter('productionEndPoint', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    public function getMerchantToken()
    {
        return $this->getParameter('merchantToken');
    }

    public function setMerchantToken($value)
    {
        return $this->setParameter('merchantToken', $value);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\CreateCardRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payeezy\Message\RefundRequest', $parameters);
    }
}

