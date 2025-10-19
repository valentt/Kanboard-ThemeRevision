# ThemeRevisionPlus - Installation Guide

## 📦 Installing as a Standalone Plugin

ThemeRevisionPlus can be installed as a **separate, independent plugin** alongside the original ThemeRevision (or on its own).

### Requirements
- Kanboard ≥ 1.2.28
- PHP ≥ 7.2
- Modern web browser (for mobile features)

---

## Installation Methods

### Method 1: Git Clone (Recommended)

```bash
# Navigate to your Kanboard plugins directory
cd /path/to/kanboard/plugins

# Clone the repository
# IMPORTANT: The folder MUST be named "ThemeRevisionPlus"
git clone https://github.com/valentt/Kanboard-ThemeRevision.git ThemeRevisionPlus

# Set permissions (Linux/Mac)
chmod -R 755 ThemeRevisionPlus
chown -R www-data:www-data ThemeRevisionPlus  # Adjust user/group as needed
```

### Method 2: Manual Download

1. **Download** the latest release:
   - Go to: https://github.com/valentt/Kanboard-ThemeRevision/releases
   - Download the ZIP file

2. **Extract** to your Kanboard plugins directory:
   ```
   /path/to/kanboard/plugins/ThemeRevisionPlus/
   ```

3. **Important**: The folder **must** be named `ThemeRevisionPlus` (not `Kanboard-ThemeRevision` or `ThemeRevision`)

4. **Set permissions** (Linux/Mac):
   ```bash
   cd /path/to/kanboard/plugins
   chmod -R 755 ThemeRevisionPlus
   chown -R www-data:www-data ThemeRevisionPlus
   ```

### Method 3: Upgrade from ThemeRevision Fork

If you already have a fork of ThemeRevision and want to convert it:

```bash
cd /path/to/kanboard/plugins/YourThemeRevisionFork

# Add this repo as remote
git remote add plus https://github.com/valentt/Kanboard-ThemeRevision.git
git fetch plus

# Merge the mobile features
git merge plus/main

# The namespace is now ThemeRevisionPlus, so you need to:
# 1. Either rename the folder to ThemeRevisionPlus, OR
# 2. Run the namespace update script if you created one
```

---

## Folder Structure

After installation, your structure should look like this:

```
kanboard/
├── plugins/
│   ├── ThemeRevisionPlus/          ← Plugin folder (MUST have this exact name)
│   │   ├── Asset/
│   │   │   ├── mobile.css          ← Mobile styles
│   │   │   ├── swipe.js            ← Mobile JavaScript
│   │   │   ├── main.min.css
│   │   │   ├── main.min.js
│   │   │   └── ...
│   │   ├── Controller/
│   │   │   ├── MobileSettingsController.php
│   │   │   └── ...
│   │   ├── Helper/
│   │   ├── Model/
│   │   ├── Template/
│   │   ├── Plugin.php              ← Main plugin file
│   │   ├── README.md
│   │   └── LICENSE
│   │
│   └── (other plugins...)
│
├── data/
├── app/
└── ...
```

---

## Activation

### 1. Verify Installation

1. **Login to Kanboard** as an administrator
2. Navigate to: **Settings → Plugins**
3. You should see: **ThemeRevisionPlus for Kanboard**
   - Version: 1.0.0
   - Author: 3D Tvornica (based on ThemeRevision by Greyaz)
   - Status: ✅ Loaded

### 2. Clear Cache (if needed)

If the plugin doesn't appear:

```bash
# Clear Kanboard cache
rm -rf /path/to/kanboard/data/cache/*

# Or via web interface
# Settings → Settings → Application settings → "Clear cache"
```

Then reload the page.

---

## First Use

### Desktop Users
The theme works immediately - no configuration needed!

### Mobile Users

Mobile features are **enabled by default** for all users.

1. **Open a project board** on your mobile device
2. **Portrait mode**:
   - You'll see one column at a time
   - Swipe left/right or use Prev/Next buttons
3. **Landscape mode**:
   - You'll see 2-3 columns
   - Scroll horizontally

### Testing Mobile Features (Desktop)

1. Open a project board in your browser
2. Press **F12** to open Developer Tools
3. Click the **device toolbar** icon (or Ctrl+Shift+M)
4. Select a mobile device (iPhone, Pixel, etc.)
5. Test portrait and landscape orientations

---

## Configuration

### Theme Settings

Navigate to: **Settings → ThemeRevisionPlus Settings**

You can customize:
- ✅ Color scheme (Light/Dark/Auto)
- ✅ Custom colors
- ✅ Google Fonts
- ✅ Icon packages (Material Icons / Font Awesome)
- ✅ Corner radius
- ✅ Task display options
- ✅ Column header info

### Mobile Features

