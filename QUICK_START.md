# ThemeRevisionPlus - Quick Start Guide

## 🚀 Installation

### Option 1: Git Clone (Recommended)
```bash
cd /path/to/kanboard/plugins
git clone https://github.com/valentt/Kanboard-ThemeRevision.git ThemeRevision
```

### Option 2: Download ZIP
1. Download from GitHub: https://github.com/valentt/Kanboard-ThemeRevision
2. Extract to `kanboard/plugins/ThemeRevision`
3. Ensure folder is named exactly `ThemeRevision`

### Option 3: Upgrade from ThemeRevision
```bash
cd /path/to/kanboard/plugins/ThemeRevision
git remote add plus https://github.com/valentt/Kanboard-ThemeRevision.git
git fetch plus
git merge plus/main
```

## ✅ Verification

### 1. Check Plugin is Loaded
- Navigate to: **Settings → Plugins**
- Look for: **ThemeRevisionPlus for Kanboard**
- Version should be: **1.0.0**
- Author: **3D Tvornica (based on ThemeRevision by Greyaz)**

### 2. Check Files Exist
```bash
cd /path/to/kanboard/plugins/ThemeRevision
ls -la Asset/mobile.css
ls -la Asset/swipe.js
ls -la Controller/MobileSettingsController.php
ls -la Template/layout/mobile_toggle.php
```

### 3. Test Mobile Features

#### On Desktop
1. Open a project board
2. Look for **Prev/Next** buttons in header (should be hidden on large screens)
3. Open browser DevTools (F12)
4. Enable device emulation (mobile view)
5. Buttons should appear

#### On Mobile Device
1. Open Kanboard in mobile browser
2. Navigate to a project board
3. **Portrait mode**:
   - Should see one column at a time
   - Swipe left/right to navigate
   - Prev/Next buttons at bottom
4. **Landscape mode**:
   - Should see 2-3 columns
   - Scroll horizontally
   - Columns snap into place

## 🧪 Quick Test Procedure

### Test 1: Portrait Mode
1. Open board on phone (portrait orientation)
2. Verify only one column visible
3. Swipe left → next column appears
4. Swipe right → previous column appears
5. Tap "Next" button → advances column
6. Tap "Prev" button → goes back
7. Reload page → should remember last column

### Test 2: Landscape Mode
1. Rotate phone to landscape
2. Should see 2-3 columns in grid
3. Scroll horizontally → smooth scrolling
4. Columns should snap to position
5. Should auto-scroll to last viewed column

### Test 3: Orientation Change
1. Start in portrait on column 3
2. Rotate to landscape
3. Should scroll to show column 3
4. Rotate back to portrait
5. Should still show column 3

### Test 4: Accessibility
1. Use screen reader (VoiceOver/TalkBack)
2. Navigate columns
3. Should announce: "Showing column X of Y: [Column Name]"
4. Try keyboard navigation (arrow keys)
5. Should navigate columns

## 🐛 Troubleshooting

### Problem: Mobile features not appearing

**Check 1**: Browser console
```
F12 → Console → Look for errors
```

**Check 2**: User metadata
```sql
-- Check mobile_beta setting
SELECT * FROM user_has_metadata WHERE meta_key = 'mobile_beta';

-- Enable for user ID 1
INSERT INTO user_has_metadata (user_id, meta_key, meta_value)
VALUES (1, 'mobile_beta', '1')
ON DUPLICATE KEY UPDATE meta_value = '1';
```

**Check 3**: Clear cache
```bash
# Kanboard cache
rm -rf data/cache/*

# Browser cache
Ctrl+Shift+R (hard reload)
```

**Check 4**: File permissions
```bash
# Files should be readable
chmod 644 Asset/mobile.css
chmod 644 Asset/swipe.js
chmod 644 Template/layout/mobile_toggle.php
chmod 644 Controller/MobileSettingsController.php
```

### Problem: Swipe not working

**Solution 1**: Check gesture thresholds in `Asset/swipe.js`:
```javascript
var SWIPE_THRESHOLD = 50;      // Try lowering to 30
var VERTICAL_THRESHOLD = 40;   // Try raising to 60
```

**Solution 2**: Disable other gesture libraries temporarily to test conflict

**Solution 3**: Test in different browser (Chrome vs Safari)

### Problem: Layout broken on specific device

**Check 1**: Minimum supported versions
- iOS Safari 12+
- Android Chrome 80+

**Check 2**: View in browser console
```
Open DevTools → Console
Check for CSS/JS errors
```

**Check 3**: Try different orientation
Some devices have quirks with orientation detection

### Problem: Desktop layout affected

**Verify**: Mobile styles should only apply below 1024px width
```css
/* This should be in mobile.css */
@media (max-width: 1024px) {
  /* Mobile styles */
}
```

If desktop is affected, mobile.css has leaked. Check media queries.

## 📱 Testing Checklist

- [ ] Plugin shows in Settings → Plugins
- [ ] Board loads without errors
- [ ] Portrait: Single column visible
- [ ] Portrait: Swipe left works
- [ ] Portrait: Swipe right works
- [ ] Portrait: Next button works
- [ ] Portrait: Prev button works
- [ ] Portrait: Column remembered after reload
- [ ] Landscape: Multiple columns visible
- [ ] Landscape: Horizontal scroll works
- [ ] Landscape: Columns snap to position
- [ ] Landscape: Auto-scrolls to last column
- [ ] Orientation change works smoothly
- [ ] Desktop layout unaffected (>1024px)
- [ ] Touch targets are 44px minimum
- [ ] Keyboard navigation works (arrow keys)
- [ ] Screen reader announces column changes
- [ ] No console errors
- [ ] Works on iOS Safari
- [ ] Works on Android Chrome

## 🎯 Next Steps

1. **Customize Colors**: Settings → ThemeRevision Settings
2. **Adjust Swipe**: Edit `Asset/swipe.js` thresholds
3. **Tweak Layout**: Edit `Asset/mobile.css` breakpoints
4. **Report Issues**: https://github.com/valentt/Kanboard-ThemeRevision/issues
5. **Read Docs**: See `MOBILE_FEATURES.md` for details

## 📚 Additional Resources

- **Full Documentation**: `README.md`
- **Mobile Features**: `MOBILE_FEATURES.md`
- **Changelog**: `CHANGELOG.md`
- **Original Theme**: https://github.com/greyaz/ThemeRevision
- **Kanboard Docs**: https://docs.kanboard.org/

## 🆘 Getting Help

1. Check `MOBILE_FEATURES.md` troubleshooting section
2. Search GitHub issues
3. Create new issue with:
   - Device/browser info
   - Kanboard version
   - Console errors
   - Steps to reproduce

---

**Enjoy your enhanced mobile Kanboard experience!** 🎉
