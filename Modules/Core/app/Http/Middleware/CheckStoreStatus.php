<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreStatus
{
    /**
     * Handle an incoming request.
     *
     * Estrutura base para verificação futura do status da loja.
     * Por exemplo: bloquear acesso quando a loja estiver em manutenção,
     * inativa ou fora do horário de funcionamento.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // TODO: Implementar lógica de verificação do status da loja
        // Exemplos futuros:
        // - Verificar se a loja está ativa
        // - Verificar horário de funcionamento
        // - Verificar modo manutenção
        // - Redirecionar ou retornar 503 conforme necessário

        return $next($request);
    }
}
