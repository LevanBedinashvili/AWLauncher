<?php
namespace app\forms;

use script\storage\AbstractStorage;
use php\time\Time;
use php\lib\str;
use php\io\File;
use php\lib\fs;
use action\Element;
use action\Animation;
use php\io\Stream;
use php\lang\System;
use php\lang\Process;
use bundle\updater\AbstractUpdater;
use bundle\updater\UpdateMe;
use php\gui\framework\AbstractForm;
use php\gui\event\UXWindowEvent; 
use php\gui\event\UXMouseEvent; 
use php\gui\event\UXKeyEvent; 
use php\gui\event\UXEvent; 

$GLOBALS['site'] = "test1.ru";
$GLOBALS['ip'] = "37.230.162.226:7777";

class MainForm extends AbstractForm
{   const VERSION = '1.0.0.0';
    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $this->ini->path = $_ENV['SystemDrive']."\\AW Launcher\\AWP Launcher\\config.ini";
        //$this->version->text = self::VERSION;
        if($this->ini->get("instal","main") != "0" || $this->ini->get("resetgame","main") != "0")
        {
            $this->button->text = "PLAY";
        }
        else
        {
            $this->button->text = "ინსტალაცია";
        }
        $this->nickname->text = $this->ini->get("nickname","main");
        $this->closelauncher->se = $this->ini->get("closelauncher","main");
        $this->derectory->text = $_ENV['SystemDrive']."\\AW Launcher\\AWP Launcher\\game";
        //
        //$this->closelauncher->selected = $this->ini->get("closelauncher","main");
        //$this->derectory->text = $_ENV['SystemDrive']."\\Games\\AWP Launcher\\game";
        //$this->boxserver1->opacity = "0"; $this->boxserver2->opacity = "0"; $this->boxserver3->opacity = "0";
        //$this->serveronline1->opacity = "0"; 
        //$this->progressonline1->opacity = "0"; $this->progressonline2->opacity = "0"; $this->progressonline3->opacity = "0";
       // Animation::fadeTo($this->boxserver1, 500, 1.0, function () use ($e, $event) {});
        //Animation::fadeTo($this->serveronline1, 500, 1.0, function () use ($e, $event) {});
       // Animation::fadeTo($this->progressonline1, 500, 1.0, function () use ($e, $event) {});
        
