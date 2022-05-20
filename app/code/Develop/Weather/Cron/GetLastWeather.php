<?php

declare(strict_types=1);

namespace Develop\Weather\Cron;

use Develop\Weather\Model\WeatherUpdater;
use Develop\Weather\Api\Data\WeatherStatusInterface;
use Develop\Weather\Api\Data\WeatherStatusInterfaceFactory;
use Develop\Weather\Api\WeatherStatusRepositoryInterface;

class GetLastWeather
{
    /**
     * @var WeatherUpdater
     */
    private WeatherUpdater $weatherUpdater;

    /**
     * @var WeatherStatusInterfaceFactory
     */
    private WeatherStatusInterfaceFactory $weatherStatusFactory;

    /**
     * @var WeatherStatusRepositoryInterface
     */
    private WeatherStatusRepositoryInterface $weatherStatusRepository;

    /**
     * @param WeatherUpdater $weatherUpdater
     * @param WeatherStatusInterfaceFactory $weatherStatusFactory
     * @param WeatherStatusRepositoryInterface $weatherStatusRepository
     */
    public function __construct(
        WeatherUpdater $weatherUpdater,
        WeatherStatusInterfaceFactory $weatherStatusFactory,
        WeatherStatusRepositoryInterface $weatherStatusRepository
    ) {
        $this->weatherUpdater = $weatherUpdater;
        $this->weatherStatusFactory = $weatherStatusFactory;
        $this->weatherStatusRepository = $weatherStatusRepository;
    }

    public function execute(): void
    {
        $currentData = $this->weatherUpdater->getCurrentWeather();

        if (empty($currentData)) {
            return; //@todo log
        }

        /** @var WeatherStatusInterface $weatherStatusModel */
        $weatherStatusModel = $this->weatherStatusFactory->create();

        $weatherStatusModel->setCityCoordinatesId($currentData['city_coordinates_id']);
        $weatherStatusModel->setWeatherInterpreterId($currentData['weather_interpreter_id']);
        $weatherStatusModel->setTemperature($currentData['temperature']);
        $weatherStatusModel->setWindSpeed($currentData['wind_speed']);
        $weatherStatusModel->setWindDirection($currentData['wind_direction']);
        $weatherStatusModel->setCreatedAt($currentData['created_at']);

        try {
            $this->weatherStatusRepository->save($weatherStatusModel);
        } catch (\Exception $error) {
            //@todo log
        }
    }
}
