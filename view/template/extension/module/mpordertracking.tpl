<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="mp-content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-mpordertracking" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        <button type="submit" onclick="$('#stay_here').val(1)" form="form-module_mp_manijmuhnt_config" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $button_stay_here; ?></button>
        <a href="<?php echo $cancel; ?>" class="btn btn-warning"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a></div>
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
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-mpordertracking" class="form-horizontal">
          <input type="hidden" name="stay_here" id="stay_here" value="0">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <!--li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li-->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="module_mpordertracking_status" id="input-status" class="form-control">
                    <?php if ($module_mpordertracking_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_edit_trackingcode; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($module_mpordertracking_edit_trackingcode) { ?>
                    <input type="radio" name="module_mpordertracking_edit_trackingcode" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="module_mpordertracking_edit_trackingcode" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$module_mpordertracking_edit_trackingcode) { ?>
                    <input type="radio" name="module_mpordertracking_edit_trackingcode" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="module_mpordertracking_edit_trackingcode" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                  <div class="help"><?php echo $help_edit_trackingcode; ?></div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <fieldset>
                <legend><?php echo $legend_order_status; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_update_order_status; ?></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($module_mpordertracking_update_order_status) { ?>
                      <input type="radio" name="module_mpordertracking_update_order_status" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="module_mpordertracking_update_order_status" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$module_mpordertracking_update_order_status) { ?>
                      <input type="radio" name="module_mpordertracking_update_order_status" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="module_mpordertracking_update_order_status" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                    <div class="help"><?php echo $help_update_order_status; ?></div>
                  </div>
                </div>
                <div id="mp-order_status">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                    <div class="col-sm-10">
                      <select name="module_mpordertracking_order_status_id" id="input-order-status" class="form-control">
                        <?php foreach ($order_statuses as $order_statuses) { ?>
                        <?php if ($order_statuses['order_status_id'] == $module_mpordertracking_order_status_id) { ?>
                        <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-override"><?php echo $entry_override; ?></label>
                    <div class="col-sm-10">
                      <input type="checkbox" name="module_mpordertracking_override" value="1" id="input-override" <?php if ($module_mpordertracking_override) { ?>checked="checked"<?php } ?> />

                      <div class="help"><?php echo $help_override; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                    <div class="col-sm-10">
                      <input type="checkbox" name="module_mpordertracking_notify" value="1" id="input-notify" <?php if ($module_mpordertracking_notify) { ?>checked="checked"<?php } ?> />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                    <div class="col-sm-10">

                      <button type="button" data-toggle="collapse" class="btn btn-primary btn-sm" href="#boscollapse_template" aria-expanded="false" aria-controls="boscollapse_template"><i class="fa fa-info-circle"></i> <?php echo $button_short_codes; ?></button>
                      <div class="codes">
                        <div class="collapse" id="boscollapse_template" style="background: #eee;">
                          <div class="card card-block">
                            <ul class="list-unstyled">
                              <li>{firstname} - <?php echo $text_sc_firstname; ?></li>
                              <li>{lastname} - <?php echo $text_sc_lastname; ?></li>
                              <li>{order_id} - <?php echo $text_sc_order_id; ?></li>
                              <li>{tracking_no} - <?php echo $text_sc_tracking_no; ?></li>
                              <li>{order_status} - <?php echo $text_sc_order_status; ?></li>
                              <li>{order_date_added} - <?php echo $text_sc_order_date_added; ?></li>
                              <li>{tracking_carrier_image} - <?php echo $text_sc_tracking_carrier_image; ?></li>
                              <li>{tracking_carrier_name} - <?php echo $text_sc_tracking_carrier_name; ?></li>
                              <li>{tracking_carrier_url} - <?php echo $text_sc_tracking_carrier_url; ?></li>
                              <li>{tracking_carrier_trackingurl} - <?php echo $text_sc_tracking_carrier_trackingurl; ?></li>

                            </ul>
                          </div>
                        </div>
                      </div>

                      <textarea name="module_mpordertracking_comment" rows="8" id="input-comment" class="form-control"><?php echo $module_mpordertracking_comment; ?></textarea>
                    </div>
                  </div>
                </div>

              </fieldset>
               <fieldset>
                <legend><?php echo $legend_carriers; ?></legend>
                <div class="table-responsive">
                  <table id="carriers" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <td class="text-left"><?php echo $entry_image; ?></td>
                        <td class="text-left"><?php echo $entry_name; ?></td>
                        <td class="text-left"><?php echo $entry_url; ?></td>
                        <td class="text-left"><?php echo $entry_tracking_url; ?><br/><div class="help"><?php echo $help_tracking_url; ?></div></td>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $carrier_row = 0; ?>
                      <?php foreach ($carriers as $carrier) { ?>
                      <tr id="carrier-row<?php echo $carrier_row; ?>">
                        <td class="text-left"><a href="" id="thumb-carrier<?php echo $carrier_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $carrier['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="tracking_carriers[<?php echo $carrier_row; ?>][image]" value="<?php echo $carrier['image']; ?>" id="input-carrier<?php echo $carrier_row; ?>" /></td>
                        <td class="text-left"><input type="hidden" name="tracking_carriers[<?php echo $carrier_row; ?>][mptracking_carrier_id]" value="<?php echo $carrier['mptracking_carrier_id']; ?>" /><input type="text" name="tracking_carriers[<?php echo $carrier_row; ?>][name]" value="<?php echo $carrier['name']; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>
                        <td class="text-left"><input type="text" name="tracking_carriers[<?php echo $carrier_row; ?>][url]" value="<?php echo $carrier['url']; ?>" placeholder="<?php echo $entry_url; ?>" class="form-control" /></td>
                        <td class="text-left"><input type="text" name="tracking_carriers[<?php echo $carrier_row; ?>][tracking_url]" value="<?php echo $carrier['tracking_url']; ?>" placeholder="<?php echo $entry_tracking_url; ?>" class="form-control" /></td>
                        <td class="text-left"><button type="button" onclick="$('#carrier-row<?php echo $carrier_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i> <?php echo $button_remove; ?></button></td>
                      </tr>
                      <?php $carrier_row++; ?>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td>
                        <td class="text-left"><button type="button" onclick="addCarrier();" id="btn-addcarrier" data-row="<?php echo $carrier_row; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_carrier_add; ?></button></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </fieldset>
            </div>
            <!--div class="tab-pane" id="tab-support">
              <div class="bs-callout bs-callout-info">
                <h4>ModulePoints <?php echo $heading_title; ?></h4>
                <center><strong><?php echo $heading_title; ?> </strong></center> <br/>
              </div>
              <fieldset>
                <div class="form-group">
                  <div class="col-md-12 col-xs-12">
                    <h4 class="text-mpsuccess text-center"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Thanks For Choosing Our Extension</h4>
                    <h4 class="text-mpsuccess text-center"><i class="fa fa-phone" aria-hidden="true"></i>Kindly Write Us At Support Email For Support</h4>
                    <ul class="list-group">
                      <li class="list-group-item clearfix">support@modulepoints.com <span class="badge"><a href="mailto:support@modulepoints.com?Subject=Request Support: <?php echo $heading_title; ?> Extension"><i class="fa fa-envelope"></i> Contact Us</a></span></li>
                    </ul>
                  </div>
                </div>
              </fieldset>
            </div-->
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    function addCarrier() {
      var carrier_row =  $('#btn-addcarrier').data('row');

      var html  = '<tr id="carrier-row' + carrier_row + '">';
      html += '  <td class="text-left"><a href="" id="thumb-carrier' + carrier_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="tracking_carriers[' + carrier_row + '][image]" value="" id="input-carrier' + carrier_row + '" /></td>';
      html += '  <td class="text-left"><input type="hidden" name="tracking_carriers[' + carrier_row + '][mptracking_carrier_id]" value="0" /><input type="text" name="tracking_carriers[' + carrier_row + '][name]" value="" placeholder="<?php echo $entry_name; ?>" class="form-control" /></td>';
      html += '  <td class="text-left"><input type="text" name="tracking_carriers[' + carrier_row + '][url]" value="" placeholder="<?php echo $entry_url; ?>" class="form-control" /></td>';
      html += '  <td class="text-left"><input type="text" name="tracking_carriers[' + carrier_row + '][tracking_url]" value="" placeholder="<?php echo $entry_tracking_url; ?>" class="form-control" /></td>';
      html += '  <td class="text-left"><button type="button" onclick="$(\'#carrier-row' + carrier_row  + '\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i> <?php echo $button_remove; ?></button></td>';
      html += '</tr>';

      $('#carriers > tbody').append(html);

      carrier_row++;

      $('#btn-addcarrier').data('row', carrier_row).attr('data-row', carrier_row);
    }
  //--></script>
</div>
<?php echo $footer; ?>