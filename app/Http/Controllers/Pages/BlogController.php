<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\BlogArticle;
use Antoree\Models\BlogCategory;
use Antoree\Models\EmailSubscribe;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\Review;
use Antoree\Models\User;
use Illuminate\Http\Request;
use Antoree\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends ViewController
{
    protected function ogList($articles)
    {
        $images = [appLogo()];
        foreach ($articles as $article) {
            if (!empty($article->featured_image)) {
                $images[] = $article->featured_image;
            }
        }
        add_filter('open_graph_tags_before_render', new CallableObject(function ($data) use ($images) {
            $data['og:image'] = $images;
            return $data;
        }));
    }

    public function index(Request $request)
    {
        $articles = !$this->is_auth ?
        BlogArticle::ofBlog()->published()->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE) :
        BlogArticle::ofBlog()->listForUser($this->auth_user)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

        $query = new QueryStringBuilder([
            'page' => $articles->currentPage()
            ], localizedURL('blog'));

        $can_add = $this->is_auth && $this->auth_user->can('compose-blog-articles');
        $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');

        $this->theme->title([trans('pages.page_blog_title_meta')],false);
        $this->theme->description(trans('pages.page_blog_desc'));
        $this->ogList($articles);

        return view($this->themePage('blog.index'), [
            'not_found' => $articles->count() <= 0,
            'articles' => $articles,
            'query' => $query,
            'page_helper' => new PaginationHelper($articles->lastPage(), $articles->currentPage(), $articles->perPage(),
                isPhoneClient() ? AppHelper::ON_PHONE_PAGINATION_ITEMS : AppHelper::DEFAULT_PAGINATION_ITEMS),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
            'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
            'can_add' => $can_add,
            'can_edit' => $can_edit,
            'status_draft' => BlogArticle::STATUS_DRAFT,
            'status_published' => BlogArticle::STATUS_PUBLISHED,
            'status_requested' => BlogArticle::STATUS_REQUESTED,
            'status_rejected' => BlogArticle::STATUS_REJECTED,
            'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
            ]);
    }

    public function create(Request $request)
    {
        $blog_categories = BlogCategory::where('type', BlogCategory::BLOG)->get();
        $can_publish = $this->auth_user->hasRole(['blog-editor', 'blog-contributor']);
        $can_request = !$can_publish && $this->auth_user->can('compose-blog-articles');
        if ($can_request && $this->auth_user->hasRole('teacher')) {
            $can_request = $this->auth_user->teacherProfile->isPublicizable();
        }

        $this->theme->title([trans('pages.page_blogpost_title_meta')],false);
        $this->theme->description(trans('pages.page_home_desc_meta'));

        return view($this->themePage('blog.add'), [
            'blog_categories' => $blog_categories,
            'status_draft' => BlogArticle::STATUS_DRAFT,
            'status_published' => BlogArticle::STATUS_PUBLISHED,
            'status_requested' => BlogArticle::STATUS_REQUESTED,
            'can_publish' => $can_publish,
            'can_request' => $can_request,
            ]);
    }

    public function store(Request $request)
    {
        // $can_publish = $this->auth_user->hasRole(['blog-editor', 'blog-contributor'])||$this->auth_user->can('compose-blog-articles');
        // $can_request = !$can_publish && $this->auth_user->can('compose-blog-articles');
        // if ($can_request && $this->auth_user->hasRole('teacher')) {
        //     $can_request = $this->auth_user->teacherProfile->isPublicizable();
        // }
        $allowed_actions = ['draft'];
        // if ($can_publish) {
        $allowed_actions[] = 'publish';
        // }
        // if ($can_request) {
        //     $allowed_actions[] = 'request';
        // }
         // dd($request->all(),$allowed_actions);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:blog_article_translations,slug',
            'content' => 'required',
            'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::BLOG,
            'featured_image' => 'sometimes|url',
            'action' => 'required|in:' . implode(',', $allowed_actions),
            ]);

        $error_redirect = redirect(localizedURL('blog/add'))->withInput();
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
                case 'request':
                $blog_article->status = BlogArticle::STATUS_REQUESTED;
                break;
                default:
                $blog_article->status = BlogArticle::STATUS_DRAFT;
                break;
            }
            $trans = $blog_article->translateOrNew(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $trans->title = $request->input('title');
            $trans->slug = $request->input('slug');
            $trans->content = clean($request->input('content'), 'blog');
            // dd($blog_article);
            $blog_article->save();
            $blog_article->categories()->attach($request->input('categories'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $error_redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);

        }
        if(isset($trans->id) && isset($trans->slug)){
            return redirect(localizedURL('blog/{slug}-{id}', ['id'=>$trans->id,'slug' => $trans->slug]));
        }
        return redirect(localizedURL('blog'));
    }

    public function edit(Request $request, $id)
    {
        $blog_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->firstOrFail();

        $blog_article_author = $blog_article->author;
        $is_author = $this->auth_user->id == $blog_article_author->id;

        if (!$is_author) { // must be author
            if (!($this->auth_user->hasRole('blog-editor') && ($blog_article->status == BlogArticle::STATUS_REQUESTED ||
                $blog_article->status == BlogArticle::STATUS_PUBLISHED))
            ) { // if not author, must be blog editor, and the article must be requested or published
                abort(404); // no permission to edit
        }
    }

    $can_publish = $this->auth_user->hasRole(['blog-editor', 'blog-contributor']);
    $can_request = !$can_publish && $this->auth_user->can('compose-blog-articles');
    if ($can_request && $this->auth_user->hasRole('teacher')) {
        $can_request = $this->auth_user->teacherProfile->isPublicizable();
    }
    $can_reject = !$is_author && $this->auth_user->hasRole('blog-editor') &&
    !$blog_article_author->hasRole(['blog-editor', 'blog-contributor']);
    return view($this->themePage('blog.edit'), [
        'blog_article' => $blog_article,
        'trans_blog_article' => $blog_article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE),
        'blog_categories' => BlogCategory::where('type', BlogCategory::BLOG)->get(),
        'article_categories' => $blog_article->categories,
        'is_author' => $is_author,
        'can_publish' => $can_publish,
        'can_request' => $can_request,
        'can_reject' => $can_reject,
        'status_draft' => BlogArticle::STATUS_DRAFT,
        'status_published' => BlogArticle::STATUS_PUBLISHED,
        'status_requested' => BlogArticle::STATUS_REQUESTED,
        'status_rejected' => BlogArticle::STATUS_REJECTED,
        ]);
}

