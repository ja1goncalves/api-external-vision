<?php

namespace App\Services\Traits;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CrudMethods
 * @package app\Services\Traits
 */
trait CrudMethods
{
    /** @var  RepositoryInterface $repository */
    protected $repository;

    /**
     * @param int $limit
     * @return mixed
     */
    public function all(int $limit = 20)
    {
//        $this->repository
//            ->resetCriteria()
//            ->pushCriteria(app('App\Criterias\FilterByStatusCriteria'))
//            ->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->repository->paginate($limit);
    }

    /**
     * @param array $data
     * @param bool $skipPresenter
     * @return mixed
     */
    public function create(array $data, $skipPresenter = false)
    {
        return $skipPresenter ? $this->repository->skipPresenter()->create($data) : $this->repository->create($data);
    }

    /**
     * @param $id
     * @param bool $skip_presenter
     * @return mixed
     */
    public function find($id, $skip_presenter = false)
    {
        if ($skip_presenter){
            return $this->repository->skipPresenter()->find($id);
        }
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return array|mixed
     */
    public function update(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param array $data
     * @param bool $first
     * @param bool $presenter
     * @return mixed
     */
    public function findWhere(array $data, $first = false, $presenter = false)
    {
        if ($first) {
            return $this->repository->skipPresenter()->findWhere($data)->first();
        }
        if ($presenter) {
            return $this->repository->findWhere($data)->first();
        }
        return $this->repository->skipPresenter()->findWhere($data);

    }

    /**
     * @param array $parsers
     * @return array
     */
    public function formattingCpf(array $parsers)
    {
        $pess = $parsers['cpf'];
        $formatCpf = $this->formatCpf($pess);
        $parsers['cpf'] = $formatCpf;

        $mother = $parsers['mother']['cpf'];
        $formatCpfMother = $this->formatCpf($mother);
        $parsers['mother']['cpf'] = $formatCpfMother;

        $copartner = $parsers['copartner']['cpf'];
        $formatCpfCopartner = $this->formatCpf($copartner);
        $parsers['copartner']['cpf'] = $formatCpfCopartner;

        return $parsers;
    }

    /**
     * Método Valida Tamanho, Confere Primeiro Digito Verificador, Calcula Segundo dígido Verificador
     *
     * @param $cpf
     * @return bool
     */
    public function validateCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--){
            $soma += $cpf{$i} * $j;
        }
        $resto = $soma % 11;

        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)){
            return false;
        }

        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--){
            $soma += $cpf{$i} * $j;
        }
        $resto = $soma % 11;

        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Método recebe CPF e Formatar no Padrão xxx.xxx.xxx-xx, caso já seja formatado
     * ele retorna ele mesmo
     *
     * @param $cpf
     * @return string
     */
    public function formatCpf($cpf)
    {
        if (strlen($cpf) == 14){
            return $cpf;
        } else{
            if (strlen($cpf) == 10){
                $zero = '0'.$cpf;
                $partOne    = substr($zero, 0, 3);
                $partTwo    = substr($zero, 3, 3);
                $partThree  = substr($zero, 6, 3);
                $partFour   = substr($zero, 9, 2);
                $mountCPF   = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
            else{
                $partOne    = substr($cpf, 0, 3);
                $partTwo    = substr($cpf, 3, 3);
                $partThree  = substr($cpf, 6, 3);
                $partFour   = substr($cpf, 9, 2);
                $mountCPF   = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
        }
    }


    /**
     * Método para verificar se tem cpf nao tem zero inicial
     *
     * @param $cpf
     * @return array
     */
    public function verificarZero($cpf)
    {
        if (strlen($cpf) == 10) {
            $array = str_split($cpf, 1);
            $string = $this->add($array);
            return $string;
        } else {
            return $cpf;
        }
    }

    /**
     * Adiciona um array em um Lista
     *
     * @param array $obj
     * @return array
     */
    public function add($obj = [])
    {
        $array = [1 => '0'];
        $newArray = array_merge($array , $obj);
        return $newArray;
    }

    /**
     * Método converte cpf em string adicionando zero na frente
     *
     * @param $cpf
     * @return array|string
     */
    public function formatString($cpf)
    {
        $format = $this->verificarZero($cpf);
        if (is_array($format)) {
            $array = $format[0] . $format[1] . $format[2] . $format[3] . $format[4] . $format[5] .
                $format[6] . $format[7] .  $format[8] . $format[9] . $format[10];
            return $array;
        } else {
            if (strlen($format) == 11) {
                return $format;
            }
        }
    }


}