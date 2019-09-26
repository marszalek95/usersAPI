<?php
// src/Controller/FormController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Controller\UserController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    /**
     *@Route("/adduser",  name="adduser")
     */
    public function addUserForm(Request $request)
    {
        $user = new User();
        $message = [];

        $user->setavatarUrl('Tip: https://lorempixel.com/250/250/people');
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $result_arr = [
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'gender' => $user->gender,
                'dob' => $user->born->format('Y-m-d'),
                'email' => $user->email,
                'phone' => $user->phone,
                'website' => $user->website,
                'address' => $user->address,
                'status' => $user->status,
                'avatar' => $user->avatarUrl
                
            ];
            $result_arr;

            $usercontroller = new UserController();
            $meta = $usercontroller->addUser($result_arr);
            if($meta['_meta']['success'] == 1)
            {
                $message = ['alert' => false, 'message' => 'User added succesfully!'];
            }
            else
            {
                $message = ['alert' => true, 'message' => $meta['result'][0]['message']];
            }
        }

        return $this->render('adduser.html.twig', [
            'user_form' => $form->createView(),
            'message' => $message
        ]);
    }

    /**
     *@Route("/edituser/id/{id}",  name="edituser")
     */
    public function editUserForm(Request $request, $id)
    {
        $user = new User();
        $message = [];

        $usercontroller = new UserController();
        $userdata = $usercontroller->idUser($id);
        

        $user->firstName = $userdata['result']['first_name'];
        $user->lastName = $userdata['result']['last_name'];
        $user->email = $userdata['result']['email'];
        $user->phone = $userdata['result']['phone'];
        $user->website = $userdata['result']['website'];
        $user->address = $userdata['result']['address'];
        $user->setavatarUrl('Tip: https://lorempixel.com/250/250/people');
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $result_arr = [
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'gender' => $user->gender,
                'dob' => $user->born->format('Y-m-d'),
                'email' => $user->email,
                'phone' => $user->phone,
                'website' => $user->website,
                'address' => $user->address,
                'status' => 'active',
                'avatar' => $user->avatarUrl
                
            ];
           
            $usercontroller = new UserController();
            $meta = $usercontroller->editUser($result_arr, $id);
            if($meta['_meta']['success'] == 1)
            {
                $message = ['alert' => false, 'message' => 'User updatet succesfully!'];
            }
            else
            {
                $message = ['alert' => true, 'message' => $meta['result'][0]['message']];
            }

        }

        return $this->render('edituser.html.twig', [
            'user_form' => $form->createView(),
            'message' => $message
        ]);
    }
    
}