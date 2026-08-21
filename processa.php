<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["txtNome"];
    $valorCompra = floatval($_POST["txtValorCompra"]);
    $formaPagamento = $_POST["cmbPag"];
    $desconto = 0;
    $valorFinal = 0;

    // CORREÇÃO: cálculo correto para cada forma de pagamento
    if ($formaPagamento == "cartaoCredito") {
        $desconto = 0;
        $valorFinal = $valorCompra;
        $mensagem = "Olá $nome, sua compra de R$ " . number_format($valorCompra, 2, ',', '.') . 
                    " foi realizada com cartão de crédito. Não há desconto. Valor final: R$ " . 
                    number_format($valorFinal, 2, ',', '.');
    } elseif ($formaPagamento == "boleto") {
        $desconto = $valorCompra * 0.08; // CORREÇÃO: 8% para boleto
        $valorFinal = $valorCompra - $desconto;
        $mensagem = "Olá $nome, sua compra de R$ " . number_format($valorCompra, 2, ',', '.') . 
                    " foi realizada com boleto. Seu desconto é de R$ " . 
                    number_format($desconto, 2, ',', '.') . 
                    ". Valor final: R$ " . number_format($valorFinal, 2, ',', '.');
    } elseif ($formaPagamento == "deposito") {
        $desconto = $valorCompra * 0.10; // CORREÇÃO: 10% para depósito
        $valorFinal = $valorCompra - $desconto;
        $mensagem = "Olá $nome, sua compra de R$ " . number_format($valorCompra, 2, ',', '.') . 
                    " foi realizada com depósito. Seu desconto é de R$ " . 
                    number_format($desconto, 2, ',', '.') . 
                    ". Valor final: R$ " . number_format($valorFinal, 2, ',', '.');
    } else {
        $mensagem = "Forma de pagamento inválida.";
    }

    echo "<div class='w3-panel w3-green'>$mensagem</div>";
}
?>

<!--
COMENTÁRIO REFLEXIVO:
Nesta etapa, identifiquei e corrigi os erros de lógica no cálculo dos descontos:
- O boleto estava com 10% (deveria ser 8%)
- O depósito estava com 8% (deveria ser 10%)

Também corrigi a exibição das mensagens:
- Adicionei o valor final após o desconto
- Usei number_format() para formatar os valores com 2 casas decimais no padrão brasileiro (R$ 1.234,56)
- Converti o valor da compra para float com floatval() para garantir cálculos corretos

A lógica segue:
1. Recebe os dados do formulário via POST
2. Identifica a forma de pagamento
3. Calcula o desconto correto conforme a regra
4. Calcula o valor final (valor - desconto)
5. Exibe mensagem formatada com todos os valores

Testei mentalmente cada cenário:
- Cartão: sem desconto, valor final = valor original
- Boleto: 8% de desconto
- Depósito: 10% de desconto
-->