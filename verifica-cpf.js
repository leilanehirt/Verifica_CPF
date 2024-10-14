console.log("Arquivo JS carregado");

function VerificaCpf(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    var cpf_recebido = document.getElementById('cpf').value;

    console.log("CPF Recebido: ", cpf_recebido); // Verificar o valor do input
    
    var cpf = cpf_recebido;
    cpf = cpf.slice(0, -2); // A partir do índice 0, remova até o índice -2
    cpf = cpf.split('').map(Number);

    //variavel cpf que vale foi criada para que possamos sugerir os dvs corretos caso o cpf seja inválido
    var cpf_que_vale = cpf

    console.log("Array de CPF: ", cpf); // Deve aparecer no console

    var dv1 = DigitoVerificador(MultiplicaCadaNumPorPeso(cpf));

    cpf.push(dv1);

    var dv2 = DigitoVerificador(MultiplicaCadaNumPorPeso(cpf));

    cpf.push(dv2);

    console.log('cpf novo: ', cpf);

    cpf = cpf.join('');

    console.log(cpf);

    //////////    verificando se o cpf_recebido é valido     ////////////////
    if (cpf == cpf_recebido) {
        var valido = true;
        var msg = "Este CPF é válido!";
    }
    else{
        valido = false;
        msg = "Este CPF é inválido!";
    }
    var veredicto = "<strong>Veredicto:</strong> "+msg;
    console.log(veredicto);

    document.getElementById("veredicto").innerHTML = veredicto;

    if (valido === false) {
        var firstpart = cpf_que_vale.slice(0, 3);
        var secondpart = cpf_que_vale.slice(3, 6);
        var thirdpart = cpf_que_vale.slice(6, 9);
        
        var primeiraparte = firstpart.join('');
        var segundaparte = secondpart.join('');
        var terceiraraparte = thirdpart.join('');
        
        cpf_que_vale = cpf_que_vale.join('');
        cpf_que_vale = primeiraparte+"."+segundaparte+"."+terceiraraparte+"-"+dv1+dv2;
        var obs = "Para este cpf ser válido, seus dois últimos dígitos devem ser: "+dv1+dv2+", ficando assim: "+cpf_que_vale;
        console.log(obs);
        document.getElementById("obs").innerHTML = obs;
    } 
}

function MultiplicaCadaNumPorPeso(vetor){
    //essa função recebe o cpf(sem dv) e multiplica cada dígito dele pelo peso
    //retorna a soma dessas multiplicações
    let soma = 0;
    if (vetor.length >= 10) { //verifica se o dv a ser encontrado é o 2º, se for ele roda esse código
        //multiplica dada dígito pelo seu peso
        for (let i=0; i < vetor.length; i++) {
            let multi = i * vetor[i];
            soma = soma + multi;
        }
        console.log("rodou o cod do dv2");
    }
    else{
        //multiplica dada dígito pelo seu peso
        for (let i=0; i < vetor.length; i++) {
            let multi = (i + 1) * vetor[i];
            soma = soma + multi;
        }
        console.log("rodou o cod do dv1");
    }
    return soma;
}

function DigitoVerificador(numero){
    //captura o resto da divisão da soma das multiplicações de cada dígito do cpf pelo seu peso
    let dv = numero % 11;
    if (dv == 10) {
        dv = 0;
    }
    return dv;
}