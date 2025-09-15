<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'xf_user'; 
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'username',
        'user_group_id',
        'panel_pts',
    ];

    /**
     * Récupère les points des utilisateurs actifs
     *
     * @return array Liste des utilisateurs actifs sous forme brute
     */
    public function getPointFromActiveUsers()
    {
        $builder = $this->db->table($this->table);

        $builder->select('username, user_group_id, panel_pts');
        $builder->where('(user_group_id >= 5 AND user_group_id <= 20) OR user_group_id IN (50, 54)');
        $builder->orderBy('panel_pts', 'DESC');

        $query = $builder->get();

        return $query->getResultArray();
    }

    /**
     * Récupère les médailles des utilisateurs actifs
     *
     * @return array Liste des utilisateurs actifs avec leurs médailles
     */
    public function getMedalsFromActiveUsers()
    {
        // Étape 1 : Récupération des utilisateurs avec leur grade
        $builder = $this->db->table('xf_user');
        $builder->select('xf_user.user_id, xf_user.username, xf_user.user_group_id, xf_user.email, xf_user_group.user_title');
        $builder->join('xf_user_group', 'xf_user_group.user_group_id = xf_user.user_group_id', 'left');
        $builder->where('(xf_user.user_group_id >= 5 AND xf_user.user_group_id <= 20) OR xf_user.user_group_id IN (50, 54)');
        $builder->orderBy('xf_user.user_group_id', 'DESC');

        $users = $builder->get()->getResultArray();

        // Étape 2 : Récupération des médailles
        $medalBuilder = $this->db->table('medal_attribut');
        $medalBuilder->select('medal_attribut.id_user, medal.name, medal.title, medal.description');
        $medalBuilder->join('medal', 'medal.id = medal_attribut.id_medal');
        $medals = $medalBuilder->get()->getResultArray();

        // Étape 3 : Organisation
        $userMedals = [];
        foreach ($medals as $medal) {
            $userMedals[$medal['id_user']][] = [
                'name' => $medal['name'],
                'title' => $medal['title'],
                'description' => $medal['description']
            ];
        }

        // Étape 4 : Association
        foreach ($users as &$user) {
            $user['medals'] = $userMedals[$user['user_id']] ?? [];
        }

        return $users;
    }

    /**
     * Récupère les utilisateurs actifs par Troop, Bordée et grade.
     *
     * @return array Liste structurée des utilisateurs actifs classés.
     */
    public function getBarracksFromActiveUsers()
    {
        // Mapping des Troops et Bordées
        $troopNames = [
            38 => 'TROOP 1',
            39 => 'TROOP 8',
            40 => 'TROOP 9 KG',
            41 => 'TROOP QG',
            45 => 'TROOP 2',
            46 => 'TROOP 3',
        ];

        $bordeeNames = [
            52 => 'Bordée 1',
            53 => 'Bordée 2'
        ];

        // Mapping des titres de grade (depuis xf_user_group)
        $userGroupTitles = [
            5 => 'Cadet',
            6 => 'Matelot',
            7 => 'Matelot breveté',
            8 => 'Quartier-maître de seconde classe',
            9 => 'Quartier-maître de première classe',
            10 => 'Second maître maistrancier',
            11 => 'Second maître de seconde classe',
            12 => 'Second maître de première classe',
            13 => 'Maître',
            14 => 'Premier maître',
            15 => 'Maître principal',
            16 => 'Major',
            17 => 'Enseigne de vaisseau de seconde classe',
            18 => 'Enseigne de vaisseau de première classe',
            19 => 'Lieutenant de vaisseau',
            20 => 'Capitaine de corvette',
            50 => 'Aspirant',
            54 => 'Réserviste',
        ];

        // Mapping des fonctions / spécialités (via secondary_group_id)
        $specialties = [
            24 => 'Lanceur anti-véhicule',
            25 => 'Sapeur',
            26 => 'Assaut',
            27 => 'Tireur d\'élite',
            28 => 'Voltigeur',
            29 => 'Soutien',
            30 => 'Fusilier',
            31 => 'Infirmier',
            32 => 'Médecin',
            33 => 'Pilote',
            48 => 'Transmission',
            49 => 'Aide de camp',
            50 => 'Aspirant',
            51 => 'Commandement',
            63 => 'Char de Combat',
        ];

        

        $builder = $this->db->table('xf_user');
        $builder->select('user_id, username, user_group_id, secondary_group_ids');
        $builder->where('(user_group_id >= 5 AND user_group_id <= 20) OR user_group_id IN (50, 54)');
        $builder->orderBy('user_group_id', 'DESC');

        $users = $builder->get()->getResultArray();

        $result = [];

        foreach ($users as $user) {
            $secondaryIds = array_map('intval', explode(',', $user['secondary_group_ids'] ?? ''));

            // Détection de la Troop
            $troopId = null;
            foreach ($secondaryIds as $id) {
                if (array_key_exists($id, $troopNames)) {
                    $troopId = $id;
                    break;
                }
            }

            if (!$troopId) continue; // skip si pas de troop

            $troopName = $troopNames[$troopId];

            // Détection de la Bordée
            $bordeeName = 'Commandement';
            foreach ($secondaryIds as $id) {
                if (isset($bordeeNames[$id])) {
                    $bordeeName = $bordeeNames[$id];
                    break;
                }
            }

            // Détection du grade
            $user['user_title'] = $userGroupTitles[$user['user_group_id']] ?? 'Inconnu';

            // Détection de spécialité
            $user['specialite'] = '—';
            foreach ($secondaryIds as $id) {
                if (isset($specialties[$id])) {
                    $user['specialite'] = $specialties[$id];
                    break;
                }
            }

            // Détection du chef
            $user['is_chef'] = in_array(86, $secondaryIds);
            $user['troop_id'] = $troopId;
            $user['troop_name'] = $troopName;
            $user['bordee_name'] = $bordeeName;

            $result[$troopName][$bordeeName][] = $user;
        }

        // Trier chaque bordée par grade décroissant
        foreach ($result as &$troop) {
            foreach ($troop as &$bordee) {
                usort($bordee, fn($a, $b) => $b['user_group_id'] <=> $a['user_group_id']);
            }
        }

        return $result;
    }
    
    public function getJobsTree()
    {
        /* Array of JobTreeNode */
        $jobTree = [];

        $builder = $this->db->table('xf_user');
        $builder->select('user_id, username, user_group_id, secondary_group_ids');
        $builder->where('(user_group_id >= 5 AND user_group_id <= 20) OR user_group_id IN (50, 54)');
        $builder->orderBy('user_order', 'ASC')->orderBy('user_group_id', 'DESC');

        $members = array_map('\App\Models\UserDTO::from_entity', $builder->get()->getResult(\App\Models\User::class));

        $builder = $this->db->table('xf_user_group');
        $builder->select('user_group_id, title');

        $groups = $builder->get()->getResultObject();

        foreach ($members as $member) {
            foreach ($groups as $group) {
                if ($member->user_group_id == $group->user_group_id) {
                    $member->primary_group = $group->title;
                }
            }
        }

        foreach ($this->getLayeredJobs() as $layer => $jobs_desc) {
            foreach ($jobs_desc as $job_desc) {
                $job = new JobTreeNode();
                $job->label = $job_desc->label;

                $job->officer = current(array_values(array_filter($members, function ($member) use ($job_desc) {
                    return in_array($job_desc->officer_group_id, explode(",", $member->secondary_group_ids));
                })));

                $job->members = array_values(array_filter($members, function ($member) use ($job_desc) {
                    return in_array($job_desc->group_id, explode(",", $member->secondary_group_ids));
                }));

                $jobTree[$layer][] = $job;
            }
        }


        return $jobTree;
    }


    private function getLayeredJobs()
    {
        return [
            'primary' => [
                new Job("Commandement", 51, 0),
            ],
            'secondary' => [
                // new Job("Administrateurs serveurs", 0, 0),
                // new Job("Trésoriers", 0, 0),
                new Job("Instructeurs", 21, 56),
                new Job("Instructeurs spé", 44, 58),
                new Job("Instructeurs BV", 64, 57),
                new Job("Scénaristes", 55, 67),
                new Job("Recruteurs", 22, 59),
            ],
            'tertiary' => [
                new Job("Opérateurs technique", 23, 60),
                new Job("Administrateurs forum", 3, 0),
                new Job("Ambassadeurs", 66, 62),
                new Job("Cartographes", 80, 79),
                new Job("Communication", 76, 73),
                new Job("Graphistes", 68, 69),
                // new Job("Photographes", 0, 0),
                new Job("Rédacteurs", 70, 71),
                new Job("Section historique", 78, 77),
                // new Job("Police militaire", 37, 61),
            ],
        ];
    }


}