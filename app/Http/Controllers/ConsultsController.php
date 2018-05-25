<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ConsultCreateRequest;
use App\Http\Requests\ConsultUpdateRequest;
use App\Repositories\ConsultRepository;
use App\Validators\ConsultValidator;

/**
 * Class ConsultsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ConsultsController extends Controller
{
    /**
     * @var ConsultRepository
     */
    protected $repository;

    /**
     * @var ConsultValidator
     */
    protected $validator;

    /**
     * ConsultsController constructor.
     *
     * @param ConsultRepository $repository
     * @param ConsultValidator $validator
     */
    public function __construct(ConsultRepository $repository, ConsultValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $consults = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $consults,
            ]);
        }

        return view('consults.index', compact('consults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConsultCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ConsultCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $consult = $this->repository->create($request->all());

            $response = [
                'message' => 'Consult created.',
                'data'    => $consult->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consult = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $consult,
            ]);
        }

        return view('consults.show', compact('consult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consult = $this->repository->find($id);

        return view('consults.edit', compact('consult'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConsultUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ConsultUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $consult = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Consult updated.',
                'data'    => $consult->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Consult deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Consult deleted.');
    }
}
