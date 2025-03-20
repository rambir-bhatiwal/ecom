<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    // Automatically generate and set the slug before saving
    protected static function booted()
    {
        static::creating(function ($role) {
            // Generate slug from the name
            $slug = Str::slug($role->name);
            $originalSlug = $slug;
            $count = 1;

            // Ensure uniqueness of the slug
            while (Role::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $role->slug = $slug; // Assign the unique slug
        });

        static::updating(function ($role) {
            // If the name is changed, regenerate the slug
            if ($role->isDirty('name')) {
                $slug = Str::slug($role->name);
                $originalSlug = $slug;
                $count = 1;

                // Ensure uniqueness of the slug
                while (Role::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $role->slug = $slug; // Regenerate and assign the unique slug
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
