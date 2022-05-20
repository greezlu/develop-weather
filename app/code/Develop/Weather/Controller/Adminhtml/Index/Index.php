<?php

declare(strict_types=1);

namespace Develop\Weather\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Develop_Weather::weather_log';

    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
