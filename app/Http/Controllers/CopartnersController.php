<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CopartnerCreateRequest;
use App\Http\Requests\CopartnerUpdateRequest;
use App\Repositories\CopartnerRepository;
use App\Validators\CopartnerValidator;

/**
 * Class CopartnersController.
 *
 * @package namespace App\Http\Controllers;
 */
class CopartnersController extends Controller
{
    /**
     * @var CopartnerRepository
     */
    protected $repository;

    /**
     * @var CopartnerValidator
     */
    protected $validator;

    /**
     * CopartnersController constructor.
     *
     * @param CopartnerRepository $repository
     * @param CopartnerValidator $validator
     */
    public function __construct(CopartnerRepository $repository, CopartnerValidator $validator)
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
        $copartners = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $copartners,
            ]);
        }

        return view('copartners.index', compact('copartners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CopartnerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CopartnerCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $copartner = $this->repository->create($request->all());

            $response = [
                'message' => 'Copartner created.',
                'data'    => $copartner->toArray(),
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
        $copartner = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $copartner,
            ]);
        }

        return view('copartners.show', compact('copartner'));
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
        $copartner = $this->repository->find($id);

        return view('copartners.edit', compact('copartner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CopartnerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CopartnerUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $copartner = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Copartner updated.',
                'data'    => $copartner->toArray(),
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
                'message' => 'Copartner deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Copartner deleted.');
    }
}
