<?php

namespace App\Http\Middleware\FaqCrud;

use Closure;
use Illuminate\Support\Facades\Auth;

class FaqCrudPermit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch ($request->route()->action['as']) {
            case 'faq_product.index': {
                if(Auth::user()->user_group->getFaqCrudRights->view != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'faq_product.store': {
                if(Auth::user()->user_group->getFaqCrudRights->create != 1) {
                    abort(403, 'Unauthorized action');
                }
                break;
            }
            case 'faq_product.edit': {
                if(Auth::user()->user_group->getFaqCrudRights->edit != 1) {
                    return redirect()->route('home');
                }
                break;
            }
        }

        return $next($request);
    }
}
