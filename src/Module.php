<?php

namespace attek\usage;

use Yii;
use yii\log\FileTarget;
use yii\base\Module as BaseModule;

/**
 * Class Module
 * @package attek\usage
 */
class Module extends BaseModule {
    public $controllerNamespace = 'attek\usage\controllers';

    /**
     * @var string|array ws
     */
    public $app = 'ws';
    /**
     * @var string|array Értesítés küldése erre az email címre vagy címekre ha több
     */
    public $adminEmail;
    /**
     * @var string Feladó email címe
     */
    public $senderEmail;
    /**
     * @var int Értesítés küldése, ha a apache szálak szám a megadott érték fölött van, default 100
     */
    public $maxUsers = 100;
    /**
     * @var int Értesítés küldése, ha a memória kihaszáltság a megadott százalék fölött van, default 80
     */
    public $memoryUsageInPercent = 80;
    /**
     * @var bool Értesítés küldése, ha a php konténer újraindult, default true
     */
    public $phpContainerRebooted = true;
    /**
     * @var bool Értesítés küldése, ha a MySql konténer újraindult, default false
     */
    public $sqlContainerRebooted = false;
    /**
     * @var string SMS service URL
     */
    public $sms_service_url;
    /**
     * @var string SMS service felhasználó név
     */
    public $sms_auth_user;
    /**
     * @var string SMS service webszervíz token
     */
    public $sms_auth_token;
    /**
     * @var string SMS service jelszó op=get_token esetén kell
     */
    public $sms_auth_pass;
    /**
     * @var string SMS service művelet típus
     */
    public $sms_operation = 'pv';
    /**
     * @var string Erre a telefonszámara megy az SMS értesítő
     */
    public $adminPhone;

    public function init() {

        $log = Yii::$app->log;
        $fileTarget = new FileTarget();
        $fileTarget->logVars = [];
        $fileTarget->logFile = Yii::getAlias('@runtime') . '/logs/usage.log';
        $fileTarget->categories = ['usage'];
        $fileTarget->levels = ['info'];
        $log->targets[] = $fileTarget;

        parent::init();
    }
}