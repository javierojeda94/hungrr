<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 24/03/2016
 * Time: 01:43 AM
 */

namespace App\Http\Controllers;

use ForceUTF8\Encoding;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ApiController extends Controller
{

    protected $statusCode = HTTPResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    protected function respondFound($data, $headers = [])
    {
        return $this->respond($data, $headers);
    }

    protected function respondCreated($message = 'Created!')
    {
        return $this->setStatusCode(HTTPResponse::HTTP_CREATED)->respondWithSuccess($message);
    }

    protected function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(HTTPResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(HTTPResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    protected function respondValidationFailure($message = 'Invalid Params!')
    {
        return $this->setStatusCode(HTTPResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }


    private function respondWithError($message)
    {
        return $this->respond(
            [
                'error' => [
                    'message' => $message,
                    'status_code' => $this->getStatusCode()
                ]
            ],
            $this->getStatusCode()
        );
    }

    private function respondWithSuccess($message)
    {
        return $this->respond(
            [
                'success' => [
                    'message' => $message,
                    'status_code' => $this->getStatusCode()
                ]
            ],
            $this->getStatusCode()
        );
    }

    private function respond($data, $headers)
    {
        $response = Response::json($data, $this->getStatusCode(), $headers, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $response;
    }

}