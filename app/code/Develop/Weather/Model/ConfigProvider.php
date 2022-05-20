<?php

namespace Develop\Weather\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    private const XML_PATH_CITY_COORDINATES_ID = 'weather_status/city_coordinates/id';
    private const XML_PATH_TIME_ZONE = 'weather_status/time_zone/code';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get current city coordinates id.
     *
     * @return int
     */
    public function getCurrentCityId(): int
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_CITY_COORDINATES_ID
        );

        return is_numeric($value) ? (int)$value : 1;
    }

    /**
     * Get current time zone.
     *
     * @return string
     */
    public function getCurrentTimeZone(): string
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_TIME_ZONE
        );

        return is_string($value) ? urlencode($value) : '';
    }
}
