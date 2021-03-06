<?php

require_once dirname(__FILE__) . '/ThirdParty/wkhtmltopdf.php';

/**
 * SilverStripeWkHtmlToPdf provides a SilverStripe-centric wrapper for the [wkhtmltopdf](http://code.google.com/p/wkhtmltopdf/) project and php bindings.
 */
class SilverStripeWkHtmlToPdf
{

	/**
	 * Localtion of the wkhtmltopdf binary. This must be set to use this module.
	 */
	protected static $bin = false;

	/**
	 * The outputter to use.
	 */
	protected $outputter = false;
	/**
	 * The inputter to use
	 */
	protected $inputter = false;

	/**
	 * Arguments to be passed onto wkpdf
	 */
	protected $arguments = array();

	/**
	 * Convinience method for getting an instance of this class
	 */
	public static function get_instance( $input, $output, $arguments = array() )
	{

		return new self( $input, $output, $arguments );

	}

	/**
	 * Set the binary for use in the module. This must be set to do any processing. This should be called from your config
	 */
	public static function set_bin( $bin )
	{

		self::$bin = $bin;

	}

	/**
	 * Get the binary location
	 */
	public static function get_bin()
	{

		return self::$bin;

	}

	/**
	 * Constructor. Create the class and set the input and output it exists.
	 */
	public function __construct( $input = null, $output = null, $arguments = array() )
	{

		if ($input instanceof SilverStripeWkHtmlToPdfInputter) {

			$this->setInputter( $input );

		}

		if ($output instanceof SilverStripeWkHtmlToPdfOutputter) {

			$this->setOutputter( $output );

		}

		if(is_array($arguments) && count($arguments)){
			$this->arguments = $arguments;
		}

	}

	/**
	 * Sets the arguments to be passed onto wkpdf
	 */
	public function setArguments($argmuments)
	{
		if(is_array($argmuments)){

			$this->arguments = $arguments;

		}else{

			user_error('Arguments must be an array');
			
		}

	}

	/**
	 * Sets the outputter ensuring it implements the interface
	 */
	public function setOutputter( SilverStripeWkHtmlToPdfOutputter $outputter )
	{

		$this->outputter = $outputter;

	}

	/**
	 * Sets the inputter ensuring it implements the interface
	 */
	public function setInputter( SilverStripeWkHtmlToPdfInputter $inputter )
	{

		$this->inputter = $inputter;

	}

	/**
	 * The almighty process method. This processes the pdf using the inputters and outputters that have been set.
	 */
	public function process()
	{

		if ( !$this->outputter || !$this->outputter instanceof SilverStripeWkHtmlToPdfOutputter ) {

			user_error( 'Need to have an outputter set in order to output the PDF' );

		}

		if ( !$this->inputter || !$this->inputter instanceof SilverStripeWkHtmlToPdfInputter ) {

			user_error( 'Need to have an inputter set in order to get the content for the PDF' );

		}

		$wkpdf = new WKPDF();

		if(is_array($this->arguments) && count($this->arguments)){

			foreach($this->arguments as $key => $value){
				$wkpdf->args_add($key, $value);
			}

		}

		if ( !self::$bin ) {

			user_error( 'wkhtmltopdf binary not set' );

		}

		$wkpdf->set_cmd( self::$bin );

		$this->inputter->process( $wkpdf );

		return $this->outputter->process( $wkpdf );

	}

}

