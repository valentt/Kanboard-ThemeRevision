# ThemeRevisionPlus for Kanboard
![License](https://img.shields.io/github/license/greyaz/ThemeRevision?color=%233860f4&style=flat-square)
![Kanboard Support](https://img.shields.io/static/v1?label=Kanboard&message=%E2%89%A51.2.28&color=green&style=flat-square)

ThemeRevisionPlus is an enhanced mobile fork of the excellent [ThemeRevision](https://github.com/greyaz/ThemeRevision) theme for [Kanboard](https://github.com/kanboard/kanboard). It maintains all the great features of ThemeRevision while adding powerful mobile-first enhancements.

**Key Mobile Enhancements:**
- 📱 **Single-column portrait mode** with swipe navigation
- 📲 **Multi-column landscape mode** with horizontal scrolling
- 👆 **Touch-optimized gestures** for smooth column switching
- ⌨️ **Keyboard navigation** support (arrow keys)
- ♿ **Accessibility improvements** for mobile users

Built on ThemeRevision's task-first design philosophy with better mobile experiences, plugin compatibility, and customization options.

## Screenshots
<img src="Screenshots/7.png" width="97%"><br>

<img src="Screenshots/2.png" width="19%"> <img src="Screenshots/4.png" width="19%"> <img src="Screenshots/3.png" width="19%"> <img src="Screenshots/5.png" width="19%"> <img src="Screenshots/6.png" width="19%"> <img src="Screenshots/8.png" width="19%"> <img src="Screenshots/9.png" width="19%"> <img src="Screenshots/12.png" width="19%"> <img src="Screenshots/10.png" width="5.9%"> <img src="Screenshots/11.png" width="5.9%">

## Features
#### Task-first
* ThemeRivision has been trying to create a high-quality but minimalist UI that helps you focus on your tasks.
* Provide support for syntax highlighting.
* More Search boxes. Display a search box in a drop-down menu automatically if items are more than 25.

#### Enhanced Mobile Experiences (ThemeRevisionPlus)
* **Portrait Mode**: Single-column view with swipe navigation
  - Swipe left/right to switch between columns
  - Prev/Next buttons for navigation
  - Session remembers last viewed column per project
  - Visual column indicator with smooth transitions
* **Landscape Mode**: Multi-column scrollable grid
  - 2-3 columns visible depending on screen width
  - Horizontal scroll with snap-to-column
  - Auto-scrolls to last viewed column
* **Touch Optimized**: 44px minimum touch targets (iOS HIG compliant)
* **Keyboard Support**: Arrow keys for column navigation
* **Accessibility**: Screen reader announcements, ARIA labels
* Modern mobile application's interactive behaviour. [screenshot1](Screenshots/10.png) [screenshot2](Screenshots/11.png)

#### Common plugins' compatibilities
* Calendar / Gantt / Group_assign / MarkdownPlus / MetaMagic / Table View ...

#### Dark mode
* An individually controlled panel for non-administrative users
* Three modes provided: Light / Dark / Auto

#### Customization friendly
* Customizable display content in the header of a column and the footer of a task card.
* All colors are configurable in the settings panel. [screenshot](Screenshots/5.png)
* Support Google fonts by just typing a font name.
* Switchable icon packages, _Google Material_ (default) and _Font Awesome_.
* Structured CSS files, easy to locate elements.  
* Utilize "rem" as the global measuring unit.

## Installation

> **⚠️ IMPORTANT**: The plugin folder **must** be named `ThemeRevisionPlus` for the plugin to work correctly.

### Quick Install (Git)
```bash
cd /path/to/kanboard/plugins
git clone https://github.com/valentt/Kanboard-ThemeRevision.git ThemeRevisionPlus
chmod -R 755 ThemeRevisionPlus  # Linux/Mac only
```

### Manual Installation
1. Download the [latest release](https://github.com/valentt/Kanboard-ThemeRevision/releases)
2. Extract to `your_kanboard_root/plugins/ThemeRevisionPlus` (folder name is critical!)
3. Set permissions (Linux/Mac): `chmod -R 755 ThemeRevisionPlus`
4. Reload Kanboard (clear cache if needed)

### Verify Installation
- Go to **Settings → Plugins**
- Look for **ThemeRevisionPlus for Kanboard v1.0.0**
- Status should show ✅ Loaded

📖 **For detailed installation instructions, troubleshooting, and upgrading, see [INSTALL.md](INSTALL.md)**

### Custom Logo
ThemeRevisionPlus uses the file `favicon.png` in `your_kanboard_root/assets/img` as the header logo. Replace it with your own if needed.

### Mobile Features
Mobile enhancements are **enabled by default** for all users. To disable for specific users:
- Users can toggle via their profile settings (coming in future version)
- Or set user metadata `mobile_beta` to `0` in the database

## Upgrading

### From ThemeRevision to ThemeRevisionPlus
ThemeRevisionPlus maintains full compatibility with ThemeRevision. Simply:
1. Back up your existing `ThemeRevision` plugin folder
2. Replace it with `ThemeRevisionPlus`
3. Your settings and customizations will be preserved

### Regular Updates
```bash
cd your_kanboard_root/plugins/ThemeRevision
git pull origin main
```

### Important Notes
* **Customized CSS files**: Back up files in `Asset/dev` before upgrading
* **Custom configs**: Export settings from the panel before major upgrades
* **Mobile features**: New mobile CSS/JS files are separate and won't affect custom styles

## Customization
#### Colors / Icons / Fonts
* Just go to the [settings panel](Screenshots/5.png): *`Settings -> ThemeRevision Settings`*   
   > **or (< 1.0.9)**  
   > Copy and move (**do not delete**) the file `config-default.php` to `config.php` in the plugin directory. Then edit the values according to the instructions in it.

#### More Styles
1. ***Make sure*** the folder `your_kanboard_root/plugins/ThemeRevision/Asset` is ***writable and executable***.
2. Switch "Mode" to "Development" in the [settings panel](Screenshots/5.png).   
   > **or (< 1.0.9)**  
   > Switch "Mode" in the config file according to the alternative method mentioned in the previous section.
3. Edit raw CSS files in the folder `Asset/dev`.

## Mobile Usage Guide

### Portrait Mode (Phone)
- **Swipe** left/right to navigate between columns
- **Tap** Prev/Next buttons in the header for navigation
- **Keyboard**: Use arrow keys (←/→) when not in text input
- Column indicator shows current position (e.g., "2 / 5: In Progress")
- Last viewed column is remembered per project

### Landscape Mode (Phone/Tablet)
- **Scroll** horizontally to view 2-3 columns at once
- Columns snap to position for easy viewing
- Automatically scrolls to last viewed column on load

### Disabling Mobile Features
If you prefer the classic desktop layout on mobile:
1. Go to your user settings
2. Look for "Mobile Beta" toggle (or contact admin to set user metadata)
3. Disable to use standard desktop view

## Browser Compatibility
- ✅ iOS Safari 12+
- ✅ Android Chrome 80+
- ✅ Desktop: All modern browsers
- ⚠️ Legacy browsers: Falls back to desktop layout

## Troubleshooting

### Mobile features not working
1. Verify you're on the board view page
2. Check browser console for JavaScript errors
3. Clear browser cache and reload
4. Ensure `mobile_beta` user metadata is set to `1`

### Swipe conflicts with other gestures
- Adjust `SWIPE_THRESHOLD` in `Asset/swipe.js` (default: 50px)
- Increase `VERTICAL_THRESHOLD` if vertical scrolling triggers column change

### Performance on large boards
- Mobile layout handles 1000+ tasks per column
- For very large boards (>2000 tasks), consider filtering/archiving

## Development

### File Structure
```
ThemeRevision/
├── Plugin.php                          # Main plugin with mobile hooks
├── Asset/
│   ├── mobile.css                      # Mobile-specific styles
│   └── swipe.js                        # Swipe gesture handler
├── Controller/
│   └── MobileSettingsController.php    # Mobile settings toggle
└── Template/
    └── layout/
        └── mobile_toggle.php           # Mobile nav buttons
```

### Customizing Mobile Behavior
Edit `Asset/swipe.js` to customize:
- `SWIPE_THRESHOLD`: Minimum swipe distance (default: 50px)
- `VERTICAL_THRESHOLD`: Max vertical movement (default: 40px)
- `TIME_THRESHOLD`: Max time for fast swipe (default: 300ms)

Edit `Asset/mobile.css` to customize:
- Column widths in landscape mode
- Touch target sizes
- Navigation button styles
- Transition animations

### Keeping Up with Upstream
Track the original ThemeRevision:
```bash
git remote add upstream https://github.com/greyaz/ThemeRevision.git
git fetch upstream
git merge upstream/main
```

## Credits & License
- **Original Theme**: [ThemeRevision](https://github.com/greyaz/ThemeRevision) by greyaz
- **Mobile Enhancements**: 3D Tvornica
- **License**: MIT

ThemeRevisionPlus extends ThemeRevision with mobile-first features while maintaining full compatibility with the original theme's excellent design and customization options.
