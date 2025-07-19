<?php
namespace App\Core\Abstract;
use App\Core\Session;
abstract class AbstractController
{
    protected Session $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }
    abstract public function create();
    abstract public function edit();
    abstract public function index();
    abstract public function store ();
    abstract public function destroy();
    abstract public function show();

protected $layout = 'base.layout';
   public function renderHtml(string $view, array $params = [])
   {
       extract($params);
       ob_start();
       // Use project root for templates
       require dirname(__DIR__, 3) . '/templates/' . $view . '.php';
       $ContentForLayout = ob_get_clean();
       require dirname(__DIR__, 3) . '/templates/layout/' . $this->layout . '.php';
   }

}
