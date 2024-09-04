<?php

namespace App\Http\Controllers\Api;

use App\Enums\FileType;
use App\Enums\VerificationResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Domain\StoreDomainRequest;
use App\Models\Domain;
use App\Services\DomainService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    public function __construct(public DomainService $domainService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), (new StoreDomainRequest)->rules());

        if ($validator->fails()) {
            return response()->json(['message' => __('Uploaded file is missing.'), 'errors' => $validator->errors()], Response::HTTP_OK);
        }

        $this->domainService->setJsonStructure($request->file('file')->getContent());
        $result = $this->domainService->validateStrucrure();

        $verificationResult = Str::ucfirst(Str::camel($result['data']['result']));

        Domain::create([
            'user_id' => Auth::user()->id,
            'file_type' => FileType::Json->value,
            'verification_result' => array_search($verificationResult, VerificationResult::toArray()),
        ]);

        return \response()->json($result, Response::HTTP_OK);
    }
}
