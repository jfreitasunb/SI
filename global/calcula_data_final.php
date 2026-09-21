<?php
function gera_data_saida($dia, $mes, $ano, $periodo)
{
    // Cria um objeto de data seguro e nativo do PHP
    $data = new DateTime("$ano-$mes-$dia");

    // Adiciona o período correspondente utilizando as strings relativas do PHP
    switch ($periodo) {
        case "30 dias":
            $data->modify('+1 month'); // Baseado na sua lógica original de $mes+1
            break;
        case "35 anos":
            $data->modify('+35 years');
            break;
        case "2 anos":
            $data->modify('+2 years');
            break;
        case "4 anos":
            $data->modify('+4 years');
            break;
        case "5 anos":
            $data->modify('+5 years');
            break;
        case "06 meses":
            $data->modify('+6 months');
            break;
        case "1 ano":
            $data->modify('+1 year');
            break;
    }

    // Retorna formatado para banco de dados padrão (YYYY-MM-DD)
    return $data->format('Y-m-d');
}
?>