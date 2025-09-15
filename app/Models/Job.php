<?php

namespace App\Models;

class Job
{
    public string $label;
    public int $group_id;
    public int $officer_group_id;


    public function __construct(string $label, int $group_id, int $officer_group_id)
    {
        $this->label = $label;
        $this->group_id = $group_id;
        $this->officer_group_id = $officer_group_id;
    }
}
