<div id="quick_add_trackingno" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $text_quick_addtracking; ?></h4>
      </div>
      <div class="modal-body form-horizontal">
        <div class="form-group">
					<label class="col-sm-12 control-label" for="input-qompt_tracking_no"><?php echo $entry_tracking_no; ?></label>
          <div class="col-sm-12">
						<input type="text" name="ompt_tracking_no" id="input-qompt_tracking_no" class="form-control"/>
          </div>
				</div>
        <div class="form-group">
          <label class="col-sm-12 control-label" for="input-qompt_tracking_carrier"><?php echo $entry_tracking_carrier; ?></label>
          <div class="col-sm-12">
            <div class="" style="height: 240px; overflow: auto;">
              <ul id="ompt_tracking_carriers" class="list-group">
                <?php foreach ($tracking_carriers as $tracking_carrier) { ?>
                <li class="list-group-item">
                  <div class="ompt_tracking_carrier">
                    <img src="<?php echo $tracking_carrier['thumb']; ?>" alt="<?php echo $tracking_carrier['name']; ?>">
                    <label><input type="radio" name="ompt_tracking_carrier_id" id="input-qompt_tracking_carrier<?php echo $tracking_carrier['mptracking_carrier_id']; ?>" class="form-control" value="<?php echo $tracking_carrier['mptracking_carrier_id']; ?>" /> <?php echo $tracking_carrier['name']; ?></label>
                  </div>
                </li>
                <?php } ?>
              </ul>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="qompt_quicksave" data-order_id=""><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
      </div>
    </div>
	</div>
</div>
<style type="text/css">

  #quick_add_trackingno .alert { margin-bottom: 0; }
  #quick_add_trackingno .form-horizontal .control-label { text-align: left; }

  .loader {border: 16px solid #f3f3f3;border-radius: 50%;border-top: 16px solid blue;border-bottom: 16px solid blue; width: 50px; height: 50px; position: fixed; left: 47%; top: 40%; -webkit-animation: spin 2s linear infinite; animation: spin 2s linear infinite; z-index: 9999;}
  #quick_add_trackingno .modal-backdrop.in { opacity: 0.2; filter: alpha(opacity=20);}
  #quick_add_trackingno .modal-backdrop { position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 1040; background-color: #000;}
  @-webkit-keyframes spin {0% { -webkit-transform: rotate(0deg); }100% { -webkit-transform: rotate(360deg); }}
  @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); }}
</style>
<script type="text/javascript"><!--
$(document).ready(function() {
  var _btnTrackingNo;
  $('#quick_add_trackingno').on('shown.bs.modal', function(e) {
    if (typeof e.relatedTarget._btnTrackingNo != 'undefined') {
      _btnTrackingNo = e.relatedTarget._btnTrackingNo;
      _btnTrackingNo.attr('disabled','disabled');
      var $i = _btnTrackingNo.find('i');
      $i.attr('class', 'fa fa-spinner fa-spin');
    }
  });
  $('#quick_add_trackingno').on('hidden.bs.modal', function(e) {
    $('#qompt_quicksave').attr('data-order_id','').data('order_id','');
    if (_btnTrackingNo) {
      _btnTrackingNo.removeAttr('disabled');
      var $i = _btnTrackingNo.find('i');
      $i.attr('class', $i.data('class'));
    }
    _btnTrackingNo = null;
  });
  // save order tracking number selected orders
  $('#qompt_quicksave').on('click', function() {
    var $this = $(this);

    var data = $('#quick_add_trackingno input').serialize();
    if (data) {
      data += '&';
    }

    data += 'override=1&append=0&order_id=' + $this.attr('data-order_id');

    $.ajax({
      url: 'index.php?route=extension/module/mpordertracking/quickTrackingNo&get=1&<?php echo $get_token; ?>=<?php echo $token; ?>',
      type: 'post',
      dataType: 'json',
      data: data,
      beforeSend: function() {
        $this.button('loading');
        $('#quick_add_trackingno').append('<div class="modal-backdrop in mp_loader"></div><div class="loader"></div>');
      },
      complete: function() {
        $('#quick_add_trackingno .mp_loader, #quick_add_trackingno .loader').remove();
        $this.button('reset');
      },
      success: function(json) {
        $('#quick_add_trackingno .alert, #quick_add_trackingno .text-danger').remove();

        if (json['error']) {
          if (typeof json['error']['warning'] != 'undefined' && json['error']['warning']) {
            $('#quick_add_trackingno .modal-header').before('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          }
          if (typeof json['error']['tracking_no'] != 'undefined' && json['error']['tracking_no']) {
            $('#input-qompt_tracking_no').after('<div class="text-danger"> ' + json['error']['tracking_no'] + '</div>');
          }
        }
        if (json['success']) {

          if (json['order_history']) {

            <?php if (VERSION >= '3.0.0.0') { ?>
              var var_token = 'api_token=<?php echo $api_token; ?>';
            <?php } else { ?>
              var var_token = 'token='+ (token && $this.data('ocapi_token') == token ? token : $this.data('ocapi_token'));
            <?php } ?>

            $.ajax({
              url: '<?php echo $catalog; ?>index.php?route=api/order/history&' + var_token + '&store_id='+ json['order_history']['store_id'] +'&order_id='+ $this.attr('data-order_id') +'',
              type: 'post',
              dataType: 'json',
              data: json['order_history'],
              beforeSend: function() {
                $('#quick_add_trackingno .mp_loader, #quick_add_trackingno .loader').remove();
                $this.button('reset');
              },
              complete: function() {
                $('#quick_add_trackingno .mp_loader, #quick_add_trackingno .loader').remove();
                $this.button('reset');
              },
              success: function(json) {
                $('.alert').remove();

                if (json['error']) {

                  $('#quick_add_trackingno .modal-header').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['success']) {

                  $('#quick_add_trackingno .modal-header').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    setTimeout(() => {
                      $('#quick_add_trackingno').modal('hide');

                      $('#history').load('index.php?route=sale/order/history&<?php echo $get_token; ?>=<?php echo $token; ?>&order_id='+$this.attr('data-order_id'));
                    }, 1500);

                }

              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });

          } else {

            $('#quick_add_trackingno .modal-header').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

            $('#quick_add_trackingno .mp_loader, #quick_add_trackingno .loader').remove();
            $this.button('reset');

            setTimeout(() => {
              $('#quick_add_trackingno').modal('hide');

              $('#history').load('index.php?route=sale/order/history&<?php echo $get_token; ?>=<?php echo $token; ?>&order_id='+$this.attr('data-order_id'));
            }, 1500);

          }

          if (_btnTrackingNo) {
            _btnTrackingNo.parents('td').find('.ompt_tracking_no').text(json['tracking_no']);
            _btnTrackingNo.replaceWith('<a class="mpedit-trackingno btn btn-success btn-xs" data-order_id="'+ $this.attr('data-order_id') +'"><i class="fa fa-pencil" data-class="fa fa-pencil"></i></a>');
          }

        }

      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });


  });
});
//--></script>