<?php namespace ACR\Controllers;

use ACR\Models\Page;
use ACR\Services\Markdown;
use Controller;
use View;
use Event;
use Glottos;

class StaticPages extends Base {

	public function show($page)
	{
		$page = Page::where('name', $page)->first();

		$lang = strtolower(Glottos::getLocaleAsText());

		return View::make('technology.pages.static')
				->with('pages', Page::getForRendering())
				->with('title', Markdown::transform($page->{'title_'.$lang}))
				->with('page', Markdown::transform($page->{'text_'.$lang}));
	}

}
