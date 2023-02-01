<?php
    global $be_themes_data;
    if(isset($be_themes_data['opt-noshow-topbar']) && $be_themes_data['opt-noshow-topbar'] == 1){
        if(count($be_themes_data['opt-topbar-widgets-pos']['left']) > 1 || count($be_themes_data['opt-topbar-widgets-pos']['right']) > 1 ) {?>
            <div id="header-top-bar">
                <div id="header-top-bar-wrap" class="<?php if(true == $be_themes_data['opt-header-wrap']){?> be-wrap<?php } ?> clearfix">
                    <?php
                    if(count($be_themes_data['opt-topbar-widgets-pos']['left']) > 1) {?>
                        <div id="header-top-bar-left"><?php
                                foreach ($be_themes_data['opt-topbar-widgets-pos']['left'] as $key => $value) {
                                    be_themes_get_topbar_widgets($key);
                                }?>
                        </div><?php
                        }
                    ?>
                    <?php
                    if(count($be_themes_data['opt-topbar-widgets-pos']['right']) > 1) {?>
                        <div id="header-top-bar-right"><?php	
                                foreach ($be_themes_data['opt-topbar-widgets-pos']['right'] as $key => $value) {
                                    be_themes_get_topbar_widgets($key);
                                }?>
                        </div><?php
                        }
                    ?>
                </div>
            </div><?php
        }
    }
?>