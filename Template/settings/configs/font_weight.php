<fieldset>
    <legend><?= t('Font Weight') ?></legend>
    <p><small><?= t('Font weight for task titles and text. Original Kanboard uses 400 (Normal).') ?></small></p>
    <select name="font_weight">
        <option value="300" <?= $configs['font_weight'] == '300' ? 'selected' : '' ?>>300 - Light</option>
        <option value="400" <?= $configs['font_weight'] == '400' ? 'selected' : '' ?>>400 - Normal (Kanboard Default)</option>
        <option value="500" <?= $configs['font_weight'] == '500' ? 'selected' : '' ?>>500 - Medium</option>
        <option value="700" <?= $configs['font_weight'] == '700' ? 'selected' : '' ?>>700 - Bold</option>
    </select>
</fieldset>
