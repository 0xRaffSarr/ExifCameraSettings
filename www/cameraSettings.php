<?php

/**
* Questa funzione determina le impostazione della macchina fotografica con cui la foto è stata realizzata.
* Restituisce un array associativo alle informazioni ricavate
*
* @param string
* @return array
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

    public function getModel(): string
    {
        // Modello
        if ($this->getExifIfd0() !== null && @array_key_exists('Model', $this->getExifIfd0())) {
          return $this->getExifIfd0()['Model'];
        }

        return '---';
    }

}
