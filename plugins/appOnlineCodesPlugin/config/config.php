<?php
if (SF_APP == 'backend') {
	stPluginHelper::addEnableModule('appOnlineCodesBackend', 'backend');
	stPluginHelper::addEnableModule('appOnlineCodesMail', 'backend');

	stPluginHelper::addRouting('appOnlineCodesPlugin', '/online_codes/:action/*', 'appOnlineCodesBackend', 'list', 'backend');

	$dispatcher->connect('stAdminGenerator.generateStProduct', array('appOnlineCodesListener', 'generateStProduct'));
	$dispatcher->connect('Payment.postSave', array('appOnlineCodesListener', 'savePaymentStatus'));
	$dispatcher->connect('autoStProductActions.postUpdateOnlineAudioFromRequest', array('appOnlineCodesListener', 'updateFromRequestFiles'));
	$dispatcher->connect('autoStProductActions.postUpdateOnlineImagesFromRequest', array('appOnlineCodesListener', 'updateFromRequestFiles'));
	$dispatcher->connect('autoStProductActions.postUpdateOnlineDocsFromRequest', array('appOnlineCodesListener', 'updateFromRequestFiles'));
	$dispatcher->connect('autoStProductActions.postUpdateOnlineCodesFromRequest', array('appOnlineCodesListener', 'updateFromRequestFiles'));

	stPluginHelper::addRouting('appOnlineCodesDownload', '/online-codes/download/:id/:hash/:file', 'appOnlineCodesFrontend', 'download', 'backend');

}

if (SF_APP == 'frontend') {
	stPluginHelper::addEnableModule('appOnlineCodesFrontend', 'frontend');
	stPluginHelper::addEnableModule('appOnlineCodesMail', 'frontend');
	
    stPluginHelper::addRouting('appOnlineCodesPlugin', '/online_codes/:action/*', 'appOnlineCodesFrontend', 'index', 'frontend');
    stPluginHelper::addRouting('appOnlineCodesDownload', '/online-codes/download/:id/:hash/:file', 'appOnlineCodesFrontend', 'download', 'frontend');

    $dispatcher->connect('Payment.postSave', array('appOnlineCodesListener', 'savePaymentStatus'));
}
