<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\BoardComment;
use App\Models\BoardCommentImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/boards.json')); //Obtiene el contenido del archivo JSON
        $boards = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/board_comments.json')); //Obtiene el contenido del archivo JSON
        $boardsComments = json_decode($jsonData, true); //Convierte el JSON en un array
        $jsonData = file_get_contents(resource_path('json/board_comment_images.json')); //Obtiene el contenido del archivo JSON
        $boardsCommentImages = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($boards as $board){
            Board::create([
                "title"             => $board["title"],
                "description"       => $board["description"],
                "game_release_id"   => $board["game_release_id"],
                "language_id"       => $board["language_id"],
                "user_id"           => $board["user_id"]
            ]);
        }
        foreach($boardsComments as $boardComment){
            BoardComment::create([
                "comment"       => $boardComment["comment"],
                "board_id"      => $boardComment["board_id"],
                "user_id"       => $boardComment["user_id"]
            ]);
        }
        foreach($boardsCommentImages as $boardCommentImage){
            BoardCommentImage::create([
                "url"             => $boardCommentImage["url"],
                "board_comment_id"  => $boardCommentImage["board_comment_id"]
            ]);
        }
    }
}
