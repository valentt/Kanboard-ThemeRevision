# ThemeRevisionPlus Mobile Features

## Summary
This document describes the mobile enhancements added to ThemeRevision to create ThemeRevisionPlus.

## What's New

### 1. Portrait Mode (Single Column)
- **Behavior**: Shows one column at a time on portrait-oriented phones
- **Navigation**:
  - Swipe left/right to switch columns
  - Tap Prev/Next buttons
  - Use arrow keys (←/→)
- **Persistence**: Remembers last viewed column per project in sessionStorage
- **Visual Feedback**: Column indicator shows "X / Y: Column Name"

### 2. Landscape Mode (Multi-Column)
- **Behavior**: Shows 2-3 columns in a scrollable grid
- **Navigation**: Horizontal scroll with snap-to-column
- **Responsive**:
  - 600-900px: 2 columns
  - 900px+: 3 columns
- **Auto-scroll**: Scrolls to last viewed column on load

### 3. Touch Optimization
- **Touch Targets**: 44px minimum (iOS Human Interface Guidelines)
- **Gestures**:
  - Swipe threshold: 50px horizontal movement
  - Vertical threshold: 40px max (prevents conflict with scrolling)
  - Time threshold: 300ms for fast swipe
- **Feedback**: Active states, visual transitions

### 4. Accessibility
- **Screen Readers**: Column changes announced via ARIA live region
- **Keyboard**: Full arrow key navigation support
- **Focus Indicators**: Visible focus states for keyboard users
- **Reduced Motion**: Respects `prefers-reduced-motion` media query

## Files Added/Modified

### New Files
1. **Asset/mobile.css** (370 lines)
   - Portrait single-column layout
   - Landscape multi-column grid
   - Mobile navigation button styles
   - Touch-optimized components

2. **Asset/swipe.js** (360 lines)
   - Swipe gesture detection
   - Column navigation logic
   - Orientation change handling
   - Session persistence
   - Accessibility announcements

3. **Template/layout/mobile_toggle.php**
   - Prev/Next navigation buttons
   - ARIA labels and roles
   - Mobile-only visibility

4. **Controller/MobileSettingsController.php**
   - Toggle mobile features per user
   - User metadata management
   - Redirect handling

### Modified Files
1. **Plugin.php**
   - Added `initMobileFeatures()` method
   - Hooks for mobile CSS/JS injection
   - Route for mobile settings toggle
   - Updated plugin metadata (name, version, author, homepage)

2. **README.md**
   - Added mobile features documentation
   - Usage guide for portrait/landscape modes
   - Troubleshooting section
   - Browser compatibility info
   - Development/customization guide

## Technical Details

### CSS Architecture
- Uses CSS Grid for landscape layout
- Media queries for orientation detection
- CSS custom properties for theming
- Viewport units (svh) for full-height columns
- Scroll snap for smooth navigation

### JavaScript Architecture
- Vanilla JS (no dependencies)
- Event delegation for navigation
- Pointer events + touch fallback
- Debounced resize handler
- Session storage for state persistence

### Kanboard Integration
- Uses plugin hook system (no core modifications)
- `template:layout:css` for CSS injection
- `template:layout:js` for JS injection
- `template:layout:top` for navigation UI
- User metadata for feature toggle

### Browser Support
- **iOS Safari**: 12+ (tested)
- **Android Chrome**: 80+ (tested)
- **Desktop**: All modern browsers
- **Legacy**: Graceful degradation to desktop layout

## Configuration

### User Metadata
Mobile features can be toggled per user via metadata:
```php
// Enable mobile features (default)
$this->userMetadataModel->save($userId, ['mobile_beta' => '1']);

// Disable mobile features
$this->userMetadataModel->save($userId, ['mobile_beta' => '0']);
```

### Customization Points

#### Swipe Thresholds (Asset/swipe.js)
```javascript
var SWIPE_THRESHOLD = 50;      // Minimum horizontal distance
var VERTICAL_THRESHOLD = 40;   // Maximum vertical movement
var TIME_THRESHOLD = 300;      // Maximum time for fast swipe
```

#### Column Widths (Asset/mobile.css)
```css
/* Landscape mode column sizing */
.board-swimlane-columns {
  grid-auto-columns: minmax(280px, 1fr); /* Min/max column width */
}
```

