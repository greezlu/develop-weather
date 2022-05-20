<?php

namespace Develop\Weather\Api\Data;

interface WeatherStatusInterface
{
    /**
     * @return ?int
     */
    public function getId(): ?int;

    /**
     * @param int $value
     * @return WeatherStatusInterface
     */
    public function setId(int $value): WeatherStatusInterface;

    /**
     * @return ?int
     */
    public function getCityCoordinatesId(): ?int;

    /**
     * @param int $value
     * @return WeatherStatusInterface
     */
    public function setCityCoordinatesId(int $value): WeatherStatusInterface;

    /**
     * @return ?int
     */
    public function getWeatherInterpreterId(): ?int;

    /**
     * @param int $value
     * @return WeatherStatusInterface
     */
    public function setWeatherInterpreterId(int $value): WeatherStatusInterface;

    /**
     * @return ?float
     */
    public function getTemperature(): ?float;

    /**
     * @param float $value
     * @return WeatherStatusInterface
     */
    public function setTemperature(float $value): WeatherStatusInterface;

    /**
     * @return ?float
     */
    public function getWindSpeed(): ?float;

    /**
     * @param float $value
     * @return WeatherStatusInterface
     */
    public function setWindSpeed(float $value): WeatherStatusInterface;

    /**
     * @return ?int
     */
    public function getWindDirection(): ?int;

    /**
     * @param int $value
     * @return WeatherStatusInterface
     */
    public function setWindDirection(int $value): WeatherStatusInterface;

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string;

    /**
     * @param ?string $value
     * @return WeatherStatusInterface
     */
    public function setCreatedAt(string $value = null): WeatherStatusInterface;
}
