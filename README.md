# Guias GNRE PHP SDK

Caro desenvolvedor, conheça a nossa API e integre seu sistema de Gestão Empresarial para automatização das emissões das GNREs. O portal GuiasGNRE.com.br oferece a possibilidade de gerar suas guias de recolhimento de tributos estaduais para todos os Estados que disponibilizaram portais para emissão e validação das guias. Através do portal GuiasGNRE.com.br você gera em um só lugar suas guias DIFAL, FCOP e ICMS ST de forma rápida, e prática, através das informações contidas nos XML’s de suas notas fiscais

- Documentação API SOAP: [Visualizar](https://guiasgnre.com.br/integracao.html)

## Requisitos

- Contrate um dos planos da GuiasGNRE a partir de R$45,90/mês: [Teste 14 dias grátis!](https://guiasgnre.com.br/index.html#content4-k).
- Instale o [Composer](https://getcomposer.org/)
- Instale a extensão SOAP do PHP em seu servidor ou ativeo.
- Realize a integração com o seu sistema.

## Endpoints

A SDK está disponível para todos os recursos da versão **1.0.0** da API de emissão.

- Gerar Guia
- Gerar Guia PDF
- Buscar Guias Pendentes
- Buscar Todas as Guias Pendentes
- Buscar Todas as Guias Com Erro
- Busca Todas as Guias Autorizadas
- Busca Guia
- Busca Guia PDF
- Gerar Arquivo PDF Fisico

## Utilização
Instale o módulo da GuiasGNRE via composer ou baixe nosso repositório e utilize a classe GuiasGNRE.php que se encontra dentro de src/GuiasGNRE/:

```php
composer require caiofelipe/guiasgnre
```

Após executar o composer, adicione o require no topo do seu arquivo. Caso tenha baixado manualmente, importe o arquivo GuiasGNRE.php diretamente na sua aplicação:

```php
require_once __DIR__ . '/vendor/autoload.php';
use GuiasGNRE\GuiasGNRE;
```

Caso esteja usando algum framework, como por exemplo o Laravel, instale o módulo da GuiasGNRE via composer e referencie o seguinte namespace em seu controller:

```php
use GuiasGNRE\GuiasGNRE;
```

Dessa forma, a classe GuiasGNRE já pode ser instanciada e utilizada conforme a sua necessidade!
Informe as suas credenciais de acesso diretamente no método construtor da classe:

```php
$this->guiasgnre = new GuiasGNRE('CNPJ_EMPRESA', 'EMAIL_USUARIO', 'TOKEN');
```

E pronto, sua plataforma já está pronta para se comunicar com a API da GuiasGNRE.
Para emitir uma guia por exemplo, deve ser utilizado o método ``` emissaoNotaFiscal( $data ) ```:

```php

$data = array(
    'ListaNfe' => array(
        'itens' => array(
            // Produtos da NF-e
            'tDadosNfe' => array(
                'emitente' => 'string', // CNPJ do Emitente (Deve ser o mesmo da assinatura)
                'serie' => 'string', // Número de série da NF
                'modelo' => 'string', // Modelo da NF
                'num_nota_fiscal' => 'decimal', // Número da NF
                'tipo_documento' => 'string', // Tipo de Documento
                'chave_nfe' => 'string', // Número de chave da NF
                'convenio' => 'string', // Convenio
                'data_emissao' => 'string', // Data de emissão da NFE - YYYY-MM-DD
                'produto' => 'string', //
                'vencimento' => '2022-01-14', // Data de vencimento da NFE - YYYY-MM-DD
                'valor' => 'decimal', // Valor do produto
                'icms_uf_destino' => 'decimal', // Valor do ICMS do estado de destino
                'fcp_uf_destino' => 'decimal', // Valor do FCP do estado de destino
                'cpf' => 'string', // CPF do destinatario
                'cnpj' => 'string', // CNPJ do destinatario
                'nome_destinatario' => 'string', // Nome do destinatario
                'municipio_destinatario' => 'string', // Municipio do destinatario
                'cod_municipio_destinat' => 'string', // Código do municipio
                'uf_destinatario' => 'string', // Estado do municipio
                'data_recepcao' => 'string', // Data de entrega
                'icms_st' => 'decimal', //
                'IE' => 'string', // Inscriçao estadual
            )
        ),
    )
);

$response = $this->guiasgnre->gerarGuia( $data );

print_r($response);

```

## Suporte

Qualquer dúvida acesse a página de integração [Central de Ajuda](https://guiasgnre.com.br/integracao.html) ou acesse o [Site](https://guiasgnre.com.br/) para conversar em tempo real no Chat.

## Atenção

Este SDK não foi desenvolvido de forma oficial pela GuiasGNRE, apenas consumimos sua API SOAP a fim de facilitar a integração com outros sistemas.