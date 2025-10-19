<?php
namespace Kanboard\Plugin\ThemeRevisionPlus;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\ThemeRevisionPlus\Model\TaskInfoCSSModel;


class Plugin extends Base
{
	public function initialize()
	{
		// register helper
		$this->helper->register('configsDataHelper', '\Kanboard\Plugin\ThemeRevisionPlus\Helper\ConfigsDataHelper');
		$this->helper->register('modeSwitchHelper', '\Kanboard\Plugin\ThemeRevisionPlus\Helper\ModeSwitchHelper');
		$this->helper->register('colorSwitchHelper', '\Kanboard\Plugin\ThemeRevisionPlus\Helper\ColorSwitchHelper');

		// add class "TR" to body
		$this->template->setTemplateOverride('layout', 'ThemeRevisionPlus:layout');

		// add logo to page
		$this->template->setTemplateOverride('header/title', 'ThemeRevisionPlus:header/title');
		$this->template->hook->attach('template:auth:login-form:before', 'ThemeRevisionPlus:auth/login_form_before');

		// admin config UI
		$this->route->addRoute('settings/themerevisionplus', 'PluginConfigsController', 'show', 'ThemeRevisionPlus');
		$this->template->hook->attach('template:config:sidebar', 'ThemeRevisionPlus:settings/sidebar');

		// set CSP
		$this->setContentSecurityPolicy(array('style-src' => '\'self\' \'unsafe-inline\' fonts.googleapis.com'));

		// load configs
		global $themeRevisionPlusConfig;
		$themeRevisionPlusConfig = $this->loadConfigs();

		// init color scheme
		$this->initColorScheme($themeRevisionPlusConfig['color_scheme']);

		// mode switch
		if (isset($themeRevisionPlusConfig['mode']) && $themeRevisionPlusConfig['mode'] == "development") {
			$this->helper->modeSwitchHelper->developmentMode();
		}
		else {
			$this->helper->modeSwitchHelper->productionMode();
		}

		// corner radius
		if (!empty($themeRevisionPlusConfig['corner_radius'])){
			$this->template->hook->attach('template:layout:head', 'ThemeRevisionPlus:layout/head_corner_radius', array('radius' => $themeRevisionPlusConfig['corner_radius']));
		}

		// icons replacement
		if (!isset($themeRevisionPlusConfig['enable_google_material_icons']) || $themeRevisionPlusConfig['enable_google_material_icons']) {
			$this->hook->on('template:layout:css', array('template' => 'plugins/ThemeRevisionPlus/Asset/material-symbols/index.min.css'));
		}

		// google fonts (load template always to handle font overrides)
		if (isset($themeRevisionPlusConfig['google_fonts'])){
			$this->template->hook->attach('template:layout:head', 'ThemeRevisionPlus:layout/head_google_fonts', array('configs' => $themeRevisionPlusConfig['google_fonts']));
		}

		// syntax highlight
		$this->hook->on('template:layout:css', array('template' => 'plugins/ThemeRevisionPlus/Asset/highlight/style.min.css'));
		$this->hook->on('template:layout:js', array('template' => 'plugins/ThemeRevisionPlus/Asset/highlight/highlight.min.js'));

		// main js
		$this->hook->on('template:layout:js', array('template' => 'plugins/ThemeRevisionPlus/Asset/main.min.js'));

		// Mobile enhancements (ThemeRevisionPlus)
		$this->initMobileFeatures();
	}

	public function onStartup(){
		// load translations
		Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');

		// enable custom task display (the css selectors depend on localized text)
		$this->enableCustomTaskDisplay($GLOBALS['themeRevisionPlusConfig']);
	}

	public function getPluginName()	{
		return 'ThemeRevisionPlus for Kanboard';
	}

	public function getPluginAuthor() {
		return '3D Tvornica (based on ThemeRevision by Greyaz)';
	}

	public function getPluginVersion() {
		return '1.0.3';
	}

	public function getPluginDescription() {
		return "Enhanced mobile theme for Kanboard with single-column portrait mode, swipe navigation, and multi-column landscape mode. Built on ThemeRevision.";
	}

	public function getPluginHomepage() {
		return 'https://github.com/valentt/Kanboard-ThemeRevision';
	}

