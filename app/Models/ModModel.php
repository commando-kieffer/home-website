<?php

namespace App\Models;

/**
 * Catalogue des mods Arma Reforger (et outils) du Commando.
 * Les données sont statiques : voir app/Data/mods.php.
 */
class ModModel
{
    private const PICTURES         = '/pictures/mods/';
    private const WORKSHOP_URL     = 'https://reforger.armaplatform.com/workshop/';
    private const WORKSHOP_AUTHOR  = 'Noks - Ohliger';
    private const WORKSHOP_LICENSE = 'Arma Public License No Derivatives (APL-ND)';

    /** @var array<string, array> */
    private array $entries;

    public function __construct()
    {
        $this->entries = [];

        foreach (require APPPATH . 'Data/mods.php' as $slug => $entry) {
            $this->entries[$slug] = $this->normalize($slug, $entry);
        }
    }

    /**
     * @return array<string, array> Les mods de contenu, dans l'ordre d'affichage
     */
    public function getMods(): array
    {
        return $this->inGroup('mods');
    }

    /**
     * @return array<string, array> Les outils pour les serveurs (mod technique ou non)
     */
    public function getTools(): array
    {
        return $this->inGroup('server');
    }

    public function find(string $slug): ?array
    {
        return $this->entries[$slug] ?? null;
    }

    /**
     * Les mods autres que $slug, pour la navigation de bas de page.
     *
     * @return array<string, array>
     */
    public function getOthers(string $slug): array
    {
        return array_diff_key($this->getMods(), [$slug => true]);
    }

    private function inGroup(string $group): array
    {
        return array_filter($this->entries, static fn (array $entry): bool => $entry['group'] === $group);
    }

    /**
     * Résout les chemins d'une image : version complète (visionneuse) et vignette.
     */
    private function picture(array $shot): array
    {
        return [
            'src'   => self::PICTURES . $shot['file'] . '.jpg',
            'thumb' => self::PICTURES . $shot['file'] . '-sm.jpg',
            'alt'   => $shot['alt'],
            'pos'   => $shot['pos'] ?? null,
        ];
    }

    private function normalize(string $slug, array $entry): array
    {
        $entry += [
            'slug'         => $slug,
            'group'        => 'mods',
            'stats'        => [],
            'features'     => [],
            'content'      => [],
            'requires'     => [],
            'facts'        => [],
            'standalone'   => [],
            'credits'      => [],
            'workshop_id'  => null,
            'workshop_url' => null,
            'repo_url'     => null,
            'shots'        => [],
            'cover'        => null,
            'install'      => null,
        ];

        $entry['standalone'] = array_map(
            static fn (array $mod): array => $mod + ['workshop_url' => self::WORKSHOP_URL . $mod['workshop_id']],
            $entry['standalone']
        );
        $entry['shots'] = array_map([$this, 'picture'], $entry['shots']);
        $entry['cover'] = $entry['cover'] !== null
            ? $this->picture($entry['cover'])
            : ($entry['shots'][0] ?? null);

        if ($entry['workshop_id'] !== null) {
            $entry['workshop_url'] = self::WORKSHOP_URL . $entry['workshop_id'];
            $entry['facts'] = array_merge(
                [['Auteur', self::WORKSHOP_AUTHOR], ['Licence', self::WORKSHOP_LICENSE]],
                $entry['facts']
            );

            // Extrait à coller dans la liste "game.mods" de la config serveur.
            $entry['install'] ??= [
                'label' => 'Config serveur (game.mods)',
                'code'  => json_encode(
                    ['modId' => $entry['workshop_id'], 'name' => $entry['name']],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                ),
            ];
        }

        return $entry;
    }
}
