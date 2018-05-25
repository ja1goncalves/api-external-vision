<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OccupationCreateRequest;
use App\Http\Requests\OccupationUpdateRequest;
use App\Repositories\OccupationRepository;
use App\Validators\OccupationValidator;

/**
 * Class OccupationsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OccupationsController extends Controller
{
    /**
     * @var OccupationRepository
     */
    protected $repository;

    /**
     * @var OccupationValidator
     */
    protected $validator;

    /**
     * OccupationsController constructor.
     *
     * @param OccupationRepository $repository
     * @param OccupationValidator $validator
     */
    public function __construct(OccupationRepository $repository, OccupationValidator $validator)
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
        $occupations = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $occupations,
            ]);
        }

        return view('occupations.index', compact('occupations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OccupationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OccupationCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $occupation = $this->repository->create($request->all());

            $response = [
                'message' => 'Occupation created.',
                'data'    => $occupation->toArray(),
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
        $occupation = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $occupation,
            ]);
        }

        return view('occupations.show', compact('occupation'));
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
        $occupation = $this->repository->find($id);

        return view('occupations.edit', compact('occupation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OccupationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OccupationUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $occupation = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Occupation updated.',
                'data'    => $occupation->toArray(),
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
                'message' => 'Occupation deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Occupation deleted.');
    }
}
