<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function newsindex()
    {
        $allNews = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'News')
            ->select('a.*', 'b.name as full_name')
            ->orderBy('date_posted', 'desc')
            ->paginate(10);

        return view('article.news.index', [
            'allNews' => $allNews,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function newsshow($id)
    {
        $showNews = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'News')
            ->where('a.id', $id)
            ->select('a.*', 'b.name as full_name')
            ->first();

        return view('article.news.show', [
            'showNews' => $showNews,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function announcementindex()
    {
        $allAnnouncements = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'Announcement')
            ->select('a.*', 'b.name as full_name')
            ->orderBy('date_posted', 'desc')
            ->paginate(10);

        return view('article.announcement.index', [
            'allAnnouncements' => $allAnnouncements,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function announcementshow($id)
    {
        $showAnnouncements = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'Announcement')
            ->where('a.id', $id)
            ->select('a.*', 'b.name as full_name')
            ->first();

        return view('article.announcement.show', [
            'showAnnouncements' => $showAnnouncements,
        ]);
    }

    public function guideindex()
    {
        $allGuides = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'Guide')
            ->select('a.*', 'b.name as full_name')
            ->orderBy('date_posted', 'desc')
            ->paginate(10);

        return view('article.guide.index', [
            'allGuides' => $allGuides,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function guideshow($id)
    {
        $showGuides = DB::connection('mysql_secondary')
            ->table('articles as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->where('a.type', 'Guide')
            ->where('a.id', $id)
            ->select('a.*', 'b.name as full_name')
            ->first();

        return view('article.guide.show', [
            'showGuides' => $showGuides,
        ]);
    }
}
