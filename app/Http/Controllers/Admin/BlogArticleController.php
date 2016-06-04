<?php
namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\MultipleLocaleContentController;
use Antoree\Models\BlogArticle;
use Antoree\Models\BlogCategory;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Display a listing of the resource.
 *
 * @return Response
 */
class BlogArticleController extends MultipleLocaleContentController
{
    protected function special(Request $request)
    {
        if ($request->has('remove')) {
            $locale = $request->input('remove');
            $id = $request->input('id');
            $blog_article = BlogArticle::findOrFail($id);
            $trans = $blog_article->translate($locale);
            if ($trans) {
                $trans->delete();
            };
        }

        $blog_articles = BlogArticle::ofBlog()->get();
        if ($request->has('update')) {
            foreach ($blog_articles as $blog_article) {
                if ($blog_article->translations->count() == 1) {
                    $trans = $blog_article->translations->first();
                    if ($trans->locale != AppHelper::INTERNATIONAL_LOCALE_CODE) {
                        $trans->locale = AppHelper::INTERNATIONAL_LOCALE_CODE;
                        $trans->save();
                    }
                }
            }
        }

        return view($this->themePage('blog_article.special'), [
            'blog_articles' => $blog_articles,
        ]);
    }

    public function index(Request $request)
    {
        // special action
        if ($request->has('special')) {
            return $this->special($request);
        }

        $filtered_status = $request->input('filtered_status', null);
        if ($filtered_status && !in_array($filtered_status, [BlogArticle::STATUS_PUBLISHED, BlogArticle::STATUS_REQUESTED, BlogArticle::STATUS_DRAFT])) {
            $filtered_status = null;
        }

        $blog_articles = BlogArticle::ofBlog()->listForUser($this->auth_user)
            ->filter($filtered_status)
            ->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $blog_articles->currentPage(),
            'filtered_status' => $filtered_status,
        ], localizedAdminURL('blog/articles'));

        return view($this->themePage('blog_article.list'), [
            'blog_articles' => $blog_articles,
            'query' => $query,
            'page_helper' => new PaginationHelper($blog_articles->lastPage(), $blog_articles->currentPage(), $blog_articles->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
            'status_draft' => BlogArticle::STATUS_DRAFT,
            'status_published' => BlogArticle::STATUS_PUBLISHED,
            'status_requested' => BlogArticle::STATUS_REQUESTED,
            'status_rejected' => BlogArticle::STATUS_REJECTED,
            'filtered_status' => $filtered_status,
            'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        ]);
    }

    public function create()
    {
        $blog_categories = BlogCategory::where('type', BlogCategory::BLOG)->get();
        return view($this->themePage('blog_article.add'), [
            'blog_categories' => $blog_categories,
        ]);
    }

    public function store(Request $request)
    {
        $allowed_actions = ['draft', 'publish'];
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:blog_article_translations,slug',
            'content' => 'required',
            'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::BLOG,
            'featured_image' => 'sometimes|url',
            'action' => 'required|in:' . implode(',', $allowed_actions),
        ]);

        $error_redirect = redirect(localizedAdminURL('blog/articles/add'))->withInput();
        if ($validator->fails()) {
            return $error_redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $blog_article = new BlogArticle();
            $blog_article->auth_id = $this->auth_user->id;
            $blog_article->type = BlogArticle::TYPE_POST;
            $blog_article->featured_image = $request->input('featured_image', '');
            switch ($request->input('action')) {
                case 'publish':
                    $blog_article->status = BlogArticle::STATUS_PUBLISHED;
                    break;
                default:
                    $blog_article->status = BlogArticle::STATUS_DRAFT;
                    break;
            }
            // trans to international locale
            $trans = $blog_article->translateOrNew(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $trans->title = $request->input('title');
            $trans->slug = $request->input('slug');
             $trans->meta_description = $request->input('meta_description');
            $trans->content = clean($request->input('content'), 'blog');

            $blog_article->save();
            $blog_article->categories()->attach($request->input('categories'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $error_redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);

        }
        return redirect(localizedAdminURL('blog/articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $blog_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->firstOrFail();

        $blog_article_author = $blog_article->author;
        $is_author = $this->auth_user->id == $blog_article_author->id;

        if (!$is_author) { // must be author
            if (!($blog_article->status == BlogArticle::STATUS_REQUESTED || $blog_article->status == BlogArticle::STATUS_PUBLISHED)) {
                // if not author, must be blog editor (always true), and the article must be requested or published
                abort(404); // no permission to edit
            }
        }

        $can_reject = !$is_author && !$blog_article_author->hasRole(['blog-editor', 'blog-contributor']);

        return view($this->themePage('blog_article.edit'), [
            'blog_article' => $blog_article,
            'trans_blog_article' => $blog_article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE),
            'blog_categories' => BlogCategory::where('type', BlogCategory::BLOG)->get(),
            'article_categories' => $blog_article->categories,
            'is_author' => $is_author,
            'can_reject' => $can_reject,
            'status_draft' => BlogArticle::STATUS_DRAFT,
            'status_published' => BlogArticle::STATUS_PUBLISHED,
            'status_requested' => BlogArticle::STATUS_REQUESTED,
            'status_rejected' => BlogArticle::STATUS_REJECTED,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $blog_article = BlogArticle::where('id', $request->input('id'))->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->firstOrFail();

        $blog_article_author = $blog_article->author;
        $is_author = $this->auth_user->id == $blog_article_author->id;
        $can_reject = !$is_author && $this->auth_user->hasRole('blog-editor') &&
            !$blog_article_author->hasRole(['blog-editor', 'blog-contributor']);
        $allowed_actions = ['publish'];
        if ($is_author) {
            $allowed_actions[] = 'draft';
        }
        if ($can_reject) {
            $allowed_actions[] = 'reject';
        }
        $validator = Validator::make($request->all(), [
            'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::BLOG,
            'title' => 'required',
            'slug' => 'required|unique:blog_article_translations,slug,' . $blog_article->id . ',art_id',
            'content' => 'required',
            'featured_image' => 'sometimes|url',
            'action' => 'required|in:' . implode(',', $allowed_actions),
        ]);

        $redirect = redirect(localizedAdminURL('blog/articles/{id}/edit', ['id' => $blog_article->id]));
        if ($validator->fails()) {
            return $redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $blog_article->featured_image = $request->input('featured_image', '');
            switch ($request->input('action')) {
                case 'publish':
                    $blog_article->status = BlogArticle::STATUS_PUBLISHED;
                    break;
                case 'reject':
                    $blog_article->status = BlogArticle::STATUS_REJECTED;
                    break;
                case 'draft':
                    $blog_article->status = BlogArticle::STATUS_DRAFT;
                    break;
            }
            $trans = $blog_article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $trans->title = $request->input('title');
            $trans->slug = $request->input('slug');
            $trans->meta_description = $request->input('meta_description');
            $trans->content = clean($request->input('content'), 'blog');

            $blog_article->save();
            $blog_article->categories()->sync($request->input('categories'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);
        }

        if ($blog_article->status == BlogArticle::STATUS_REJECTED && !$is_author) {
            return redirect(localizedAdminURL('blog/articles'));
        }

        return $redirect;
    }

    public function destroy(Request $request, $id)
    {
        $blog_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->firstOrFail();

        $redirect_url = localizedAdminURL('blog/articles');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        if ($blog_article->auth_id != $this->auth_user->id) {
            return redirect($redirect_url)->withErrors([trans('error.not_author')]);
        }
        return $blog_article->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }
}