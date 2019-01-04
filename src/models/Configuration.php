<?php

namespace SlothCMS\Models;

/**
 * Class Configuration holds information about SlothCMS's configuration
 *
 *
 * @package SlothCMS\Models
 */
class Configuration {

    private $siteName;
    private $siteSubtitle;
    private $timezone;
    private $timeDateFormat;
    private $mainLanguage;
    private $otherLanguages;
    private $currentTheme;

    /**
     * Configuration constructor.
     * @param $siteName
     * @param $siteSubtitle
     * @param $timezone
     * @param $timeDateFormat
     * @param $mainLanguage
     * @param $otherLanguages
     * @param $currentTheme
     */
    public function __construct($siteName, $siteSubtitle, $timezone, $timeDateFormat, $mainLanguage, $otherLanguages, $currentTheme)
    {
        $this->siteName = $siteName;
        $this->siteSubtitle = $siteSubtitle;
        $this->timezone = $timezone;
        $this->timeDateFormat = $timeDateFormat;
        $this->mainLanguage = $mainLanguage;
        $this->otherLanguages = $otherLanguages;
        $this->currentTheme = $currentTheme;
    }


    /**
     * Generates JSON string from fields in this class
     *
     * @return false|string
     */
    public function toJson() {
        return json_encode(get_object_vars($this));
    }

    /**
     * @return mixed
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * @param mixed $siteName
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;
    }

    /**
     * @return mixed
     */
    public function getSiteSubtitle()
    {
        return $this->siteSubtitle;
    }

    /**
     * @param mixed $siteSubtitle
     */
    public function setSiteSubtitle($siteSubtitle)
    {
        $this->siteSubtitle = $siteSubtitle;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return mixed
     */
    public function getTimeDateFormat()
    {
        return $this->timeDateFormat;
    }

    /**
     * @param mixed $timeDateFormat
     */
    public function setTimeDateFormat($timeDateFormat)
    {
        $this->timeDateFormat = $timeDateFormat;
    }

    /**
     * @return mixed
     */
    public function getMainLanguage()
    {
        return $this->mainLanguage;
    }

    /**
     * @param mixed $mainLanguage
     */
    public function setMainLanguage($mainLanguage)
    {
        $this->mainLanguage = $mainLanguage;
    }

    /**
     * @return mixed
     */
    public function getOtherLanguages()
    {
        return $this->otherLanguages;
    }

    /**
     * @param mixed $otherLanguages
     */
    public function setOtherLanguages($otherLanguages)
    {
        $this->otherLanguages = $otherLanguages;
    }

    /**
     * @return mixed
     */
    public function getCurrentTheme()
    {
        return $this->currentTheme;
    }

    /**
     * @param mixed $currentTheme
     */
    public function setCurrentTheme($currentTheme)
    {
        $this->currentTheme = $currentTheme;
    }


}