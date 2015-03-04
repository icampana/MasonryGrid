<?php
/**
 * This is an HTML of widget management pupup. Please look at AdminController.php to see how $form variable is created.
 * Feel free to modify this file, but leave intact ID attributes and classes with 'ips' prefix.
 *
 */
?>
<div class="ip ipPluginMasonryGridPopup" id="ipMasonryGridPopup">
    <div class="modal fade ipsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                    <iframe frameBorder="0" border="0" hspace="0" vspace="0" marginwidth="0" marginheight="0" src="<?php echo escAttr($gridUrl) ?>"></iframe>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _e('Ok', 'MasonryGrid'); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php _e('Cancel', 'MasonryGrid'); ?></button>
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
        </div>
    </div>
</div>
