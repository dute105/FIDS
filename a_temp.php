<!doctype html>
<?php include('display_functions.php'); ?>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Untitled Document</title>
<link href="src/boilerplate.css" rel="stylesheet" type="text/css">
<link href="src/style.css" rel="stylesheet" type="text/css">
<link href="src/parse.css" rel="stylesheet" type="text/css">
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="src/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">
<div id="LayoutDiv1">
<header>
  <img src="img/arrivals.gif" /><img src="img/flytucson.png" id="logo" />
  </header>
  
  <div class="clears"></div><div id='arrivals'><?php arrivals(); ?></div></div>
</div>


</body>
</html>
