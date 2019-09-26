<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use App\Controller\FormController;

class UserController extends AbstractController
{
    /**
     * @Route("/users/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="users_paginated")
     * @Route("/users", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="users")
     */
        public function getUsers($page)
        {
            $url = "https://gorest.co.in/public-api/users?_format=json&access-token=PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW&page={$page}";

            $client = HttpClient::create();

            $response = $client->request('GET', $url);
            $response_arr = $response->toArray();

            return $this->render('users.html.twig', 
            [
                'users' => $response_arr['result'],
                'meta' => $response_arr['_meta']
            ]);
        }

        /**
         * @Route("/search/query/{query}/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="search_paginated")
         * @Route("/search", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="search")
         */
        public function findUsers($query, $page)
        {
            $url = "https://gorest.co.in/public-api/users?first_name={$query}&_format=json&access-token=PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW&page={$page}";

            $client = HttpClient::create();

            $response = $client->request('GET', $url);
            $response_arr = $response->toArray();

            return $this->render('search.html.twig', 
            [
                'users' => $response_arr['result'],
                'meta' => $response_arr['_meta'],
                'query' => $query
            ]);         
        }

        /**
         * @Route("/userinfo/id/{id}", defaults={"_format"="html"}, methods={"GET"}, name="userinfo")
         * 
         */
        public function infoUsers($id)
        {
        
            $response_arr = $this->idUser($id);

            return $this->render('userinfo.html.twig', 
            [
                'user' => $response_arr['result'],
                'meta' => $response_arr['_meta'],
            ]);         
        }

        public function idUser($id)
        {
            $url = "https://gorest.co.in/public-api/users/{$id}?&_format=json&access-token=PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW";

            $client = HttpClient::create();

            $response = $client->request('GET', $url);
            $response_arr = $response->toArray();

            return $response_arr;
        }

        public function addUser($body)
        {
            $url = "https://gorest.co.in/public-api/users";

            $client = HttpClient::create();

            $response = $client->request('POST', $url, [
                'verify_host' => false,
                'headers' => ['Authorization' => 'Bearer PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW'], 
                'json' => $body         
            ]);
            
            $response_arr = $response->toArray();

            return $response_arr;
        }

        public function editUser($body, $id)
        {
            $url = "https://gorest.co.in/public-api/users/{$id}";

            $client = HttpClient::create();

            $response = $client->request('PATCH', $url, [
                'verify_host' => false,
                'headers' => ['Authorization' => 'Bearer PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW'], 
                'json' => $body         
            ]);
            
            $response_arr = $response->toArray();

            return $response_arr;
        }

        /**
         * @Route("/UserController/delete/{id}", name="deletepost")
         * 
         */
        public function deleteUser($id)
        {
            $url = "https://gorest.co.in/public-api/users/{$id}";

            $client = HttpClient::create();

            $response = $client->request('DELETE', $url, [
                'verify_host' => false,
                'headers' => ['Authorization' => 'Bearer PlWJ9sxUSB5XiFj--yGSNYJi1r46ZUefNUfW'],       
            ]);
            
            $response_arr = $response->toArray();
            if($response_arr['_meta']['success'] == true)
            {
                $this->addFlash('success', 'User deleted successfully!');
            }
            else
            {
                $this->addFlash('fail', 'Something went wrong');
            }

            return $this->redirectToRoute('users');
        }       
}