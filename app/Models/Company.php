<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'companies';
    protected $primaryKey = 'companies_id';
    protected $fillable = [
        'company_name',
        'company_end_subscription',
        'company_active',
    ];
}
