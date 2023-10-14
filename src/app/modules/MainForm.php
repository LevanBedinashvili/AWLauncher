<?php
namespace app\modules;

use action\Animation;
use php\time\Time;
use php\compress\ZipFile;
use Exception;
use php\lib\arr;
use php\lang\Thread;
use bundle\http\HttpResponse;
use action\Element;
use php\io\Stream;
use bundle\updater\UpdateMe;
use php\io\File;
use php\lib\fs;
use php\gui\framework\AbstractModule;
use php\gui\framework\ScriptEvent; 

$GLOBALS['site'] = "test1.ru";

class MainForm extends AbstractModule
{
    /**
     * @event update.action 
     */
    function doUpdateAction(ScriptEvent $e = null)
    {    
        if(file_get_contents("https://www.google.com"))
        {
            if(file_get_contents("test1.ru"))
            {
                $news1 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/news/1.txt'), true);
                //$news2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/news/2.txt'), true);
                Element::loadContentAsync($this->news1, $news1['img'], function () use ($e, $event){});
                //Element::loadContentAsync($this->news2, $news2['img'], function () use ($e, $event){});
                
                $config = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/config.txt'), true);
                $monitoring1 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/1.php'), true);
                //$monitoring2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/2.php'), true);
               // $monitoring3 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/3.php'), true);
                
                if(!$monitoring1['serveronline']){$this->serveronline1->fillColor = "FF0000";}else{$this->serveronline1->fillColor = "52E93A";}
                //$this->online1->text = ''.$monitoring1['online'].'/'.$monitoring1['maxonline'].'';
                //$this->progressonline1->progressK = $monitoring1['online'] / $monitoring1['maxonline'];
                $this->nameserver1->text = ''.$monitoring1['name'].'';
                $this->label->text = ''.$news1['news_text'].'';
                $this->programmlogs("ახალი ამბების განახლება.");
            }
            else
            {
                $this->programmlogs("ახალი ამბების განახლება.");
                $this->form("message")->message->text = "აღმოჩენილია პრობლემა, სერვერი დროებით მიუწვდმელია";
                $this->loadForm('message');
            }
        }
        else
        {
            $this->programmlogs("შეცდომა: არ არის ინტერნეტთან წვდომა");
            $this->form("message")->message->text = "თქვენ არ გაქვთ ინტერნეტთან კავშირი";
            $this->loadForm('message');
        }
    }
    /**
     * @event downloader.progress 
     */
    function doDownloaderProgress(ScriptEvent $event = null)
    {   
        if($this->button->text == "შეჩერება")
        {
            $percent = round($event->progress * 100 / $event->max, 2);
            $this->progress->progressK = $event->progress / $event->max;
            $this->message->text = "ჩატვირთვა:".$percent."% (".round($this->downloader->speed / 1024)." KB/s)";
        } 
    }
    /**
     * @event downloader.errorOne 
     */
    function doDownloaderErrorOne(ScriptEvent $event = null)
    {    
        $message = $event->error ?: 'неизвестная';
        
        /** @var HttpResponse $response */
        $response = $event->response;
        
        if ($response->isNotFound()) {
            $message = 'ფაილი ვერ მოიძებნა';
        } else if ($response->isAccessDenied()) {
            $message = 'მიუწვდომელია';
        } else if ($response->isServerError()) {
            $message = 'სერვერი მიუწვდომელია';
        }
        $this->message->text = 'შეცდომა - '.$message.''; 
        $this->programmlogs("შეცდომა: ".$message.".");   
    }
    /**
     * @event downloader.successAll 
     */
    function doDownloaderSuccessAll(ScriptEvent $event = null)
    {   
        if($this->button->text == "შეჩერება")
        {
            $this->button->enabled = false;
            $this->programmlogs("Unpacking game files.");
            $zip = new ZipFile("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game/GrandTheftAutoSA.zip");
            $to = "".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game";
            new Thread(function()use($zip, $to)
            {
                try
                {
                    $unpacked = 0;
                    $count = arr::count($zip->statAll()); 
                    $zip->unpack($to, null, function($name)use(&$unpacked, $count)
                    {
                        $unpacked += 1;
                        $isEnd = $unpacked == $count;
                        uiLater(function()use($unpacked, $isEnd, $count, $name)
                        {
                            $this->progress->progressK = $unpacked / $count;
                            if($isEnd)
                            {
                                $this->programmlogs("ჩატვირთვა დასრულებულია");
                                $this->button->enabled = true;
                                $this->progress->progress = 0;
                                $this->ini->set("instal",1,"main");
                                $this->ini->set("resetgame",1,"main");
                                $this->button->text = "Играть";
                                $this->dowloand_sborka_sucsessful->start();
                                $this->message->text = 'თამაშის ჩატვირთვა დასტულდა წარმატებით';
                                app()->hideForm($this->getContextFormName());
                                app()->showForm('MainForm'); 
                                return $this->timer->start();
                            }
                            $this->message->text = 'Unpacking File: '.$name;
                        });
                    });
                }
                catch(Exception $ex) { uiLater(function() { $this->message->text = 'შეცდომა ფაილის გადმოტვირთვისას'; }); }
            })->start();  
        }
        if($this->button->text == "ПРОВЕРКА...")
        {
            $this->progress->progress = 0;
            $this->button->text = "ТЕСТ";
        }
    }

