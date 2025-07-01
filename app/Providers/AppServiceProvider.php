<?php

namespace App\Providers;

use App\Repositories\AnneeRepository;
use App\Repositories\BanqueRepository;
use App\Repositories\CaisseRepository;
use App\Repositories\ChequeRepository;
use App\Repositories\ClasseRepository;
use App\Repositories\CycleRepository;
use App\Repositories\InscriptionRepository;
use App\Repositories\Interfaces\AnneeRepositoryInterface;
use App\Repositories\Interfaces\BanqueRepositoryInterface;
use App\Repositories\Interfaces\CaisseRepositoryInterface;
use App\Repositories\Interfaces\ChequeRepositoryInterface;
use App\Repositories\Interfaces\ClasseRepositoryInterface;
use App\Repositories\Interfaces\CycleRepositoryInterface;
use App\Repositories\Interfaces\InscriptionRepositoryInterface;
use App\Repositories\Interfaces\NiveauRepositoryInterface;
use App\Repositories\Interfaces\PaiementRepositoryInterface;
use App\Repositories\Interfaces\ProduitRepositoryInterface;
use App\Repositories\Interfaces\UtilisateurRepositoryInterface;
use App\Repositories\NiveauRepository;
use App\Repositories\PaiementRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\UtilisateurRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->bind(CycleRepositoryInterface::class, CycleRepository::class);
        $this->app->bind(NiveauRepositoryInterface::class, NiveauRepository::class);
        $this->app->bind(ClasseRepositoryInterface::class, ClasseRepository::class);
        $this->app->bind(AnneeRepositoryInterface::class, AnneeRepository::class);
        $this->app->bind(InscriptionRepositoryInterface::class, InscriptionRepository::class);
        $this->app->bind(PaiementRepositoryInterface::class, PaiementRepository::class);
        $this->app->bind(BanqueRepositoryInterface::class, BanqueRepository::class);
        $this->app->bind(ChequeRepositoryInterface::class, ChequeRepository::class);
        $this->app->bind(ProduitRepositoryInterface::class, ProduitRepository::class);
        $this->app->bind(CaisseRepositoryInterface::class, CaisseRepository::class);
        $this->app->bind(UtilisateurRepositoryInterface::class, UtilisateurRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
