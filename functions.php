
<?php

/**
 * options all, f, d
 *
 */


/**
 *  Contenido directo en src
 */

function listarContenidoNombresDirecto($src, $opt = 'all'){

    $resultado = [];

    foreach (new DirectoryIterator($src) as $fileInfo) {
        //Es . o .. saltamos
        if($fileInfo->isDot()) continue;
        // Imprimir nombre
        // carpetas en negrita
        if ($fileInfo->isDir()){
            if($opt === 'f') continue;
             $resultado[] = $fileInfo->getFilename();
        }else{
            // archivos normal
            if($opt === 'd') continue;
            $resultado[] = $fileInfo->getFilename();
        }

    }
    return $resultado;
}



function listarContenidoRelativoDirecto($src, $opt = 'all'){

    $resultado = [];

    foreach (new DirectoryIterator($src) as $fileInfo) {
        //Es . o .. saltamos
        if($fileInfo->isDot()) continue;
        // Imprimir nombre
        // carpetas en negrita
        if ($fileInfo->isDir()){
            if($opt === 'f') continue;
            $resultado[] = $fileInfo->getPathname();
        }else{
            // archivos normal
            if($opt === 'd') continue;
            $resultado[] = $fileInfo->getPathname();
        }

    }
    return $resultado;
}




function listarPathDirecto($src, $opt = 'all'){

    $resultado = [];

    foreach (new DirectoryIterator($src) as $fileInfo) {
        //Es . o .. saltamos
        if($fileInfo->isDot()) continue;
        // Imprimir noPath
        // carpetas en negrita
        if ($fileInfo->isDir()){
            if($opt === 'f') continue;
            $resultado[] =  realpath($fileInfo->getPathname());
        }else{
            // archivos normal
            if($opt === 'd') continue;
            $resultado[] = realpath($fileInfo->getPathname());
        }

    }
    return $resultado;
}

/**
 *  Retornar un array de todas las carpetas de una carpeta
 *  Type:
 *
 *  a -> muestra todo (Default)
 *  d -> muestra solo carpetas
 *  f -> muestra solo archivos
 *
 *  empty -> muestra vacios (Default)
 *  false -> oculta carpetas vacias
 *

 */

function is_dir_empty($dir){
    $scan = scandir($dir);
    if (count($scan) > 2){
        return false;
    }else{
        return true;
    }
}


function getRelContents($dir, $type = 'a', $empty = true, &$results = [])
{

    $final = glob($dir, GLOB_ONLYDIR);

    return $final;


}


function getDirContents($dir, $type = 'a', $empty = true, &$results = [])
{
    $files = scandir($dir);

    $f = [];
    $d = [];
    $anoe = [];


    foreach ($files as $key => $value) {
         $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        //$path = $dir . DIRECTORY_SEPARATOR . $value;
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, 'a', true, $results);
            $results[] = $path;
        }
    }

    $all = str_replace('\\', '/', $results);;


    /**
     *  MOSTRAMOS TODO SALVO CARPETAS VACIAS
     *
     */


    if ($type == "a" && !$empty) {
        foreach ($all as $el) {
            if (is_dir($el)) {
                $sub = count(scandir($el));
                if ($sub > 2) {
                    $anoe[] = $el;
                } else {
                    continue;
                }
            } else {
                $anoe[] = $el;
            }

        }
        return $anoe;
    }

    /**
     *  FILTRAMOS MOSTRAR SOLO CARPETAS y opcional no vacias
     */

    if ($type == 'd') {
        foreach ($all as $el) {
            if (!is_dir($el)) continue;

            if (!$empty) {
                $sub = count(scandir($el));
                if ($sub > 2) {
                    $d[] = $el;
                } else {
                    continue;
                }
            }
            $d[] = $el;


        }

        return array_unique($d);
    }

    /**
     *  FILTRAMOS MOSTRAR archivos
     */

    if ($type == 'f') {
        foreach ($all as $el) {
            if (is_dir($el)) continue;
            $f[] = $el;
        }
        return array_unique($f);
    }


    return array_unique($all);


}


    function copiarCarpetas($src, $dest = '/'){

        $listado = getRelContents($src, 'd');


    }


function copiar($src, $dest, $opt = 'a'){

    $origen_path = dirname(realpath($src));
    $destino_path = realpath($dest);

    if(!file_exists($dest)) mkdir($dest, 0755);

    $o = getDirContents($src, 'a');


    $destDirNames = [];


    foreach($o as $oitem){

        $destcarpeta = explode('/', $oitem);
        $firstword = $destcarpeta[0];
        $new = str_replace($firstword, $dest, $oitem);
        $destDirNames[] = $new;
        if(is_dir($oitem) && !file_exists($oitem)) mkdir($new, 0755);
    }

//    print_r($o);
//    echo "<hr>";
//    print_r($destDirNames);
   // print_r($destDirNames);

// CREACIÓN DE LOS ARCHIVOS COPIAS

    for($i = 0; $i < count($o); ++$i ){
        if(is_dir($o[$i])) continue;
        copy($o[$i], $destDirNames[$i]);
    }

 //   $orutas = getDirContents($src, 'f');


    return true;
}






//function contenidob();
