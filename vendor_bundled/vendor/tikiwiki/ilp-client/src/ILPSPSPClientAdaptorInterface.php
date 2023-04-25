<?php

namespace WikiSuite\ILP;

interface ILPSPSPClientAdaptorInterface
{
    function createInvoice(
        $amount,
        $assetCode,
        $assetScale,
        $webhook = "",
        $extraFields = []
    ): string;

    /**
     * @param $pointer
     * @return Invoice
     */
    function getInvoice($pointer): Invoice;

    /**
     * @param $pointer
     * @return bool
     */
    function checkInvoiceIsPaid($pointer): bool;
}