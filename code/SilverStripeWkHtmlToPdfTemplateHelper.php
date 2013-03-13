<?php

class SilverStripeWkHtmlToPdfTemplateHelper extends ViewableData
{

    public function EmbedCss($css)
    {

        if (file_exists(BASE_PATH . $css)) {
            return '<style>' . file_get_contents(BASE_PATH . $css) . '</style>';
        }

    }

    public function EmbedBase64Image($image)
    {

        if (file_exists(BASE_PATH . $image)) {
            return 'data:image/png;base64,' . base64_encode(file_get_contents(BASE_PATH . $image));
        }

    }

}

class SilverStripeWkHtmlToPdfTemplateHelper_ImageExtension extends DataExtension
{

    public function extraStatics()
    {

        return array();

    }

    public function Base64()
    {

        return singleton('SilverStripeWkHtmlToPdfTemplateHelper')->EmbedBase64Image('/' . $this->owner->getRelativePath());

    }

}