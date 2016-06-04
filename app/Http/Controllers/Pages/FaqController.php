<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\BlogArticle;
use Antoree\Models\BlogArticleTranslation;
use Antoree\Models\BlogCategory;
use Antoree\Models\BlogCategoryTranslation;
use Illuminate\Http\Request;
use Antoree\Http\Requests;

class FaqController extends ViewController
{
    public function layoutCompound(Request $request, $id = null)
    {
        $categories = BlogCategory::ofFaq()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $faq_article = null;
        $faq_menu = [];
        if ($categories->count() > 0) {
            $first = true;
            foreach ($categories as $category) {
                $faq_menu[$category->id] = [
                'name' => $category->name,
                'children' => [],
                ];

                $articles = $category->articles()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
                foreach ($articles as $article) {
                    $faq_menu[$category->id]['children'][] = [
                    'name' => $article->title,
                    'link' => localizedURL('faq/{id?}', ['id' => $article->id]),
                    'active' => (empty($id) && $first) || ($id == $article->id),
                    ];

                    if ($first) {
                        $faq_article = $article;
                        $first = false;
                    }
                }
            }

            if (!empty($id)) {
                $faq_article = BlogArticle::where('id', $id)->whereHas('categories', function ($query) {
                    $query->where('type', BlogCategory::FAQ);
                })->firstOrFail();
            }
        }

        return view($this->themePage('faq'), [
            'faq_menu' => $faq_menu,
            'faq_article' => $faq_article,
            ]);
    }

    public function viewCompound(Request $request, $slug = null, $id = null)
    {
        $arr1 = explode('-', $slug);
        $arr2 = explode('-', $id);
        $arr = array_merge($arr1,$arr2);
        array_pop($arr);
        $slug = implode('-',(array)$arr);
        // dd($slug);
        $empty_slug = empty($slug);
        $categories = BlogCategory::ofFaq()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $faq_article = null;
        $faq_menu = [];
        if ($categories->count() > 0) {
            $first = true;
            foreach ($categories as $category) {
                $faq_menu[$category->id] = [
                'name' => $category->name,
                'children' => [],
                ];

                $articles = $category->articles()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
                foreach ($articles as $article) {
                    $item = [
                    'name' => $article->title,
                    'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                    'active' => ($empty_slug && $first) || $article->translations->contains('slug', $slug),
                    ];
                    $faq_menu[$category->id]['children'][] = $item;

                    if ($item['active']) {
                        $faq_article = $article;
                    }

                    if ($first) {
                        $first = false;
                    }
                }
            }
        }

        if (!(isEmptyAll($faq_menu) || empty($faq_article))) {
            $this->theme->title($faq_article->title);
            $this->theme->description($faq_article->content);
        }

        return view($this->themePage('faq'), [
            'faq_menu' => $faq_menu,
            'faq_article' => $faq_article,
            ]);
    }

    public function viewTmp(Request $request, $slug = null)
    {
        $empty_slug = empty($slug);
        $categories = BlogCategory::ofFaq()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $faq_article = null;
        $faq_menu = [];
        if ($categories->count() > 0) {
            $first = true;
            foreach ($categories as $category) {
                $faq_menu[$category->id] = [
                'name' => $category->name,
                'children' => [],
                ];

                $articles = $category->articles()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
                foreach ($articles as $article) {
                    $item = [
                    'name' => $article->title,
                    'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                    'active' => ($empty_slug && $first) || $article->translations->contains('slug', $slug),
                    ];
                    $faq_menu[$category->id]['children'][] = $item;

                    if ($item['active']) {
                        $faq_article = $article;
                    }

                    if ($first) {
                        $first = false;
                    }
                }
            }
        }

        if (!(isEmptyAll($faq_menu) || empty($faq_article))) {
            $this->theme->title($faq_article->title);
            $this->theme->description($faq_article->content);
        }

        return view($this->themePage('faq'), [
            'faq_menu' => $faq_menu,
            'faq_article' => $faq_article,
            ]);
    }

    public function viewPolicy(Request $request)
    {
       // dd('ok');
        $empty_slug = true;
        $categories = BlogCategory::ofFaq()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $faq_article = null;
        $faq_menu = [];
        if ($categories->count() > 0) {
            $first = true;
            foreach ($categories as $category) {
                $faq_menu[$category->id] = [
                'name' => $category->name,
                'children' => [],
                ];

                $articles = $category->articles()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
                foreach ($articles as $article) {
                    if($article->id == 6){
                        $item = [
                        'name' => $article->title,
                        'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                        'active' => true,
                        ];
                        // dd($article);
                    }else{
                        $item = [
                        'name' => $article->title,
                        'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                        'active' => false,
                        ];
                    }
                    
                    $faq_menu[$category->id]['children'][] = $item;

                    if ($item['active']) {
                        $faq_article = $article;
                    }

                    if ($first) {
                        $first = false;
                    }
                }
            }
        }

        if (!(isEmptyAll($faq_menu) || empty($faq_article))) {
            $this->theme->title($faq_article->title);
            $this->theme->description($faq_article->content);
        }

        return view($this->themePage('faq'), [
            'faq_menu' => $faq_menu,
            'faq_article' => $faq_article,
            ]);
    }

    public function viewService(Request $request)
    {
       // dd('ok');
        $empty_slug = true;
        $categories = BlogCategory::ofFaq()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $faq_article = null;
        $faq_menu = [];
        if ($categories->count() > 0) {
            $first = true;
            foreach ($categories as $category) {
                $faq_menu[$category->id] = [
                'name' => $category->name,
                'children' => [],
                ];

                $articles = $category->articles()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
                foreach ($articles as $article) {
                    if($article->id == 7){
                        $item = [
                        'name' => $article->title,
                        'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                        'active' => true,
                        ];
                        // dd($article);
                    }else{
                        $item = [
                        'name' => $article->title,
                        'link' => localizedURL('faq/view/{slug?}-{id}', ['slug' => $article->slug,'id'=>$article->id]),
                        'active' => false,
                        ];
                    }
                    
                    $faq_menu[$category->id]['children'][] = $item;

                    if ($item['active']) {
                        $faq_article = $article;
                    }

                    if ($first) {
                        $first = false;
                    }
                }
            }
        }

        if (!(isEmptyAll($faq_menu) || empty($faq_article))) {
            $this->theme->title($faq_article->title);
            $this->theme->description($faq_article->content);
        }

        return view($this->themePage('faq'), [
            'faq_menu' => $faq_menu,
            'faq_article' => $faq_article,
            ]);
    }
}
