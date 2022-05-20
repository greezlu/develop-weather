<?php

namespace Develop\Weather\Model;

use Develop\Weather\Api\Data\WeatherStatusInterface;
use Develop\Weather\Model\ResourceModel\WeatherStatus as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class WeatherStatus extends AbstractModel implements WeatherStatusInterface
{
    private const CITY_COORDINATES_ID       = 'city_coordinates_id';
    private const WEATHER_INTERPRETER_ID    = 'weather_interpreter_id';
    private const TEMPERATURE               = 'temperature';
    private const WIND_SPEED                = 'wind_speed';
    private const WIND_DIRECTION            = 'wind_direction';
    private const CREATED_AT                = 'created_at';

    /**
     * @inheridoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheridoc
     */
    public function getId(): ?int
    {
        $id = $this->getData($this->_idFieldName);
        return is_numeric($id) ? (int)$id : null;
    }

    /**
     * @inheridoc
     */
    public function setId($id): WeatherStatus
    {
        return $this->setData($this->_idFieldName, $id);
    }

    /**
     * @inheridoc
     */
    public function getCityCoordinatesId(): ?int
    {
        $value = $this->getData(self::CITY_COORDINATES_ID);
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * @inheridoc
     */
    public function setCityCoordinatesId(int $value): WeatherStatusInterface
    {
        return $this->setData(self::CITY_COORDINATES_ID, $value);
    }

    /**
     * @inheridoc
     */
    public function getWeatherInterpreterId(): ?int
    {
        $value = $this->getData(self::WEATHER_INTERPRETER_ID);
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * @inheridoc
     */
    public function setWeatherInterpreterId(int $value): WeatherStatusInterface
    {
        return $this->setData(self::WEATHER_INTERPRETER_ID, $value);
    }

    /**
     * @inheridoc
     */
    public function getTemperature(): ?float
    {
        $value = $this->getData(self::TEMPERATURE);
        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * @inheridoc
     */
    public function setTemperature(float $value): WeatherStatusInterface
    {
        return $this->setData(self::TEMPERATURE, $value);
    }

    /**
     * @inheridoc
     */
    public function getWindSpeed(): ?float
    {
        $value = $this->getData(self::WIND_SPEED);
        return is_numeric($value) ? (float)$value : null;
    }

    /**
     * @inheridoc
     */
    public function setWindSpeed(float $value): WeatherStatusInterface
    {
        return $this->setData(self::WIND_SPEED, $value);
    }

    /**
     * @inheridoc
     */
    public function getWindDirection(): ?int
    {
        $value = $this->getData(self::WIND_DIRECTION);
        return is_numeric($value) ? (int)$value : null;
    }

    /**
     * @inheridoc
     */
    public function setWindDirection(int $value): WeatherStatusInterface
    {
        return $this->setData(self::WIND_DIRECTION, $value);
    }

    /**
     * @inheridoc
     */
    public function getCreatedAt(): ?string
    {
        $value = $this->getData(self::CREATED_AT);
        return is_string($value) ? $value : null;
    }

    /**
     * @inheridoc
     */
    public function setCreatedAt(string $value = null): WeatherStatusInterface
    {
        return $this->setData(
            self::CREATED_AT,
            $value ?? date('Y-m-d H:i:s')
        );
    }
}
