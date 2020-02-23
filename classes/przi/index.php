<?php
/* Pre-resize images 2.3.1 by Teseo. */
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
Plugin Name: Pre-resize Images
Description: Pre-resize images on client side before uploading them
Version: 2.3.1
Author: teseo
Short Name: preResize_images
Plugin update URI: pre-resize-images
*/

require 'reorder_functions.php';

function przi_ajax_photos($resources = null) {
    if($resources == null) $resources = osc_get_item_resources();

    if(Session::newInstance()->_getForm('order_photos') != '') {
        $savedOrder = Session::newInstance()->_getForm('order_photos');
        Session::newInstance()->_drop('order_photos');
        Session::newInstance()->_dropKeepForm('order_photos');
    }

    $currentOrder = array();
    foreach($resources as $_r) {
        $currentOrder[] = array('order' => $_r['pk_i_id'], $_r);
    }

    $aImages = array();
    if(Session::newInstance()->_getForm('photos') != '') {
        $aImages = Session::newInstance()->_getForm('photos');
        if(isset($aImages['name'])) {
            $aImages = $aImages['name'];
        } else {
            $aImages = array();
        }
        Session::newInstance()->_drop('photos');
        Session::newInstance()->_dropKeepForm('photos');

        foreach($aImages as $img) {
            $currentOrder[] = array('order' => $img);
        }
    }

    if(isset($savedOrder)) {
        $keys = array_flip($savedOrder);
        usort($currentOrder, function ($a, $b) use ($keys) {
            return $keys[$a['order']] - $keys[$b['order']];
        });
    }

    $maxImages = (int)osc_max_images_per_item();
    $is_edit = Params::getParam('action') == 'item_edit'; ?>

    <div id="restricted-fine-uploader"></div>
    <div style="clear:both;"></div>
    <?php if(count($aImages) > 0 || ($resources != null && is_array($resources) && count($resources) > 0)) { ?>
        <ul>
            <?php foreach($currentOrder as $key => $order) {
                $isResource = is_numeric($order['order']);
                if($isResource) $img =$order[0]['pk_i_id'] . '.' . $order[0]['s_extension'];
                else $img = $order['order']; ?>

                <li class="qq-upload-success">
                    <span class="qq-upload-file"><?php echo $img; $img = osc_esc_html($img); ?></span>
                    <?php if($isResource) { ?>
                        <a class="qq-upload-delete" href="#" photoid="<?php echo $order[0]['pk_i_id']; ?>" itemid="<?php echo $order[0]['fk_i_item_id']; ?>" photoname="<?php echo $order[0]['s_name']; ?>" photosecret="<?php echo Params::getParam('secret'); ?>"><?php _e('Delete'); ?></a>
                        <div class="ajax_preview_img"><img src="<?php echo osc_apply_filter('resource_path', osc_base_url() . $order[0]['s_path']) . $order[0]['pk_i_id'] . '_thumbnail.' . $order[0]['s_extension']; ?>" alt="<?php echo osc_esc_html($img); ?>"></div>
                        <input type="hidden" name="order_photos[]" value="<?php echo $order[0]['pk_i_id']; ?>">
                    <?php } else { ?>
                        <a class="qq-upload-delete" href="#" ajaxfile="<?php echo $img; ?>"><?php _e('Delete'); ?></a>
                        <div class="ajax_preview_img"><img src="<?php echo osc_base_url(); ?>oc-content/uploads/temp/<?php echo $img; ?>" alt="<?php echo $img; ?>"></div>
                        <input type="hidden" name="ajax_photos[]" value="<?php echo $img; ?>">
                        <input type="hidden" name="order_photos[]" value="<?php echo $img; ?>">
                    <?php } ?>
                    <div class="qq-upload-actions">
                        <a class="primary_image btn btn-mtx bg-accent w-100" title="<?php echo osc_esc_js(__('Make primary image', 'matrix')); ?>"><?php echo osc_esc_js(__('Primary', 'matrix')); ?></a>
                    </div>
                </li>
            <?php }; ?>
        </ul>
    <?php } ?>

    <div style="clear:both;" class="qq-upload-delete"></div>

    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area">
                <span><?php _e('Drop images here', 'matrix'); ?></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button bg-accent">
                <div><?php echo osc_esc_js(__('Click here or drop images to upload.', 'matrix').($maxImages ? ' '.sprintf(__('(%s max)', 'matrix'), $maxImages) : '')); ?></div>
                <div class="reorder_text"><?php _e('Drag thumbnails to reorder images', 'matrix'); ?></div>
            </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span><?php _e('Uploading...', 'matrix'); ?></span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            <ul class="qq-upload-list-selector qq-upload-list">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-upload-actions">
                        <a class="qq-upload-cancel-selector qq-upload-cancel btn btn-mtx bg-accent" href="#"><?php _e('Cancel'); ?></a>
                        <a class="qq-upload-retry-selector qq-upload-retry btn btn-mtx bg-accent" href="#"><?php _e('Retry'); ?></a>
                        <a class="qq-upload-delete-selector qq-upload-delete btn btn-mtx bg-accent" href="#"><?php _e('Delete'); ?></a>
                    </div>
                    <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
        </div>
    </script>
    <?php $aExt = explode(',', osc_allowed_extension());
    foreach($aExt as $key => $value) {
        $aExt[$key] = "'" . $value . "'";
    }

    $allowedExtensions = join(',', $aExt); ?>
    <script>
        $(document).ready(function () {
            function makeSortable() {
                $(".reorder_text").show();
                $("ul.qq-upload-list li:first").find('.primary_image').css('display', 'none');
                $("#restricted-fine-uploader ul.qq-upload-list").sortable({
                    containment: '#restricted-fine-uploader',
                    distance: 5,
                    handle: '.ajax_preview_img',
                        stop: function (event, ui) {
                        $("ul.qq-upload-list li:first").find('.primary_image').css('display', 'none');
                        $("ul.qq-upload-list li").not(':first').find('.primary_image').css('display', 'block');
                    }
                });
            }

            var fineUploaderContainer = $('#restricted-fine-uploader');

            $('li > .qq-upload-delete').on('click', function (evt) {
                evt.preventDefault();
                var parent = $(this).parent()
                var result = confirm('<?php echo osc_esc_js(__("This action can't be undone. Are you sure you want to continue?")); ?>');
                var urlrequest = '';
                if($(this).attr('ajaxfile') != undefined) {
                    urlrequest = 'ajax_photo=' + $(this).attr('ajaxfile');
                } else {
                    urlrequest = 'id=' + $(this).attr('photoid') + '&item=' + $(this).attr('itemid') + '&code=' + $(this).attr('photoname') + '&secret=' + $(this).attr('photosecret');
                }
                if(result) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo osc_base_url(true); ?>?page=ajax&action=delete_image&' + urlrequest,
                        dataType: 'json',
                        success: function (data) {
                            parent.remove();
                        }
                    });
                }
            });

            fineUploaderContainer.on('click', '.primary_image', function (event) {
                $(this).parent().parent().prependTo('ul.qq-upload-list');
                $("ul.qq-upload-list li:first").find('.primary_image').css('display', 'none');
                $("ul.qq-upload-list li").not(':first').find('.primary_image').css('display', 'block');
            });

            fineUploaderContainer.on('click', 'a.qq-upload-delete', function (event) {
                $('#restricted-fine-uploader .flashmessage-error').remove();
                setTimeout(function() {
                    $("ul.qq-upload-list li:first").find('.primary_image').css('display', 'none');
                }, 400);
            });

            // INIT settings
            var isAndroidChrome = qq.android() && qq.chrome();

            fineUploaderContainer.fineUploader({
                request: {
                    endpoint: '<?php echo osc_base_url(true) . "?page=ajax&action=runhook&hook=przi_ajax_uploader&scaling="; ?>' + qq.supportedFeatures.scaling
                },
                scaling: qq.supportedFeatures.scaling ? {
                    sendOriginal: false,
                    defaultQuality: 80,
                    includeExif: false,
                    sizes: [
                        {name: "", maxSize: <?php echo mtx_pref('przi_size'); ?>}
                    ],
                    customResizer: !qq.ios() && !qq.ie() && !isAndroidChrome && function (resizeInfo) {
                        return new Promise(function (resolve, reject) {
                            pica.resizeCanvas(resizeInfo.sourceCanvas, resizeInfo.targetCanvas, { alpha: true }, resolve);
                        })
                    }
                } : {},
                multiple: true,
                validation: {
                    allowedExtensions: [<?php echo $allowedExtensions; ?>],
                    sizeLimit: qq.supportedFeatures.scaling ? 0 : <?php echo (int) osc_max_size_kb()*1024; ?>,
                    itemLimit: <?php echo $maxImages; ?>
                },
                messages: {
                    tooManyItemsError: '<?php echo osc_esc_js(__('Too many items ({netItems}) would be uploaded. Item limit is {itemLimit}.'));?>',
                    onLeave: '<?php echo osc_esc_js(__('The files are being uploaded, ifyou leave now the upload will be cancelled.'));?>',
                    typeError: '<?php echo osc_esc_js(__('{file} has an invalid extension. Valid extension(s): {extensions}.'));?>',
                    sizeError: '<?php echo osc_esc_js(__('{file} is too large, maximum file size is {sizeLimit}.'));?>',
                    emptyError: '<?php echo osc_esc_js(__('{file} is empty, please select files again without it.'));?>'
                },
                deleteFile: {
                    enabled: true,
                    method: "POST",
                    forceConfirm: false,
                    endpoint: '<?php echo osc_base_url(true) . "?page=ajax&action=delete_ajax_upload"; ?>'
                },
                retry: {
                    showAutoRetryNote: true,
                    showButton: true
                },
                text: {
                    uploadButton: '<?php echo osc_esc_js(__('Click or Drop for upload images')); ?>',
                    waitingForResponse: '<?php echo osc_esc_js(__('Processing...')); ?>',
                    retryButton: '<?php echo osc_esc_js(__('Retry')); ?>',
                    cancelButton: '<?php echo osc_esc_js(__('Cancel')); ?>',
                    failUpload: '<?php echo osc_esc_js(__('Upload failed')); ?>',
                    deleteButton: '<?php echo osc_esc_js(__('Delete')); ?>',
                    deletingStatusText: '<?php echo osc_esc_js(__('Deleting...')); ?>',
                    formatProgress: '<?php echo osc_esc_js(__('{percent}% of {total_size}')); ?>'
                }
            }).on('error', function (event, id, name, errorReason, xhrOrXdr) {
                $('#restricted-fine-uploader .flashmessage-error').remove();
                fineUploaderContainer.append('<div class="flashmessage flashmessage-error">' + errorReason + '<a class="close" style="color: #fff; float: right; padding-right: 10px; cursor: pointer;" onclick="javascript:$(\'.flashmessage-error\').remove();" >X</a></div>');
            }).on('statusChange', function (event, id, old_status, new_status) {
                $(".alert.alert-error").remove();
            }).on('complete', function (event, id, fileName, responseJSON) {
                if(responseJSON.success) {
                    $('#restricted-fine-uploader .flashmessage-error').remove();
                    $('.qq-upload-delete').show();
                    var li = $(".qq-upload-list li[qq-file-id='" + id + "']");

                    // @TOFIX @FIXME escape $responseJSON_uploadName below
                    // need a js function similar to osc_esc_js(osc_esc_html())
                    $(li).append('<div class="ajax_preview_img"><img src="<?php echo osc_base_url(); ?>oc-content/uploads/temp/' + responseJSON.uploadName + '" alt="auto_' + responseJSON.uploadName + '"></div>');
                    $(li).append('<input type="hidden" name="ajax_photos[]" value="' + responseJSON.uploadName + '"></input>');
                    $(li).append('<input type="hidden" name="order_photos[]" value="' + responseJSON.uploadName + '"></input>');
                    $(li).find('.qq-upload-actions').append('<a class="primary_image btn btn-mtx bg-accent" title="<?php echo osc_esc_js(__('Make primary image', 'matrix')); ?>"><?php echo osc_esc_js(__('Primary', 'matrix')); ?></a>');
                }

                makeSortable();

                <?php if($is_edit) { ?>
            }).on('validateBatch', function (event, fileOrBlobDataArray) {
                var len = fileOrBlobDataArray.length;
                var result = canContinue(len);

                return result.success;
            });

            function canContinue(numUpload) {
                var strUrl = "<?php echo osc_base_url(true) . "?page=ajax&action=ajax_validate&id=" . osc_item_id() . "&secret=" . osc_item_secret(); ?>";
                var strReturn = {};

                jQuery.ajax({
                    url: strUrl,
                    success: function (html) {
                        strReturn = html;
                    },
                    async: false
                });
                var json = JSON.parse(strReturn);
                var total = parseInt(json.count) + $("#restricted-fine-uploader input[name='ajax_photos[]']").size() + (numUpload);
                <?php if($maxImages>0) { ?>
                    if(total <=<?php echo $maxImages;?>) {
                        json.success = true;
                    } else {
                        json.success = false;

                        $('.qq-upload-button').after('<div class="flashmessage flashmessage-error" style="margin-bottom: 20px;"><?php echo osc_esc_js(sprintf(__('Too many items were uploaded. Item limit is %d.'), $maxImages)); ?><a class="close" style="color: #fff; float: right; padding-right: 10px; cursor: pointer;" onclick="javascript:$(\'.flashmessage-error\').remove();" >X</a></div>');
                    }
                <?php } else { ?>
                    json.success = true;
                <?php } ?>
                return json;
            }

            <?php } else { ?>
        });
        <?php } ?>

            makeSortable();

            $(".qq-upload-success:first .primary_image").css('display', 'none');
            $(".qq-upload-success").prependTo('.qq-upload-list-selector');
        })
    </script>
<?php
}

function przi_ajax_uploader() {
    require_once 'prziAjaxUploader.php';
    $uploader = new prziAjaxUploader();
    $filename = uniqid("qqfile_") . "." . pathinfo(Params::getParam('qqfilename'), PATHINFO_EXTENSION);
    $result = $uploader->handleUpload(osc_content_path() . 'uploads/temp/' . $filename);
    $result['uploadName'] = $filename;

    if(Params::getParam('scaling') == 'false') {
        // auto rotate
        require_once 'prziImageProcessing.php';
        try {
            $img = prziImageProcessing::fromFile(osc_content_path() . 'uploads/temp/' . $filename);
            $img->autoRotate();
            $img->saveToFile(osc_content_path() . 'uploads/temp/auto_' . $filename);

            $result['uploadName'] = 'auto_' . $filename;
            echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        } catch (Exception $e) {
            echo "";
        }
    } else {
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
}
osc_add_hook('ajax_przi_ajax_uploader', 'przi_ajax_uploader');
?>
