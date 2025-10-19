<?= $this->asset->css('plugins/ThemeRevisionPlus/Asset/spectrum/min.css') ?>
<?= $this->asset->js('plugins/ThemeRevisionPlus/Asset/spectrum/min.js') ?>

<!-- Title -->
<div class="page-header">
    <h2><?= t('ThemeRevisionPlus Settings') ?></h2>
</div>

<?php if ($this->user->isAdmin()): ?>
    <!-- diff colors -->
    <?php if (!empty($color_diffs)): ?>
        <?= $this->render('ThemeRevisionPlus:settings/configs/color_update_notice', array('color_difffs' => $color_diffs)) ?>
    <?php endif ?>

    <!-- Configs -->
    <form method="post" action="<?= $this->url->href('PluginConfigsController', 'save', array('plugin' => 'ThemeRevisionPlus')) ?>">
        <?= $this->form->csrf() ?>
        <!-- Color Scheme -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/color_scheme', array('configs' => $configs)) ?>

        <!-- Logo -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/logo') ?>

        <!-- Task Color -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/task_color', array('configs' => $configs)) ?>

        <!-- Icons -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/icons', array('configs' => $configs)) ?>

        <!-- Google Fonts -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/google_fonts', array('configs' => $configs)) ?>

        <!-- Column Header Info -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/column_header_info', array('configs' => $configs)) ?>

        <!-- Board Task Info -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/board_task_info', array('configs' => $configs)) ?>

        <!-- Corner Radius -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/corner_radius', array('configs' => $configs)) ?>

        <!-- Font Weight -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/font_weight', array('configs' => $configs)) ?>

        <!-- Light Palette -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/palette', array('configs' => $configs, 'end_keys' => $end_keys, 'color' => 'light')) ?>

        <!-- Dark Palette -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/palette', array('configs' => $configs, 'end_keys' => $end_keys, 'color' => 'dark')) ?>

        <!-- Mode -->
        <?= $this->render('ThemeRevisionPlus:settings/configs/mode', array('configs' => $configs)) ?>
        
        <!-- Save -->
        <p><input type="submit" class="btn btn-blue" value="<?= t('Save') ?>"></p>
    </form>
    
    <!-- Reset -->
    <form method="post" action="<?= $this->url->href('PluginConfigsController', 'reset', array('plugin' => 'ThemeRevisionPlus')) ?>">
        <fieldset>
            <legend><?= t('Reset Configs') ?></legend>
            <input type="submit" class="btn btn-red" value="<?= t('Reset') ?>"> 
        </fieldset>
    </form>

    <!-- init color pickers -->
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event){
            if ($){
                $(".tr-color-picker > input[type='text']").spectrum({
                    preferredFormat: "rgb",
                    showInput: true,
                    showAlpha: true
                });
                $(".overwrite-checkbox").change(function(event) {
                    $(event.target).val($(event.target).is(':checked')) 
                });
            }
        });
    </script>
<?php else: ?>
    <p class="alert alert-error"><?= t('Access Forbidden') ?></p>
<?php endif ?>
