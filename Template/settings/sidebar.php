<li <?= $this->app->checkMenuSelection('PluginConfigsController', 'show', 'ThemeRevisionPlus') ?>>
    <?= $this->url->link(t('ThemeRevisionPlus Settings'), 'PluginConfigsController', 'show', array('plugin' => 'ThemeRevisionPlus')) ?>
</li>
