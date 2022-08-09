<?php namespace Depcore\CompanyInfo;

use Backend;
use Event;
use System\Classes\PluginBase;
use Rainlab\User\Models\User;
use Depcore\CompanyInfo\Models\Business;
use RainLab\User\Controllers\Users as UsersController;
use Yaml;

/**
 * CompanyInfo Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'depcore.companyinfo::lang.plugin.name',
            'description' => 'depcore.companyinfo::lang.plugin.description',
            'author'      => 'Depcore',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {

        Event::listen('backend.form.extendFields', function ($widget) {

            if (!$widget->model instanceof User) return;
            if (!$widget->model->business) {
                $widget->model->business = new Business();
                $widget->model->business->user_id = 1; // temp information probably needs defered  binding

            }

        });

        Event::listen('rainlab.user.register', function ( $user, $data ) {
            if (array_key_exists('business',$data))
            {
                $data['business']['company_name'] = '-';
                $data['business']['identification_number'] = '-';
                $user->business = new Business( $data['business'] );
                $user->save(  );
            }
        });

        User::extend( function( $model ) {

            $model->addFillable([
                'phone',
                'street',
                'number',
                'post_code',
                'city',
            ]);

            $model->hasOne['business'] = [
                Business::class,
                'key' => 'user_id',
            ];

        });

        User::extend( function($model) {

            $model->bindEvent('model.beforeDelete', function() use ($model) {
                $model->business && $model->business->delete();
            });

            $model->bindEvent('model.beforeSave', function() use ($model) {
                $data = post('business');
                if(!$data) return;
                if(!$model->business) $model->business = new Business;
                if(!$data) return;
                $model->business->fill($data);
                $model->business->save();
            });

        });

        UsersController::extendFormFields( function( $form, $model ) {

            if(!$model instanceof User) return;
            if(!$model->exists) return;

            Business::getFromUser( $model );

            $form->addTabFields(
                Yaml::parseFile(plugins_path().'/depcore/companyinfo/models/business/fields.yaml')
            );
        } );

        UsersController::extend( function ($controller) {
            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                '$/depcore/companyinfo/config/config_relation_business.yaml'
            );
        });

    }

}