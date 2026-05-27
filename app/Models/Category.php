<?php
 
// ============================================================
// FILE: app/Models/Category.php
// ============================================================
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Category extends Model
{
    use HasFactory;
 
    protected $fillable = ['name', 'slug', 'icon', 'is_active'];
 
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
 
    public function activeMenus()
    {
        return $this->hasMany(Menu::class)->where('is_available', true);
    }
}
