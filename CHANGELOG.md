# Changelog

All notable changes to ThemeRevisionPlus will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.2] - 2025-10-19

### Fixed
- **Settings Menu Bug**: Fixed hardcoded references causing settings page errors
  - `Controller/PluginConfigsController.php`: Updated template path from `ThemeRevision:settings/configs` to `ThemeRevisionPlus:settings/configs`
  - `Controller/PluginConfigsController.php`: Fixed redirect URLs to use `plugin=ThemeRevisionPlus` instead of `plugin=ThemeRevision`
  - `Template/settings/sidebar.php`: Updated menu link and selection check to use `ThemeRevisionPlus`
  - Page title now shows "ThemeRevisionPlus Settings" instead of "ThemeRevision Settings"
  - This resolves the "Internal Error: Controller not found" when accessing settings

### Technical Details
- Settings menu now correctly links to `?controller=PluginConfigsController&action=show&plugin=ThemeRevisionPlus`
- All save/dismiss/reset actions redirect to correct plugin name
- Cache clearing recommended after deployment
- No database changes required

---

## [1.0.1] - 2025-10-19

### Fixed
- **Critical CSS Loading Bug**: Fixed hardcoded paths in Helper classes and templates
  - `Helper/ModeSwitchHelper.php`: Changed `plugins/ThemeRevision` to `plugins/ThemeRevisionPlus` for CSS loading
  - `Helper/ConfigsDataHelper.php`: Updated config file paths to use `plugins/ThemeRevisionPlus`
  - `Template/settings/configs.php`: Fixed Spectrum color picker asset paths and form action URLs
  - This resolves the "white text on white background" issue where menus were invisible
  - Users should clear browser cache (Ctrl+Shift+R) after update

### Technical Details
- All plugin asset paths now correctly reference `plugins/ThemeRevisionPlus/`
- Cache clearing recommended after deployment
- No database changes required

---

## [1.0.0] - 2025-10-19

### Added - Mobile Enhancements
- **Portrait Mode**: Single-column view with swipe navigation for phones
  - Swipe left/right gesture detection for column switching
  - Visual column indicator showing current position
  - Session persistence of last viewed column per project
  - Keyboard navigation with arrow keys

- **Landscape Mode**: Multi-column grid layout for phones and tablets
  - Responsive 2-3 column display based on screen width
  - Horizontal scrolling with snap-to-column behavior
  - Auto-scroll to last viewed column on page load

- **Touch Optimization**
  - 44px minimum touch targets (iOS HIG compliant)
  - Improved tap areas for buttons and dropdowns
  - Smooth scrolling with `-webkit-overflow-scrolling`

- **Accessibility Improvements**
  - Screen reader announcements for column changes
  - ARIA labels and roles on navigation controls
  - Keyboard focus indicators
  - Respects `prefers-reduced-motion` preference

- **Navigation Controls**
  - Prev/Next buttons for column navigation
  - Fixed position in portrait (bottom of screen)
  - Header position in landscape mode
  - Disabled state on first/last column

- **New Files**
  - `Asset/mobile.css` - Mobile-specific styles and layouts
  - `Asset/swipe.js` - Swipe gesture handler and navigation logic
  - `Template/layout/mobile_toggle.php` - Mobile navigation buttons
  - `Controller/MobileSettingsController.php` - User settings controller
  - `MOBILE_FEATURES.md` - Comprehensive mobile features documentation
  - `CHANGELOG.md` - This file

### Changed
- **Plugin.php**
  - Added `initMobileFeatures()` method for mobile functionality
  - Mobile CSS/JS injection via hooks
  - User metadata check for mobile beta toggle
  - Updated plugin metadata:
    - Name: "ThemeRevisionPlus for Kanboard"
    - Author: "3D Tvornica (based on ThemeRevision by Greyaz)"
    - Version: "1.0.0"
    - Description: Enhanced with mobile features
    - Homepage: Updated to fork URL

- **README.md**
  - Updated title and branding to ThemeRevisionPlus
  - Added mobile features documentation
  - Added mobile usage guide (portrait/landscape)
  - Added browser compatibility section
  - Added troubleshooting guide
  - Added development/customization instructions
  - Added upstream tracking instructions

### Technical Details
- Minimum Kanboard version: 1.2.28
- Browser support: iOS Safari 12+, Android Chrome 80+
- No modifications to Kanboard core
- All features implemented via plugin hooks
- Fully compatible with existing ThemeRevision customizations

### Migration from ThemeRevision
- Drop-in replacement - maintains full compatibility
- Existing settings and customizations preserved
- Mobile features enabled by default
- Can be disabled per-user via metadata

---

## Previous Versions (ThemeRevision)

This fork is based on ThemeRevision 1.1.12 by greyaz.

For ThemeRevision changelog, see: https://github.com/greyaz/ThemeRevision

### ThemeRevision 1.1.12 Base Features
- Task-first minimalist UI
- Dark/Light/Auto color schemes
- Customizable colors and fonts
- Google Material Icons
- Syntax highlighting
- Plugin compatibility (Calendar, Gantt, etc.)
- Mobile-responsive base layout
- Configurable task and column info display

---

**Note**: ThemeRevisionPlus maintains all original ThemeRevision features while adding enhanced mobile-specific functionality.