Mobile enhancements are controlled via user metadata:

**Enable for all users** (default):
```sql
-- No action needed - enabled by default
```

**Disable for a specific user**:
```sql
INSERT INTO user_has_metadata (user_id, meta_key, meta_value)
VALUES (123, 'mobile_beta', '0')
ON DUPLICATE KEY UPDATE meta_value = '0';
```

**Re-enable for a specific user**:
```sql
UPDATE user_has_metadata
SET meta_value = '1'
WHERE user_id = 123 AND meta_key = 'mobile_beta';
```

---

## Side-by-Side with ThemeRevision

You **can** have both themes installed:

```
kanboard/plugins/
├── ThemeRevision/          ← Original theme
└── ThemeRevisionPlus/      ← This theme (with mobile features)
```

They use **different namespaces** and **different config variables**, so they won't conflict.

**To switch between themes:**
- Only **one** theme can be active at a time
- Disable one by renaming its folder (e.g., `ThemeRevision.disabled`)
- Or move one out of the plugins directory temporarily

---

## Troubleshooting

### Plugin not appearing in Settings → Plugins

**Check 1**: Folder name
```bash
# Must be exactly "ThemeRevisionPlus" (case-sensitive on Linux)
ls /path/to/kanboard/plugins/
```

**Check 2**: File permissions
```bash
# All files should be readable
find ThemeRevisionPlus -type f -exec chmod 644 {} \;
find ThemeRevisionPlus -type d -exec chmod 755 {} \;
```

**Check 3**: PHP errors
```bash
# Check Kanboard logs
tail -f /path/to/kanboard/data/debug.log

# Or check web server logs
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx
```

**Check 4**: Clear cache and reload

### Mobile features not working

**Check 1**: Browser console
- Open DevTools (F12)
- Check Console tab for JavaScript errors

**Check 2**: User metadata
```sql
SELECT * FROM user_has_metadata
WHERE meta_key = 'mobile_beta' AND user_id = YOUR_USER_ID;

-- Should return '1' or no row (defaults to '1')
```

**Check 3**: Clear browser cache
- Hard reload: Ctrl+Shift+R (Windows/Linux) or Cmd+Shift+R (Mac)

### Layout broken or conflicting

**Check 1**: Disable other themes
- Only one theme should be active

**Check 2**: Check for plugin conflicts
- Temporarily disable other plugins to test

**Check 3**: Browser compatibility
- iOS Safari 12+
- Android Chrome 80+
- Desktop: All modern browsers

---

## Uninstallation

### Complete Removal

```bash
# 1. Remove plugin folder
rm -rf /path/to/kanboard/plugins/ThemeRevisionPlus

# 2. Clear cache
rm -rf /path/to/kanboard/data/cache/*

# 3. (Optional) Clean database
mysql -u root -p kanboard_db << EOF
DELETE FROM settings WHERE option LIKE 'themerevisionplus_%';
DELETE FROM user_has_metadata WHERE meta_key = 'mobile_beta';
EOF
```

### Temporary Disable

```bash
# Just rename the folder
cd /path/to/kanboard/plugins
mv ThemeRevisionPlus ThemeRevisionPlus.disabled
```

To re-enable, rename it back to `ThemeRevisionPlus`.

---

## Updating

### Via Git

```bash
cd /path/to/kanboard/plugins/ThemeRevisionPlus
git pull origin main

# Clear cache
rm -rf ../../data/cache/*
```

### Manual Update

1. **Backup** your current installation
2. **Download** the latest release
3. **Replace** the old folder with the new one
4. **Clear cache**
5. **Test** the update

### Keeping Custom Changes

If you've customized CSS/JS:

```bash
# Before updating, backup your changes
cd /path/to/kanboard/plugins/ThemeRevisionPlus
cp Asset/dev/css/custom.css ~/backup/
cp Asset/mobile.css ~/backup/

# After updating, restore your changes
cp ~/backup/custom.css Asset/dev/css/
cp ~/backup/mobile.css Asset/
```

---

## Support & Documentation

- **Quick Start**: See [QUICK_START.md](QUICK_START.md)
- **Mobile Features**: See [MOBILE_FEATURES.md](MOBILE_FEATURES.md)
- **Full Documentation**: See [README.md](README.md)
- **Changelog**: See [CHANGELOG.md](CHANGELOG.md)
- **Issues**: https://github.com/valentt/Kanboard-ThemeRevision/issues
- **Original Theme**: https://github.com/greyaz/ThemeRevision

---

## License

MIT License - See [LICENSE](LICENSE) file

- Original ThemeRevision: Copyright (c) 2022 greyaz
- Mobile Enhancements: Copyright (c) 2025 3D Tvornica

---

**Enjoy your mobile-optimized Kanboard! 🎉**
