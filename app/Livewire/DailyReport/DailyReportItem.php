<?php

namespace App\Livewire\DailyReport;

use App\Livewire\BaseComponent;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DailyReportItem extends BaseComponent
{
    use LivewireAlert;

    public $daily_report;
    public $disableUpdate = false;

    public function mount(DailyReport $daily_report)
    {
        $this->daily_report = $daily_report;

        if($this->authUser->employee->id != $daily_report->employee_id) {
            $this->disableUpdate = true;
        }
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this daily report?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-daily-report',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-daily-report')]
    public function delete()
    {
        // dd($this->daily_report);
        $this->daily_report->delete();
        $this->alert('success', 'Daily Report deleted successfully');

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus Daily Report");

        return redirect()->route('daily-report.index');
    }

    public function render()
    {
        $employee = $this->daily_report->employee;
        $user = $employee->user;
        $recipients = $this->daily_report->dailyReportRecipients;

        // Ambil employee terlebih dahulu, lalu ambil user dari setiap employee
        $users = $recipients->map(function ($recipient) {
            $employee = $recipient->employee; // Ambil employee dari recipient
            return $employee ? $employee->user : null; // Ambil user dari employee, atau null jika tidak ada employee
        })->filter(); // Hapus nilai null dari koleksi

        return view('livewire.daily-report.daily-report-item', [
            'daily_report' => $this->daily_report,
            'employee' => $employee,
            'user' => $user,
            'recipients' => $recipients,
            'users' => $users
        ]);
    }
}
