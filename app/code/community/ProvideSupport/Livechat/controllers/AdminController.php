<?php
class ProvideSupport_Livechat_AdminController extends Mage_Adminhtml_Controller_Action
{
    public function settingsAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addJs('provide/jquery.js');
        $this->getLayout()->getBlock('head')->addJs('provide/jquery-noconflict.js');
        $this->getLayout()->getBlock('head')->addJs('provide/md5.js');
        $this->getLayout()->getBlock('head')->addJs('provide/provide.js');
        $this->_addContent($this->getLayout()->createBlock('livechat/settings'))->_setActiveMenu('livechat');
        $this->renderLayout();
    }
    public function helpAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('livechat/help'))->_setActiveMenu('livechat');
        $this->renderLayout();
    }
    public function ajaxAction()
    {
        $dbction = $this->getRequest()->getParam('action');
        $db      = Mage::getModel('livechat/livechat')->load(1);
        if (!empty($dbction)) {
            switch ($dbction) {
                case 'getaccount':
                    echo $db->content;
                    break;
                case 'setaccount':
                    $data             = array(
                        'accountName' => $this->getRequest()->getParam('accountName'),
                        'accountHash' => $this->getRequest()->getParam('accountHash')
                    );
                    $param            = Zend_Json::decode($db->content);
                    $param['account'] = $data;
                    $param            = Zend_Json::encode((array) $param);
                    $db->setContent($param);
                    $db->save();
                    echo $db->content;
                    break;
                case 'setsettings':
                    $settings          = $this->getRequest()->getParam('settings');
                    $param             = Zend_Json::decode($db->content);
                    $param['settings'] = $settings;
                    $param             = Zend_Json::encode((array) $param);
                    $db->setContent($param);
                    $db->save();
                    echo $db->content;
                    break;
                case 'setcode':
                    $param = Zend_Json::decode($db->content);
                    $value = $this->getRequest()->getParam('value');
                    $type  = $this->getRequest()->getParam('type');
                    if ($type == 'true') {
                        $param['hiddencode'] = '';
                        $param['hiddencode'] = $value;
                    } else {
                        $param['code'] = '';
                        $param['code'] = $value;
                    }
                    $param = Zend_Json::encode((array) $param);
                    $db->setContent($param);
                    $db->save();
                    echo $db->content;
                    break;
                case 'clearall':
                    $param               = Zend_Json::decode($db->content);
                    $data                = array(
                        'accountName' => '',
                        'accountHash' => ''
                    );
                    $param['account']    = $data;
                    $param['hiddencode'] = '';
                    $param['code']       = '';
                    $param['settings']   = 'null';
                    $param               = Zend_Json::encode((array) $param);
                    $db->setContent($param);
                    $db->save();
                    echo $db->content;
                    break;
                default:
                    break;
            }
        }
    }
    public function indexAction()
    {
        settingsAction();
    }
}