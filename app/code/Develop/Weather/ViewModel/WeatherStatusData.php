<?php

declare(strict_types=1);

namespace Develop\Weather\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Develop\Weather\Model\WeatherResolver;
use Develop\Weather\Api\WeatherStatusRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class WeatherStatusData implements ArgumentInterface
{
    /**
     * @var WeatherStatusRepositoryInterface
     */
    private WeatherStatusRepositoryInterface $weatherStatusRepository;

    /**
     * @var WeatherResolver
     */
    private WeatherResolver $weatherResolver;

    /**
     * @param WeatherStatusRepositoryInterface $weatherStatusRepository
     * @param WeatherResolver $weatherResolver
     */
    public function __construct(
        WeatherStatusRepositoryInterface $weatherStatusRepository,
        WeatherResolver $weatherResolver
    ) {
        $this->weatherStatusRepository = $weatherStatusRepository;
        $this->weatherResolver = $weatherResolver;
    }

    /**
     * Get last weather status data.
     *
     * @return array
     */
    public function getWeatherData(): array
    {
        try {
            $weatherStatus = $this->weatherStatusRepository->getLast();
        } catch (NoSuchEntityException $error) {
            return [];
        }

        $cityCoordinatesId      = $weatherStatus->getCityCoordinatesId();
        $weatherInterpreterId   = $weatherStatus->getWeatherInterpreterId();

        return [
            'City'                  => $this->weatherResolver->getCityName($cityCoordinatesId),
            'Weather Description'   => $this->weatherResolver->getWeatherDescription($weatherInterpreterId),
            'Temperature'           => $weatherStatus->getTemperature(),
            'Wind Speed'            => $weatherStatus->getWindSpeed(),
            'Wind Direction'        => $weatherStatus->getWindDirection()
        ];
    }
}
