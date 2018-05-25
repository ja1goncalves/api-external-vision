<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MotherCreateRequest;
use App\Http\Requests\MotherUpdateRequest;
use App\Repositories\MotherRepository;
use App\Validators\MotherValidator;

/**
 * Class MothersController.
 *
 * @package namespace App\Http\Controllers;
 */
class MothersController extends Controller
{
    /**
     * @var MotherRepository
     */
    protected $repository;

    /**
     * @var MotherValidator
     */
    protected $validator;

    /**
     * MothersController constructor.
     *
     * @param MotherRepository $repository
     * @param MotherValidator $validator
     */
    public function __construct(MotherRepository $repository, MotherValidator $validator)
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
        $mothers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mothers,
            ]);
        }

        return view('mothers.index', compact('mothers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MotherCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MotherCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mother = $this->repository->create($request->all());

            $response = [
                'message' => 'Mother created.',
                'data'    => $mother->toArray(),
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
        $mother = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mother,
            ]);
        }

        return view('mothers.show', compact('mother'));
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
        $mother = $this->repository->find($id);

        return view('mothers.edit', compact('mother'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MotherUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MotherUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mother = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Mother updated.',
                'data'    => $mother->toArray(),
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
                'message' => 'Mother deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Mother deleted.');
    }
}
