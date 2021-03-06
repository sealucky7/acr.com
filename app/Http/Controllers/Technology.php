<?php namespace App\Http\Controllers;

use View;
use App\Data\Models\Article;
use App\Data\Models\Page;
use Glottos;
use Redirect;
use App\Services\RandomArticlePhoto;

class Technology extends Base {

	protected $article;

	public function __construct(Article $article)
	{
		$this->article = $article;
	}

	public function index()
	{

		return View::make('technology.pages.index')
				->with('articles', Article::published()->orderBy('created_at', 'desc')->get())
				->with('pageTitle', g('Recent Articles'))
				->with('summary', true);

	}

	public function show($slug, $language = null)
	{
		if ($language)
		{
			Glottos::setLocale($language);

			return Redirect::route('technology.articles.show', $slug);
		}

		if ($article = Article::findBySlug($slug))
		{
			return View::make('technology.pages.article')
					->with('article', $article)
					->with('photo', RandomArticlePhoto::random());
		}

		return Redirect::route('technology');
	}

	public function months($month, $year)
	{
		return View::make('technology.pages.index')
				->with('articles', Article::fromMonth($month, $year)->published()->orderBy('created_at', 'desc')->get())
				->with('pageTitle', g('Articles from ') . g(date("F", mktime(0, 0, 0, $month, 10))) . ' ' . $year )
				->with('summary', true);
	}

}
