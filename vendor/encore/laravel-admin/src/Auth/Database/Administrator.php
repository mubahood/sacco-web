<?php

namespace Encore\Admin\Auth\Database;

use App\Models\Enterprise;
use App\Models\StudentHasClass;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Administrator extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;
    use HasPermissions;
    use DefaultDatetimeFormat;
    use Notifiable;

    protected $fillable = ['username', 'password', 'name', 'avatar'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            /* if ($model->enterprise_id == null) {
                die("enterprise is required");
            }
            $enterprise_id = ((int)($model->enterprise_id));
            $e = Enterprise::find($enterprise_id);
            if ($e == null) {
                die("enterprise is required");
            }
            $model->name = $model->first_name . " " . $model->last_name;
            return $model; */
        });

        self::created(function ($model) {
            //created
        });

        self::updating(function ($model) {
            if ($model->enterprise_id == null) {
                die("enterprise is required");
            }
            $enterprise_id = ((int)($model->enterprise_id));
            $e = Enterprise::find($enterprise_id);
            if ($e == null) {
                die("enterprise is required");
            }
            if ($model->first_name != null) {
                if (strlen($model->first_name) > 2) {
                    $model->name = $model->first_name . " " . $model->last_name;
                }
            }

            return $model;
        });

        self::updated(function ($model) {
            // ... code here
        });

        self::deleting(function ($model) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }


    /** 
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return admin_asset($default);
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    public function enterprise()
    {
        $e = Enterprise::find($this->enterprise_id);
        if ($e == null) {
            $this->enterprise_id = 1;
            $this->save();
        }
        return $this->belongsTo(Enterprise::class);
    }

    public function classes()
    {
        return $this->hasMany(StudentHasClass::class);
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.user_permissions_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function group()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public static function get_logged_on_user($id)
    {
        $new_user = Administrator::where('id', $id)
            ->with('group')->first();
        if ($new_user == null) {
            return null;
        }
        return $new_user;
    }
}
