<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\UserModel;
use App\Models\CommandoNameModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('generic/head') 
             . view('generic/header')
             . view('index')
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function history(): string
    {
        return view('generic/head') 
             . view('generic/header')
             . view('static/history')
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function points(): string
    {
        $userModel = new UserModel();

        $data['active_listofusers_points'] = $userModel->getPointFromActiveUsers();

        return view('generic/head') 
             . view('generic/header')
             . view('pages/points', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function decorations(): string
    {
        $userModel = new UserModel();

        $data['active_listofusers_medals'] = $userModel->getMedalsFromActiveUsers();

        return view('generic/head') 
             . view('generic/header')
             . view('pages/decorations', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function caserne(): string
    {
        $userModel = new UserModel();

        $data['barracks_data'] = $userModel->getBarracksFromActiveUsers();

        return view('generic/head') 
             . view('generic/header')
             . view('pages/caserne', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function metiers(): string
    {
        $userModel = new UserModel();

        $data['jobs_tree'] = $userModel->getJobsTree();

        return view('generic/head') 
             . view('generic/header')
             . view('pages/metiers', $data);
    }

    public function galerie($category = null, int $pic_id = -1): string
    {
        $galleryModel = new GalleryModel();
        $data = [
            'categories' => [],
            'pictures' => [],
            'in_album' => false,
            'pic_id' => $pic_id
        ];

        if (empty($category)) {
            $data['categories'] = $galleryModel->getCategories();
        } else {
            $data['pictures'] = $galleryModel->getPicturesOfCategory($category);
            $data['in_album'] = true;
        }

        return view('generic/head') 
             . view('generic/header')
             . view('pages/galerie', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function noms(): string
    {
        $commandoNames = new CommandoNameModel();

        $data['commando_names'] = $commandoNames->getFreeNames();

        return view('generic/head') 
             . view('generic/header')
             . view('pages/noms', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }
}
