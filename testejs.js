console.log("Arquivo JS carregado");

function VerificaCpf(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    var cpf_recebido = document.getElementById('cpf').value;
    console.log("CPF Recebido: ", cpf_recebido); // Verificar o valor do input

    var cpf = cpf_recebido.slice(0, -2).split('').map(Number);
    var cpf_que_vale = cpf.slice(); // Clonar o array
    console.log("Array de CPF: ", cpf); // Deve aparecer no console

    var dv1 = DigitoVerificador(MultiplicaCadaNumPorPeso(cpf));
    cpf.push(dv1);
    var dv2 = DigitoVerificador(MultiplicaCadaNumPorPeso(cpf));
    cpf.push(dv2);
    console.log('cpf novo: ', cpf);

    // Transformar array de volta em string para comparação
    if (cpf.join('') === cpf_recebido) {
        var valido = true;
        var msg = "Este CPF é válido!";
    } else {
        valido = false;
        msg = "Este CPF é inválido!";
    }

    var veredicto = "<strong>Veredicto:</strong> " + msg;
    document.getElementById("veredicto").innerHTML = veredicto;

    if (valido === false) {
        var firstpart = cpf_que_vale.slice(0, 3);
        var secondpart = cpf_que_vale.slice(3, 6);
        var thirdpart = cpf_que_vale.slice(6);

        var primeiraparte = firstpart.join('');
        var segundaparte = secondpart.join('');
        var terceiraraparte = thirdpart.join('');

        cpf_que_vale = primeiraparte + "." + segundaparte + "." + terceiraraparte + "-" + dv1 + dv2;
        var obs = "Para este CPF ser válido, seus dois últimos dígitos devem ser: " + dv1 + dv2 + ", ficando assim: " + cpf_que_vale;
        console.log(obs);
        document.getElementById("obs").innerHTML = obs;
    }
}

function MultiplicaCadaNumPorPeso(vetor) {
    let soma = 0;
    if (vetor.length >= 10) {
        for (let i = 0; i < vetor.length; i++) {
            let multi = (i + 1) * vetor[i];
            soma += multi;
        }
        console.log("rodou o cod do dv2");
    } else {
        for (let i = 0; i < vetor.length; i++) {
            let multi = i * vetor[i];
            soma += multi;
        }
        console.log("rodou o cod do dv1");
    }
    return soma;
}

function DigitoVerificador(numero) {
    let dv = numero % 11;
    if (dv === 10) {
        dv = 0;
    }
    return dv;
}
