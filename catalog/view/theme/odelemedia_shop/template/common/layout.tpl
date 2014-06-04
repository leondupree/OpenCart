<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="image/<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/odelemedia_shop/stylesheet/stylesheet.css" />
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/odelemedia_shop/stylesheet/ie6.css" />
<![endif]-->
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/thickbox/thickbox-compressed.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/thickbox/thickbox.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tab.js"></script>
</head>
<body>
<div id="container">
  <div id="header"><?php echo $header; ?></div>
  <div id="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div id="column_left">
    <?php foreach ($modules as $module) { ?>
    <?php if ($module['position'] == 'left') { ?>
    <?php echo ${$module['code']}; ?>
    <?php } ?>
    <?php } ?>
  </div>
  <div id="column_right">
    <?php foreach ($modules as $module) { ?>
    <?php if ($module['position'] == 'right') { ?>
    <?php echo ${$module['code']}; ?>
    <?php } ?>
    <?php } ?>
       <div id="module_cart" class="box">
           <div class="top"> </div>
           <div class="middle">
                <div style="text-align: center;"><iframe src="http://rcm.amazon.com/e/cm?t=odemed-20&o=1&p=29&l=ur1&category=pets&banner=1HQX46CSHMPJYSYMDSR2&f=ifr" width="120" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe></div>
           </div>
           <div class="bottom"> </div>
       </div>

  </div>
  <div id="content"><?php echo $content; ?></div>
  <div id="footer"><?php echo $footer; ?></div>
</div>
</body>
</html>