<?php

namespace App\Observers;

use App\Models\general_ledger;

class YourModelObserver
{
    /**
     * Handle the general_ledger "created" event.
     *
     * @param  \App\Models\general_ledger  $general_ledger
     * @return void
     */
    public function created(general_ledger $general_ledger)
    {
        
    }
  

    /**
     * Handle the general_ledger "updated" event.
     *
     * @param  \App\Models\general_ledger  $general_ledger
     * @return void
     */
    public function updating(general_ledger $general_ledger)
    {
        $user = Auth::user();

        if($user){
            $updateHistory = $model->update_history ?: '';
            $updateHistory .= ($updateHistory ? ',' : '') . $user->name . ',' . now()->toDateString();
            $model->update_history = $updateHistory;
        }
    }

    /**
     * Handle the general_ledger "deleted" event.
     *
     * @param  \App\Models\general_ledger  $general_ledger
     * @return void
     */
    public function deleted(general_ledger $general_ledger)
    {
        //
    }

    /**
     * Handle the general_ledger "restored" event.
     *
     * @param  \App\Models\general_ledger  $general_ledger
     * @return void
     */
    public function restored(general_ledger $general_ledger)
    {
        //
    }

    /**
     * Handle the general_ledger "force deleted" event.
     *
     * @param  \App\Models\general_ledger  $general_ledger
     * @return void
     */
    public function forceDeleted(general_ledger $general_ledger)
    {
        //
    }
}