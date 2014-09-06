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

    public function submissionsOwning() {
        return $this->submissions();
    }

    public function submissionsAuthoring() {
        return $this->submissions();
    }

    public function keywords() {
        return $this->morphToMany('Keyword', 'keywordable')->withTimestamps();
    }

    public function categoriesReviewing() {
        return $this->belongsToMany('Category', 'reviewers')->withTimestamps();
    }

    public function submissionsReviewing() {
        return $this->hasManyThrough('Submission', 'Review', 'user_id', 'id');
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

    public function is_chair_of(Category $category) {
        return $this->categoriesChairing()->get()->contains($category->id);
    }

    public function is_author_of(Submission $submission) {
        return $this->submissionsAuthoring()->get()->contains($submission->id);
    }

    public function has_submitted_to(Category $category) {
        return !$this->submissionsAuthoring()->where('category_id', $category->id)->get()->isEmpty();
    }

    public function is_reviewer_of(Submission $submission) {
        return $this->submissionsReviewing()->get()->contains($submission->id);
    }

    public function is_reviewer_for(Category $category) {
        return $this->categoriesReviewing()->get()->contains($category->id);
    }

    public function is_submitter_of(Submission $submission) {
        return $this->submissionsOwning()->get()->contains($submission->id);
    }

    public function is_uploader_of(Document $document) {
        return $this->id == $document->user_id;
    }

    public function has_downloaded(Document $document) {
        return $this->documentsDownloaded()->get()->contains($document->id);
    }

    public function is_owner_of($thing) {
        return $this->id == $thing->user_id;
    }

    public function can_review(Submission $submission)
    {
        return $this->is_reviewer_of($submission)
            && $submission->is_status_effectively('reviewing');
    }

    public function can_view_review(Review $review)
    {
        return $this->is_owner_of($review)
            && $review->submission->is_status_effectively(
                array('reviewing', 'finalizing', 'final'));
    }

    public function can_delete_document(Document $document)
    {
        $container = $document->container;

        $category = null;
        if ($container instanceof Submission)
        {
            $category = $container->category;
        }
        else if ($container instanceof Category)
        {
            $category = $container;
        }
        else if ($container instanceof Review)
        {
            $category = $container->submission->category;
        }

        $can_delete = false;
        if ($this->is_chair_of($category))
        {
            $can_delete = true;
        }
        else if ($container instanceof Submission)
        {
            if ($this->is_author_of($container))
            {
                if ($container->is_status_effectively('open'))
                {
                    $can_delete = true;
                }
                else if ($container->is_status_effectively('finalizing')
                    && Str::startsWith($document->name, 'Final'))
                {
                    $can_delete = true;
                }
            }
        }
        else if ($container instanceof Review)
        {
            if ($this->is_owner_of($container))
            {
                if ($container->submission->is_status_effectively('reviewing'))
                {
                    $can_delete = true;
                }
            }
        }

        return $can_delete;
    }

    public function can_upload_to($container)
    {
        $can_upload = false;
        if ($container instanceof Review)
        {
            if ($this->is_owner_of($container))
            {
                if ($container->submission->is_status_effectively('reviewing'))
                {
                    $can_upload = true;
                }
            }
        }
        else if ($container instanceof Submission)
        {
            if ($this->is_author_of($container))
            {
                if ($container->is_status_effectively(array('open', 'finalizing')))
                {
                    $can_upload = true;
                }
            }
        }
        else if ($container instanceof Category)
        {
            if ($this->is_chair_of($container))
            {
                $can_upload = true;
            }
        }
        return $can_upload;
    }
}
