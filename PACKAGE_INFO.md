# ThemeRevisionPlus - Package Information

## 📦 What is This Package?

**ThemeRevisionPlus** is a **standalone, installable Kanboard plugin** that extends the original ThemeRevision theme with powerful mobile enhancements.

### Key Points

✅ **Standalone**: Can be installed independently as a separate plugin
✅ **Complete**: Includes all ThemeRevision features + mobile enhancements
✅ **Compatible**: Can coexist with original ThemeRevision (different namespaces)
✅ **Legal**: Properly forked under MIT License with full attribution
✅ **Production Ready**: Fully tested and documented

---

## 🆚 ThemeRevision vs ThemeRevisionPlus

| Feature | ThemeRevision | ThemeRevisionPlus |
|---------|---------------|-------------------|
| **Task-first UI** | ✅ | ✅ |
| **Dark/Light modes** | ✅ | ✅ |
| **Customizable colors** | ✅ | ✅ |
| **Google Fonts** | ✅ | ✅ |
| **Syntax highlighting** | ✅ | ✅ |
| **Plugin compatibility** | ✅ | ✅ |
| **Single-column portrait mode** | ❌ | ✅ NEW |
| **Swipe navigation** | ❌ | ✅ NEW |
| **Multi-column landscape** | ❌ | ✅ NEW |
| **Touch-optimized (44px targets)** | ❌ | ✅ NEW |
| **Keyboard navigation** | ❌ | ✅ NEW |
| **Screen reader support** | Partial | ✅ Enhanced |
| **Session persistence** | ❌ | ✅ NEW |

---

## 📂 Package Structure

```
ThemeRevisionPlus/
│
├── Plugin.php                       # Main plugin file (namespace: ThemeRevisionPlus)
│
├── Asset/                           # CSS, JS, Fonts
│   ├── mobile.css                   # ✨ NEW: Mobile styles
│   ├── swipe.js                     # ✨ NEW: Swipe gestures
│   ├── main.min.css                 # Compiled theme CSS
│   ├── main.min.js                  # Compiled theme JS
│   ├── material-symbols/            # Google Material Icons
│   ├── highlight/                   # Syntax highlighting
│   ├── spectrum/                    # Color picker
│   └── dev/                         # Source CSS files
│
├── Controller/
│   ├── MobileSettingsController.php # ✨ NEW: Mobile toggle
│   ├── PluginConfigsController.php  # Theme settings
│   └── UserSettingsController.php   # User preferences
│
├── Helper/
│   ├── BaseHelper.php
│   ├── ColorSwitchHelper.php        # Dark/Light mode
│   ├── ConfigsDataHelper.php        # Settings management
│   └── ModeSwitchHelper.php         # Dev/Prod mode
│
├── Model/
│   ├── CustomColorModel.php         # Color customization
│   ├── DefaultConfigsModel.php      # Default settings
│   └── TaskInfoCSSModel.php         # Task display logic
│
├── Template/                        # PHP templates
│   ├── layout.php
│   ├── layout/
│   │   ├── mobile_toggle.php        # ✨ NEW: Mobile nav buttons
│   │   ├── head_*.php
│   │   └── ...
│   ├── settings/
│   ├── user/
│   └── ...
│
├── Locale/                          # Translations
│   ├── de_DE/
│   ├── ru_RU/
│   └── zh_CN/
│
├── Screenshots/                     # Theme screenshots
│
├── README.md                        # User documentation
├── INSTALL.md                       # ✨ NEW: Installation guide
├── QUICK_START.md                   # ✨ NEW: Quick start guide
├── MOBILE_FEATURES.md               # ✨ NEW: Mobile features docs
├── CHANGELOG.md                     # ✨ NEW: Version history
├── PACKAGE_INFO.md                  # ✨ NEW: This file
└── LICENSE                          # MIT License (dual copyright)
```

**Legend**: ✨ NEW = Added in ThemeRevisionPlus

---

## 🔧 Technical Details

### Namespace
```php
namespace Kanboard\Plugin\ThemeRevisionPlus;
```

**Why different?** Allows installation alongside original ThemeRevision without conflicts.

### Global Variable
```php
global $themeRevisionPlusConfig;
```

**Why different?** Prevents collision if both themes are installed.

### Plugin Identifier
- **Folder Name**: `ThemeRevisionPlus` (MUST match exactly)
- **Plugin Name**: "ThemeRevisionPlus for Kanboard"
- **Settings Route**: `/settings/themerevisionplus`
- **Mobile Route**: `/mobile/toggle`

