<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 18/05/18
 * Time: 08:26
 */

namespace App\Services\Parsers;

use App\Consult;

class ConsultsParser
{
    /**
     * @param array $parsers
     * @return \Illuminate\Http\JsonResponse
     */
    public function createConsult(array $parsers)
    {
        $data = $this->dataConsult($parsers);

        $consult = new Consult($data);
        $consult->save();

        if(empty($consult))
        {
            $data = null;
        }
        else{
            $data = $consult['id'];
        }
        return $data;
    }

    /**
     * @param array $parsers
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateConsult(array $parsers)
    {
        $data = $this->dataConsult($parsers);

        $consult = Consult::where('cpf',$parsers['cpf'])->update($data);

        if(empty($consult))
        {
            $data = null;
        }
        else{
            $data = $consult['id'];
        }
        return $data;

    }

    /**
     * @param array $parsers
     * @return mixed
     * @throws \Exception
     */
    public function searchConsult(array $parsers)
    {
        $consult = Consult::where('cpf',$parsers['cpf'])->first();

        if(empty($consult))
        {
            $data = null;
        }
        else{
            $data = $consult['id'];
        }
            return $data;
    }

    /**
     * @param array $parsers
     * @return array
     */
    public function dataConsult(array $parsers)
    {
        $data = [
            'protocol'         => $parsers['protocol'],
            'cpf'              => $parsers['cpf'],
            'name'             => $parsers['name'],
            'sex'              => $parsers['sex'],
            'signo_zodiacal'   => $parsers['signo_zodiacal'],
            'date_birth'       => $parsers['date_birth'],
            'age'              => $parsers['age'],
            'estimated_income' => $parsers['estimated_income'],
        ];

        return $data;
    }

}
