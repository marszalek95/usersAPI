<?php
// src/Controller/SearchController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchController extends Controller
{ 
    public function searchUserForm(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            
            ->getForm();

        return $this->render('searchBar.html.twig', [
            'search_form' => $form->createView()
        ]);
    }

    /**
    *@Route("handleSearch",  name="handleSearch")
    *@param Request $request
    */
    public function handleSearch(Request $request)
    {      
        $query = $request->request->get('form')['search'];
        
        return $this->redirect("search/query/{$query}/page/1");
    }
}
