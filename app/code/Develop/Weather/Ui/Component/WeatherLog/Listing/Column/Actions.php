<?php

declare(strict_types=1);

namespace Develop\Weather\Ui\Component\WeatherLog\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var string
     */
    protected string $editUrl;

    /**
     * @var string
     */
    protected string $removeUrl;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param string $editUrl
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        $editUrl = '',
        $removeUrl = '',
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder   = $urlBuilder;
        $this->editUrl      = $editUrl;
        $this->removeUrl    = $removeUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');

                if (isset($item['id'])) {
                    $removeUrl = $this->urlBuilder->getUrl($this->removeUrl, ['id' => $item['id']]);
                    $item[$name]['remove']   = [
                        'href'      => $removeUrl,
                        'label'     => __('Remove')
                    ];
                }
            }
        }

        return $dataSource;
    }
}
