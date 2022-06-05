<?php
namespace FiePaw\AntiInternalKick;
use FiePaw\AntiInternalKick\utils\ModifiedRakLib;
use pocketmine\network\mcpe\raklib\RakLibInterface;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;


/**
 * Class Main
 * @package Jibix\AntiInternalKick
 * @author Jibix Updated By FiePaw
 * @date 29.08.2021 - 17:25
 * @project AntiInternalKick
 */
class Main extends PluginBase{

    /** @var Main */
    private static Main $instance;

    /**
     * Function getInstance
     * @return Main
     */
    public static function getInstance(): Main{
        return self::$instance;
    }

    /**
     * Function onEnable
     */
    public function onEnable(): void{
        self::$instance = $this;
        $this->saveResource('config.yml');

        $network = Server::getInstance()->getNetwork();
        foreach ($network->getInterfaces() as $interface) {
            if ($interface instanceof RakLibInterface) {
                $interface->shutdown();

                $network->unregisterInterface($interface);
                $network->registerInterface(new ModifiedRakLib($this->getServer()));
                return;
            }
        }
    }
}