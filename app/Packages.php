<?php

namespace App;

use App\Region;
use App\Packages;
use App\Package2destination;
use App\Http\Helpers\Helpers;
use App\Translations\Language;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Packages extends Model implements HasMedia
{
  use HasMediaTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['is_active', 'map'];    

    static public function getAll(){
      $packages = Packages::select('packages.id', 'packages.is_active');
      $languages = Language::getAll();

      foreach ($languages as $language) {
        $packages->addSelect("ct$language->id.name as title$language->id")
          ->join("packages_translation as ct$language->id", 'packages.id', '=', "ct$language->id.fk_package")
          ->join("languages as l$language->id", "l$language->id.id", '=', "ct$language->id.fk_language")
          ->where("l$language->id.iso", $language->iso);
      }

      return $packages->get();
    }

    static function getLists() {
      //return Region::orderBy('region')->pluck('region', 'id');
    }  

    static function getEdit($id){

      $package = Packages::select('id', 'is_active', 'map');
      $result = $package->where('id', $id)->get()->first();
  
      if (is_array($id)) {
        if (count($result) == count(array_unique($id))) {
          return $result;
        }
      } elseif (! is_null($result)) {
        return $result;
      }
  
      //Laravel 4 fallback
      return abort(404);
    }

    static function getShow($id) {
      $package = Packages::select('packages.id', 'map', 'packages_translation.name', 'packages_translation.summary', 'packages_translation.body');
      $package->join("packages_translation", 'packages.id', '=', "packages_translation.fk_package");
      $package->join("languages", 'languages.id', '=', "packages_translation.fk_language");
      $package->where([
        ['packages.id', '=', $id],
        ['languages.iso', '=', App::getLocale()]
      ]);

      return $package->get()->first();
    }  
    
    static function getRelated($id) {
      $currentDestinations = Package2destination::orderBy('id')->where('fk_package', $id)->pluck('fk_destination');

      $related = Packages::select('packages.id', 'packages_translation.name', 'packages_translation.summary', 'package2destination.fk_destination');
      $related->join("packages_translation", 'packages.id', '=', "packages_translation.fk_package");
      $related->join("languages", 'languages.id', '=', "packages_translation.fk_language");
      $related->join("package2destination", 'packages.id', '=', "package2destination.fk_package");
      
      $related->where([
        ['packages.id', '!=', $id],
        ['languages.iso', '=', App::getLocale()],
      ])->whereIn('package2destination.fk_destination', $currentDestinations)->limit(3);

      return $related->get();
    }

    static function getHome() {
      $home = Packages::select('packages.id', 'packages_translation.name', 'packages_translation.summary');
      $home->join("packages_translation", 'packages.id', '=', "packages_translation.fk_package");
      $home->join("languages", 'languages.id', '=', "packages_translation.fk_language");
      $home->where('is_active', 1)->where('languages.iso', App::getLocale());

      return $home->limit(6)->get();
    }

    public function getPrice() {
      return 'ARS ' . number_format(rand(5000, 199999), 0, null, '.');
    }

    public function getBodyHtmlAttribute() {
      return Helpers::draft2html($this->attributes['body']);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('backoffice')
          ->fit(Manipulations::FIT_CROP, 120, 120)
          ->optimize();
    
        $this->addMediaConversion('slider')
          ->fit(Manipulations::FIT_CROP, 760, 420)
          ->optimize();       
          
        $this->addMediaConversion('preview')
          ->fit(Manipulations::FIT_CROP, 370, 204)
          ->optimize();               

        $this->addMediaConversion('facebook')
          ->fit(Manipulations::FIT_CROP, 500, 261)
          ->optimize();           
    }
  }