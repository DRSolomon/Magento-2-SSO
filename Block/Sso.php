<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Sso
 * @author    Webkul Software Private Limited
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Sso\Block;

class Sso extends \Magento\Framework\View\Element\Template
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\Sso\Helper\Data                          $dataHelper
     * @param \Magento\Customer\Model\Session                  $customerSession
     * @param array                                            $data
     */
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\Sso\Helper\Data $dataHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Webkul\Sso\Model\ResourceModel\Integrations\CollectionFactory $integrationCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_dataHelper = $dataHelper;
        $this->_customerSession = $customerSession;
        $this->_integrationCollection  =$integrationCollection;
    }

    public function getLoggedInUserDetail(){
        $customerDetal = $this->_dataHelper->getLoggedInUserDetail();
        return $customerDetal;

    }

    public function isAuthorized()
    {
        $autorizationToken = $this->getRequest()->getParams();
        if (isset($autorizationToken)) {
            return $this->_dataHelper->isAuthorized($autorizationToken);
        }
        return false;
    }
    public function isLoggedIn() 
    {
        $isLoggedIn = $this->_dataHelper->isLoggedIn();
        return $isLoggedIn ;
    }
    
    public function getClientName() 
    {
        $autorizationToken = $this->getRequest()->getParams();
        $name = "";
        if (isset($autorizationToken['client_id']) && !empty($autorizationToken['client_id'])) {
            $collection = $this->_integrationCollection->create()->addFieldToFilter('client_id',['eq'=>$autorizationToken['client_id']]);
            if($collection->getSize() == 1) {
                foreach($collection as $model) {
                    $name = $model->getName();
                    break;
                }
                return $name;
            } else {
                return $name;
            }
            return $collection->getName();
        } else {
            return $name;
        }
    }
}