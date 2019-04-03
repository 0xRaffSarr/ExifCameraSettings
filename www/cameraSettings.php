<?php

/**
* Questa funzione determina le impostazione della macchina fotografica con cui la foto è stata realizzata.
* Restituisce un array associativo alle informazioni ricavate
*
* @param string
* @return array
*/


function cameraSettings($imagePath) {

    // verifica se il file è stato e se esse esiste prima di continuare
    if ((isset($imagePath)) and (file_exists($imagePath))) {

      // Inizializzo le due matrici contenenti le informazioni
      $exif_ifd0 = exif_read_data($imagePath ,'IFD0' ,0);
      $exif_exif = exif_read_data($imagePath ,'EXIF' ,0);

      //errore di controllo
      $notFound = "Unavailable";

      // Produttore
      if (@array_key_exists('Make', $exif_ifd0)) {
        $camMake = $exif_ifd0['Make'];
      } else { $camMake = $notFound; }

      // Modello
      if (@array_key_exists('Model', $exif_ifd0)) {
        $camModel = $exif_ifd0['Model'];
      } else { $camModel = $notFound; }

      // Esposizione
      if (@array_key_exists('ExposureTime', $exif_ifd0)) {
        $camExposure = $exif_ifd0['ExposureTime'];
      } else { $camExposure = $notFound; }

      // Apertura
      if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
        $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
      } else { $camAperture = $notFound; }

      // Data
      if (@array_key_exists('DateTime', $exif_ifd0)) {
        $camDate = $exif_ifd0['DateTime'];
      } else { $camDate = $notFound; }

      // ISO
      if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
        $camIso = $exif_exif['ISOSpeedRatings'];
      } else { $camIso = $notFound; }

      // Copyright
      if(@array_key_exists('Copyright',$exif_exif)){
          $phCopyright = $exif_exif['COMPUTED']['Copyright'];
      } else{ $phCopyright = $notFound; }

      //Flash
      if(@array_key_exists('Flash',$exif_exif)){
          if($exif_exif['Flash'] != 0 && $exif_exif['Flash'] != 16 && $exif_exif['Flash'] != 24 && $exif_exif['Flash'] != 32){
              $flash = 'Si';
          } else { $flash = 'No';}
      }
      else{ $flash = $notFound; }

      //array di ritorno
      $return = [];
      $return['make'] = $camMake;
      $return['model'] = $camModel;
      $return['exposure'] = $camExposure;
      $return['aperture'] = $camAperture;
      $return['date'] = $camDate;
      $return['iso'] = $camIso;
      $return['copyright'] = $phCopyright;
      $return['flash'] = $flash;
      return $return;

    } else {
      return false;
    }
}
?>


<?php
$x = cameraSettings('1.jpg');

echo $x['make']." <br> ".$x['model']." <br> ".$x['exposure']." <br> ".$x['aperture']." <br> ISO: ".$x['iso']." <br> Data: ".$x['date']." <br>Copyright: ".$x['copyright']." <br>Flash: ".$x['flash'];
?>