    /**
     * @event timer.action 
     */
    function doTimerAction(ScriptEvent $e = null)
    {    
        $this->programmlogs("არქივის წაშლა - GrandTheftAutoSA.zip.");
        unlink("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game/GrandTheftAutoSA.zip");
    }

    /**
     * @event timerAlt.action 
     */
    function doTimerAltAction(ScriptEvent $e = null)
    {    
        $this->button->text = "შეჩერება";
        $this->downloader->destDirectory = "".$_ENV['SystemDrive']."\\AW Launcher\\AWP Launcher\\game";  
        $this->downloader->urls = "https://github.com/LivingCoder/awrp/releases/download/0.1/GrandTheftAutoSA.zip";
        $this->downloader->start();
        $this->message->text = "დაკავშირება სერვერთან";
        $this->programmlogs("დაწყებულია თამაშის ჩატვირთვა");
    }

    /**
     * @event start_game.action 
     */
    function doStart_gameAction(ScriptEvent $e = null)
    {   
        $this->message->text = "თამაშის ჩართვა";
        $this->programmlogs("[DEBUG]Game Start");
        $this->text_off_start_game->start(); 
        execute(''.$_ENV['SystemDrive'].'/AW Launcher/AW Launcher/game/samp.exe '.$GLOBALS['ip'].' -n'.$this->ini->get("nickname","main").'');
        $this->text_off_start_game->start(); 
        $this->programmlogs("[DEBUG]Connection to ".$GLOBALS['ip']);
    }

    /**
     * @event text_off_start_game.action 
     */
    function doText_off_start_gameAction(ScriptEvent $e = null)
    {    
        $this->message->text = "";
    }

    /**
     * @event update_ini.successAll 
     */
    function doUpdate_iniSuccessAll(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event update_ini.done 
     */
    function doUpdate_iniDone(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event ini.save 
     */
    function doIniSave(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event ini.construct 
     */
    function doIniConstruct(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event ini.error 
     */
    function doIniError(ScriptEvent $e = null)
    {    
        
    }

    /**
     * @event dowloand_sborka_sucsessful.action 
     */
    function doDowloand_sborka_sucsessfulAction(ScriptEvent $e = null)
    {    
        $this->message->text = ''; 
    }
    /**
     * Лог программы
     */
    function programmlogs($logs)
    {    
        $now = Time::now();
        $time = $now->toString('yyyy-MM-dd HH:mm');
        if(fs::isDir("".$_ENV['SystemDrive']."/Games/AWP Launcher"))
        {
            Stream::putContents($_ENV['SystemDrive']."\\Games\\AWP Launcher\\logs.log", $time." - "."".$logs.""."\r\n", "a+");
        }
    }
}
