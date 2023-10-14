<?php
namespace app\modules;

use php\lib\fs;
use php\io\Stream;
use php\time\Time;
use bundle\updater\UpdateMe;
use Exception;
use php\lib\arr;
use php\lang\Thread;
use bundle\http\HttpResponse;
use php\gui\framework\ScriptEvent;
use php\gui\framework\AbstractModule;

$GLOBALS['site'] = "https://other.tumple-project.ru";

class launch extends AbstractModule
{
    /**
     * @event downloader.progress 
     */
    function doDownloaderProgress(ScriptEvent $event = null)
    {    
        $this->label->text = "Подготовка к запуску";
        $this->progressBar->progressK = $event->progress / $event->max;
    }
    /**
     * @event downloader.errorOne 
     */
    function doDownloaderErrorOne(ScriptEvent $event = null)
    {    
        $message = $event->error ?: 'Неизвестная ошибка';
        /** @var HttpResponse $response */
        $response = $event->response;
        if ($response->isNotFound()) $message = 'NotFound';
        else if ($response->isAccessDenied()) $message = 'AccessDenied';
        else if ($response->isServerError()) $message = 'ServerError';
        $this->label->text = $message;
        $this->programmlogs("Ошибка: ".$message.".");   
    }
    /**
     * @event downloader.successAll 
     */
    function doDownloaderSuccessAll(ScriptEvent $event = null)
    {
        $this->loadForm('MainForm');
        app()->hideForm($this->getContextFormName());
        $this->programmlogs("Запуск лаунчера.");   
    }
    /**
     * Лог программы
     */
    function programmlogs($logs)
    {    
        $now = Time::now();
        $time = $now->toString('yyyy-MM-dd HH:mm');
        if(fs::isDir("".$_ENV['SystemDrive']."/Games/Tumple Launcher"))
        {
            Stream::putContents($_ENV['SystemDrive']."\\Games\\Tumple Launcher\\logs.log", $time." - "."".$logs.""."\r\n", "a+");
        }
    }
}
