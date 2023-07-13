<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right form-inline">
                <button type="submit" form="form-shipping" name="apply" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success"><i class="fa fa-check"></i></button>
                <button type="submit" form="form-shipping" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
                <span class="pull-right"><?php echo $text_info; ?></span>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-main" data-toggle="tab"><?php echo $tab_main; ?></a></li>
                    <li><a href="#tab-advanced-options" data-toggle="tab"><?php echo $tab_advanced_options; ?></a></li>
                    <li><a href="#tab-cargo-info" data-toggle="tab"><?php echo $tab_cargo_info; ?></a></li>
                    <li><a href="#tab-info" data-toggle="tab"><?php echo $tab_info; ?></a></li>
                    <li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
                </ul>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-shipping" class="form-horizontal">
                    <div class="tab-content">
                        <div class="tab-pane active form-horizontal" id="tab-main">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><span class="help" title="<?php echo $help_status; ?>" data-toggle="tooltip"><?php echo $entry_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_status" id="input-status" class="form-control">
                                        <option value="0" <?php echo "0" == $boovicargo_status ? "selected" : ""; ?>><?php echo $text_disabled; ?></option>
                                        <option value="1" <?php echo "1" == $boovicargo_status ? "selected" : ""; ?>><?php echo $text_enabled; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-payment-type"><span class="help" title="<?php echo $help_payment_type; ?>" data-toggle="tooltip"><?php echo $entry_payment_type; ?></span></label>
                                <div class="col-sm-10">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="boovicargo_payment_type[]" value="1" <?php echo is_array($boovicargo_payment_type) && in_array("1", $boovicargo_payment_type) ? "checked" : ""; ?>/> <?php echo $online_odeme; ?></label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="boovicargo_payment_type[]" value="2" <?php echo is_array($boovicargo_payment_type) && in_array("2", $boovicargo_payment_type) ? "checked" : ""; ?>/> <?php echo $kapida_nakit_odeme; ?></label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="boovicargo_payment_type[]" value="3" <?php echo is_array($boovicargo_payment_type) && in_array("3", $boovicargo_payment_type) ? "checked" : ""; ?>/> <?php echo $Kaida_kredi_karti; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-new-order-status"><span class="help" title="<?php echo $help_new_order_status; ?>" data-toggle="tooltip"><?php echo $entry_new_order_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_new_order_status" id="input-new-order-status" class="form-control">
                                        <option value="0"><?php echo $text_none; ?></option>
                                        <?php foreach ($order_status_all as $item) { ?>
                                            <option value="<?php echo $item['order_status_id']; ?>" <?php echo $item['order_status_id'] == $boovicargo_new_order_status ? "selected" : ""; ?>><?php echo $item['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($error_new_order_status): ?>
                                        <div class="text-danger"><?php echo $error_new_order_status; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-order-status-type"><span class="help" title="<?php echo $help_order_status_type; ?>" data-toggle="tooltip"><?php echo $entry_order_status_type; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_order_status_type" id="input-order-status-type" class="form-control">
                                        <option value="0"><?php echo $text_none; ?></option>
                                        <?php foreach ($order_status_all as $item) { ?>
                                            <option value="<?php echo $item['order_status_id']; ?>" <?php echo $item['order_status_id'] == $boovicargo_order_status_type ? "selected" : ""; ?>><?php echo $item['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane form-horizontal" id="tab-advanced-options">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cargo-mail-notifications"><span class="help" title="<?php echo $help_cargo_mail_notifications; ?>" data-toggle="tooltip"><?php echo $entry_cargo_mail_notifications; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_cargo_mail_notifications" id="input-cargo-mail-notifications" class="form-control">
                                        <option value="1" <?php echo "1" == $boovicargo_cargo_mail_notifications ? "selected" : ""; ?>><?php echo $hayir; ?></option>
                                        <option value="2" <?php echo "2" == $boovicargo_cargo_mail_notifications ? "selected" : ""; ?>><?php echo $sadece_takip_linki; ?></option>
                                        <option value="3" <?php echo "3" == $boovicargo_cargo_mail_notifications ? "selected" : ""; ?>><?php echo $tum_kargo_hareketleri; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-mail-content"><span class="help" title="<?php echo $help_mail_content; ?>" data-toggle="tooltip"><?php echo $entry_mail_content; ?></span></label>
                                <div class="col-sm-10">
                                    <textarea name="boovicargo_mail_content" id="input-mail-content" class="form-control summernote" rows="5"><?php echo $boovicargo_mail_content; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-shipping-complete-order-status"><span class="help" title="<?php echo $help_shipping_complete_order_status; ?>" data-toggle="tooltip"><?php echo $entry_shipping_complete_order_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_shipping_complete_order_status" id="input-shipping-complete-order-status" class="form-control">
                                        <option value="0"><?php echo $text_none; ?></option>
                                        <?php foreach ($order_status_all as $item) { ?>
                                            <option value="<?php echo $item['order_status_id']; ?>" <?php echo $item['order_status_id'] == $boovicargo_shipping_complete_order_status ? "selected" : ""; ?>><?php echo $item['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-shipping-return-order-status"><span class="help" title="<?php echo $help_shipping_return_order_status; ?>" data-toggle="tooltip"><?php echo $entry_shipping_return_order_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_shipping_return_order_status" id="input-shipping-return-order-status" class="form-control">
                                        <option value="0"><?php echo $text_none; ?></option>
                                        <?php foreach ($order_status_all as $item) { ?>
                                            <option value="<?php echo $item['order_status_id']; ?>" <?php echo $item['order_status_id'] == $boovicargo_shipping_return_order_status ? "selected" : ""; ?>><?php echo $item['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cargo-barcode-type"><span class="help" title="<?php echo $help_cargo_barcode_type; ?>" data-toggle="tooltip"><?php echo $entry_cargo_barcode_type; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="boovicargo_cargo_barcode_type" id="input-cargo-barcode-type" class="form-control">
                                        <option value="1" <?php echo "1" == $boovicargo_cargo_barcode_type ? "selected" : ""; ?>><?php echo $irsaliye; ?></option>
                                        <option value="2" <?php echo "2" == $boovicargo_cargo_barcode_type ? "selected" : ""; ?>><?php echo $kucuk_barkod; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane form-horizontal" id="tab-cargo-info">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sendeo-user-id"><span class="help" title="<?php echo $help_sendeo_user_id; ?>" data-toggle="tooltip"><?php echo $entry_sendeo_user_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="boovicargo_sendeo_user_id" value="<?php echo $boovicargo_sendeo_user_id; ?>" placeholder="<?php echo $entry_sendeo_user_id; ?>" id="input-sendeo-user-id" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-field-new"><span class="help" title="<?php echo $help_field_new; ?>" data-toggle="tooltip"><?php echo $entry_field_new; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="boovicargo_field_new" value="<?php echo $boovicargo_field_new; ?>" placeholder="<?php echo $entry_field_new; ?>" id="input-field-new" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sendeo-user-key"><span class="help" title="<?php echo $help_sendeo_user_key; ?>" data-toggle="tooltip"><?php echo $entry_sendeo_user_key; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="boovicargo_sendeo_user_key" value="<?php echo $boovicargo_sendeo_user_key; ?>" placeholder="<?php echo $entry_sendeo_user_key; ?>" id="input-sendeo-user-key" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane form-horizontal" id="tab-info">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-aciklama-alani-test"><span class="help" title="<?php echo $help_aciklama_alani_test; ?>" data-toggle="tooltip"><?php echo $entry_aciklama_alani_test; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="boovicargo_aciklama_alani_test" value="<?php echo $boovicargo_aciklama_alani_test; ?>" placeholder="<?php echo $entry_aciklama_alani_test; ?>" id="input-aciklama-alani-test" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane form-horizontal" id="tab-support">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-yardim-test-alani"><span class="help" title="<?php echo $help_yardim_test_alani; ?>" data-toggle="tooltip"><?php echo $entry_yardim_test_alani; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="boovicargo_yardim_test_alani" value="<?php echo $boovicargo_yardim_test_alani; ?>" placeholder="<?php echo $entry_yardim_test_alani; ?>" id="input-yardim-test-alani" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php echo $footer; ?>
</div>
