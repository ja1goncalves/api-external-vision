<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ApiLogCreateRequest;
use App\Http\Requests\ApiLogUpdateRequest;
use App\Repositories\ApiLogRepository;
use App\Validators\ApiLogValidator;

/**
 * Class ApiLogsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ApiLogsController extends Controller
{
    /**
     * @var ApiLogRepository
     */
    protected $repository;

    /**
     * @var ApiLogValidator
     */
    protected $validator;

    /**
     * ApiLogsController constructor.
     *
     * @param ApiLogRepository $repository
     * @param ApiLogValidator $validator
     */
    public function __construct(ApiLogRepository $repository, ApiLogValidator $validator)
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
        $apiLogs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $apiLogs,
            ]);
        }

        return view('apiLogs.index', compact('apiLogs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApiLogCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ApiLogCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $apiLog = $this->repository->create($request->all());

            $response = [
                'message' => 'ApiLog created.',
                'data'    => $apiLog->toArray(),
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
        $apiLog = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $apiLog,
            ]);
        }

        return view('apiLogs.show', compact('apiLog'));
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
        $apiLog = $this->repository->find($id);

        return view('apiLogs.edit', compact('apiLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ApiLogUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ApiLogUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $apiLog = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ApiLog updated.',
                'data'    => $apiLog->toArray(),
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
                'message' => 'ApiLog deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ApiLog deleted.');
    }
}
