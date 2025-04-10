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

    private function parseParams($options, $page, $limit)
    {
        $defaultParams = [
            'page' => $page,
            'limit' => $limit,
        ];

        // Combina os parâmetros padrão com os fornecidos em $options
        $params = array_merge($defaultParams, $options);

        // Converte os parâmetros para a string de query
        return http_build_query($params);
    }

    public function listLeiloes($options = [], $page = 1, $limit = 100)
    {

        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/leiloes?' . $queryString);
    }

    public function loadLeilao($id)
    {
        return $this->callApi('get', '/api/public/leiloes/' . $id);
    }

    public function listLotes($leilaoId = null, $options = [], $page = 1, $limit = 100)
    {
        if (!empty($leilaoId)) {
            $options['leilao'] = $leilaoId;
        }
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/lotes?' . $queryString);
    }

    public function loadLote($id)
    {
        return $this->callApi('get', '/api/public/lotes/' . $id);
    }

    public function listBens($options = [], $page = 1, $limit = 100)
    {
        if (!empty($leilaoId)) {
            $options['leilao'] = $leilaoId;
        }
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/estoque?' . $queryString);
    }

    public function loadBem($id)
    {
        return $this->callApi('get', '/api/public/estoque/' . $id);
    }

    public function listBanners($options = [])
    {
        $queryString = $this->parseParams($options, 1, 10000);
        return $this->callApi('get', '/api/public/banners?' . $queryString);
    }

    public function listContents($options = [], $page = 1, $limit = 100)
    {
        $queryString = $this->parseParams($options, $page, $limit);
        return $this->callApi('get', '/api/public/contents?' . $queryString);
    }

    public function loadContent($id)
    {
        return $this->callApi('get', '/api/public/contents/' . $id);
    }

    public function listMenus($options = [])
    {
        $queryString = $this->parseParams($options, 1, 10000);
        return $this->callApi('get', '/api/public/menus?' . $queryString);
    }

    public function getCacheVendedores()
    {
        return $this->callApi('get', '/api/public/cache/vendedores');
    }

    public function getComitente($id, $incluirEventos = true, $incluirDestaques = true)
    {
        $queryString = $this->parseParams([
            'incluirEventos' => $incluirEventos,
            'incluirDestaques' => $incluirDestaques,
        ], 1, 10000);
        return $this->callApi('get', '/api/public/comitentes/' . $id . '?' . $queryString);
    }

    public function login($username, $password, $headers = [])
    {
        return $this->callApi('post', '/api/auth', [
            'json' => [
                'user' => $username,
                'pass' => $password,
            ],
            'headers' => $headers
        ]);
    }

    /**
     * Métodos do usuário logado
     */
    public function recuperarSenha($userNameOrEmail)
    {
        return $this->callApi('post', '/api/public/arrematantes/service/recupera-senha', [
            'json' => [
                'login' => $userNameOrEmail
            ]
        ]);
    }

    public function userCredentials()
    {
        return $this->callAuthApi('get', '/api/userCredentials');
    }

    public function getLeiloesLotesFavoritos()
    {
        return $this->callAuthApi('get', '/api/arrematantes/meusFavoritos');
    }

    public function getLotesFavoritos($leilao = null)
    {
        $url = '/api/arrematantes/lotes/favoritos';
        if (!empty($leilao)) {
            $url .= '?leilao=' . $leilao;
        }
        return $this->callAuthApi('get', $url);
    }

    public function definirLoteFavorito($id)
    {
        return $this->callAuthApi('get', sprintf('/api/arrematantes/lotes/%s/favorito', $id));
    }

    public function removerLoteFavorito($id)
    {
        return $this->callAuthApi('delete', sprintf('/api/arrematantes/lotes/%s/favorito', $id));
    }

    public function definirLeilaoFavorito($id)
    {
        return $this->callAuthApi('get', sprintf('/api/arrematantes/leiloes/%s/favorito', $id));
    }

    public function getLeiloesFavoritos()
    {
        return $this->callAuthApi('get', '/api/arrematantes/leiloes/favoritos');
    }

    public function removerLeilaoFavorito($id)
    {
        return $this->callAuthApi('delete', sprintf('/api/arrematantes/leiloes/%s/favorito', $id));
    }

    public function definirBemFavorito($id)
    {
        return $this->callAuthApi('get', sprintf('/api/arrematantes/bens/%s/favorito', $id));
    }

    public function removerBemFavorito($id)
    {
        return $this->callAuthApi('delete', sprintf('/api/arrematantes/bens/%s/favorito', $id));
    }

    public function lance($loteId, $valor, $parcelado = false, $parcelas = null, $entrada = null)
    {
    }

    public function registrarContato($assunto, $mensagem, $tipoId = null, $personId = null, $email = null, $telefone = null, $extra = [])
    {
    }
}