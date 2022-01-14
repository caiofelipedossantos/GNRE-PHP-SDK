<?php

namespace GuiasGNRE;

use Exception;
use stdClass;

class GuiasGNRE
{

    private $crendentials;

    private const HOST = "//guiasgnre.com.br/webgnre/geraguiagnre.wso?WSDL";

    public function __construct($empresa, $usuario, $token)
    {
        $this->crendentials = array(
            'sEmpresa'  => $empresa,
            'sUsuario'  => $usuario,
            'sChaveApi' => $token,
        );
    }

    /**
     * Efetua a emissão da guia e retorna um XML.
     *
     * @param array $data
     * @return array
     */
    public function gerarGuia(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'GeraGuia', $data);
    }

    /**
     * Efetua a emissão da guiae retorna o pack dos bytes do PDF a ser montado.
     *
     * @param array $data
     * @return array
     */
    public function gerarGuiaPDF(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'GeraGuiaPDF', $data);
    }

    /**
     * Efetua a busca das guias pendentes de acordo com o filtro enviado.
     *
     * @param array $data
     * @return array
     */
    public function buscaGuiasPendentes(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaGuiasPendentes', $data);
    }

    /**
     * Efetua a busca de todas as guias pendentes
     *
     * @param array $data
     * @return array
     */
    public function buscaTodasGuiasPendentes(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaTodasGuiasPendentes', $data);
    }

    /**
     * Efetua a busca de todas as guias com erro
     *
     * @param array $data
     * @return array
     */
    public function buscaTodasGuiasComErro(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaTodasGuiasComErro', $data);
    }

    /**
     * Efetua a busca de todas as guias autoriadas
     *
     * @param array $data
     * @return array
     */
    public function buscaTodasGuiasAutorizadas(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaTodasGuiasAutorizadas', $data);
    }

    /**
     * Efetua a busca de uma guia
     *
     * @param array $data
     * @return array
     */
    public function buscaGuia(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaGuia', $data);
    }

    /**
     * Efetua a busca do PDF da guia já autorizada.
     *
     * @param array $data
     * @return void
     */
    public function buscaGuiaPDF(array $data)
    {
        $data = array_merge($data, $this->crendentials);
        return $this->connectGuiasGnre(self::HOST, 'BuscaGuiaPDF', $data);
    }


    /**
     * Efetua a criação do arquivo de acordo com os bytes recebidos pelo webservice.
     *
     * @param array $unsignedByte
     * @param string $target
     * @param string|null $file_name
     * @return array
     */
    public function generatePDF(array $unsignedByte, string $target = "/", string $file_name = null)
    {
        try {
            // Efetua o empacotamento dos bytes
            $pdf_pack = pack("C*", ...$unsignedByte);

            if (substr($target, -1) == "/" || substr($target, -1) == "") {
                $target = "";
            } else {
                $target .= "/";
            }

            // Verifica se o caminho desejado existe
            if ($target != "/" && !file_exists($target)) {
                umask(0);
                mkdir($target, 0777, true);
            }

            // Verifica se foi enviado um nome
            if (empty($file_name)) {
                $file_name = md5(time());
            }

            if (file_put_contents($target . $file_name . ".pdf", $pdf_pack)) {
                $success = new StdClass;
                $success->status = true;
                $success->message = 'PDF Gerado com sucesso!';
                return json_decode(json_encode($success), true);
            } else {
                $error = new StdClass;
                $error->status = false;
                $error->message = 'Erro ao gerar PDF. Verifique junto ao programador e a sua hospedagem.';
                $error->error = error_get_last();
                return json_decode(json_encode($error), true);
            }
        } catch (Exception $ex) {
            $error = new StdClass;
            $error->status = false;
            $error->message = 'Erro ao gerar PDF. Verifique junto ao programador e a sua hospedagem.';
            $error->error = $ex->getMessage();
            return json_decode(json_encode($error), true);
        }
    }

    /**
     * Efetua a conexão com o webservice e processa a requisição desejada.
     *
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return array
     */
    private function connectGuiasGnre($endpoint, $method, array $data)
    {
        try {
            // Verifica se o SoapClient existis
            if (!extension_loaded("soap")) {
                $error = new StdClass;
                $error->error = 'SoapClient não localizado! Não é possível obter conexão na API da Guias GNRE. Verifique junto ao programador e a sua hospedagem. (PHP: ' . phpversion() . ')';

                return json_decode(json_encode($error), true);
            }

            $soapClient = new \SoapClient($endpoint, [
                'exceptions' => true
            ]);

            return json_decode(json_encode($soapClient->{$method}($data)), true);
        } catch (Exception $ex) {
            $error = new StdClass;
            $error->message = 'Erro ao processar a requisição. Verifique junto ao programador e a sua hospedagem.';
            $error->error = $ex->getMessage();
            return json_decode(json_encode($error), true);
        }
    }
}
