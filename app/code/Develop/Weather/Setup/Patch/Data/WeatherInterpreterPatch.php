<?php

declare(strict_types=1);

namespace Develop\Weather\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class WeatherInterpreterPatch implements DataPatchInterface
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
            foreach ($item[0] as $id) {
                $connection->insert(
                    $this->moduleDataSetup->getTable('weather_interpreter'),
                    [
                        'id'            => $id,
                        'description'   => $item[1]
                    ]
                );
            }
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
            [[0], 'Clear sky'],
            [[1, 2, 3], 'Mainly clear, partly cloudy, and overcast'],
            [[45, 48], 'Fog and depositing rime fog'],
            [[51, 53, 55], 'Drizzle: Light, moderate, and dense intensity'],
            [[56, 57], 'Clear sky'],
            [[61, 63, 65], 'Clear sky'],
            [[66, 67], 'Freezing Rain: Light and heavy intensity'],
            [[71, 73, 75], 'Snow fall: Slight, moderate, and heavy intensity'],
            [[77], 'Snow grains'],
            [[80, 81, 82], 'Rain showers: Slight, moderate, and violent'],
            [[85, 86], 'Snow showers slight and heavy'],
            [[95], 'Thunderstorm: Slight or moderate'],
            [[96, 99], 'Thunderstorm with slight and heavy hail']
        ];
    }
}
