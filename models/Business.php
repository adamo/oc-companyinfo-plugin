<?php namespace Depcore\CompanyInfo\Models;

use Model;

/**
 * Business Model
 */
class Business extends Model
{
    // use \October\Rain\Database\Traits\Validation;

    // public $rules = [
    //     'identification_number' => 'sometimes|required',
    //     'company_name' => 'sometimes|required',
    //     'street_name' => 'sometimes|required',
    //     'street_number' => 'sometimes|required',
    //     'post_code' => 'sometimes|required',
    //     'city' => 'sometimes|required|max:50',
    // ];

    // public $customMessages = [
    //     'name.sometimes' => 'depcore.companyinfo::lang.business.name_required',
    // ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'depcore_companyinfo_businesses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id','company_name','identification_number','street_name','street_number','post_code','city','notices'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'user' => '\RainLab\Users\Models\User',
    ];


    public static function getFromUser($user)
    {
        if($user->profile) return $user->profile();

        $profile = new static;
        $profile->user = $user;
        $profile->save();

        $user->profile = $profile;
        return $profile;
    }

}