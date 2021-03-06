API_Football\App\Controllers\Frontend\Base_Controller
===============

Blueprint for Frontend related Controllers. All Frontend Controllers should extend this Base_Controller




* Class name: Base_Controller
* Namespace: API_Football\App\Controllers\Frontend
* This is an **abstract** class
* Parent class: [API_Football\Core\Controller](API_Football-Core-Controller.md)





Properties
----------


### $model

    protected Object $model

Holds Model object



* Visibility: **protected**


### $view

    protected Object $view

Holds View Object



* Visibility: **protected**


Methods
-------


### register_hook_callbacks

    mixed API_Football\App\Controllers\Frontend\Base_Controller::register_hook_callbacks()

Register callbacks for actions and filters. Most of your add_action/add_filter
go into this method.

NOTE: register_hook_callbacks method is not called automatically. You
as a developer have to call this method where you see fit. For Example,
You may want to call this in constructor, if you feel hooks/filters
callbacks should be registered when the new instance of the class
is created.

The purpose of this method is to set the convention that first place to
find add_action/add_filter is register_hook_callbacks method.

* Visibility: **protected**
* This method is **abstract**.




### get_instance

    object API_Football\Core\Controller::get_instance(mixed $model_class_name, mixed $view_class_name)

Provides access to a single instance of a module using the singleton pattern



* Visibility: **public**
* This method is **static**.
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)


#### Arguments
* $model_class_name **mixed** - &lt;p&gt;Model Class to be associated with the controller.&lt;/p&gt;
* $view_class_name **mixed** - &lt;p&gt;View Class to be associated with the controller.&lt;/p&gt;



### get_model

    object API_Football\Core\Controller::get_model()

Get model.

In most of the cases, the model will be set as per routes in defined in routes.php.
So if you are not sure which model class is currently being used, search for the
current controller class name in the routes.php

* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)




### get_view

    object API_Football\Core\Controller::get_view()

Get view

In most of the cases, the view will be set as per routes in defined in routes.php.
So if you are not sure which view class is currently being used, search for the
current controller class name in the routes.php

* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)




### set_model

    void API_Football\Core\Controller::set_model(\API_Football\Core\Model $model)

Sets the model to be used



* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)


#### Arguments
* $model **[API_Football\Core\Model](API_Football-Core-Model.md)** - &lt;p&gt;Model object to be associated with the current controller object.&lt;/p&gt;



### set_view

    void API_Football\Core\Controller::set_view(\API_Football\Core\View $view)

Sets the view to be used



* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)


#### Arguments
* $view **[API_Football\Core\View](API_Football-Core-View.md)** - &lt;p&gt;View object to be associated with the current controller object.&lt;/p&gt;



### __construct

    mixed API_Football\Core\Controller::__construct(\API_Football\Core\Model $model, mixed $view)

Constructor



* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)


#### Arguments
* $model **[API_Football\Core\Model](API_Football-Core-Model.md)** - &lt;p&gt;Model object to be used with current controller object.&lt;/p&gt;
* $view **mixed** - &lt;p&gt;View object to be used with current controller object. Otherwise false.&lt;/p&gt;



### init

    void API_Football\Core\Controller::init(\API_Football\Core\Model $model, mixed $view)

Sets Model & View to be used with current controller



* Visibility: **protected**
* This method is defined by [API_Football\Core\Controller](API_Football-Core-Controller.md)


#### Arguments
* $model **[API_Football\Core\Model](API_Football-Core-Model.md)** - &lt;p&gt;Model to be associated with this controller.&lt;/p&gt;
* $view **mixed** - &lt;p&gt;Either View/its child class object or False.&lt;/p&gt;


