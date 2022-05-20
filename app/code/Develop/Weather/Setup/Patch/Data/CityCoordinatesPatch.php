<?php

namespace Develop\Weather\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class CityCoordinatesPatch implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $data = $this->getData();

        foreach ($data as $item) {
            $connection->insert(
                $this->moduleDataSetup->getTable('weather_city_coordinates'),
                [
                    'name'      => $item[0],
                    'latitude'  => $item[1],
                    'longitude' => $item[2]
                ]
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            ['Lublin', 51.246452, 22.568445],
            ['Paris', 48.8567, 2.3510],
            ['London', 51.5002, -0.1262],
            ['Berlin', 52.5235, 13.4115]
        ];
    }
}
