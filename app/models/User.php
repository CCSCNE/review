<?php


use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $fillable = array('email', 'password');

    public function submissions() {
        return $this->hasMany('Submission');
    }

    public function keywords() {
        return $this->morphToMany('Keyword', 'keywordable')->withTimestamps();
    }

    public function categoriesReviewing() {
        return $this->belongsToMany('Category', 'reviewers')->withTimestamps();
    }

    public function reviews() {
        return $this->hasMany('Review');
    }

    public function categoriesChairing() {
        return $this->belongsToMany('Category', 'chairs')->withTimestamps();
    }

    public function documentsDownloaded() {
        return $this->belongsToMany('Document', 'downloads')->withTimestamps();
    }
}
