<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Misc\Response;

require_once 'Registry.php';
require_once 'Response.php';

$pagetitle = 'Hello world';

$response = Registry::Instance()->Response;

include_once "template.php";
	?>
<h1 class="blog-header"><?=$pagetitle?></h1>
<div class="container">
	<div class="row">
		<p><?="The message was ".$response->IndexGetOut('message'); ?></p>
	</div>
</div>

