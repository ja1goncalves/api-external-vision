<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 18/05/18
 * Time: 08:26
 */

namespace App\Services\Parsers;

use App\Consult;
use App\Mother;
use App\Phone;
use App\Street;

class ConsultsParser
{
    /**
     * Consult
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

    public function searchConsult($parsers)
    {
        $consult = Consult::where('cpf',$parsers)->first();

        if(empty($consult))
        {
            $data = null;
        }
        else{
            $data = $consult;
        }
            return $data;
    }

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

    /**
     * Phone
     */
    public function searchPhone(array $parsers,$consultId)
    {
        $phone = Phone::where('consult_id', $consultId)->first();

        if(empty($phone))
        {
            $data = null;
        }
        else{
            $data = $consultId;
        }
        return $data;
    }

    public function createPhone(array $parsers, $consultId)
    {
        $data = $this->dataPhone($parsers);

        $phone = new Phone($data);
        $phone->save();

        if(empty($phone))
        {
            $data = null;
        }
        else{
            $data = $phone['id'];
        }
        return $data;
    }

    public function updatePhone(array $parsers,$consultId)
    {
        $data = $this->dataPhone($parsers);

        $consult = Phone::where('phoneable_id',$consultId)->update($data);

        if(empty($consult))
        {
            $data = null;
        }
        else{
            $data = $consult['id'];
        }
        return $data;
    }

    public function dataPhone(array $parsers,$consult)
    {
        $data = [
            'phone'          => $parsers['telefone'] ,
            'consult_id'     => $consult['id'],
            'phoneable_id'   => $consult['id'] ,
            'phoneable_type' => 'App\\Consult'
        ];

        return $data;
    }

    public function dataPhoneMothers(array $parsers, $mother,$consultId)
    {
        $data = [
            'phone'          => $parsers['telefone'] ,
            'consult_id'     => $consultId,
            'phoneable_id'   => $mother['id'] ,
            'phoneable_type' => 'App\\Mother'
        ];

        return $data;
    }

    public function dataPhoneCopartner(array $parsers,$copartner,$consultId)
    {
        $data = [
            'phone'          => $parsers['telefone'] ,
            'consult_id'     => $consultId,
            'phoneable_id'   => $copartner['id'] ,
            'phoneable_type' => 'App\\Copartner'
        ];

        return $data;
    }

    /**
     * Mother
     */
    public function createMother(array $parsers)
    {
        $data = $this->dataMother($parsers);

        $mother = new Mother($data);
        $mother->save();

        if(empty($mother))
        {
            $data = null;
        }
        else{
            $data = $mother['id'];
        }
        return $data;
    }

    public function updateMother(array $parsers)
    {
        $data = $this->dataMother($parsers);

        $mother = Mother::where('cpf',$parsers['cpf'])->update($data);

        if(empty($mother))
        {
            $data = null;
        }
        else{
            $data = $mother['id'];
        }
        return $data;
    }

    public function searchMother(array $parsers)
    {
        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $mother  = Mother::where('consult_id',$consult['id'])->first();

        if(empty($mother))
        {
            $data = null;
        }
        else{
            $data = $consult['id'];
        }
        return $data;
    }

    public function dataMother(array $parsers, $consultId)
    {
        $data = [
            'name'      => $parsers['mother']['nome'],
            'cpf'       => $parsers['mother']['cpf'],
            'consult_id'=> $consultId
        ];
        return $data;
    }

    /**
     * Street
     */
    public function createStreet(array $parsers)
    {
        $data = $this->dataStreet($parsers);

        $street = new Street($data);
        $street->save();

        if(empty($street))
        {
            $data = null;
        }
        else{
            $data = $street['id'];
        }
        return $data;
    }

    public function updateStreet(array $parsers)
    {
        $data = $this->dataMother($parsers);

        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $street  = Street::where('consult_id',$consult)->update($data);

        if(empty($street))
        {
            $data = null;
        }
        else{
            $data = $street['id'];
        }
        return $data;
    }

    public function searchStreet(array $parsers)
    {
        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $street  = Street::where('consult_id',$consult['id'])->first();

        if(empty($street))
        {
            $data = null;
        }
        else{
            $data = $street['id'];
        }
        return $data;
    }

