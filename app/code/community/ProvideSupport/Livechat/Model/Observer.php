<?php
class ProvideSupport_Livechat_Model_Observer
{
    public $countPastCode;
    public function __construct()
    {
        $this->provide  = Mage::getModel('livechat/livechat')->load(1)->getData('content');
        $this->view     = Zend_Json::decode($this->provide, Zend_Json::TYPE_OBJECT);
        $this->settings = Zend_Json::decode($this->view->settings, Zend_Json::TYPE_OBJECT);
        $this->pos      = $this->settings->buttonLocation;
        $this->list     = $this->settings->buttonAvailableMenusList[0];
        $this->helper   = Mage::helper('livechat/data');
        $this->helper->initCode($this->view);
    }
    public function insertBlock($observer)
    {
        if (Mage::app()->getLayout()->getArea() == 'frontend') {
            $_name = $observer->getBlock()->getNameInLayout();
            $_type = $observer->getBlock()->getType();
            if ($this->settings->pluginEnabled) {
                if ($this->pos == 'fixed') {
                    if ($_name == 'root') {
                        $this->handler();
                    }
                } elseif ($this->pos == 'define') {
                    if ($_name == $this->list) {
                        $this->countPastCode = true; //1
                        $this->handler();
                    } else {
                        if ($_name == 'before_body_end' && !$this->countPastCode && $this->settings->buttonAvailableWhole) {
                            $this->helper->showModuleHiddenCode();
                            $this->countPastCode = true;
                        }
                    }
                }
            }
        }
    }
    protected function handler()
    {
        $this->helper->initJs();
        if ($this->settings->buttonAvailableAll == false && $this->settings->buttonAvailablePost == false && $this->settings->buttonAvailableWhole == false) {
            //Nothing to display in fixed position
        } elseif ($this->settings->buttonAvailableAll == false && $this->settings->buttonAvailablePost == false && $this->settings->buttonAvailableWhole) {
            //Only display the hidden code
            if ($this->pos === 'fixed') {
                $this->helper->showModuleJsHiddenCode();
            } else {
                $this->helper->showModuleHiddenCode();
                $this->countPastCode = true;
            }
        } else {
            if ($this->settings->buttonAvailableAll) {
                $this->helper->showInAllCode($this->pos);
            } else {
                $this->helper->showInAllHiddenCode($this->pos);
            }
            if ($this->settings->buttonAvailablePost) {
                if ($this->settings->buttonAvailablePostWhich == 'all') {
                    $this->helper->showAllPageCode($this->pos);
                } elseif ($this->settings->buttonAvailablePostWhich == 'selected') {
                    $this->helper->showSelectedPageCode($this->pos);
                }
            } else {
                $this->helper->showAllPageHiddenCode($this->pos);
            }
        }
    }
}
