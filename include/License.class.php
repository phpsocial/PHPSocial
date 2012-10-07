<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of License
 *
 * @author NE
 */
class License {

	const LICENSE_FILENAME = 'license';

	/**
	 * Key used in license code generating
	 *
	 * @var string
	 */
	private $_licenseKey = '';

	private $_licFilePath = '';
	/**
	 * License code
	 *
	 * @var string
	 */
	private $_licenseCode = '';

	public function  __construct($licenseKey = '') {
		if(empty($licenseKey)) {
			$licenseKey = $_SERVER['SERVER_NAME'];
		}
        $licenseKey = trim($licenseKey);
        	
        if (substr($licenseKey, 0, 7) == "http://") {
            $licenseKey = substr($licenseKey, 7);
        }
        if (substr($licenseKey, 0, 4) == "www.") {
            $licenseKey = substr($licenseKey, 4);
        }
      
        if (substr($licenseKey, (strlen($licenseKey)-1), 1) == "/") {
            $licenseKey = substr($licenseKey, 0, (strlen($licenseKey)-1));
        }   

		$this->_licenseKey = hash('sha256' , trim($licenseKey), true);
	}

	/**
	 * Set license file path. Put trailing slash here (my_path/)
	 *
	 * @param string $path
	 */
	public function setLicFilePath($path) {
		$this->_licFilePath = $path;
	}

	/**
	 * Generate the license code
	 *
	 * @return string
	 */
	public function generate() {
		return $this->_generate();
	}

	/**
	 * Accept license code
	 *
	 * @param string $licenseCode
	 * @return boolean
	 */
	public function acceptLicense($licenseCode) {

		$this->_licenseCode = $licenseCode;
		if($this->_validate()) {
			$this->_save();
			return true;
		}
		return false;
	}

	/**
	 * Check existing license code
	 *
	 * @return boolean
	 */
	public function check() {
		$this->_licenseCode = file_get_contents($this->_licFilePath . self::LICENSE_FILENAME);
		return $this->_validate();
	}

	/**
	 * Validate given license code
	 *
	 * @param string $licenseCode
	 * @return boolean
	 */
	private function _validate() {
	
	
		if($this->_licenseCode === $this->_generate()) {		
			return true;
		}
		return false;
	}

	/**
	 * Save the license code into file
	 * 
	 */
	private function _save() {
		file_put_contents($this->_licFilePath . self::LICENSE_FILENAME, $this->_licenseCode);
	}

	/**
	 * Generate license code using license key
	 *
	 * @return string
	 */
	private function _generate() {
		return trim(substr((md5(base64_encode($this->_licenseKey))), 2, 10));
	}

}

