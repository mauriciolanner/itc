<?php
//recebe o post
$busca = strtoupper($_POST['arquivo_app']);
$codigocliente = $_POST['codigo_app'];

if($busca == null || $codigocliente == null){
    $retornoApp = array("ARQUIVO" => "FALTA_INFO");
    echo json_encode($retornoApp);
    //echo "FALTA_INFO";
    exit;
}

$retornoApp = null;
////busca todas as pastas
$diret = $codigocliente.'/';
$diretoriosPermitidos = array();

//verfica se o diretório solicitado existe
if(!is_dir ($diret)){
    $retornoApp = array("ARQUIVO" => "CODIGO_NAO_EXISTE");
    echo json_encode($retornoApp);
    exit;
}

//se existe pega todas as pastas dentro do diretorio
foreach (glob ($diret."*", GLOB_ONLYDIR) as $pastas) {
	if (is_dir ($pastas)) {
        $diretoriosPermitidos[] = str_replace ($diret,"",$pastas);
	}
}

$dir = new DirectoryIterator( $diret );
 
foreach($dir as $file)
{
    // verifica se $file é diferente de '.' ou '..'
    if (!$file->isDot())
    {
        // listando somente os diretórios
        if  ( $file->isDir() )
        {
            // atribui o nome do diretório a variável
            $dirName = $file->getFilename();
 
            // listando somente o diretório permitido
            if( in_array($dirName, $diretoriosPermitidos)) {
                // subdiretórios
                $caminho = $file->getPathname();
                // chamada da função de recursividade
                //simplesmente desisti de usar função, por algum motivo ela não retorna
                //$retorno = recursivo($caminho, $dirName, $busca);
                global $dirName;
 
                $DI = new DirectoryIterator( $caminho );
                foreach ($DI as $file){
                    if (!$file->isDot())
                    {
                        if  ( $file->isFile() )
                        {
                            //
                            $fileName = $file->getFilename();
                            //
                            $pattern = '/' . $busca . '/';
                            if(preg_match($pattern, $fileName)){
                                $retornoApp = array("ARQUIVO" => "http://itc.aquaload.com.br/".$caminho."/".$fileName);
                                //echo $retornoApp;
                            }
                        }
                    }
            
                }
                
                //fim
            }
        }
 
    }
}
if($retornoApp != null){
    echo json_encode($retornoApp);
}else{
    $retornoApp = array("ARQUIVO" => "ARQUIVO_NAO_EXISTE");
    echo json_encode($retornoApp);
}

/*
function recursivo( $caminho, $dirName, $busca ){
 
    global $dirName;
 
    $DI = new DirectoryIterator( $caminho );
 
    foreach ($DI as $file){
        if (!$file->isDot())
        {
            if  ( $file->isFile() )
            {
                //
                $fileName = $file->getFilename();
                //
                $pattern = '/' . $busca . '/';
                if(preg_match($pattern, $fileName)){
                    $retornoApp = $caminho."/".$fileName;
                    //echo $retornoApp;
                    return $retornoApp;
                }
            }
        }
 
    }
}

/*/////


?>