<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\Models\SecurityRequest;

class SecurityRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = SecurityRequest::query()->with('user')->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(20)->withQueryString();

        return view('admin::security-requests.index', compact('requests'));
    }
}