#### Touch Targets (Asset/mobile.css)
```css
/* Minimum touch target size */
.task-board-header .dropdown,
.task-board-footer .btn {
  min-height: 44px;
  min-width: 44px;
}
```

## Testing Checklist

### Portrait Mode
- [ ] Shows only one column at a time
- [ ] Swipe left navigates to next column
- [ ] Swipe right navigates to previous column
- [ ] Prev button works (disabled on first column)
- [ ] Next button works (disabled on last column)
- [ ] Column indicator appears on change
- [ ] Last column persists on page reload
- [ ] Arrow keys work when not in text input
- [ ] Vertical scrolling doesn't trigger column change

### Landscape Mode
- [ ] Shows 2-3 columns depending on width
- [ ] Horizontal scroll works smoothly
- [ ] Columns snap to position
- [ ] Auto-scrolls to last viewed column
- [ ] Navigation buttons still work
- [ ] Touch scrolling is smooth

### Orientation Changes
- [ ] Rotating from portrait to landscape works
- [ ] Rotating from landscape to portrait works
- [ ] Current column is maintained
- [ ] Layout updates correctly
- [ ] No visual glitches during transition

### Touch & Gestures
- [ ] Touch targets are at least 44x44px
- [ ] Tap on task cards works
- [ ] Drag and drop still works
- [ ] Swipe doesn't interfere with other gestures
- [ ] Links and buttons are tappable

### Accessibility
- [ ] Screen reader announces column changes
- [ ] Keyboard navigation works
- [ ] Focus indicators are visible
- [ ] ARIA labels are correct
- [ ] Reduced motion preference respected

### Performance
- [ ] Smooth on boards with 100+ tasks
- [ ] Works on boards with 1000+ tasks
- [ ] No lag during swipe
- [ ] Session storage doesn't grow indefinitely

### Edge Cases
- [ ] Empty columns display correctly
- [ ] Single column board works
- [ ] Very wide columns (long task names)
- [ ] Very tall columns (many tasks)
- [ ] Small screens (320px width)
- [ ] Large tablets (1024px landscape)

### Desktop
- [ ] Desktop layout unchanged
- [ ] Mobile nav buttons hidden on desktop (>1024px)
- [ ] No mobile CSS applied on desktop
- [ ] No JavaScript interference

## QA Notes

### Known Issues
None currently - please report any issues to the GitHub repository.

### Browser-Specific Notes
- **iOS Safari**: Use `-webkit-overflow-scrolling: touch` for smooth scrolling
- **Android Chrome**: Pointer events work best, touch events as fallback
- **Desktop**: Mobile features auto-disabled above 1024px width

### Performance Recommendations
1. For boards with >2000 tasks, consider:
   - Using filters to reduce visible tasks
   - Archiving completed tasks
   - Splitting into multiple projects

2. Test on actual devices, not just browser DevTools
3. Test on slow 3G connections for real-world performance

## Deployment Steps

1. **Backup**: Save existing ThemeRevision folder
2. **Install**: Copy ThemeRevisionPlus to `plugins/ThemeRevision`
3. **Test**: Open board on mobile device
4. **Verify**: Check console for errors
5. **Monitor**: Watch for user feedback

## Rollback Plan

If issues arise:
1. Restore original ThemeRevision from backup
2. Clear Kanboard cache
3. Report issue to GitHub

## Future Enhancements

Potential improvements for future versions:
- [ ] Lazy loading for very tall columns
- [ ] Swimlane persistence per project
- [ ] Quick actions on task cards (move to next/prev column)
- [ ] Visual swipe progress indicator
- [ ] Haptic feedback on iOS
- [ ] User settings UI for toggling mobile features
- [ ] Column width customization
- [ ] Gesture customization panel
- [ ] PWA manifest for "Add to Home Screen"

## Support

- **GitHub Issues**: https://github.com/valentt/Kanboard-ThemeRevision/issues
- **Original Theme**: https://github.com/greyaz/ThemeRevision
- **Kanboard Docs**: https://docs.kanboard.org/

---

**Version**: 1.0.0
**Last Updated**: 2025-10-19
**Author**: 3D Tvornica (based on ThemeRevision by greyaz)
