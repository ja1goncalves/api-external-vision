<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StreetCreateRequest;
use App\Http\Requests\StreetUpdateRequest;
use App\Repositories\StreetRepository;
use App\Validators\StreetValidator;

/**
 * Class StreetsController.
 *
 * @package namespace App\Http\Controllers;
 */
class StreetsController extends Controller
{
    /**
     * @var StreetRepository
     */
    protected $repository;

    /**
     * @var StreetValidator
     */
    protected $validator;

    /**
     * StreetsController constructor.
     *
     * @param StreetRepository $repository
     * @param StreetValidator $validator
     */
    public function __construct(StreetRepository $repository, StreetValidator $validator)
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
        $streets = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $streets,
            ]);
        }

        return view('streets.index', compact('streets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StreetCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StreetCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $street = $this->repository->create($request->all());

            $response = [
                'message' => 'Street created.',
                'data'    => $street->toArray(),
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
        $street = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $street,
            ]);
        }

        return view('streets.show', compact('street'));
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
        $street = $this->repository->find($id);

        return view('streets.edit', compact('street'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StreetUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StreetUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $street = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Street updated.',
                'data'    => $street->toArray(),
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
                'message' => 'Street deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Street deleted.');
    }
}
