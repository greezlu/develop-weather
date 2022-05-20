<?php

namespace Develop\Weather\Controller\Adminhtml\Action;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Develop\Weather\Api\WeatherStatusRepositoryInterface;

class Delete implements HttpPostActionInterface, HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Develop_Weather::weather_log';

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var WeatherStatusRepositoryInterface
     */
    private WeatherStatusRepositoryInterface $weatherStatusRepository;

    /**
     * @var MessageManagerInterface
     */
    private MessageManagerInterface $messageManager;

    /**
     * @param RedirectFactory $redirectFactory
     * @param RequestInterface $request
     * @param WeatherStatusRepositoryInterface $weatherStatusRepository
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        RedirectFactory $redirectFactory,
        RequestInterface $request,
        WeatherStatusRepositoryInterface $weatherStatusRepository,
        MessageManagerInterface $messageManager
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->request = $request;
        $this->weatherStatusRepository = $weatherStatusRepository;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $data = $this->request->getParams();

        if (isset($data['id']) && is_numeric($data['id'])) {
            try {
                $this->weatherStatusRepository->deleteById((int)$data['id']);
                $this->messageManager->addSuccessMessage(__('The entity was deleted.'));
            } catch (\Exception $error) {
                $this->messageManager->addErrorMessage(__('The entity was not deleted.'));
            }
        } else if (!empty($data['selected'])) {
            try {
                foreach ($data['selected'] as $entityId) {
                    if (is_numeric($entityId)) {
                        $this->weatherStatusRepository->deleteById((int)$entityId);
                    }
                }
                $this->messageManager->addSuccessMessage(__('List of entities was deleted.'));
            } catch (\Exception $error) {
                $this->messageManager->addErrorMessage(__('Not all of the entities were deleted.'));
            }
        }

        return $this->redirectFactory->create()->setPath('*/index/index');
    }
}