	private function loadConfigs() {
		$configs;
		$defConfigs = $this->helper->configsDataHelper->getDefaultConfigs();
        $dbConfigs = $this->helper->configsDataHelper->loadConfigs();
        $oldConfigs = $this->helper->configsDataHelper->calcOldConfigs($dbConfigs);
        //old user, need update
        if (!empty($oldConfigs)){
			// check color diffs
            $colorDiffs = $this->helper->configsDataHelper->calcColorDiffs($oldConfigs);
            if (!empty($colorDiffs)){
                $this->helper->configsDataHelper->saveColorDiffs($colorDiffs);
            }
			// merged configs
            $mergedConfigs = $this->helper->configsDataHelper->calcMergedConfigs($oldConfigs, $defConfigs);
			// load and save configs
            $configs = $mergedConfigs;
            $this->helper->configsDataHelper->saveConfigs($configs);
        }
        //old user, need not update
        elseif (!empty($dbConfigs)){
			// Merge with default configs to ensure new palettes (like dark_v2_palette) are included
			// IMPORTANT: Always use palette colors from defaults, not from database
			// This ensures that palette updates in DefaultConfigsModel.php are applied immediately
            $configs = array_merge($defConfigs, $dbConfigs);
			// Override database palettes with fresh ones from defaults
			$configs['light_palette'] = $defConfigs['light_palette'];
			$configs['dark_palette'] = $defConfigs['dark_palette'];
			$configs['dark_v2_palette'] = $defConfigs['dark_v2_palette'];
			$configs['normal_dark_palette'] = $defConfigs['normal_dark_palette'];
        }
        //new user
        else {
			// load and save configs
            $configs = $defConfigs;
            $this->helper->configsDataHelper->saveConfigs($configs);
        }
		return $configs;
	}

	private function initColorScheme($colorScheme) {
		if (isset($colorScheme) && $colorScheme == "light") {
			$this->helper->colorSwitchHelper->setColor2Light();
		}
		elseif (isset($colorScheme) && $colorScheme == "dark"){
			$this->helper->colorSwitchHelper->setColor2Dark();
		}
		elseif (isset($colorScheme) && $colorScheme == "dark_v2"){
			$this->helper->colorSwitchHelper->setColor2DarkV2();
		}
		elseif (isset($colorScheme) && $colorScheme == "normal_dark"){
			$this->helper->colorSwitchHelper->setColor2NormalDark();
		}
		else {
			// user config UI
			$this->route->addRoute('user/:user_id/theme', 'UserSettingsController', 'show', 'ThemeRevisionPlus');
			$this->template->hook->attach('template:user:sidebar:actions', 'ThemeRevisionPlus:user/sidebar');
			$this->template->hook->attach('template:header:dropdown', 'ThemeRevisionPlus:user/header_dropdown');
			$this->helper->colorSwitchHelper->setColorByUser();
		}
	}

	private function enableCustomTaskDisplay($config){
		// adjust column and task info
		$columnList = array();
		$taskList = array();
		foreach($config['column_header_info'] as $key => $value){
			if ($value == false){
				$columnList[] = $key;
			}
		}
		foreach($config['board_task_info'] as $key => $value){
			if ($value == false){
				$taskList[] = $key;
			}
		}
		$this->template->hook->attach('template:layout:head', 'ThemeRevisionPlus:layout/head_task_info_display', array(
			'styles' 	=> TaskInfoCSSModel::getFullCSS($columnList, $taskList),
			'opacity' 	=> $config['task_footer_opacity']
		));
	}

	private function initMobileFeatures() {
		$controller = $this->router->getController();
		$action     = $this->router->getAction();

		// Check if mobile features are enabled for this user
		$enabled = $this->userSession->isLogged()
			? $this->userMetadataModel->get($this->userSession->getId(), 'mobile_beta', '1') === '1'
			: true;

		// Only apply mobile features on the board view
		if ($enabled && $controller === 'BoardViewController' && $action === 'show') {
			// Inject mobile CSS
			$this->hook->on('template:layout:css', array('template' => 'plugins/ThemeRevisionPlus/Asset/mobile.css'));

			// Inject mobile JavaScript
			$this->hook->on('template:layout:js', array('template' => 'plugins/ThemeRevisionPlus/Asset/swipe.js'));

			// Add mobile navigation toggle to header
			$this->template->hook->attach('template:layout:top', 'ThemeRevisionPlus:layout/mobile_toggle');
		}

		// Add route for mobile settings toggle
		if ($this->userSession->isLogged()) {
			$this->route->addRoute('mobile/toggle', 'MobileSettingsController', 'toggle', 'ThemeRevisionPlus');
		}
	}
}
