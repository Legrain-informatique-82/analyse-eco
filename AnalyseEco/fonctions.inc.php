<?php
//pour ajouter la balise
function simplexml_addChild($parent, $name, $value)
{
    $new_child = new SimpleXMLElement("<$name>$value</$name>");
    $node1 = dom_import_simplexml($parent);
    $dom_sxe = dom_import_simplexml($new_child);
    $node2 = $node1->ownerDocument->importNode($dom_sxe, true);
    $node1->appendChild($node2);
    return simplexml_import_dom($node2);
}

//pour ajouter la attribu

function simplexml_addAttribute($parent, $name, $value=''){
    $node1 = dom_import_simplexml($parent);
    $node1->setAttribute($name,$value);
    return simplexml_import_dom($node1);
}
?>