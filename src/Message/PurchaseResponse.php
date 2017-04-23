<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use lembdev\WorldPay\Traits\GetAmount;
use lembdev\WorldPay\Traits\GetBillingAddress1;
use lembdev\WorldPay\Traits\GetBillingCity;
use lembdev\WorldPay\Traits\GetBillingCountry;
use lembdev\WorldPay\Traits\GetBillingPostcode;
use lembdev\WorldPay\Traits\GetCardClass;
use lembdev\WorldPay\Traits\GetCardCountryCode;
use lembdev\WorldPay\Traits\GetCardExpiryMonth;
use lembdev\WorldPay\Traits\GetCardExpiryYear;
use lembdev\WorldPay\Traits\GetCardholder;
use lembdev\WorldPay\Traits\GetCardIssuer;
use lembdev\WorldPay\Traits\GetCardMaskedNumber;
use lembdev\WorldPay\Traits\GetCardPrepaid;
use lembdev\WorldPay\Traits\GetCardProductTypeDescContactless;
use lembdev\WorldPay\Traits\GetCardProductTypeDescNonContactless;
use lembdev\WorldPay\Traits\GetCardSchemeName;
use lembdev\WorldPay\Traits\GetCardSchemeType;
use lembdev\WorldPay\Traits\GetCardStartMonth;
use lembdev\WorldPay\Traits\GetCardStartYear;
use lembdev\WorldPay\Traits\GetCardType;
use lembdev\WorldPay\Traits\GetCurrencyCode;
use lembdev\WorldPay\Traits\GetCustomerOrderCode;
use lembdev\WorldPay\Traits\GetDescription;
use lembdev\WorldPay\Traits\GetEnvironment;
use lembdev\WorldPay\Traits\GetOrderCode;
use lembdev\WorldPay\Traits\GetPaymentStatus;
use lembdev\WorldPay\Traits\GetPaymentType;
use lembdev\WorldPay\Traits\GetShopperEmailAddress;
use lembdev\WorldPay\Traits\GetToken;
use Omnipay\Common\CreditCard;

class PurchaseResponse extends AbstractResponse
{
    use GetOrderCode;
    use GetToken;
    use GetDescription;
    use GetAmount;
    use GetCurrencyCode;
    use GetCustomerOrderCode;
    use GetPaymentStatus;
    use GetShopperEmailAddress;
    use GetEnvironment;
    use GetPaymentType;
    use GetCardholder;
    use GetCardExpiryMonth;
    use GetCardExpiryYear;
    use GetCardStartMonth;
    use GetCardStartYear;
    use GetCardType;
    use GetCardMaskedNumber;
    use GetCardSchemeType;
    use GetCardSchemeName;
    use GetCardIssuer;
    use GetCardCountryCode;
    use GetCardClass;
    use GetCardProductTypeDescContactless;
    use GetCardProductTypeDescNonContactless;
    use GetCardPrepaid;
    use GetBillingAddress1;
    use GetBillingPostcode;
    use GetBillingCity;
    use GetBillingCountry;

    protected $creditCard;

    public function getCard()
    {
        if ($this->creditCard) {
            return $this->creditCard;
        }

        if ($this->isSuccessful()) {
            return $this->creditCard = new CreditCard([
                'expiryMonth'     => $this->getExpiryMonth(),
                'expiryYear'      => $this->getExpiryYear(),
                'startMonth'      => $this->getStartMonth(),
                'startYear'       => $this->getStartYear(),
                'name'            => $this->getCardholder(),
                'number'          => str_replace('x', '1', $this->getMaskedCardNumber()),
                'country'         => $this->getCountry(),
                'billingAddress1' => $this->getBillingAddress1(),
                'billingPostcode' => $this->getBillingPostcode(),
                'billingCity'     => $this->getBillingCity(),
                'billingCountry'  => $this->getBillingCountry(),
                'email'           => $this->getShopperEmailAddress(),
            ]);
        }

        return null;
    }
}