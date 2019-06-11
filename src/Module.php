<?php

namespace attek\usage;


class Module extends \yii\base\Module {
    public $controllerNamespace = 'attek\usage\controllers';

    public $adminEmail;
    public $senderEmail;
    public $maxUsers = 100;
    public $memoryUsageInPercent = 80;
    public $phpContainerRebooted = true;
    public $sqlContainerRebooted = false;
    public $sms_service_url;
    public $sms_auth_user;
    public $sms_auth_pass;
    public $adminPhone;

    public function init() {
        parent::init();
    }
}