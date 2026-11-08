<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\UserModel;
use App\Models\CommandoNameModel;
use App\Models\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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

        $raw_data = $userModel->getBarracksFromActiveUsers();
        $data['barracks_data'] = $raw_data['barracks'];
        $data['cadets']        = $raw_data['cadets'];

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
             . view('pages/metiers', $data)
             . view('generic/footer')
             . view('generic/foot');
    }

    public function galerie($category = null, int $pic_id = -1): string
    {
        $galleryModel = new GalleryModel();
        $data = [
            'categories' => [],
            'pictures' => [],
            'category' => null,
            'in_album' => false,
            'pic_id' => $pic_id
        ];

        if (empty($category)) {
            $data['categories'] = $galleryModel->getCategories();
        } else {
            $data['pictures'] = $galleryModel->getPicturesOfCategory($category);
            $data['category'] = $galleryModel->getCategory($category);
            $data['in_album'] = true;
        }

        return view('generic/head') 
             . view('generic/header')
             . view('pages/galerie', $data)
             . view('generic/footer')
             . view('generic/foot'); 
    }

    public function mods(): string
    {
        $modModel = new ModModel();

        $data = [
            'title'       => 'Mods Arma Reforger – CK 2004',
            'description' => 'Les mods Arma Reforger du Commando Kieffer : props, structures, armes, équipements, animations et outils serveur.',
            'mods'        => $modModel->getMods(),
            'tools'       => $modModel->getTools(),
        ];

        return view('generic/head', $data)
             . view('generic/header')
             . view('pages/mods', $data)
             . view('generic/footer')
             . view('generic/foot');
    }

    public function mod(string $slug): string
    {
        $modModel = new ModModel();
        $entry = $modModel->find($slug);

        if ($entry === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'       => $entry['name'] . ' – Mods – CK 2004',
            'description' => $entry['tagline'],
            'entry'       => $entry,
            'others'      => $modModel->getOthers($slug),
        ];

        return view('generic/head', $data)
             . view('generic/header')
             . view('pages/mod', $data)
             . view('generic/footer')
             . view('generic/foot');
    }

    public function not_found(): string
    {
        $data = ['title' => 'Page introuvable – CK 2004'];

        return view('generic/head', $data)
             . view('generic/header')
             . view('pages/not_found')
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
