<?php
    switch ($_POST['action']) {
        case 'mostrarTodos':
            mostrarTodo();
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
    

?>