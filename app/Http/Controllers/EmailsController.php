<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EmailCreateRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Repositories\EmailRepository;
use App\Validators\EmailValidator;

/**
 * Class EmailsController.
 *
 * @package namespace App\Http\Controllers;
 */
class EmailsController extends Controller
{
    /**
     * @var EmailRepository
     */
    protected $repository;

    /**
     * @var EmailValidator
     */
    protected $validator;

    /**
     * EmailsController constructor.
     *
     * @param EmailRepository $repository
     * @param EmailValidator $validator
     */
    public function __construct(EmailRepository $repository, EmailValidator $validator)
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
        $emails = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $emails,
            ]);
        }

        return view('emails.index', compact('emails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmailCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(EmailCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $email = $this->repository->create($request->all());

            $response = [
                'message' => 'Email created.',
                'data'    => $email->toArray(),
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
        $email = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $email,
            ]);
        }

        return view('emails.show', compact('email'));
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
        $email = $this->repository->find($id);

        return view('emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmailUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(EmailUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $email = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Email updated.',
                'data'    => $email->toArray(),
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
                'message' => 'Email deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Email deleted.');
    }
}
