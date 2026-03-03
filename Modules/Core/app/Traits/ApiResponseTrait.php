<?php

namespace Modules\Core\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Retorna uma resposta JSON de sucesso padronizada.
     *
     * @param  mixed  $data  Dados a serem retornados (array, object, etc.)
     * @param  string  $message  Mensagem opcional de sucesso
     * @param  int  $code  Código HTTP (padrão: 200)
     */
    protected function successResponse(mixed $data = null, string $message = 'Operação realizada com sucesso.', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Retorna uma resposta JSON de erro padronizada.
     *
     * @param  string  $message  Mensagem de erro
     * @param  int  $code  Código HTTP (padrão: 400)
     * @param  array|null  $errors  Lista de erros de validação ou detalhes adicionais
     */
    protected function errorResponse(string $message = 'Ocorreu um erro.', int $code = 400, ?array $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Retorna uma resposta JSON de recurso não encontrado.
     */
    protected function notFoundResponse(string $message = 'Recurso não encontrado.'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Retorna uma resposta JSON de erro de validação.
     *
     * @param  array  $errors  Erros de validação (campo => mensagens)
     * @param  string  $message  Mensagem geral
     */
    protected function validationErrorResponse(array $errors, string $message = 'Os dados fornecidos são inválidos.'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }
}
