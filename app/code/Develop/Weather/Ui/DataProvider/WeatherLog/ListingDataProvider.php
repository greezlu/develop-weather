<?php

declare(strict_types=1);

namespace Develop\Weather\Ui\DataProvider\WeatherLog;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\DB\Select;

class ListingDataProvider extends DataProvider
{
    /**
     * @inheridoc
     */
    public function getSearchResult()
    {
        $result = parent::getSearchResult();

        if ($result->isLoaded()) {
            return $result;
        }

        /** @var Select $select */
        $select = $result->getSelect();

        $select->join(
            'weather_city_coordinates',
            'main_table.city_coordinates_id = weather_city_coordinates.id',
            'name'
        );

        $select->join(
            'weather_interpreter',
            'main_table.weather_interpreter_id = weather_interpreter.id',
            'description'
        );

        return $result;
    }
}
