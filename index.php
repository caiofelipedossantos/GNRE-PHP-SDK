<?php

use GuiasGNRE\GuiasGNRE;

require_once 'vendor/autoload.php';

$guias = new GuiasGNRE('03685405000107', 'sady@digidata.com.br', 'K09RcnJHQV11MEl3K3JlXTAzNjg1NDA1MDAwMTA3');

$data = array(
    'ListaNfe' => array(
        'itens' => array(
            'tDadosNfe' => array(
                'emitente' => '03685405000107', // emit > CNPJ
                'serie' => '004', // serie
                'modelo' => '55', //mod
                'num_nota_fiscal' => '233', //nNF
                'tipo_documento' => '10', // tpNF
                'chave_nfe' => '35211203685405000107550040000002331128692464', // protNFe > infProt > chNFe
                'convenio' => '',
                'data_emissao' => '2021-12-01', // dhEmi
                'produto' => '5',
                'vencimento' => '2022-01-14',
                'valor' => '7.19',
                'icms_uf_destino' => 'PR',
                'fcp_uf_destino' => '',
                'cpf' => '10405576943',
                'cnpj' => '',
                'nome_destinatario' => 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL',
                'municipio_destinatario' => 'COLOMBO',
                'cod_municipio_destinat' => '05805',
                'uf_destinatario' => 'PR',
                'data_recepcao' => '',
                'icms_st' => '',
                'IE' => '',
            )
        ),
    )
);

/*$data = array(
    'Lote' => array(
        'retorno' => '',
        'msg_retorno' => '',
        'lote' => '4',
        'recibos' => array(
            'tReciboNota' => array(
                'emitente' => '03685405000107',
                'num_nota_fiscal' => '233',
                'modelo' => '55',
                'serie' => '004',
                'emissao_nf' => '2021-12-01',
                'receita' => '100102',
                'status' => '3',
                'recibo' => '2201958394',
                'data_recibo' => '2022-01-14 11:15:53'
            )
        )
    )
);
*/

//print_r($guias->connectGuiasGnre('https://guiasgnre.com.br/webgnre/geraguiagnre.wso?WSDL', 'BuscaTodasGuiasAutorizadas', $data));
echo "<pre>";
$result = $guias->gerarGuia($data);
print_r($result);

//$pdf_str = $result['BuscaGuiaPDFResult']['pdf_guias']['tPdfGuias']['pdf']['unsignedByte'];
//print_r($guias->generatePDF($pdf_str, "/", "2201958394"));
