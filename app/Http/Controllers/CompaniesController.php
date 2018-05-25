<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CompanieCreateRequest;
use App\Http\Requests\CompanieUpdateRequest;
use App\Repositories\CompanieRepository;
use App\Validators\CompanieValidator;

/**
 * Class CompaniesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CompaniesController extends Controller
{
    /**
     * @var CompanieRepository
     */
    protected $repository;

    /**
     * @var CompanieValidator
     */
    protected $validator;

    /**
     * CompaniesController constructor.
     *
     * @param CompanieRepository $repository
     * @param CompanieValidator $validator
     */
    public function __construct(CompanieRepository $repository, CompanieValidator $validator)
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
        $companies = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companies,
            ]);
        }

        return view('companies.index', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanieCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompanieCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $companie = $this->repository->create($request->all());

            $response = [
                'message' => 'Companie created.',
                'data'    => $companie->toArray(),
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
        $companie = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companie,
            ]);
        }

        return view('companies.show', compact('companie'));
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
        $companie = $this->repository->find($id);

        return view('companies.edit', compact('companie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanieUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompanieUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $companie = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Companie updated.',
                'data'    => $companie->toArray(),
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
                'message' => 'Companie deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Companie deleted.');
    }
}
