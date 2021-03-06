<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','year','sinopsis','duration','type','image','file','trailer','season','chapter'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idVideo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function genere() {
        return $this->hasManyThrough(genre::class, genreXvideo::class);
    }


    
    public function scopeType($query,$type){
        return $query->where('type',$type);   
    }

    public function scopeJoinGeneres($query, $idGen){
        return $query->rightJoin('GenreXVideo', 'videos.idVideo', '=' ,'GenreXVideo.idVideo')->where("GenreXVideo.idGenere", $idGen);   
    }

    public function scopeTitle($query, $partOfTitle){
        return $query->where('title', 'like', '%'.$partOfTitle.'%');   
    }
    
    public function scopePelis($query){
        return $query->where('type',"movie");   
    }

    public function scopeVideos($query) {
        return $query;
    }

    public function scopeSeries($query) {
        return $query->where('type', 'serie')->where('season', 0)->where('chapter', 0);
    }

    public function findById($query, $id) {
        return $query->where('idVideo', $id);
    }

    public function scopeFindByTitle($query, $title) {
        return $query->where('title', '=', $title);
    }

}
