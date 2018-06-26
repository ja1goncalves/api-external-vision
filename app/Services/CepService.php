<?php

namespace App\Services;

class CepService
{
    /**
     * Busca de Enderreço via cep, api viacep
     *
     * @param $cep
     * @return mixed
     * @throws \Exception
     */
    public function findCep($cep)
    {
        if (empty($cep) or is_null($cep)){
            throw new \Exception('Cep inválido!');
        } else {
            $url = config("acess.urls.cep");
            $cep = AppHelper::removeCharacters($cep);
            $res = PersonService::getInstance()->request('GET', $url . $cep . '/json/');
            $json = json_decode($res->getBody(), true);

            return $json;
        }
    }

    public function validarCep($cep) {
        // retira espacos em branco
        $cep = trim($cep);

        if(!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
            return false; //CEP inválido
        }
        else{
            return true;//CEP valido
        }
    }


}