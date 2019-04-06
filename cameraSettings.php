<?php

/**
* Questa classe determina le impostazione della macchina fotografica con cui la foto è stata realizzata.
*/

class ExifDataRead
{
    private $exifIfd0 = null;
    private $exifExif = null;

    public function __construct(string $imagePath)
    {
        if(empty($imagePath) || !file_exists($imagePath))
        {
            exit ('File non trovato');
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
        // Produttore
        if ($this->getExifIfd0() !== null && @array_key_exists('Make', $this->getExifIfd0())) {
          return $this->getExifIfd0()['Make'];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getModel(): string
    {
        // Modello
        if ($this->getExifIfd0() !== null && @array_key_exists('Model', $this->getExifIfd0())) {
          return $this->getExifIfd0()['Model'];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getExposureTime(): string
    {
        // Esposizione
        if ($this->getExifIfd0() !== null && @array_key_exists('ExposureTime', $this->getExifIfd0())) {
          return $this->getExifIfd0()['ExposureTime'];
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
        if ($this->getExifIfd0() !== null && @array_key_exists('DateTime', $this->getExifIfd0())) {
          return $this->getExifIfd0()['DateTime'];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getIso(): string
    {
        // ISO
        if ($this->getExif() !== null && @array_key_exists('ISOSpeedRatings',$this->getExif())) {
          return $this->getExif()['ISOSpeedRatings'];
        }

        return '---';
    }

    /**
    * @return string
    */
    public function getCopyright(): string
    {
        // Copyright
        if($this->getExifIfd0() !== null && @array_key_exists('Copyright',$this->getExifIfd0())){
            return $this->getExifIfd0()['Copyright'];
        }

        return '---';
    }

    /**
    * @return int
    */
    public function getFlash(): int
    {
        if($this->getExif() !== null && @array_key_exists('Flash',$this->getExif())){
            return $this->getExif()['Flash'];
        }

        return '---';
    }
    /**
    * @return string
    */
    public function getStatusFlash(): string
    {
        $flash = $this->getFlash();

        if($flash === 0){
            return 'Si';
        }

        return 'No';
    }
}
