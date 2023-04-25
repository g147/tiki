<?php

namespace WikiSuite\ILP\Providers;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WikiSuite\ILP\ILPSPSPClientAdaptorInterface;
use WikiSuite\ILP\Invoice;
use WikiSuite\ILP\PointerTrait;

class ILPInvoiceServerClient implements ILPSPSPClientAdaptorInterface
{
    use PointerTrait;

    private string $baseURL;
    private string $token;
    private bool $ssl;

    /**
     * ILPInvoiceServerClient constructor.
     * @param string $baseURL
     * @param string $token
     * @param bool $ssl
     */
    public function __construct(string $baseURL, string $token, bool $ssl = true)
    {
        $this->baseURL = $baseURL;
        $this->token = $token;
        $this->ssl = $ssl;
    }

    /**
     * @return string
     */
    public function getBaseURL(): string
    {
        return $this->baseURL;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @param $amount
     * @param $assetCode
     * @param $assetScale
     * @param string $webhook
     * @param array $extraFields
     * @return string Pointer to invoice
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function createInvoice(
        $amount,
        $assetCode,
        $assetScale,
        $webhook = "",
        $extraFields = []
    ): string
    {
        $params = array_merge(
            $extraFields,
            [
                'amount' => $amount,
                'assetCode' => $assetCode,
                'assetScale' => $assetScale,
                'webhook' => $webhook,
            ]
        );


        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            trim($this->getBaseURL(), '/'),
            [
                'auth_bearer' => $this->getToken(),
                'body' => $params,
            ]
        );
        $data = $response->toArray(true);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return $this->resolvePointer($propertyAccessor->getValue($data, "[invoice]"), $this->isSsl());
    }

    public function getPointerId($pointer)
    {
        $re = '/.*\/(.*)/';
        preg_match_all($re, $pointer, $matches, PREG_SET_ORDER, 0);
        if (!empty($matches) && count($matches[0]) >= 2 && strlen($matches[0][1]) == 36) {
            return $matches[0][1];
        }

        return false;
    }

    public function getInvoice($pointer): Invoice
    {
        $url = $this->resolvePointer($pointer, $this->isSsl());

        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            $url,
            [
                'auth_bearer' => $this->getToken(),
                'headers' => [
                    'Accept' => 'application/spsp4+json, application/spsp+json',
                ],
            ]
        );

        return $this->jsonToInvoice($response->toArray(true));
    }


    private function jsonToInvoice($data): Invoice
    {
        $invoice = new Invoice();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $invoice->setDestinationAccount($propertyAccessor->getValue($data, '[destination_account]'));
        $invoice->setSharedSecret($propertyAccessor->getValue($data, '[shared_secret]'));
        $invoice->setBalance($propertyAccessor->getValue($data, '[push][balance]'));
        $invoice->setAmount($propertyAccessor->getValue($data, '[push][invoice][amount]'));
        $invoice->setAssetCode($propertyAccessor->getValue($data, '[push][invoice][asset][code]'));
        $invoice->setCodeScale($propertyAccessor->getValue($data, '[push][invoice][asset][scale]'));
        $invoice->setAdditionalFields($propertyAccessor->getValue($data, '[push][invoice][additional_fields]'));

        return $invoice;
    }

    function checkInvoiceIsPaid($pointer): bool
    {
        $invoice = $this->getInvoice($pointer);

        return ($invoice && $invoice->isPayed());
    }
}