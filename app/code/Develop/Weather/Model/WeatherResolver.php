<?php

declare(strict_types=1);

namespace Develop\Weather\Model;

use Develop\Weather\Model\WeatherCityCoordinates as CityCoordinates;
use Develop\Weather\Model\WeatherCityCoordinatesFactory as CityCoordinatesFactory;
use Develop\Weather\Model\ResourceModel\WeatherCityCoordinates as CityCoordinatesResource;
use Develop\Weather\Model\ResourceModel\WeatherInterpreter as WeatherInterpreterResource;

class WeatherResolver
{
    /**
     * @var CityCoordinatesResource
     */
    private CityCoordinatesResource $cityCoordinatesResource;

    /**
     * @var WeatherCityCoordinatesFactory
     */
    private WeatherCityCoordinatesFactory $cityCoordinatesFactory;

    /**
     * @var WeatherInterpreterResource
     */
    private WeatherInterpreterResource $weatherInterpreterResource;

    /**
     * @var WeatherInterpreterFactory
     */
    private WeatherInterpreterFactory $weatherInterpreterFactory;

    /**
     * @param CityCoordinatesResource $cityCoordinatesResource
     * @param WeatherCityCoordinatesFactory $cityCoordinatesFactory
     * @param WeatherInterpreterResource $weatherInterpreterResource
     * @param WeatherInterpreterFactory $weatherInterpreterFactory
     */
    public function __construct(
        CityCoordinatesResource $cityCoordinatesResource,
        CityCoordinatesFactory $cityCoordinatesFactory,
        WeatherInterpreterResource $weatherInterpreterResource,
        WeatherInterpreterFactory $weatherInterpreterFactory
    ) {
        $this->cityCoordinatesResource      = $cityCoordinatesResource;
        $this->cityCoordinatesFactory       = $cityCoordinatesFactory;
        $this->weatherInterpreterResource   = $weatherInterpreterResource;
        $this->weatherInterpreterFactory    = $weatherInterpreterFactory;
    }

    /**
     * Get city geo coordinates by coordinate_id.
     *
     * @param int $cityCoordinatesId
     * @return array
     */
    public function getCityGeoCoordinates(int $cityCoordinatesId): array
    {
        /** @var CityCoordinates $cityCoordinatesModel */
        $cityCoordinatesModel = $this->cityCoordinatesFactory->create();

        $this->cityCoordinatesResource->load($cityCoordinatesModel, $cityCoordinatesId);

        return [
            'latitude'  => (float)$cityCoordinatesModel->getData('latitude'),
            'longitude' => (float)$cityCoordinatesModel->getData('longitude')
        ];
    }

    /**
     * Get city name by coordinate_id.
     *
     * @param int $cityCoordinatesId
     * @return string
     */
    public function getCityName(int $cityCoordinatesId): string
    {
        /** @var CityCoordinates $cityCoordinatesModel */
        $cityCoordinatesModel = $this->cityCoordinatesFactory->create();

        $this->cityCoordinatesResource->load($cityCoordinatesModel, $cityCoordinatesId);

        return $cityCoordinatesModel->getData('name') ?? '';
    }

    /**
     * Get weather description by interpreter_code.
     *
     * @param int $weatherCode
     * @return string
     */
    public function getWeatherDescription(int $weatherCode): string
    {
        /** @var WeatherInterpreter $weatherInterpreterModel */
        $weatherInterpreterModel = $this->weatherInterpreterFactory->create();

        $this->weatherInterpreterResource->load($weatherInterpreterModel, $weatherCode);

        return $weatherInterpreterModel->getData('description') ?? '';
    }
}