    public function dataStreet(array $parsers, $consultId)
    {
        $data = [
            'type_street'  => $parsers['street']['type_street'],
            'public_place' => $parsers['street']['public_place'],
            'number'       => $parsers['street']['number'],
            'complement'   => $parsers['street']['complement'],
            'neighborhood' => $parsers['street']['neighborhood'],
            'city'         => $parsers['street']['city'],
            'uf'           => $parsers['street']['uf'],
            'zipcode'      => $parsers['street']['zipcode'],
            'score'        => $parsers['street']['score'],
            'consult_id'   => $consultId
        ];
        return $data;
    }

    /**
     * Email
     */
    public function createEmail(array $parsers)
    {
        $data = $this->dataEmail($parsers);

        $email = new Email($data);
        $email->save();

        if(empty($email))
        {
            $data = null;
        }
        else{
            $data = $email['id'];
        }
        return $data;
    }

    public function updateEmail(array $parsers)
    {
        $data = $this->dataEmail($parsers);

        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $email  = Email::where('consult_id',$consult)->update($data);

        if(empty($email))
        {
            $data = null;
        }
        else{
            $data = $email['id'];
        }
        return $data;
    }

    public function searchEmail(array $parsers)
    {
        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $email  = Email::where('consult_id',$consult['id'])->first();

        if(empty($email))
        {
            $data = null;
        }
        else{
            $data = $email['id'];
        }
        return $data;
    }

    public function dataEmail(array $parsers, $consultId)
    {
        $data = [
            'email'      => $parsers['email']['email'],
            'consult_id' => $consultId
        ];
        return $data;
    }


    /**
     * Occupation
     */
    public function createOccupation(array $parsers)
    {
        $data = $this->dataOccupation($parsers);

        $occupation = new Occupation($data);
        $occupation->save();

        if(empty($occupation))
        {
            $data = null;
        }
        else{
            $data = $occupation['id'];
        }
        return $data;
    }

    public function updateOccupation(array $parsers)
    {
        $data = $this->dataOccupation($parsers);

        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $occupation  = Occupation::where('consult_id',$consult)->update($data);

        if(empty($occupation))
        {
            $data = null;
        }
        else{
            $data = $occupation['id'];
        }
        return $data;
    }

    public function searchOccupation(array $parsers)
    {
        $consult     = Consult::where('cpf',$parsers['cpf'])->first();
        $occupation  = Occupation::where('consult_id',$consult['id'])->first();

        if(empty($occupation))
        {
            $data = null;
        }
        else{
            $data = $occupation['id'];
        }
        return $data;
    }

    public function dataOccupation(array $parsers, $consultId)
    {
        $data = [
            'code'             => $parsers['occupation']['code']  ,
            'description'      => $parsers['occupation']['description']  ,
            'cnpj'             => $parsers['occupation']['cnpj']  ,
            'corporate'        => $parsers['occupation']['corporate']  ,
            'cnae'             => $parsers['occupation']['cnae']  ,
            'description_cnae' => $parsers['occupation']['description_cnae']  ,
            'postage'          => $parsers['occupation']['postage']  ,
            'salary'           => $parsers['occupation']['salary']  ,
            'salary_range'     => $parsers['occupation']['salary_range'] ,
            'consult_id'       => $consultId
        ];
        return $data;
    }

    /**
     * Vehicles
     */
    public function createVehicles(array $parsers)
    {
        $data = $this->dataVehicles($parsers);

        $vehicles = new Vehicles($data);
        $vehicles->save();

        if(empty($vehicles))
        {
            $data = null;
        }
        else{
            $data = $vehicles['id'];
        }
        return $data;
    }

    public function updateVehicles(array $parsers)
    {
        $data = $this->dataVehicles($parsers);

        $consult = Consult::where('cpf',$parsers['cpf'])->first();
        $vehicles  = Vehicles::where('consult_id',$consult)->update($data);

        if(empty($vehicles))
        {
            $data = null;
        }
        else{
            $data = $vehicles['id'];
        }
        return $data;
    }

    public function searchVehicles(array $parsers)
    {
        $consult     = Consult::where('cpf',$parsers['cpf'])->first();
        $vehicles  = Vehicles::where('consult_id',$consult['id'])->first();

        if(empty($vehicles))
        {
            $data = null;
        }
        else{
            $data = $vehicles['id'];
        }
        return $data;
    }

    public function dataVehicles(array $parsers, $consultId)
    {
        $data = [
            'board'               =>$parsers['vehicles']['board'] ,
            'brand_model'         =>$parsers['vehicles']['brand_model'],
            'manufacturing_year'  =>$parsers['vehicles']['manufacturing_year'],
            'model_year'          =>$parsers['vehicles']['model_year'],
            'consult_id'          => $consultId
        ];
        return $data;
    }

}
