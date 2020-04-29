
<?php  function isValid($date, $format = 'd/m/Y'){
    $dt = DateTime::createFromFormat($format, $date);
    return $dt && $dt->format($format) === $date;
  }
  ?>