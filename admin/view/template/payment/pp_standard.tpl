<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_email; ?></td>
        <td><input type="text" name="pp_standard_email" value="<?php echo $pp_standard_email; ?>" />
          <br />
          <?php if ($error_email) { ?>
          <span class="error"><?php echo $error_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_test; ?></td>
        <td><?php if ($pp_standard_test) { ?>
          <input type="radio" name="pp_standard_test" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="pp_standard_test" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="pp_standard_test" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="pp_standard_test" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_transaction; ?></td>
        <td><select name="pp_standard_transaction">
            <?php if (!$pp_standard_transaction) { ?>
            <option value="0" selected="selected"><?php echo $text_authorization; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_authorization; ?></option>
            <?php } ?>
            <?php if ($pp_standard_transaction) { ?>
            <option value="1" selected="selected"><?php echo $text_sale; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_sale; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="pp_standard_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $pp_standard_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_geo_zone; ?></td>
        <td><select name="pp_standard_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $pp_standard_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="pp_standard_status">
            <?php if ($pp_standard_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input type="text" name="pp_standard_sort_order" value="<?php echo $pp_standard_sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
