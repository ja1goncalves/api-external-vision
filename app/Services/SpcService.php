<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 15/05/18
 * Time: 12:41
 */

namespace App\Services;

//use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\AppController;

class SpcService 
{
    /**
     * Retorna quantidade de vezes em que a API Assertiva foi utilizada no mês solicitado.
     *
     * @param Request $request
     * @return string
     */
    public function getAssertivaReport(Request $request) {
        $month = (!empty($request->get('month'))) ? $request->get('month') : date('m');
        return json_encode(['month_total' => count(ApiLog::whereBetween('created_at', [date("Y-{$month}-01 00:00:00"), date("Y-{$month}-31 23:59:59") ])->where('name', 'like', 'Assertiva')->get())]);
    }

    /**
     * Busca CPF ou CNPJ no webservice do SPC
     *
     * @param Request $request
     * - documento (CPF ou CNPJ)
     * @return string
     */

    public function consultSpc(Request $request) {

        //$url = "https://servicos.spc.org.br:443/spc/remoting/ws/consulta/consultaWebService?wsdl"; // PRODUÇÃO
        $url = "https://treina.spc.org.br:443/spc/remoting/ws/consulta/consultaWebService?wsdl"; // SANDBOX

        /*$auth = [ // PRODUÇÃO
                  'login' => '1577427',
                 'password' => '10455423'
               ];
        */
        $auth = [ // SANDBOX
            'login' => '398759',
            'password' => '09052018',
            'trace' => 1
        ];

        try {
            $client = new \SoapClient($url, $auth);

            $doc = $request->get('document');

            $data = [
                "code-product"      => 227, // Novo SPC Mix Mais
                'document-consumer' => $doc,
                'type-consumer'     => (strlen($doc) == 11) ? 'F' : 'J'
            ];

            $consultData = $client->consultDataSpc($data);
             $log = new ApiLog();
             $log->log('SPC', 'New SPC Mix Mais', 'Document: ' . $doc);

            return json_encode($consultData);

        } catch(\SoapFault $e) {
            return response()->json([
                "error"   => true,
                "message" => $e->getMessage(),
                "line"    => $e->getLine()
            ], $e->getCode());
        } catch(Exception $e) {
            return response()->json([
                "error"   => true,
                "message" => $e->getMessage(),
                "line"    => $e->getLine()
            ], $e->getCode());
        }
    }

    /**
     * @param $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultDataSpc($document){

        $spc = Consults::find($document);

        if($spc){
            return response()->json(['data'=>$spc,'status'=>true]);
        }else{
            return response()->json(['data'=>'Não foi possível retornar as informações','status'=>false]);
        }
    }
}