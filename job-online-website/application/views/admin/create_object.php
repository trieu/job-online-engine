<?php
   // $object_class = new ObjectClass();
    echo $object_class->getObjectClassName()." - ";
    foreach ($object_class->getUsableProcesses() as $pro) {
        echo $pro->getProcessName().br(2);
        break;
    }

?>


<?php
    if(isset ($objectCacheHTML)) {
       echo html_entity_decode($objectCacheHTML['cacheContent']);
    }
?>

<input type="submit" value="OK" />
<input type="button" value="Cancel" />