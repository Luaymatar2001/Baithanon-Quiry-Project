<?php

namespace App\Http\Controllers;

use App\Models\household;
use App\Models\head_children;
use App\Models\partner;
use App\Models\city;
use App\Models\governorates;
use App\Models\location;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total heads of households
        $totalHeads = household::count();

        // Total children and wives
        $totalChildren = head_children::count();
        $totalWives = partner::count();

        // Homepage visits (placeholder, as not tracked)
        $homepageVisits =  cache()->get('homepage_visits', 0); // TODO: Implement tracking

        // Data updates (total records as proxy)
        $dataUpdates = $totalHeads + $totalChildren + $totalWives;

        // Individuals who submitted declarations (approved households)
        $submittedDeclarations = household::where('legal_confirmation', 1)->count();

        // Total cities, governorates, regions
        $totalCities = city::count();
        $totalGovernorates = governorates::count();
        $totalRegions = location::count();

        // Total admin panel users
        $totalAdmins = User::count();

        // Distribution of heads of households by governorate and region
        $distribution = household::selectRaw('governorates.name as governorate, locations.name as region, COUNT(*) as count')
            ->join('governorates', 'heads_households.governorate_id', '=', 'governorates.id')
            ->join('locations', 'heads_households.location_id', '=', 'locations.id')
            ->groupBy('governorates.name', 'locations.name')
            ->get();

        return view('Dashboard/statistic', compact(
            'totalHeads',
            'totalChildren',
            'totalWives',
            'homepageVisits',
            'dataUpdates',
            'submittedDeclarations',
            'totalCities',
            'totalGovernorates',
            'totalRegions',
            'totalAdmins',
            'distribution'
        ));
    }
}
