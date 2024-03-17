<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Models\Link;
use App\Services\Api\GoogleSafeBrowsing;
use App\Services\LinkGenerator;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    public function index(): Response
    {
        $links = Link::all();

        return Inertia::render('Links/Index', [
                'links' => $links,
                'flash' => session('flash', []),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function store(LinkStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $safeUrl = $this->isUrlSafe($request->url);

        if ($safeUrl) {
            $generateHash = (new LinkGenerator())->generateLink($validated['url']);

            Link::create([
                'url' => $validated['url'],
                'hash' => $generateHash,
            ]);

            return $this->redirectToBackWithFlash('Link created successfully', 'success');
        } else {
            return $this->redirectToBackWithFlash('The link contains malware', 'error');
        }
    }

    /**
     * @throws Exception
     */
    private function isUrlSafe(string $url): bool
    {
        return (new GoogleSafeBrowsing())->isSafeUrl($url);
    }

    private function redirectToBackWithFlash(string $message, string $status): RedirectResponse
    {
        return Redirect::back()->with('flash', [
            'message' => $message,
            'status' => $status,
        ]);
    }
}
