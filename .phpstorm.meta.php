<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace PHPSTORM_META {
    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
        \Omnipay\Omnipay::create('') => [
            'Skeleton' instanceof \Omnipay\Skeleton\Gateway,
        ],
        \Omnipay\Common\GatewayFactory::create('') => [
            'Skeleton' instanceof \Omnipay\Skeleton\Gateway,
        ],
    ];
}