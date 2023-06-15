<?php
declare(strict_types=1);

namespace Base\PopupModule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;

class Popup extends Template
{
    const POPUP_CONFIG_PATH_BLOCK = 'popup_general/general/cms_block_popup';
    const BLOCK_TYPE = 'Magento\Cms\Block\Block';
    const IMAGE_CONFIG = 'popup_general/general/image';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context                $context,
        array                  $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public  function getBlockFromScope () : string {
        $result = '';
        $blockId = $this->_scopeConfig->getValue(self::POPUP_CONFIG_PATH_BLOCK, ScopeInterface::SCOPE_STORE);
        if ($blockId) {
            $result = $this->getLayout()
                ->createBlock(self::BLOCK_TYPE)
                ->setBlockId($blockId)
                ->toHtml();
        }
        return $result;
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getBaseUrlMedia() : string
    {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * @return string
     */
    public function getImageForPopup () : string
    {
        $result = '';
        $image = $this->_scopeConfig->getValue(self::IMAGE_CONFIG, ScopeInterface::SCOPE_STORE);
        if ($image) {
                $result = $image;
        }
        return $result;
    }
}
