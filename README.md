# cakeinsertapi
REST
Many newer application programmers are realizing the need to open their core functionality to a greater audience. Providing easy, unfettered access to your core API can help get your platform accepted, and allows for mashups and easy integration with other systems.

While other solutions exist, REST is a great way to provide easy access to the logic you’ve created in your application. It’s simple, usually XML-based (we’re talking simple XML, nothing like a SOAP envelope), and depends on HTTP headers for direction. Exposing an API via REST in CakePHP is simple.

The Simple Setup
The fastest way to get up and running with REST is to add a few lines to your routes.php file, found in app/Config. The Router object features a method called mapResources(), that is used to set up a number of default routes for REST access to your controllers. Make sure mapResources() comes before require CAKE . 'Config' . DS . 'routes.php'; and other routes which would override the routes. If we wanted to allow REST access to a recipe database, we’d do something like this:

//In app/Config/routes.php...

Router::mapResources('recipes');
Router::parseExtensions();
The first line sets up a number of default routes for easy REST access while parseExtensions() method specifies the desired result format (e.g. xml, json, rss). These routes are HTTP Request Method sensitive.

HTTP format	URL format	Controller action invoked
GET	/recipes.format	RecipesController::index()
GET	/recipes/123.format	RecipesController::view(123)
POST	/recipes.format	RecipesController::add()
POST	/recipes/123.format	RecipesController::edit(123)
PUT	/recipes/123.format	RecipesController::edit(123)
DELETE	/recipes/123.format	RecipesController::delete(123)
CakePHP’s Router class uses a number of different indicators to detect the HTTP method being used. Here they are in order of preference:

The _method POST variable
The X_HTTP_METHOD_OVERRIDE
The REQUEST_METHOD header
The _method POST variable is helpful in using a browser as a REST client (or anything else that can do POST easily). Just set the value of _method to the name of the HTTP request method you wish to emulate.

Once the router has been set up to map REST requests to certain controller actions, we can move on to creating the logic in our controller actions. A basic controller might look something like this:

// Controller/RecipesController.php
class RecipesController extends AppController {

    public $components = array('RequestHandler');

    public function index() {
        $recipes = $this->Recipe->find('all');
        $this->set(array(
            'recipes' => $recipes,
            '_serialize' => array('recipes')
        ));
    }

    public function view($id) {
        $recipe = $this->Recipe->findById($id);
        $this->set(array(
            'recipe' => $recipe,
            '_serialize' => array('recipe')
        ));
    }

    public function add() {
        $this->Recipe->create();
        if ($this->Recipe->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function edit($id) {
        $this->Recipe->id = $id;
        if ($this->Recipe->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->Recipe->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}
