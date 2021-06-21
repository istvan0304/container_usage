<?php

namespace istvan0304\usage\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class UsageController
 * @package istvan0304\usage\controllers
 */
class UsageController extends Controller
{

    public $nagiosFilePath;
    public $nagiosFileName;
    public $watchThreads;
    public $memoryWatch;
    public $phpContainerRebooted;
    public $sqlContainerRebooted;
    public $volumes;

    public function init()
    {
        $module = $this->module;
        $this->nagiosFilePath = trim(rtrim($module->nagiosFilePath, '\/'));
        $this->nagiosFileName = trim(ltrim($module->nagiosFileName, '\/'));
        $this->watchThreads = $module->watchThreads;
        $this->memoryWatch = $module->memoryWatch;
        $this->phpContainerRebooted = $module->phpContainerRebooted;
        $this->sqlContainerRebooted = $module->sqlContainerRebooted;
        $this->volumes = $module->volumes;

        parent::init();
    }

    /**
     * php yii usage
     */
    public function actionIndex()
    {
        $containerMessage = '';

        // .not_rebooted fájl létrehozásának idejét adja vissza.
        if ($this->phpContainerRebooted) {
            $filePath = '/var/.not_rebooted';
            if (!is_file($filePath)) {
                $file = fopen($filePath, "w");
                fclose($file);
            }

            $containerMessage .= 'php_reboot|' . date('Y-m-d H:i:s', filemtime($filePath)) . PHP_EOL;
        }

        // Sql konténer legutolsó újraindulásának az időpontját adja vissza.
        if ($this->sqlContainerRebooted) {
            $connection = Yii::$app->db;
            $sqlUpSince = $connection->createCommand('SELECT NOW() - INTERVAL VARIABLE_VALUE SECOND AS "value"
            FROM performance_schema.session_status
            WHERE VARIABLE_NAME = "Uptime"')->queryOne();
            $containerMessage .= 'sql_reboot|' . $sqlUpSince['value'] . PHP_EOL;
        }

        // Memória adatok
        if ($this->memoryWatch) {
            $memoryLimit = exec('cat /sys/fs/cgroup/memory/memory.limit_in_bytes');
            $memoryUsage = exec('cat /sys/fs/cgroup/memory/memory.usage_in_bytes');
//            $memoryUsagePercent = $memoryUsage / $memoryLimit * 100;
            $memoryMessage = 'memory|' . $memoryLimit . '|' . $memoryUsage . PHP_EOL;
            $containerMessage .= $memoryMessage;
        }

        // Apache szálak száma
        if ($this->memoryWatch) {
            $users = exec('ps -aux | grep apache2 | wc -l');
            $containerMessage .= 'threads|' . $users . PHP_EOL;
        }

        // Csatolások figyelése.
        if (is_array($this->volumes) && !empty($this->volumes)){
            $volumeMessage = '';

            foreach ($this->volumes as $key => $volumeErrorPath){
                if(file_exists($volumeErrorPath)){
                    $volumeMessage .= $key . '|' . date('Y-m-d H:i:s', filemtime($volumeErrorPath)) . PHP_EOL;
                }else{
                    $volumeMessage .= $key . '|' . 0 . PHP_EOL;
                }
            }

            $containerMessage .= $volumeMessage;
        }

        Console::output($containerMessage);

        if(!is_dir($this->nagiosFilePath)){
            mkdir($this->nagiosFilePath, 0777, true);
        }

        file_put_contents($this->getPath(), $containerMessage);
        Yii::info($containerMessage, 'usage');
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return trim(rtrim($this->nagiosFilePath, '\/')) . DIRECTORY_SEPARATOR . trim(ltrim($this->nagiosFileName, '\/'));
    }
}
