<?php

use xrs\exifData\exception\FileNotFoundException;

class ExifDataRead
{
    private $exifIfd0 = null;
    private $exifExif = null;

    private const MAKE = 'Make';
    private const MODEL = 'Model';
    private const EXPOSURE_TIME = 'ExposureTime';
    private const DATE_TIME = 'DateTime';
    private const ISO_SPEED_RATING = 'ISOSpeedRatings';
    private const COPYRIGHT = 'Copyright';
    private const FLASH = 'Flash';

    /**
     * ExifDataRead constructor.
     * @param string $imagePath
     * @throws FileNotFoundException
     */
    public function __construct(string $imagePath)
    {
        if(empty($imagePath) || !file_exists($imagePath))
        {
            throw new FileNotFoundException($imagePath);
        }

        $this->setExifIfd0($imagePath);
        $this->setExif($imagePath);
    }

    /**
     * @param string $imagePath
     */
    private function setExifIfd0(string $imagePath)
    {
        $this->exifIfd0 = exif_read_data($imagePath ,'IFD0' ,0);
    }

    /**
    * @return array
    */
    private function getExifIfd0(): ?array
    {
        return $this->exifIfd0;
    }

    /**
     * @param string $imagePath
     */
    private function setExif(string $imagePath)
    {
        $this->exifExif = exif_read_data($imagePath ,'EXIF' ,0);
    }

    /**
    * @return array
    */
    private function getExif(): ?array
    {
        return $this->exifExif;
    }

    /**
    * @return string
    */
    public function getMake(): string
    {
        if ($this->getExifIfd0() !== null && @array_key_exists(self::MAKE, $this->getExifIfd0())) {
          return $this->getExifIfd0()[self::MAKE];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getModel(): string
    {
        // Modello
        if ($this->getExifIfd0() !== null && @array_key_exists(self::MODEL, $this->getExifIfd0())) {
          return $this->getExifIfd0()[self::MODEL];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getExposureTime(): string
    {
        // Esposizione
        if ($this->getExifIfd0() !== null && @array_key_exists(self::EXPOSURE_TIME, $this->getExifIfd0())) {
          return $this->getExifIfd0()[self::getExposureTime()];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getApertureFNumber(): string
    {
        // Apertura
        if ($this->getExifIfd0() !== null && @array_key_exists('ApertureFNumber', $this->getExifIfd0()['COMPUTED'])) {
          return $this->getExifIfd0()['COMPUTED']['ApertureFNumber'];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getDateTime(): string
    {
        // Data
        if ($this->getExifIfd0() !== null && @array_key_exists(self::DATE_TIME, $this->getExifIfd0())) {
          return $this->getExifIfd0()[self::DATE_TIME];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getIso(): string
    {
        // ISO
        if ($this->getExif() !== null && @array_key_exists(self::ISO_SPEED_RATING,$this->getExif())) {
          return $this->getExif()[self::ISO_SPEED_RATING];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getCopyright(): string
    {
        // Copyright
        if($this->getExifIfd0() !== null && @array_key_exists(self::COPYRIGHT,$this->getExifIfd0())){
            return $this->getExifIfd0()[self::COPYRIGHT];
        }

        return '---';
    }

    /**
    * @return int
    */
    public function getFlash(): int
    {
        if($this->getExif() !== null && @array_key_exists(self::FLASH,$this->getExif())){
            return $this->getExif()[self::FLASH];
        }

        return '---';
    }
    /**
    * @return bool
    */
    public function getStatusFlash(): bool
    {
        $flash = $this->getFlash();

        return $flash === 0;
    }
}
