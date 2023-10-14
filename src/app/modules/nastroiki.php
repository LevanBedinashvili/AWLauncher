<?php
namespace app\modules;

use Exception;
use php\lib\arr;
use php\lang\Thread;
use php\compress\ZipFile;
use php\gui\framework\AbstractModule;
use php\gui\framework\ScriptEvent; 


class nastroiki extends AbstractModule
{

    /**
     * @event downloader.successAll 
     */
    function doDownloaderSuccessAll(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event downloader.progress 
     */
    function doDownloaderProgress(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event downloader.errorOne 
     */
    function doDownloaderErrorOne(ScriptEvent $e = null)
    {    
        
    }

}
