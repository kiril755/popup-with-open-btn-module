<?php
declare(strict_types=1);

namespace Base\PopupModule\Model\Config;

use Magento\Config\Model\Config\Backend\Image as BackendImage;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\FileSystemException;

class Image extends BackendImage
{
    const UPLOAD_DIR = 'popup/image';

    /**
     * @return string
     * @throw LocalizedException
     */
    protected function _getUploadDir() : string
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * @return string[]
     */
    protected function _getAllowedExtensions() : array
    {
        return ['jpg', 'jpeg', 'png', 'svg'];
    }

    /**
     * @return string|null
     */
    protected function getTmpFileName() : string|null
    {
        $tmpName = null;
        if (isset($_FILES['groups']))
        {
            $tmpName = $_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value'];
        }
        else
        {
            $tmpName = is_array($this->getValue()) ? $this->getValue()['tmp_name'] : null;
        }
        return $tmpName;
    }

    /**
     * @return Image
     * @throws LocalizedException
     * @throws FileSystemException
     */
    public function beforeSave() : Image
    {
        $value = $this->getValue();
        $deleteFlag = is_array($value) && !empty($value['delete']);
        if ($this->isTmpFileAvailable($value) && $imageName = $this->getUploadedImageName($value))
        {
            $fileTmpName = $this->getTmpFileName();
            if ($this->getOldValue() && ($fileTmpName || $deleteFlag))
            {
                $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
            }
        }
        return parent::beforeSave();
    }

    /**
     * @param $value
     * @return bool
     */
    private function isTmpFileAvailable($value) : bool
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }

    /**
     * @param $value
     * @return string
     */
    private function getUploadedImageName($value) : string
    {
        if (is_array($value) && isset($value[0]['name']))
        {
            return $value[0]['name'];
        }
        return '';
    }
}
