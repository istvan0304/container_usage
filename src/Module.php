<?php

namespace istvan0304\usage;

use Yii;
use yii\log\FileTarget;
use yii\base\Module as BaseModule;

/**
 * Class Module
 * @package istvan0304\usage
 */
class Module extends BaseModule {

    public $controllerNamespace = 'istvan0304\usage\controllers';

    /**
     * Nagios fájl elérési útvonala.
     * @var string
     */
    public $nagiosFilePath  = DIRECTORY_SEPARATOR . 'nagios';
    /**
     * Fájl név.
     * @var string
     */
    public $nagiosFileName  = 'watch.txt';
    /**
     * Szálk számának figyelése. Default true.
     * @var bool
     */
    public $watchThreads  = true;
    /**
     * Memória figyelés. Default true.
     * @var bool
     */
    public $memoryWatch = true;
    /**
     * @var bool Értesítés küldése, ha a php konténer újraindult, default true
     */
    public $phpContainerRebooted = true;
    /**
     * @var bool Értesítés küldése, ha a MySql konténer újraindult, default false
     */
    public $sqlContainerRebooted = true;
    /**
     * Csatolások.
     * @var array
     */
    public $volumes = [];

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
