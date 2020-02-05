<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hotel extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($rooms) {
      foreach ($rooms->room()->get() as $hotel_room) {
        $hotel_room->delete();
      }
    });
  }
  public function hotel_type_name()
  {
    return $this->belongsTo(hotel_type::class, 'hotel_type');
  }
  public function hotel_images()
  {
    return $this->hasMany(hotel_image::class, 'hotel_id');
  }
  public function hotel_loction_name()
  {
    return $this->belongsTo(Location::class, 'hotel_location');
  }
  public function hotel_reviews()
  {
    return $this->hasMany(hotel_review::class, 'hotel_id');
  }
  public function room()
  {
    return $this->hasMany(room::class, 'room_hotel');
  }
  public function package()
  {
    return $this->hasMany(package::class, 'package_hotel');
  }
  public function card()
  {
    return $this->belongsTo(card::class, 'hotel_card');
  }
}
