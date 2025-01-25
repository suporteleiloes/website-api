<?php

namespace Suporteleiloes\WebsiteApi;

use Suporteleiloes\WebsiteApi\Traits\HttpTrait;

class ApiService
{
    private $apiUrl;
    private $apiClient;
    private $apiKey;

    use HttpTrait;

    public function __construct($apiUrl = null, $apiClient = null, $apiKey = null)
    {
        $this->apiUrl = $apiUrl;
        $this->apiClient = $apiClient;
        $this->apiKey = $apiKey;
    }

    private function parseParams($options, $page, $limit) {
        $defaultParams = [
            'page' => $page,
            'limit' => $limit,
        ];

        // Combina os parâmetros padrão com os fornecidos em $options
        $params = array_merge($defaultParams, $options);

        // Converte os parâmetros para a string de query
        return http_build_query($params);
    }

    public function listLeiloes($options = [], $page = 1, $limit = 100) {

        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/leiloes?' . $queryString);
    }

    public function loadLeilao($id) {
        return $this->callApi('get', '/api/public/leiloes/' . $id);
    }

    public function listLotes($leilaoId = null, $options = [], $page = 1, $limit = 100) {
        if (!empty($leilaoId)) {
            $options['leilao'] = $leilaoId;
        }
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/lotes?' . $queryString);
    }

    public function loadLote($id) {
        return $this->callApi('get', '/api/public/lotes/' . $id);
    }
    public function listBens($options = [], $page = 1, $limit = 100) {
        if (!empty($leilaoId)) {
            $options['leilao'] = $leilaoId;
        }
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/estoque?' . $queryString);
    }
    public function loadBem($id) {
        return $this->callApi('get', '/api/public/estoque/' . $id);
    }
    public function listBanners($options = []) {
        $queryString = $this->parseParams($options, 1, 10000);
        return $this->callApi('get', '/api/public/banners?' . $queryString);
    }
    public function listContents($options = [], $page = 1, $limit = 100) {
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/contents?' . $queryString);
    }
    public function loadContent($id) {
        return $this->callApi('get', '/api/public/contents/' . $id);
    }
    public function listMenus($options = []) {
        $queryString = $this->parseParams($options, 1, 10000);
        return $this->callApi('get', '/api/public/menus?' . $queryString);
    }

    /**
     * Métodos do usuário logado
     */
    public function login($username, $password) {}
    public function logout() {}
    public function recuperarSenha($userNameOrEmail) {}

    public function definirLoteFavorito($id) {}
    public function definirLeilaoFavorito($id) {}
    public function definirBemFavorito($id) {}
    public function lance($loteId, $valor, $parcelado = false, $parcelas = null, $entrada = null) {}
    public function registrarContato($assunto, $mensagem, $tipoId = null, $personId = null, $email = null, $telefone = null, $extra = []) {}
}