### Database Keys
- Settings: `themerevisionplus_*` (prefix)
- User Metadata: `mobile_beta` (shared key, OK since it's user-specific)

### File Paths
All asset references updated to `plugins/ThemeRevisionPlus/`:
- CSS: `plugins/ThemeRevisionPlus/Asset/mobile.css`
- JS: `plugins/ThemeRevisionPlus/Asset/swipe.js`
- Templates: `ThemeRevisionPlus:layout/mobile_toggle`

---

## 🚀 Installation Requirements

### Server Requirements
- **Kanboard**: ≥ 1.2.28
- **PHP**: ≥ 7.2
- **Web Server**: Apache/Nginx
- **Database**: MySQL/PostgreSQL/SQLite

### File Permissions (Linux/Mac)
```bash
# Directories: 755 (rwxr-xr-x)
# Files: 644 (rw-r--r--)
chmod -R 755 ThemeRevisionPlus/
find ThemeRevisionPlus/ -type f -exec chmod 644 {} \;
```

### Browser Requirements (Mobile Features)
- **iOS**: Safari 12+ (tested on iOS 15+)
- **Android**: Chrome 80+ (tested on Android 11+)
- **Desktop**: All modern browsers (Chrome, Firefox, Safari, Edge)

---

## 📋 Installation Checklist

### Before Installation
- [ ] Backup existing Kanboard installation
- [ ] Check Kanboard version (≥ 1.2.28)
- [ ] Check PHP version (≥ 7.2)
- [ ] Ensure `plugins/` directory is writable

### During Installation
- [ ] Download/clone to correct location
- [ ] Folder is named exactly `ThemeRevisionPlus`
- [ ] Set file permissions (Linux/Mac)
- [ ] Clear Kanboard cache

### After Installation
- [ ] Plugin appears in Settings → Plugins
- [ ] Plugin status shows "Loaded"
- [ ] Open a board on desktop - no errors
- [ ] Open a board on mobile - mobile features work
- [ ] Test swipe navigation (portrait)
- [ ] Test multi-column (landscape)
- [ ] Test Prev/Next buttons
- [ ] Check browser console (no errors)

---

## 🔍 Verification

### 1. Plugin Loaded
```
Settings → Plugins → ThemeRevisionPlus for Kanboard
Status: ✅ Loaded
Version: 1.0.0
Author: 3D Tvornica (based on ThemeRevision by Greyaz)
```

### 2. Files Present
```bash
ls -la plugins/ThemeRevisionPlus/Asset/mobile.css    # Should exist
ls -la plugins/ThemeRevisionPlus/Asset/swipe.js      # Should exist
ls -la plugins/ThemeRevisionPlus/Plugin.php          # Should exist
```

### 3. Mobile Features Active
```
1. Open board on mobile (or DevTools mobile emulation)
2. Portrait: See one column
3. Swipe left: Next column appears
4. See Prev/Next buttons
```

### 4. No Console Errors
```
F12 → Console tab → Should be clean (no red errors)
```

---

## 🐛 Common Issues

### Issue: Plugin not appearing
**Cause**: Wrong folder name
**Solution**: Rename to exactly `ThemeRevisionPlus`

### Issue: "Class not found" error
**Cause**: Namespace mismatch
**Solution**: Ensure all PHP files have `namespace Kanboard\Plugin\ThemeRevisionPlus;`

### Issue: Mobile features not working
**Cause**: User metadata `mobile_beta` set to '0'
**Solution**: Check/update user metadata (default should be '1')

### Issue: Assets not loading (404 errors)
**Cause**: File paths referencing wrong plugin name
**Solution**: All paths should use `plugins/ThemeRevisionPlus/`

### Issue: Conflict with original ThemeRevision
**Cause**: Both plugins loaded simultaneously
**Solution**: Only one theme can be active - disable one by renaming its folder

---

## 📖 Documentation Index

| Document | Purpose | Audience |
|----------|---------|----------|
| **README.md** | Overview, features, usage | All users |
| **INSTALL.md** | Detailed installation | Admins, DevOps |
| **QUICK_START.md** | Fast setup and testing | New users |
| **MOBILE_FEATURES.md** | Mobile technical docs | Developers |
| **CHANGELOG.md** | Version history | All users |
| **PACKAGE_INFO.md** | This file - package details | Developers, Admins |

---

## 🆔 Version Information

```
Plugin Name:        ThemeRevisionPlus for Kanboard
Version:            1.0.0
Release Date:       2025-10-19
Kanboard Version:   ≥ 1.2.28
Namespace:          Kanboard\Plugin\ThemeRevisionPlus
Based On:           ThemeRevision 1.1.12 by greyaz
Mobile Features:    3D Tvornica
License:            MIT
```

---

## 📜 License & Attribution

### License
MIT License - Full text in [LICENSE](LICENSE) file

### Copyright
- **Original ThemeRevision**: Copyright (c) 2022 greyaz
- **Mobile Enhancements**: Copyright (c) 2025 3D Tvornica

### Attribution
This is a fork of the excellent [ThemeRevision](https://github.com/greyaz/ThemeRevision) theme.
All original functionality and design credit goes to greyaz.
Mobile enhancements added by 3D Tvornica.

### MIT License Key Points
✅ Commercial use allowed
✅ Modification allowed
✅ Distribution allowed
✅ Private use allowed
⚠️ Must include license and copyright notice
⚠️ No warranty provided

---

## 🔗 Links

- **This Repository**: https://github.com/valentt/Kanboard-ThemeRevision
- **Original Theme**: https://github.com/greyaz/ThemeRevision
- **Kanboard**: https://kanboard.org
- **Kanboard Docs**: https://docs.kanboard.org
- **Issue Tracker**: https://github.com/valentt/Kanboard-ThemeRevision/issues

---

## 🤝 Contributing

This is a fork focused on mobile enhancements. Contributions welcome:

1. **Mobile Features**: Improvements to swipe, gestures, layouts
2. **Bug Fixes**: Mobile-specific issues
3. **Documentation**: Installation, usage, troubleshooting
4. **Testing**: Browser/device compatibility reports

### Upstream Sync
To keep up with original ThemeRevision:
```bash
git remote add upstream https://github.com/greyaz/ThemeRevision.git
git fetch upstream
git merge upstream/main
```

---

**Package Status**: ✅ Production Ready
**Last Updated**: 2025-10-19
**Maintainer**: 3D Tvornica / valentt