        if(file_get_contents("https://www.google.com"))
        {
            if(file_get_contents("test1.ru"))
            {
                $news1 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/news/1.txt'), true);
             //   $news2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/news/2.txt'), true);
                Element::loadContentAsync($this->news1, $news1['img'], function () use ($e, $event){});
               // Element::loadContentAsync($this->news2, $news2['img'], function () use ($e, $event){});
                // Автообновление лаунера сборки
                //
                //$update_test = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/update.txt'), true);
               // $monitoring2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/2.php'), true);
               // $monitoring3 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/3.php'), true);
                //if(!$monitoring1['serveronline']){$this->serveronline1->fillColor = "FF0000";}else{$this->serveronline1->fillColor = "52E93A";}
              //  $this->online1->text = ''.$monitoring1['online'].'/'.$monitoring1['maxonline'].'';
               // $this->progressonline1->progressK = $monitoring1['online'] / $monitoring1['maxonline'];
                $monitoring1 = json_decode(Stream::getContents('https://github.com/LivingCoder/awrp/releases/download/0.1/test.txt'), true);
                $this->nameserver1->text = ''.$monitoring1['name'].'';
                $this->label->text = ''.$news1['news_text'].'';
              /*  if($config['count_server'] == 2)
                {
                    if(!$monitoring2['serveronline']){$this->serveronline2->fillColor = "FF0000";}else{$this->serveronline2->fillColor = "52E93A";}
                    $this->online2->text = ''.$monitoring2['online'].'/'.$monitoring2['maxonline'].'';
                    $this->progressonline2->progressK = $monitoring2['online'] / $monitoring2['maxonline'];
                    $this->nameserver2->text = ''.$monitoring2['name'].'';
                    
                    Animation::fadeTo($this->boxserver2, 1000, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->serveronline2, 1000, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->progressonline2, 1000, 1.0, function () use ($e, $event) {});
                }
                if($config['count_server'] == 3)
                {
                    if(!$monitoring2['serveronline']){$this->serveronline2->fillColor = "FF0000";}else{$this->serveronline2->fillColor = "52E93A";}
                    $this->online2->text = ''.$monitoring2['online'].'/'.$monitoring2['maxonline'].'';
                    $this->progressonline2->progressK = $monitoring2['online'] / $monitoring2['maxonline'];
                    $this->nameserver2->text = ''.$monitoring2['name'].'';
                    if(!$monitoring3['serveronline']){$this->serveronline3->fillColor = "FF0000";}else{$this->serveronline3->fillColor = "52E93A";}
                    $this->online3->text = ''.$monitoring3['online'].'/'.$monitoring3['maxonline'].'';
                    $this->progressonline3->progressK = $monitoring3['online'] / $monitoring3['maxonline'];
                    $this->nameserver3->text = ''.$monitoring3['name'].'';
                    
                    Animation::fadeTo($this->boxserver2, 1000, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->serveronline2, 1000, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->progressonline2, 1000, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->boxserver3, 1500, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->serveronline3, 1500, 1.0, function () use ($e, $event) {});
                    Animation::fadeTo($this->progressonline3, 1500, 1.0, function () use ($e, $event) {});
                }*/
            }
            else
            {
                $this->programmlogs("შეცდომა: სერვერი დროებით მიუწვდომელია.");
            }
        }
        else
        {
            $this->programmlogs("შეცდომა: არ არის ინტერნეტ კავშირი.");
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @event button.click-Left 
     */
    function doDowloadClickLeft(UXMouseEvent $e = null)
    {    
        if(fs::isDir("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game")){}else{$dir = new File("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game");$dir->mkdirs();}
        $this->ini->set("nickname",$this->nickname->text,"main");
        if($this->button->text != "შეჩერება")
        {
            if($this->ini->get("instal","main") != "0")
            {       
                if($this->button->text == "PLAY")
                {
                    //$ip = "37.230.162.226:7777";
                    $this->programmlogs("[DEBUG]Start preparation");
                    $this->message->text = "ჩატვირთვისთვის მომზადება";
                    execute(''.$_ENV['SystemDrive'].'/AW Launcher/AWP Launcher/game/samp.exe '.$GLOBALS['ip'].' -n'.$this->ini->get("nickname","main").'');
                    $this->programmlogs("Подключение к серверу - ".$ip['ip']);
                    if($this->ini->get("closelauncher","main") != "")
                    {
                        app()->shutdown();
                    }
                    else 
                    {
                        Animation::fadeTo($this->serverpanel, 200, 0.0, function () use ($e, $event){});
                        Animation::fadeTo($this->settingpanel, 400, 0.0, function () use ($e, $event)
                        {
                            $this->serverpanel->hide();
                            $this->blegroundsetting->hide();
                        });
                    }
                }
                /*$this->blegroundsetting->opacity = "0";
                $this->blegroundsetting->show();
                Animation::fadeTo($this->blegroundsetting, 200, 0.8, function () use ($e, $event) {});
                
                $config = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/config.txt'), true);
                $monitoring1 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/1.txt'), true);
                $this->panelnameserver1->text = ''.$monitoring1['name'].'';
                if($config['count_server'] == 2)
                {
                    $monitoring2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/2.txt'), true);
                    $this->panelnameserver2->show();
                    $this->panelnameserver2->text = ''.$monitoring2['name'].'';
                }
                if($config['count_server'] == 3)
                {
                    $monitoring2 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/2.txt'), true);
                    $monitoring3 = json_decode(Stream::getContents(''.$GLOBALS['site'].'/launcher/server/3.txt'), true);
                    $this->panelnameserver2->show();
                    $this->panelnameserver3->show();
                    $this->panelnameserver2->text = ''.$monitoring2['name'].'';
                    $this->panelnameserver3->text = ''.$monitoring3['name'].'';
                }
                $this->serverpanel->show();
                $this->serverpanel->opacity = "0";
                Animation::fadeTo($this->serverpanel, 400, 1.0, function () use ($e, $event) { });*/
            }
            else 
            {
                $this->button->text = "შეჩერება";
                $this->downloader->destDirectory = "".$_ENV['SystemDrive']."\\AW Launcher\\AWP Launcher\\game";  
                $this->downloader->urls = "https://github.com/LivingCoder/awrp/releases/download/0.1/GrandTheftAutoSA.zip";
                $this->downloader->start();
                $this->message->text = "სერვერთან დაკავშირება...";
                $this->programmlogs("დაწყებულია თამაშის გადმოწერა");
            }
        }
        else 
        {
            $this->downloader->stop();
            $this->message->text = "ჩატვირთვა შეჩერებულია!";
            $this->button->text = "ინსტალაცია";
            $this->progress->progressK = 0;
            $this->programmlogs("თამაშის ჩატვირთვა შეჩერებულია");
        } 
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




    /**
     * @event svernuti.click-Left 
     */
    function doSvernutiClickLeft(UXMouseEvent $e = null)
    {    
        app()->minimizeForm($this->getContextFormName());
        $this->programmlogs("[DEBUG]Launcher MinimizaForm");
    }

    /**
     * @event close_program.click-Left 
     */
    function doClose_programClickLeft(UXMouseEvent $e = null)
    {
        //НЕ ТРОГАТЬ!
        
        // Generated
        $e = $event ?: $e; // legacy code from 16 rc-2
        
        app()->hideForm($this->getContextFormName());
        $this->programmlogs("[DEBUG]Launcher Exit");
        if($this->button->text == "შეჩერება")
        {
            $this->programmlogs("არქივის წაშლა - GrandTheftAutoSA.zip.");
            $file = new File("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher/game/GrandTheftAutoSA.zip");
            $file->delete();
        }
    }

    /**
     * @event imageAlt.mouseDown-Left 
     */
    function doImageAltMouseDownLeft(UXMouseEvent $e = null)
    {    
$e = $event ?: $e; // legacy code from 16 rc-2

		browse('https://www.youtube.com/watch?v=qn80WFGM2Ns&feature=youtu.be&fbclid=IwAR2WETUYjILhhUKCW9oVjhepfcJKERo0_MjJBXwEcxTmf3M-J5F3hl_EDBU');

        
    }





    /**
     * @event Dowload.mouseDown-Left 
     */


    /**
     * @event svernuti.click-Left 
     */
  

    /**
     * @event Dowload.click-Left 
     */
    /**
     * Лог программы
     */
    function programmlogs($logs)
    {    
        $now = Time::now();
        $time = $now->toString('(yyyy-MM-dd HH:mm)');
        if(fs::isDir("".$_ENV['SystemDrive']."/AW Launcher/AWP Launcher"))
        {
            Stream::putContents($_ENV['SystemDrive']."\\AW Launcher\\AWP Launcher\\logs.log", $time." - "."".$logs.""."\r\n", "a+");
        }
    }
}
/*

function doPanelnameserver3ClickLeft(UXMouseEvent $e = null)
    {    
        $ip = json_decode(Stream::getContents("".$GLOBALS['site']."/launcher/server/3.txt"), true);
        execute(''.$_ENV['SystemDrive'].'/Games/AMBURG LAUNCHER/game/samp.exe '.$ip['ip'].' -n'.$this->ini->get("nickname","main").'');
        $this->programmlogs("სერვერთან დაკავშირება - ".$ip['ip']);
        if($this->ini->get("closelauncher","main") != "")
        {
            app()->shutdown();
        }
        else 
        {
            Animation::fadeTo($this->serverpanel, 200, 0.0, function () use ($e, $event){});
            Animation::fadeTo($this->settingpanel, 400, 0.0, function () use ($e, $event)
            {
                $this->serverpanel->hide();
                $this->blegroundsetting->hide();
            });
        }
        
    }

*/
