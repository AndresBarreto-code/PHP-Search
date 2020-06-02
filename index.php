<?php
    switch ($_POST['action']) {
        case 'mostrarTodos':
            mostrarTodo();
        break;
        case 'initFiltros':
            initFiltros();
        break;
        case 'filtro':
            filtro($_POST['filtro']);
        break;
        default:
            echo "otro";
        break;
    }

    function mostrarTodo(){
        $file = fopen("./data-1.json","r");
        $data = json_decode(fread($file,filesize("./data-1.json")));
        $httmlTemplate="";
        foreach($data as $clave => $valor){
            $httmlTemplate.=templateCard($valor);
        }
        echo $httmlTemplate; 
        fclose($file);
    }
    function initFiltros(){
        $file = fopen("./data-1.json","r");
        $data = json_decode(fread($file,filesize("./data-1.json")));
        $jsonResponce = new stdClass;
        $jsonResponce->ciudades= "";
        $jsonResponce->tipos= "";
        $ciudades=array();
        $tipos=array();
        foreach($data as $clave => $valor){
            if(!in_array($valor->Ciudad,$ciudades)){
                array_push($ciudades,$valor->Ciudad);
                $jsonResponce->ciudades.=templateOption($valor,'Ciudad');
            }
            if(!in_array($valor->Tipo,$tipos)){
                array_push($tipos,$valor->Tipo);
                $jsonResponce->tipos.=templateOption($valor,'Tipo');
            }
        }
        echo json_encode($jsonResponce);
        fclose($file);  
    }
    function filtro($filtro){
        $from=(double)$filtro["fromSlide"];
        $to=(double)$filtro["toSlide"];
        $file = fopen("./data-1.json","r");
        $data = json_decode(fread($file,filesize("./data-1.json")));
        $httmlTemplate="";
        foreach($data as $clave => $valor){
            $precio=(double)str_replace(['$',','],'',$valor->Precio);
            if(($from <= $precio) && ($precio <= $to)){
                if(!$filtro["city"]){
                    if(!$filtro["type"]){
                        $httmlTemplate.=templateCard($valor);
                    }elseif($filtro["type"]===$valor->Tipo){
                        $httmlTemplate.=templateCard($valor);
                    }
                }elseif($filtro["city"]===$valor->Ciudad){
                    if(!$filtro["type"]){
                        $httmlTemplate.=templateCard($valor);
                    }elseif($filtro["type"]===$valor->Tipo){
                        $httmlTemplate.=templateCard($valor);
                    }
                }
            }
        }
        echo $httmlTemplate; 
        fclose($file);
    }

    function templateCard($valor){
        return 
        '<div class="card horizontal">
            <div class="card-image">
                <img src="img/home.jpg" >
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <div>
                        <b>Direccion: </b><span>'.$valor->Direccion.'</span>
                    </div>
                    <div>
                        <b>Ciudad: </b><span>'.$valor->Ciudad.'</span>
                    </div>
                    <div>
                        <b>Telefono: </b><span>'.$valor->Telefono.'</span>
                    </div>
                    <div>
                        <b>Código postal: </b><span>'.$valor->Codigo_Postal.'</span>
                    </div>  
                    <div>
                        <b>Precio: </b><span class="precioTexto" id="precioTexto">'.$valor->Precio.'</span>
                    </div>
                    <div>
                        <b>Tipo: </b><span>'.$valor->Tipo.'</span>
                    </div>
                </div>
                <div class="card-action right-align">
                    <a href="#">Ver más</a>
                </div>
            </div>
        </div>';

    }
    
    function templateOption($valor,$Option){
        return '<option value="'.$valor->$Option.'">'.$valor->$Option.'</option>';
    }
    

?>