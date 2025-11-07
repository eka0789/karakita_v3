<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ML\CharacterRFService;

class TrainCharacterModel extends Command
{
    protected $signature = 'karakita:train-model';
    protected $description = 'Latih model Random Forest karakter siswa';

    public function handle(CharacterRFService $svc)
    {
        $this->info('Training model Random Forest...');
        $svc->train();
        $this->info('✅ Model tersimpan di storage/app/ml/model_rf.serialized');
    }
}