public function update(Request $request)
{
    $blog_article = BlogArticle::where('id', $request->input('id'))->whereHas('categories', function ($query) {
        $query->where('type', BlogCategory::BLOG);
    })->firstOrFail();

    $blog_article_author = $blog_article->author;
    $is_author = $this->auth_user->id == $blog_article_author->id;
        // $can_publish = $this->auth_user->hasRole(['blog-editor', 'blog-contributor']);
        // $can_request = !$can_publish && $this->auth_user->can('compose-blog-articles');
        // if ($can_request && $this->auth_user->hasRole('teacher')) {
        //     $can_request = $this->auth_user->teacherProfile->isPublicizable();
        // }
        // if ($can_request && in_array($blog_article->status, [BlogArticle::STATUS_REQUESTED, BlogArticle::STATUS_PUBLISHED])) {
        //     $can_request = false;
        // }
        // $can_reject = !$is_author && $this->auth_user->hasRole('blog-editor') &&
        //     !$blog_article_author->hasRole(['blog-editor', 'blog-contributor']);
        // $allowed_actions = [];
        // if ($is_author) {
        //     $allowed_actions[] = 'draft';
        // }
        // if ($can_publish) {
        //     $allowed_actions[] = 'publish';
        // }
        // if ($can_reject) {
        //     $allowed_actions[] = 'reject';
        // }
        // if ($can_request) {
        //     $allowed_actions[] = 'request';
        // }
        // dd($request->all(),$allowed_actions);
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'slug' => 'required|unique:blog_article_translations,slug,' . $blog_article->id . ',art_id',
        'content' => 'required',
        'categories' => 'required|exists:blog_categories,id,type,' . BlogCategory::BLOG,
        'featured_image' => 'sometimes|url',
            // 'action' => 'required|in:' . implode(',', $allowed_actions),
        ]);

    $redirect = redirect(localizedURL('blog/{id}/edit', ['id' => $blog_article->id]));
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
            case 'request':
            $blog_article->status = BlogArticle::STATUS_REQUESTED;
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
        $trans->content = clean($request->input('content'), 'blog');
        $blog_article->save();
        $blog_article->categories()->sync($request->input('categories'));

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        return $redirect->withErrors([trans('error.database_insert') . ' (' . $e->getMessage() . ')']);
    }

    if ($blog_article->status == BlogArticle::STATUS_REJECTED && !$is_author) {
        return redirect(localizedURL('blog'));
    }

    return $redirect;
}

