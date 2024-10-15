<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Verificador de CPF</title>
    </head>
    <body>
        <nav>
            <a href="index.html"><img src="img/casa1.png" class="icone"> Início</a>
            <a href="verifica-cpf.php" class="ativo"><img src="img/php-logo1.png" class="icone"> Verificador de CPF em PHP</a>
            <a href="verifica-cpf.html"><img src="img/js-logo1.png" class="icone"> Verificador de CPF em JavaScript</a>
            <a href="comofunciona.html"><img src="img/faq.png" class="icone"> Como é feita a Verificação?</a>
        </nav>

        <div class="site">
            <div class="conteudo">
                <h1>Verificador de CPF</h1>
                <form id="form-cpf" action="">
                    <label for="cpf">Digite o CPF a ser verificado: </label>
                    <input id="cpf" name="cpf" type="text" minlength="11" maxlength="11" pattern="\d*" placeholder="Apenas números" required>
                    <br>
                    <div class="alinha-btn">
                        <input type="submit" value="Verificar">
                    </div>
                </form>

                <?php
                    function MultiplicaCadaNumPorPeso($vetor){
                        //essa função recebe o cpf(sem dv) e multiplica cada dígito dele pelo peso
                        //retorna a soma dessas multiplicações
                        $soma = 0;
                        if (count($vetor) >= 10) { //verifica se o dv a ser encontrado é o 2º, se for ele roda esse código
                            //multiplica dada dígito pelo seu peso
                            for ($i=0; $i < count($vetor); $i++) {
                                $multi = $i * $vetor[$i];
                                $soma = $soma + $multi;
                            }
                        }else{
                            //multiplica dada dígito pelo seu peso
                            for ($i=0; $i < count($vetor); $i++) {
                                $multi = ($i + 1) * $vetor[$i];
                                $soma = $soma + $multi;
                            }
                        }
                        return $soma;
                    }
                    function MultiplicaCadaNumPorPeso2($vetor){
                        //essa função recebe o cpf(sem dv) e multiplica cada dígito dele pelo peso
                        //retorna a soma dessas multiplicações
                        $soma = 0;
                        //multiplica dada dígito pelo seu peso
                        for ($i=0; $i < count($vetor); $i++) { 
                            $multi = $i * $vetor[$i];
                            $soma = $soma + $multi;
                        }
                        return $soma;
                    }
                
                    function DigitoVerificador($numero){
                        //captura o resto da divisão da soma das multiplicações de cada dígito do cpf pelo seu peso
                        $dv = $numero % 11;
                        if ($dv == 10) {
                            $dv = 0;
                        }
                        return $dv;
                    }
                    // se existir um valor em um campo cpf sendo enviado por get
                    if (isset($_GET['cpf'])) {
                        $cpf_recebido = $_GET['cpf'];
                        // função substr está removendo os dois últimos caracteres 
                        $cpf = substr($cpf_recebido, 0, -2);
                        // função str_split está dividindo a string em um array de caracteres
                        $cpf = str_split($cpf);

                    //variavel cpf que vale foi criada para que possamos sugerir os dvs corretos caso o cpf seja inválido
                        $cpf_que_vale = $cpf;

                ////////////   ENCONTRANDO O 1º DÍGITO VERIFICADOR   ////////////////

                        ////multiplica dada dígito pelo seu peso        
                        $resultado = MultiplicaCadaNumPorPeso($cpf);
                    
                        //captura o resto da divisão por 11
                        $dv1 = DigitoVerificador($resultado);
                    
                        //echo "<br>Primeiro dígito verificador = ".$dv1."<br>";
                    
                        // Adiciona o 1º digito verificador ao final do array
                        array_push($cpf, $dv1);
                        //print_r($cpf); // Exibe o array atualizado
                    
                ////////////   ENCONTRANDO O 2º DÍGITO VERIFICADOR   ////////////////
                    
                        //multiplica dada dígito pelo seu peso     
                        $resultado = MultiplicaCadaNumPorPeso($cpf);
                    
                        //captura o resto da divisão por 11
                        $dv2 = DigitoVerificador($resultado);
                    
                        //As 2 linhas de código a cima também podem ser escritas assim:
                        //$dv2 = DigitoVerificador(MultiplicaCadaNumPorPeso($cpf));
                    
                        //echo "<br>Segundo dígito verificador = ".$dv2."<br>";
                    
                        // Adiciona o 2º digito verificador ao final do array
                        array_push($cpf, $dv2); 
                        //print_r($cpf); // Exibe o array atualizado
                    
                        //implode("separador", Array a ser transformado em string) = transforma array em string
                        $cpf = implode("", $cpf); // Sem separador
                    
                //////////    verificando se o $cpf_recebido é valido     ////////////////
                        if ($cpf == $cpf_recebido) {
                            $valido = true;
                            $msg = "Este CPF é válido!";
                        }
                        else{
                            $valido = false;
                            $msg = "Este CPF é inválido!";
                        }
                        echo "<p><strong>Veredicto:</strong> ".$msg."</p>";
                    
                        if ($valido === false) {
                            $firstpart = array_slice($cpf_que_vale, 0, 3);
                            $secondpart = array_slice($cpf_que_vale, 3, 3);
                            $thirdpart = array_slice($cpf_que_vale, 6, 3);

                            $primeiraparte = implode("", $firstpart);
                            $segundaparte = implode("", $secondpart);
                            $terceiraraparte = implode("", $thirdpart);
                            
                            $cpf_que_vale = implode("", $cpf_que_vale);

                            $cpf_que_vale = $primeiraparte.".".$segundaparte.".".$terceiraraparte."-".$dv1.$dv2;
                            echo "<p class='obs'>Para este cpf ser válido, seus dois últimos dígitos devem ser: ".$dv1.$dv2.", ficando assim: ".$cpf_que_vale."</p>";
                        }                
                    }else{
                        echo "<p>Você precisa digitar algo!</p>";
                    }
                ?>
            </div>
        </div>
        
        <footer>
        <h2>Considerações Importantes: </h2>
            <p>É importante atentar-se que este site verifica se o CPF é válido a partir da lógica de <strong>verificação matemática</strong></p>
            <p>CPFs com números repetidos ou sequências óbvias, mesmo que validados pela verificação matemática, não são considerados válidos pela 
                Receita Federal e não são atribuídos a pessoas reais, justamente para evitar fraudes.</p>
            <p>A versão em PHP não funciona fora de um servidor que dê suporte a essa tecnologia (e o netlify não suporta PHP).</p>
        </footer>     
    </body>
</html>
















