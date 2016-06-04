<?php

namespace Antoree\Http\Controllers\admin;

use Antoree\Http\Controllers\MultipleLocaleContentController;
use Antoree\Models\BlogArticle;
use Antoree\Models\BlogCategory;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FaqArticleController extends MultipleLocaleContentController
{
    public function index(Request $request)
    {
        $faq_articles = BlogArticle::whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::FAQ);
        })->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $faq_articles->currentPage()
        ], localizedAdminURL('faq/articles'));
        return view($this->themePage('faq_article.list'), [
            'faq_articles' => $faq_articles,
            'query' => $query,
            'page_helper' => new PaginationHelper($faq_articles->lastPage(), $faq_articles->currentPage(), $faq_articles->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
        ]);
    }

    public function create()
    {
        $faq_categories = BlogCategory::where('type', BlogCategory::FAQ)->get();
        return view($this->themePage('faq_article.add'), [
            'faq_categories' => $faq_categories,
        ]);
    }

    public function store(Request $request)
    {
        $categories = $request->input('categories', []);

        $this->validateMultipleLocaleData($request, ['title', 'slug', 'content'], [
            'title' => 'required',
            'slug' => 'required|unique:blog_article_translations,slug',
            'content' => 'required'
        ], $data, $successes, $fails, $old);

        $error_redirect = redirect(localizedAdminURL('faq/articles/add'))
            ->withInput(array_merge([
                'categories' => $categories
            ], $old));

        if (count($successes) <= 0 && count($fails) > 0) {
            return $error_redirect->withErrors($fails[0]);
        }

        $validator = Validator::make($request->all(), [
            'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::FAQ
        ]);
        if ($validator->fails()) {
            return $error_redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $faq_article = new BlogArticle();
            $faq_article->auth_id = $this->auth_user->id;
            $faq_article->type = BlogArticle::TYPE_POST;
            $faq_article->status = BlogArticle::STATUS_PUBLISHED;
            foreach ($successes as $locale) {
                $transData = $data[$locale];
                $trans = $faq_article->translateOrNew($locale);
                $trans->title = $transData['title'];
                $trans->slug = $transData['slug'];
                $trans->content = clean($transData['content'], 'faq');
            }
            $faq_article->save();
            if (count($categories) > 0) {
                $faq_article->categories()->attach($categories);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $error_redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);

        }
        return redirect(localizedAdminURL('faq/articles'));
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
        $faq_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::FAQ);
        })->firstOrFail();

        return view($this->themePage('faq_article.edit'), [
            'faq_article' => $faq_article,
            'faq_categories' => BlogCategory::where('type', BlogCategory::FAQ)->get(),
            'article_categories' => $faq_article->categories
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
        $faq_article = BlogArticle::where('id', $request->input('id'))->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::FAQ);
        })->firstOrFail();

        $categories = $request->input('categories', []);

        $redirect = redirect(localizedAdminURL('faq/articles/{id}/edit', ['id' => $faq_article->id]));

        $this->validateMultipleLocaleData($request, ['title', 'slug', 'content'], [
            'title' => 'required',
            'slug' => 'required|unique:blog_article_translations,slug,' . $faq_article->id . ',art_id',
            'content' => 'required'
        ], $data, $successes, $fails, $old);
        if (count($successes) <= 0 && count($fails) > 0) {
            return $redirect->withErrors($fails[0]);
        }

        $validator = Validator::make($request->all(), [
            'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::FAQ
        ]);
        if ($validator->fails()) {
            return $redirect->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $faq_article->status = BlogArticle::STATUS_PUBLISHED;
            foreach ($successes as $locale) {
                $transData = $data[$locale];
                $trans = $faq_article->translateOrNew($locale);
                $trans->title = $transData['title'];
                $trans->slug = $transData['slug'];
                $trans->content = clean($transData['content'], 'faq');
            }
            if (count($categories) > 0) {
                $faq_article->categories()->sync($categories);
            } else {
                $faq_article->categories()->detach();
            }
            $faq_article->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);
        }
        return $redirect;
    }

    public function destroy(Request $request, $id)
    {
        $faq_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::FAQ);
        })->firstOrFail();

        $redirect_url = localizedAdminURL('faq/articles');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }
        return $faq_article->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }
}
