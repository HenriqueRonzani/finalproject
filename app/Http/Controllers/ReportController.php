<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    
    public function reportPost(Post $post)
    {
        $reporterid = auth()->user()->id;

        $exists = Report::where('reportable_id', $post->id,)
        ->where('user_id', $reporterid)->exists();

        if (!$exists){
        
        $report = new Report([
            'user_id' => $reporterid,
            'status' => 'pending',
        ]);
        

        $post->reports()->save($report);
        $reportcount = $post->report_count +1;
        DB::table('posts')->where('id', $post->id)->update(['report_count' => $reportcount]);
        }

        return back();
    }

    public function reportComment(Comment $comment)
    {
        $reporterid = auth()->user()->id;
        
        $report = new Report([
            'user_id' => $reporterid,
            'status' => 'pending',
        ]);

        $comment->reports()->save($report);
        $reportcount = $comment->report_count +1;
        DB::table('comments')->where('id', $comment->id)->update(['report_count' => $reportcount]);

        return back();
    }
    
    public function deletePost(Post $post)
    {
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        $post->delete();
        Report::where('reportable_type', 'App\Models\Post')->where('reportable_id', $post->id)->update(['status' => 'solved']);
        return back();
    }
    
    public function ignorePost(Post $post)
    {
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        Report::where('reportable_type', 'App\Models\Post')->where('reportable_id', $post->id)->update(['status' => 'solved']);
        return back();
    }

    public function deleteComment(Comment $comment)
    {
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        $comment->delete();
        Report::where('reportable_type', 'App\Models\Comment')->where('reportable_id', $comment->id)->update(['status' => 'solved']);
        return back();
    }
    
    public function ignoreComment(Comment $comment)
    {
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        Report::where('reportable_type', 'App\Models\Comment')->where('reportable_id', $comment->id)->update(['status' => 'solved']);
        return back();
    }
}
