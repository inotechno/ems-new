<?php

namespace App\Livewire\AttendanceTemp;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AttendanceTempItem extends BaseComponent
{
    use LivewireAlert;

    #[Reactive]
    public $attendance;

    public $employee;
    public $attendance_id, $employee_name, $image_url, $email, $timestamp, $distance, $notes, $distanceFormatted, $noteExcerpt, $latitude, $longitude, $image_path, $created_at;

    public function mount()
    {
        $this->attendance_id = $this->attendance->id;
        $this->employee = $this->attendance->employee;
        $this->employee_name = $this->employee->user->name;
        $this->image_url = $this->attendance->image_url;
        $this->email = $this->employee->user->email;
        $this->timestamp = $this->attendance->timestamp;
        $this->latitude = $this->attendance->latitude;
        $this->distance = $this->attendance->distance;
        $this->longitude = $this->attendance->longitude;
        $this->created_at = $this->attendance->created_at;
        $this->notes = $this->attendance->notes;
        $this->image_path = $this->attendance->image_path;

        $this->distanceFormatted();
        $this->notesExcerpt();
    }

    public function notesExcerpt()
    {
        // Jika Notes lebih dari 50 karakter
        if (strlen($this->notes) > 50) {
            $excerptIn = substr($this->notes, 0, 50);
            $this->noteExcerpt = '<p class="d-inline-block m-0 fst-italic" id="notes-in-' . $this->attendance_id . '">' . $excerptIn . '</p> <a data-id="' . $this->attendance_id . '" data-excerpt="' . $excerptIn . '" data-notes="' . $this->notes . '" href="javascript: void(0);" class="read-more-in">Read More</a>';
        } else {
            $this->noteExcerpt = '<p class="fst-italic">' . $this->notes . '</p>';
        }
    }

    public function distanceFormatted()
    {
        if ($this->distance != null) {
            if ($this->distance < 1) {
                $this->distanceFormatted = '<span class="text-success">' . $this->distance . ' Km</span>';
            } elseif ($this->distance >= 1) {
                $this->distanceFormatted = '<span class="text-warning">' . $this->distance . ' Km</span>';
            } else {
                $this->distanceFormatted = '<span class="text-danger">' . $this->distance . ' Km</span>';
            }
        }else{
            $this->distanceFormatted = '<span class="text-secondary">Tidak ada</span>';
        }
    }

    public function approveConfirm()
    {
        $this->alert('info', 'Are you sure you want to approve this attendance temporary?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#00a8ff',
            'confirmButtonText' => 'Yes, Approve',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'approve',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    public function rejectConfirm()
    {
        $this->alert('warning', 'Are you sure you want to reject attendance temporary?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'reject',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('approve')]
    public function approve()
    {
        try{
            $attendanceTemp = $this->attendance;
            $attendance = $attendanceTemp->replicate();
            $attendance->setTable('attendances');
            $attendance->save();

            $attendanceTemp->delete();
            $this->alert('success', 'Attendance approved successfully');

            activity()
                    ->causedBy($this->authUser) // Pengguna yang melakukan login
                    ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                    ->event('approve')
                    ->log("{$this->authUser->name} telah menyetujui Attendance Temporary");

            return redirect()->route('attendance-temporary.index');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
            return;
        }
    }

    #[On('reject')]
    public function reject()
    {
        try{
            $this->attendance->delete();
            // Delete image from gcs
            Storage::disk('gcs')->delete($this->image_path);
            $this->alert('success', 'Attendance rejected successfully');

            activity()
                    ->causedBy($this->authUser) // Pengguna yang melakukan login
                    ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                    ->event('reject attendance temporary')
                    ->log("{$this->authUser->name} telah menolak Attendance Temporary");

            return redirect()->route('attendance-temporary.index');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.attendance-temp.attendance-temp-item');
    }
}
