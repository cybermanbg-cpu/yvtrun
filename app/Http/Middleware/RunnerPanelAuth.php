<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// https://вашият-сайт.com/api/owntracks/pub?u=runner1&d=phone


class RunnerPanelAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Ако вече е влязъл (има сесия), пропускаме
        if ($request->session()->has('runner_panel_authenticated')) {
            return $next($request);
        }
        
        // Ако е изпратена парола
        if ($request->isMethod('post') && $request->input('password')) {
            $correctPassword = env('RUNNER_PANEL_PASSWORD', 'Yambol2026');
            
            if ($request->input('password') === $correctPassword) {
                $request->session()->put('runner_panel_authenticated', true);
                return redirect()->route('runner.panel');
            }
            
            return back()->withErrors(['password' => 'Невалидна парола!']);
        }
        
        // Покажи формата за вход
        return response()->view('runner.login');
    }
}