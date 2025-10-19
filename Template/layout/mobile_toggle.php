<?php
/**
 * ThemeRevisionPlus - Mobile Navigation Controls
 * Displays prev/next buttons for column navigation on mobile devices
 */

// Only show on board view
if ($this->app->router->getController() === 'BoardViewController'
    && $this->app->router->getAction() === 'show'):
?>

<div class="mobile-nav-controls pull-right" id="mobile-nav-controls" role="navigation" aria-label="Column navigation">
    <button
        type="button"
        data-mobile-prev-col
        class="btn btn-sm mobile-nav-btn"
        title="<?= t('Previous column') ?>"
        aria-label="<?= t('Previous column') ?>"
        id="mobile-prev-col-btn"
    >
        <span aria-hidden="true">&#8592;</span> <?= t('Prev') ?>
    </button>

    <button
        type="button"
        data-mobile-next-col
        class="btn btn-sm mobile-nav-btn"
        title="<?= t('Next column') ?>"
        aria-label="<?= t('Next column') ?>"
        id="mobile-next-col-btn"
    >
        <?= t('Next') ?> <span aria-hidden="true">&#8594;</span>
    </button>
</div>

<?php endif; ?>
