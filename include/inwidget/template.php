<?php 
/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        template.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * https://inwidget.ru/MIT-license.txt
 * 
 * @link https://inwidget.ru
 * @copyright 2014-2019 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @package inWidget
 *
 */

if(!$inWidget instanceof \inWidget\Core) {
	throw new \Exception('inWidget object was not initialised.');
}

?>
<!DOCTYPE html> 
<html lang="ru">
	<head>
		<title>Instagram Widget</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?= $inWidget->langName ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	</head>
<body>
<div class="flex-row sc7__inwidget">
		<?$i = 0;
		$count = $inWidget->countAvailableImages($inWidget->data->images);
		if ($count>0) {
			if ($inWidget->config['imgRandom'] === true) shuffle($inWidget->data->images);
				foreach ($inWidget->data->images as $key=>$item){
					if($inWidget->isBannedUserId($item->authorId) === true) continue;
					switch ($inWidget->preview){
						case 'large':
							$thumbnail = $item->large;
							break;
						case 'fullsize':
							$thumbnail = $item->fullsize;
							break;
						default:
							$thumbnail = $item->small;
					}
//					echo '<a href="'.$item->link.'" class="image" target="_blank"><span style="background-image:url('.$thumbnail.');">&nbsp;</span></a>';
					echo '<div class="sc7__in-im" style="background-image:url('.$thumbnail.');"></div>';
					$i++;
					if($i >= $inWidget->view) break;
				}
		}
		else {
			if (!empty($inWidget->config['HASHTAG'])) {
				$inWidget->lang['imgEmptyByHash'] = str_replace(
					'{$hashtag}', 
					$inWidget->config['HASHTAG'], 
					$inWidget->lang['imgEmptyByHash']
				);
				echo '<div class="empty">'.$inWidget->lang['imgEmptyByHash'].'</div>';
			}
			else echo '<div class="empty">'.$inWidget->lang['imgEmpty'].'</div>';
		}
	?>
</div>

<?if (isset($inWidget->data->isBackup)): ?>
	<div class='cacheError'>
		<?= $inWidget->lang['errorCache'].' '.date('Y-m-d H:i:s',$inWidget->data->lastupdate) .' <br /> '. $inWidget->lang['updateNeeded'] ?>
	</div>
<?endif;?>
</body>
</html>

<!-- 
	inWidget - free Instagram widget for your site!
	https://inwidget.ru
	© Alexandr Kazarmshchikov
-->