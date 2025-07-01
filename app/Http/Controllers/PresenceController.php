<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Personnels;
use App\Models\Presence;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function scannerQr($code_qr)
    {
        $personnel = Personnel::where('qr_code', $code_qr)->first();

        if (!$personnel) {
            return response()->json(['message' => 'QR code invalide'], 404);
        }

        $aujourdhui = Carbon::today();
        $maintenant = Carbon::now();

        $presence = Presence::firstOrCreate(
            [
                'personnel_id' => $personnel->id,
                'date' => $aujourdhui
            ],
            [
                'heure_arrivee' => $maintenant->format('H:i:s'),
                'retard' => $maintenant->gt(Carbon::createFromTime(7, 30)) ? 'oui' : 'non'
            ]
        );

        if (!$presence->wasRecentlyCreated && !$presence->heure_depart) {
            $presence->update(['heure_depart' => $maintenant->format('H:i:s')]);
        }

        return response()->json([
            'message' => 'Présence enregistrée',
            'data' => $presence
        ]);
    }
}
