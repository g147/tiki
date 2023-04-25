<?php

namespace WikiSuite\ILP;


class Invoice
{
    private string $destinationAccount;
    private string $sharedSecret;
    private int $balance;
    private int $amount;
    private string $assetCode;
    private string $codeScale;
    private array $additionalFields;

    /**
     * @return string
     */
    public function getDestinationAccount(): string
    {
        return $this->destinationAccount;
    }

    /**
     * @param string $destinationAccount
     */
    public function setDestinationAccount(string $destinationAccount): void
    {
        $this->destinationAccount = $destinationAccount;
    }

    /**
     * @return string
     */
    public function getSharedSecret(): string
    {
        return $this->sharedSecret;
    }

    /**
     * @param string $sharedSecret
     */
    public function setSharedSecret(string $sharedSecret): void
    {
        $this->sharedSecret = $sharedSecret;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getAssetCode(): string
    {
        return $this->assetCode;
    }

    /**
     * @param string $assetCode
     */
    public function setAssetCode(string $assetCode): void
    {
        $this->assetCode = $assetCode;
    }

    /**
     * @return string
     */
    public function getCodeScale(): string
    {
        return $this->codeScale;
    }

    /**
     * @param string $codeScale
     */
    public function setCodeScale(string $codeScale): void
    {
        $this->codeScale = $codeScale;
    }

    /**
     * @return array
     */
    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    /**
     * @param array $additionalFields
     */
    public function setAdditionalFields(array $additionalFields): void
    {
        $this->additionalFields = $additionalFields;
    }

    /**
     * @return bool
     */
    public function isPayed(): bool
    {
        return $this->getBalance() === $this->getAmount();
    }
}