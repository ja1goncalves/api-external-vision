<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 18/05/18
 * Time: 08:26
 */

namespace App\Services\Parsers;

use function Psy\debug;
use App\Services\Service;
use App\Consult;

class ConsultsParser
{


    /**
     * @param array $parsers
     * @return \Illuminate\Http\JsonResponse
     */
    public function createConsult(array $parsers)
    {
        try
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

            $consult = new Consult($data);
            $consult->save();

            if( empty($consult) )
            {
                throw new \Exception('Consulta não salva!');
            }
            return response()->json(['error' => false, 'message' => 'Consulta cadastrado com sucesso!'], 200);
        }
        catch  (\Exception $e)
        {
            return response()->json( ['error' => true, 'message' => $e->getMessage()], 500 );
        }
    }

    /**
     * @param array $parsers
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateConsult(array $parsers)
    {
        try
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

             $consult = Consult::where('id',$parsers['id'])->update($data);
            \Log::debug($consult);

            if( empty($consult) )
            {
                throw new \Exception('Consulta não salva!');
            }
            return response()->json(['error' => false, 'message' => 'Consulta cadastrado com sucesso!'], 200);
        }
        catch  (\Exception $e)
        {
            return response()->json( ['error' => true, 'message' => $e->getMessage()], 500 );
        }
    }


}