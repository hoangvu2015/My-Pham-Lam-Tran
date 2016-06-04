<?php

namespace Antoree\Console\Commands;

use Illuminate\Console\Command;

use Antoree\Models\BlogArticle;

class UpdateViewBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:views_blog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'random chọn 1 số từ 500 -> 1000 insert số view vào các bài viết cũ .';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start update views blog !!');

        $blogs = new BlogArticle();
        $blogs = $blogs->OfBlog()->get();

        foreach ($blogs as $key => $value) {
            $trans_article = $value->translate('--');
            
            if($trans_article->id == 295){
                $value->views = 1062;
                $value->save();
            }else if($trans_article->id == 287){
                $value->views = 496;
                $value->save();
            }else if($trans_article->id == 248){
                $value->views = 820;
                $value->save();
            }else if($trans_article->id == 273){
                $value->views = 894;
                $value->save();
            }else{
                $value->views = rand(100,300);
                $value->save();
            }
        }
        
        $this->info('Done update views blog !!');
    }
}
