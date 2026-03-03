<?php

namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Notification\Models\EmailTemplate;

class AdminNotificationController extends Controller
{
    public function index(): View
    {
        $templates = EmailTemplate::orderBy('mailable_class')->get();

        return view('notification::admin.index', compact('templates'));
    }

    public function edit(EmailTemplate $emailTemplate): View
    {
        $placeholders = EmailTemplate::availablePlaceholders();

        return view('notification::admin.edit', compact('emailTemplate', 'placeholders'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $emailTemplate->update([
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.notification.templates.index')
            ->with('success', 'Template de e-mail atualizado com sucesso.');
    }
}
