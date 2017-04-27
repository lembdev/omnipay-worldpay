<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use lembdev\WorldPay\Traits\GetCardExpiryMonth;
use lembdev\WorldPay\Traits\GetCardExpiryYear;
use lembdev\WorldPay\Traits\GetCardholder;
use lembdev\WorldPay\Traits\GetCardIssueNumber;
use lembdev\WorldPay\Traits\GetCardMaskedNumber;
use lembdev\WorldPay\Traits\GetCardStartMonth;
use lembdev\WorldPay\Traits\GetCardStartYear;
use lembdev\WorldPay\Traits\GetReusable;
use lembdev\WorldPay\Traits\GetToken;
use Omnipay\Common\CreditCard;

class CardCreateResponse extends AbstractResponse
{
    use GetToken;
    use GetReusable;
    use GetCardExpiryMonth;
    use GetCardExpiryYear;
    use GetCardIssueNumber;
    use GetCardholder;
    use GetCardMaskedNumber;
    use GetCardStartMonth;
    use GetCardStartYear;

    /**
     * @var CreditCard
     */
    protected $creditCard;

    /**
     * @return null|CreditCard
     */
    public function getCard()
    {
        if ($this->creditCard) {
            return $this->creditCard;
        }

        if ($this->isSuccessful()) {
            return $this->creditCard = new CreditCard([
                'expiryMonth' => $this->getExpiryMonth(),
                'expiryYear'  => $this->getExpiryYear(),
                'issueNumber' => $this->getIssueNumber(),
                'name'        => $this->getCardholder(),
                'number'      => str_replace('*', '1', $this->getMaskedCardNumber()),
                'startMonth'  => $this->getStartMonth(),
                'startYear'   => $this->getStartYear(),
            ]);
        }

        return null;
    }
}
