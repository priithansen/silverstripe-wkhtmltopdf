<?php

class HeydayWkHtmlToPdfStringOutput implements HeydayWkHtmlToPdfOutputter
{

	public function process(WKPDF $wkpdf)
	{

		$wkpdf->render();
		return $wkpdf->output(WKPDF::$PDF_ASSTRING, false);

	}

}
