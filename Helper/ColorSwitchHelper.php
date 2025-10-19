<?php

namespace Kanboard\Plugin\ThemeRevisionPlus\Helper;
use Kanboard\Plugin\ThemeRevisionPlus\Helper\BaseHelper;
use Kanboard\Plugin\ThemeRevisionPlus\Model\CustomColorModel;

class ColorSwitchHelper extends BaseHelper
{
    public function setColor2Dark(){
        $this->container['colorModel'] = $this->container->factory(function ($c) {
            return new CustomColorModel($c, "dark");
        });
    }

    public function setColor2Light(){
        $this->container['colorModel'] = $this->container->factory(function ($c) {
            return new CustomColorModel($c, "light");
        });
    }

    public function setColor2NormalDark(){
        $this->container['colorModel'] = $this->container->factory(function ($c) {
            return new CustomColorModel($c, "normal_dark");
        });
    }

    public function setColor2DarkV2(){
        $this->container['colorModel'] = $this->container->factory(function ($c) {
            return new CustomColorModel($c, "dark_v2");
        });
    }

    public function setColorByUser(){
        $this->container['colorModel'] = $this->container->factory(function ($c) {
            return new CustomColorModel($c, "auto");
        });
        
        $this->getPlugin()->on('app.bootstrap', function($c) {
            // get user id
            $userId = $this->userSession->getId();
            // get setting
		    $remoteScheme = $this->userMetadataModel->get($userId, "TR.color.scheme.user", "");
            // set color
            if ($remoteScheme== "light"){
                $this->setColor2Light();
            }
            elseif ($remoteScheme== "dark"){
                $this->setColor2Dark();
            }
        });
    }
}