public function destroy(Request $request, $id)
{
    $blog_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
        $query->where('type', BlogCategory::BLOG);
    })->firstOrFail();

    $redirect_url = localizedURL('blog/author/{id}', ['id' => $blog_article->auth_id]);
    $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
    if (!empty($rdr)) {
        $redirect_url = $rdr;
    }

    if ($blog_article->auth_id != $this->auth_user->id) {
        return redirect($redirect_url)->withErrors([trans('error.not_author')]);
    }
    return $blog_article->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
}

public function indexByCategory(Request $request, $id)
{
    $category = BlogCategory::findOrFail($id);
    if ($category->type != BlogCategory::BLOG) {
        abort(404);
    }

    $articles = !$this->is_auth ?
    $category->articles()->published()->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE) :
    $category->articles()->listForUser($this->auth_user)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

    $query = new QueryStringBuilder([
        'page' => $articles->currentPage()
        ], localizedURL('blog/category/{id}', ['id' => $category->id]));
    $can_add = $this->is_auth && $this->auth_user->can('compose-blog-articles');
    $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');

    $this->theme->title([trans('pages.page_teachers_title_meta'), trans_choice('label.category', 1), $category->name]);
    $this->theme->description($category->description);
    $this->ogList($articles);

    return view($this->themePage('blog.by_category'), [
        'not_found' => $articles->count() <= 0,
        'articles' => $articles,
        'query' => $query,
        'page_helper' => new PaginationHelper($articles->lastPage(), $articles->currentPage(), $articles->perPage(),
            isPhoneClient() ? AppHelper::ON_PHONE_PAGINATION_ITEMS : AppHelper::DEFAULT_PAGINATION_ITEMS),
        'rdr_param' => rdrQueryParam($request->fullUrl()),
        'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
        'by_category' => $category,
        'can_add' => $can_add,
        'can_edit' => $can_edit,
        'status_draft' => BlogArticle::STATUS_DRAFT,
        'status_published' => BlogArticle::STATUS_PUBLISHED,
        'status_requested' => BlogArticle::STATUS_REQUESTED,
        'status_rejected' => BlogArticle::STATUS_REJECTED,
        'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        ]);
}

public function viewByCategory(Request $request, $slug, $id)
{
    $arr = explode('-', $id);
        // dd(intval(last($arr)));
    $category = BlogCategory::whereTranslation('cat_id', intval(last($arr)))->firstOrFail();
        // $category = BlogCategory::whereTranslation('slug', $slug)->firstOrFail();
    if ($category->type != BlogCategory::BLOG) {
        abort(404);
    }

    $articles = !$this->is_auth ?
    $category->articles()->published()->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE) :
    $category->articles()->listForUser($this->auth_user)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

    $query = new QueryStringBuilder([
        'page' => $articles->currentPage()
        ], localizedURL('blog/category/{id}', ['id' => $category->id]));
    $can_add = $this->is_auth && $this->auth_user->can('compose-blog-articles');
    $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');
        // $this->theme->title([trans('pages.page_teachers_title_meta'), trans_choice('label.category', 1), $category->name]);
    $this->theme->title([$category->name],false);
    $this->theme->description($category->description);
    $this->ogList($articles);
    return view($this->themePage('blog.by_category'), [
        'not_found' => $articles->count() <= 0,
        'articles' => $articles,
        'query' => $query,
        'page_helper' => new PaginationHelper($articles->lastPage(), $articles->currentPage(), $articles->perPage(),
            isPhoneClient() ? AppHelper::ON_PHONE_PAGINATION_ITEMS : AppHelper::DEFAULT_PAGINATION_ITEMS),
        'rdr_param' => rdrQueryParam($request->fullUrl()),
        'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
        'by_category' => $category,
        'can_add' => $can_add,
        'can_edit' => $can_edit,
        'status_draft' => BlogArticle::STATUS_DRAFT,
        'status_published' => BlogArticle::STATUS_PUBLISHED,
        'status_requested' => BlogArticle::STATUS_REQUESTED,
        'status_rejected' => BlogArticle::STATUS_REJECTED,
        'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        ]);
}

public function indexByAuthor(Request $request, $id)
{
    $author = User::findOrFail($id);

    $articles = !$this->is_auth ?
    $author->articles()->ofBlog()->published()->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE) :
    $author->articles()->ofBlog()->listForUser($this->auth_user)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);

    $query = new QueryStringBuilder([
        'page' => $articles->currentPage()
        ], localizedURL('blog/author/{id}', ['id' => $author->id]));

    $can_add = $this->is_auth && $this->auth_user->can('compose-blog-articles');
    $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');

    $this->theme->title([trans('pages.page_teachers_title_meta'), trans('label.author'), $author->name]);
    $this->theme->description(trans('pages.page_blog_desc'));
    $this->ogList($articles);

    return view($this->themePage('blog.by_author'), [
        'id' => $id,
        'not_found' => $articles->count() <= 0,
        'articles' => $articles,
        'query' => $query,
        'page_helper' => new PaginationHelper($articles->lastPage(), $articles->currentPage(), $articles->perPage(),
            isPhoneClient() ? AppHelper::ON_PHONE_PAGINATION_ITEMS : AppHelper::DEFAULT_PAGINATION_ITEMS),
        'rdr_param' => rdrQueryParam($request->fullUrl()),
        'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
        'by_author' => $author,
        'can_add' => $can_add,
        'can_edit' => $can_edit,
        'status_draft' => BlogArticle::STATUS_DRAFT,
        'status_published' => BlogArticle::STATUS_PUBLISHED,
        'status_requested' => BlogArticle::STATUS_REQUESTED,
        'status_rejected' => BlogArticle::STATUS_REJECTED,
        'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        ]);
}

public function viewByAuthor(Request $request, $slug)
{
//        return view($this->themePage('blog.by_author'), [
//
//        ]);
}

protected function ogSingle($featured_image, $content)
{
    $imageUrls = extractImageUrls($content);
    if (!empty($featured_image)) {
        array_unshift($imageUrls, $featured_image);
    }
    if (count($imageUrls) > 0) {
        add_filter('open_graph_tags_before_render', new CallableObject(function ($data) use ($imageUrls) {
            $data['og:image'] = $imageUrls;
            return $data;
        }));
    }
}

public function layoutSingle(Request $request, $id)
{
    $article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
        $query->where('type', BlogCategory::BLOG);
    })->first();

    $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');

    $is_author = false;
    $author = null;
    $categories = null;
    $reviews = null;
    $count_reviews = 0;
    $featured_image = null;
    if ($article->status != BlogArticle::STATUS_PUBLISHED &&
        ($this->is_auth && $article->auth_id != $this->auth_user->id)
        ) {
        $article = null;
}
$trans_article = null;
if ($article != null) {
    $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
    $author = $article->author;
    $is_author = $this->is_auth && $author->id == $this->auth_user->id;
    $categories = $article->categories;
    $featured_image = $article->featured_image;
    $reviews = $is_author || ($this->is_auth && $this->auth_user->hasRole('blog-editor')) ?
    $article->reviews()->orderBy('created_at', 'desc')->get() :
    $article->reviews()->approved()->orderBy('created_at', 'desc')->get();
    $count_reviews = $reviews->count();

    $this->theme->title([$trans_article->title], false);
    $this->theme->description($trans_article->content);
    if($trans_article->meta_description){
        $this->theme->description($trans_article->meta_description);
    }
    
    $this->ogSingle($featured_image, $trans_article->content);
}

return view($this->themePage('blog.single'), [
    'not_found' => $article == null,
    'is_author' => $is_author,
    'author' => $author,
    'article' => $article,
    'trans_article' => $trans_article,
    'categories' => $categories,
    'reviews' => $reviews,
    'count_reviews' => $count_reviews,
    'max_rate' => Review::MAX_RATE,
//            'parallax_image' => $featured_image,
    'can_edit' => $can_edit,
    'status_draft' => BlogArticle::STATUS_DRAFT,
    'status_published' => BlogArticle::STATUS_PUBLISHED,
    'status_requested' => BlogArticle::STATUS_REQUESTED,
    'status_rejected' => BlogArticle::STATUS_REJECTED,
    ]);
}

