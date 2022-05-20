<?php

declare(strict_types=1);

namespace Develop\Weather\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;

class WeatherUpdater
{
    private const ENDPOINT = 'https://api.open-meteo.com/v1/forecast'
    . '?latitude=%f'
    . '&longitude=%f'
    . '&current_weather=true'
    . '&timezone=%s';

    /**
     * @var Curl
     */
    private Curl $curl;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    /**
     * @var WeatherResolver
     */
    private WeatherResolver $weatherResolver;

    /**
     * @param Curl $curl
     * @param Json $json
     * @param ConfigProvider $configProvider
     * @param WeatherResolver $weatherResolver
     */
    public function __construct(
        Curl $curl,
        Json $json,
        ConfigProvider $configProvider,
        WeatherResolver $weatherResolver
    ) {
        $this->json             = $json;
        $this->curl             = $curl;
        $this->configProvider   = $configProvider;
        $this->weatherResolver  = $weatherResolver;
    }

    /**
     * @return array
     */
    public function getCurrentWeather(): array
    {
        $cityCoordinatesId = $this->configProvider->getCurrentCityId();
        $timezone = $this->configProvider->getCurrentTimeZone();

        $decodedResponse = $this->getResponse($cityCoordinatesId, $timezone);

        if (empty($decodedResponse) || isset($decodedResponse['error'])) {
            return []; //@todo log
        }

        return [
            'city_coordinates_id'       => $cityCoordinatesId,
            'weather_interpreter_id'    => $decodedResponse['current_weather']['weathercode'] ?? null,
            'temperature'               => $decodedResponse['current_weather']['temperature'] ?? null,
            'wind_speed'                => $decodedResponse['current_weather']['windspeed'] ?? null,
            'wind_direction'            => $decodedResponse['current_weather']['winddirection'] ?? null,
            'created_at'                => date('Y-m-d H:i:s')
        ];
    }

    /**
     * @param int $cityCoordinatesId
     * @param string $timezone
     * @return array
     */
    private function getResponse(int $cityCoordinatesId, string $timezone): array
    {
        $coordinates = $this->weatherResolver->getCityGeoCoordinates($cityCoordinatesId);

        $url = $this->getUrl($coordinates, $timezone);
        $this->curl->get($url);

        $response = $this->curl->getBody();

        return (array)$this->json->unserialize($response ?? '{}');
    }

    /**
     * @param $coordinates
     * @param string $timezone
     * @return string
     */
    private function getUrl($coordinates, string $timezone): string
    {
        return sprintf(
            self::ENDPOINT,
            $coordinates['latitude'] ?? '',
            $coordinates['latitude'] ?? '',
            $timezone
        );
    }
}
