<?php
// Check if Google Fonts is enabled
$googleFontsEnabled = isset($GLOBALS['themeRevisionPlusConfig']['enable_google_fonts']) && $GLOBALS['themeRevisionPlusConfig']['enable_google_fonts'];

if ($googleFontsEnabled) {
    // Original Google Fonts loading logic
    $styles = "";
    $fonts = "@import url('https://fonts.googleapis.com/css2?";

    foreach($configs as $key => $value){
        if (!empty(trim($value))){
            $fonts .= "family=".str_replace(" ", "+", trim($value)).":wght@400;700&";
            switch ($key){
                case "ui":
                    $styles.= "--style-fontfamily:'".trim($value)."',sans-serif !important;";
                    break;
                case "codes":
                    $styles.= "--style-fontfamily-code:'".trim($value)."',monospace !important;";
                    break;
            }
        }
    }
    if (!empty($styles)){
        $styles = $fonts."display=swap');".":root{".$styles."}";
    }

    if ($styles): ?>
        <style><?= $styles ?></style>
    <?php endif;

} else {
    // Google Fonts disabled - use system defaults
    ?>
    <style>
        :root {
            --style-fontfamily: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            --style-fontfamily-code: "Courier New", Courier, monospace !important;
        }
    </style>
<?php } ?>