public function viewSingle(Request $request,$slug,$id)
{
    $id = intval(last(explode('-', $id)));
    $article = BlogArticle::whereTranslation('art_id', $id)->whereHas('categories', function ($query) {
        $query->where('type', BlogCategory::BLOG);
    })->first(); 

    if($article===null){
        $url = $slug.'-'.$id;
        $idGet = explode('-', $url);
        $idGet = (int)$idGet[count($idGet)-1];
        $article = BlogArticle::whereTranslation('id', $idGet)->whereHas('categories', function ($query) {
           $query->where('type', BlogCategory::BLOG);
       })->first();
    }
    
    $can_edit = $this->is_auth && $this->auth_user->hasRole('blog-editor');

    $is_author = false;
    $author = null;
    $categories = null;
    $reviews = null;
    $count_reviews = 0;
    $featured_image = null;
    $trans_article = null;
    $most_read = null;
    if ($article != null) {
        $author = $article->author()->first();
        $article->views += 1;
        $article->save();

        $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
        $categories = $article->categories;
        $featured_image = $article->featured_image;
        $reviews = $is_author || ($this->is_auth && $this->auth_user->hasRole('blog-editor')) ?
        $article->reviews()->orderBy('created_at', 'desc')->get() :
        $article->reviews()->approved()->orderBy('created_at', 'desc')->get();
        $count_reviews = $reviews->count();

        $this->theme->title([$trans_article->title], false);
        $this->theme->description($trans_article->content);
        if($trans_article->meta_description){
            $this->theme->description($trans_article->meta_description);
        }
        $this->ogSingle($featured_image, $trans_article->content);

        $most_read = $categories->first()->articles()
        ->where('id','<>',$article->id)
        ->ofBlog()
        ->orderBy('views','desc')
        ->take(6)->get();
    }else{
        abort(404);
    }
    $createdAt = $article->created_at->format('Y-m-d H:i');

    return view($this->themePage('blog.single'), [
        'createdAt'=>$createdAt,
        'author' => $author,
        'not_found' => $article == null,
        'article' => $article,
        'trans_article' => $trans_article,
        'categories' => $categories,
        'reviews' => $reviews,
        'count_reviews' => $count_reviews,
        'most_read' => $most_read,
        'slug' => $slug,
        'id' => $id,
        'max_rate' => Review::MAX_RATE,
        'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        'can_edit' => $can_edit,
        ]);
}
public function subscribeEmail(Request $request)
{
    $email_subcribe_request = $request->all();
    $subscribe_email_key = false;
    $email = $email_subcribe_request['email'];
    if (isset($email) && $email != "") {
        $email_subcribe_obj = new EmailSubscribe;
        if(empty($email_subcribe_obj->where('email',$email)->get()->toArray())){
           $email_subcribe_obj->email = $email;
           $email_subcribe_obj->name = "";
           $email_subcribe_obj->phone = "";
           $user_id = User::where('email',$email)->pluck('id');
           if($user_id == null) $user_id = "";
           $email_subcribe_obj->user_id = $user_id;
           $email_subcribe_obj->save();
       }
       $subscribe_email_key = true;
   }
   return redirect($email_subcribe_request['link'])->with('subscribe_email_key',$subscribe_email_key);
}
public function addReview(Request $request, $id)
{
    $article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
        $query->where('type', BlogCategory::BLOG);
    })->first();
    $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);

    $validator = $this->is_auth ? Validator::make($request->all(), [
        'review' => 'required',
        'rate' => 'sometimes|integer'
        ]) : Validator::make($request->all(), [
        'name' => 'required|max:255',
        'email' => 'required|max:255',
        'website' => 'sometimes|url',
        'review' => 'required',
        'rate' => 'sometimes|integer'
        ]);

        $error_rdr = redirect(localizedURL('blog/view/{slug}', ['slug' => $trans_article->slug]) . '#comment-section')
        ->withInput();

        if ($validator->fails()) {
            return $error_rdr->withErrors($validator, 'review');
        }

        DB::beginTransaction();
        try {
            $review = $this->is_auth ? Review::create([
                'user_id' => $this->auth_user->id,
                'content' => escHtml($request->input('review')),
                'rate' => $request->input('rate', 0),
                'approved' => true
                ]) : Review::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'website' => $request->input('website', ''),
                'content' => escHtml($request->input('review')),
                'rate' => $request->input('rate', 0),
                'approved' => true
                ]);

                $article->reviews()->attach($review->id);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();

                return $error_rdr->withErrors([trans('error.database_insert') . '(' . $ex->getMessage() . ')'], 'review');
            }

            return redirect(localizedURL('blog/view/{slug}', ['slug' => $trans_article->slug]) . '#comment-' . $review->id);
        }

        public function destroyReview(Request $request, $id, $review_id)
        {
            $article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
                $query->where('type', BlogCategory::BLOG);
            })->first();
            $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $review = $article->reviews()->findOrFail($review_id);

            $redirect_url = localizedURL('blog/view/{slug}', ['slug' => $trans_article->slug]) . '#comment-section';
            $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
            if (!empty($rdr)) {
                $redirect_url = $rdr;
            }

            DB::beginTransaction();
            try {
                $article->reviews()->detach($review->id);
                $review->delete();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();

                return redirect($redirect_url)->withErrors([trans('error.database_delete') . '(' . $ex->getMessage() . ')'], 'review');
            }

            return redirect($redirect_url);
        }

        public function approveReview(Request $request, $id, $review_id)
        {
            $article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
                $query->where('type', BlogCategory::BLOG);
            })->first();
            $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $review = $article->reviews()->findOrFail($review_id);

        if ($article->auth_id != $this->auth_user->id) { // need to be owner
            abort(404);
        }

        $redirect_url = localizedURL('blog/view/{slug}', ['slug' => $trans_article->slug]) . '#comment-' . $review->id;
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        $review->approved = true;

        return $review->save() === true ? redirect($redirect_url) :
        redirect($redirect_url)->withErrors([trans('error.database_update')], 'review');
    }

    public function rejectReview(Request $request, $id, $review_id)
    {
        $article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->first();
        $trans_article = $article->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
        $review = $article->reviews()->findOrFail($review_id);

        if ($article->auth_id != $this->auth_user->id) { // need to be owner
            abort(404);
        }

        $redirect_url = localizedURL('blog/view/{slug}', ['slug' => $trans_article->slug]) . '#comment-' . $review->id;
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        $review->approved = false;

        return $review->save() === true ? redirect($redirect_url) :
        redirect($redirect_url)->withErrors([trans('error.database_update')], 'review');
    }
}
