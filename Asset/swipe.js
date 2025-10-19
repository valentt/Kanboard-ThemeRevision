/**
 * ThemeRevisionPlus - Mobile Swipe Navigation
 * Handles swipe gestures and column navigation for mobile board view
 */

(function () {
  'use strict';

  // Only run on board view controller
  var body = document.body;
  if (!body.classList.contains('controller-boardviewcontroller') ||
      !body.classList.contains('action-show')) {
    return;
  }

  // Get the columns container
  var columnsWrap = document.querySelector('.board-swimlane-columns');
  if (!columnsWrap) {
    return;
  }

  // Get all columns
  var columns = Array.prototype.slice.call(columnsWrap.querySelectorAll('.board-column'));
  if (!columns.length) {
    return;
  }

  // Get project ID for session storage key
  var projEl = document.querySelector('[data-project-id]');
  var projectKey = projEl
    ? 'kb_col_idx_' + projEl.getAttribute('data-project-id')
    : 'kb_col_idx';

  // Media query for landscape detection
  var mqLand = window.matchMedia('(orientation: landscape)');
  if (mqLand.addEventListener) {
    mqLand.addEventListener('change', applyLayout);
  } else if (mqLand.addListener) {
    mqLand.addListener(applyLayout);
  }

  // Current column index (restore from session storage)
  var idx = clamp(parseInt(sessionStorage.getItem(projectKey) || '0', 10), 0, columns.length - 1);

  // Utility functions
  function clamp(n, a, b) {
    return Math.max(a, Math.min(n, b));
  }

  function isLand() {
    return mqLand.matches;
  }

  function isMobile() {
    return window.innerWidth <= 1024;
  }

  /**
   * Set the active column (portrait mode only)
   */
  function setActive(i) {
    idx = clamp(i, 0, columns.length - 1);
    sessionStorage.setItem(projectKey, String(idx));

    if (isLand() || !isMobile()) {
      return;
    }

    // Update column visibility
    columns.forEach(function (c, j) {
      c.style.display = (j === idx) ? '' : 'none';
      c.classList.toggle('is-active', j === idx);
    });

    // Update navigation buttons state
    updateNavButtons();

    // Show column indicator
    showColumnIndicator();

    // Announce to screen readers
    announceColumn();
  }

  /**
   * Scroll to the active column (landscape mode)
   */
  function scrollToActive() {
    if (!isLand() || !isMobile()) {
      return;
    }

    var target = columns[idx];
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        inline: 'start',
        block: 'nearest'
      });
    }
  }

  /**
   * Apply layout based on orientation
   */
  function applyLayout() {
    if (!isMobile()) {
      // Desktop: show all columns normally
      columns.forEach(function (c) {
        c.style.display = '';
        c.classList.remove('is-active');
      });
      return;
    }

    if (isLand()) {
      // Landscape: show all columns in scrollable grid
      columns.forEach(function (c) {
        c.style.display = '';
        c.classList.remove('is-active');
      });
      scrollToActive();
    } else {
      // Portrait: show only active column
      setActive(idx);
    }
  }

  /**
   * Update prev/next button states
   */
  function updateNavButtons() {
    var prevBtn = document.querySelector('[data-mobile-prev-col]');
    var nextBtn = document.querySelector('[data-mobile-next-col]');

    if (prevBtn) {
      prevBtn.disabled = idx === 0;
      prevBtn.setAttribute('aria-label', 'Previous column (' + (idx) + ' of ' + columns.length + ')');
    }

    if (nextBtn) {
      nextBtn.disabled = idx === columns.length - 1;
      nextBtn.setAttribute('aria-label', 'Next column (' + (idx + 2) + ' of ' + columns.length + ')');
    }
  }

  /**
   * Show temporary column indicator
   */
  function showColumnIndicator() {
    var indicator = document.getElementById('column-indicator');

    if (!indicator) {
      indicator = document.createElement('div');
      indicator.id = 'column-indicator';
      indicator.className = 'column-indicator';
      document.body.appendChild(indicator);
    }

    var columnTitle = columns[idx].querySelector('.board-column-title');
    var titleText = columnTitle ? columnTitle.textContent.trim() : 'Column ' + (idx + 1);

    indicator.textContent = (idx + 1) + ' / ' + columns.length + ': ' + titleText;
    indicator.classList.add('show');

    // Hide after 1.5 seconds
    clearTimeout(indicator.hideTimeout);
    indicator.hideTimeout = setTimeout(function () {
      indicator.classList.remove('show');
    }, 1500);
  }

  /**
   * Announce column change to screen readers
   */
  function announceColumn() {
    var announcer = document.getElementById('column-announcer');

    if (!announcer) {
      announcer = document.createElement('div');
      announcer.id = 'column-announcer';
      announcer.className = 'sr-only';
      announcer.setAttribute('role', 'status');
      announcer.setAttribute('aria-live', 'polite');
      announcer.style.position = 'absolute';
      announcer.style.left = '-10000px';
      announcer.style.width = '1px';
      announcer.style.height = '1px';
      announcer.style.overflow = 'hidden';
      document.body.appendChild(announcer);
    }

    var columnTitle = columns[idx].querySelector('.board-column-title');
    var titleText = columnTitle ? columnTitle.textContent.trim() : 'Column ' + (idx + 1);

    announcer.textContent = 'Showing column ' + (idx + 1) + ' of ' + columns.length + ': ' + titleText;
  }

  /**
   * Swipe gesture detection
   */
  var startX = null;
  var startY = null;
  var tracking = false;
  var startTime = null;

  var SWIPE_THRESHOLD = 50;  // Minimum distance for swipe
  var VERTICAL_THRESHOLD = 40; // Maximum vertical movement
  var TIME_THRESHOLD = 300; // Maximum time for fast swipe

  function handlePointerDown(e) {
    if (isLand() || !isMobile()) {
      return;
    }

    // Ignore if target is interactive element
    var target = e.target;
    if (target.closest('a, button, input, select, textarea, [contenteditable]')) {
      return;
    }

    tracking = true;
    startTime = Date.now();
    var point = e.touches ? e.touches[0] : e;
    startX = point.clientX;
    startY = point.clientY;
  }

  function handlePointerUp(e) {
    if (!tracking || isLand() || !isMobile()) {
      return;
    }

    tracking = false;

    var point = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0] : e;
    var dx = point.clientX - startX;
    var dy = point.clientY - startY;
    var elapsed = Date.now() - startTime;

    // Check if it's a valid swipe
    var isHorizontalSwipe = Math.abs(dx) > SWIPE_THRESHOLD && Math.abs(dy) < VERTICAL_THRESHOLD;
    var isFastSwipe = elapsed < TIME_THRESHOLD;

    if (isHorizontalSwipe || (isFastSwipe && Math.abs(dx) > SWIPE_THRESHOLD / 2)) {
      if (dx < 0 && idx < columns.length - 1) {
        // Swipe left: next column
        setActive(idx + 1);
      } else if (dx > 0 && idx > 0) {
        // Swipe right: previous column
        setActive(idx - 1);
      }
    }
  }

  function handlePointerCancel() {
    tracking = false;
  }

  // Attach swipe event listeners
  columnsWrap.addEventListener('pointerdown', handlePointerDown, { passive: true });
  columnsWrap.addEventListener('pointerup', handlePointerUp, { passive: true });
  columnsWrap.addEventListener('pointercancel', handlePointerCancel, { passive: true });

  // Fallback for older browsers
  columnsWrap.addEventListener('touchstart', handlePointerDown, { passive: true });
  columnsWrap.addEventListener('touchend', handlePointerUp, { passive: true });
  columnsWrap.addEventListener('touchcancel', handlePointerCancel, { passive: true });

  /**
   * Button click handlers
   */
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-mobile-prev-col]')) {
      e.preventDefault();
      if (idx > 0) {
        setActive(idx - 1);
      }
    }

    if (e.target.closest('[data-mobile-next-col]')) {
      e.preventDefault();
      if (idx < columns.length - 1) {
        setActive(idx + 1);
      }
    }
  });

  /**
   * Keyboard navigation
   */
  document.addEventListener('keydown', function (e) {
    if (!isMobile() || isLand()) {
      return;
    }

    // Arrow keys when not focused on input
    if (!e.target.matches('input, textarea, select, [contenteditable]')) {
      if (e.key === 'ArrowLeft' && idx > 0) {
        e.preventDefault();
        setActive(idx - 1);
      } else if (e.key === 'ArrowRight' && idx < columns.length - 1) {
        e.preventDefault();
        setActive(idx + 1);
      }
    }
  });

  /**
   * Handle window resize
   */
  var resizeTimeout;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(applyLayout, 150);
  });

  /**
   * Handle visibility change (restore state when returning to tab)
   */
  document.addEventListener('visibilitychange', function () {
    if (!document.hidden) {
      applyLayout();
    }
  });

  /**
   * Initialize layout on load
   */
  function init() {
    applyLayout();

    // Small delay to ensure DOM is ready
    setTimeout(function () {
      updateNavButtons();
    }, 100);
  }

  // Run initialization
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
