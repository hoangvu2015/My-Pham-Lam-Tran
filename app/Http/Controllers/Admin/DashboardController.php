<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\BlogArticle;
use Antoree\Models\Teacher;
use Antoree\Models\TmpLearningRequest;
use Antoree\Models\Topic;
use Illuminate\Http\Request;

use Antoree\Http\Requests;

class DashboardController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return view($this->themePage('dashboard'), [
            'topics' => Topic::all()->count(),
            'newly_external_lrs' => 10,
            'processed_external_lrs' => 10,
            'newly_teachers' => 10,
            'becoming_teachers' => 10,
            'approved_teachers' => 10,
            'verified_teachers' => 10,
            'rejected_teachers' => 10,
            'published_blog_articles' => BlogArticle::ofBlog()->where('status', BlogArticle::STATUS_PUBLISHED)->count(),
            'requested_blog_articles' => BlogArticle::ofBlog()->where('status', BlogArticle::STATUS_REQUESTED)->count(),
        ]);
    }
}
