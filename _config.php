<?php

Director::addRules(100, array(
	SilverStripeWkHtmlToPdfController::$url_segment . '//$Action/$ID/$OtherID' => 'SilverStripeWkHtmlToPdfController'
));

Object::add_extension('Image', 'SilverStripeWkHtmlToPdfTemplateHelper_ImageExtension');
