<?php

namespace App\Livewire\Attendance;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AttendanceItem extends Component
{
    #[Reactive]
    public $attendance;
    public $day;
    public $employee;
    public $checkIn;
    public $checkOut;
    public $duration;
    public $duration_string;
    public $badge_color;
    public $distanceInFormatted, $distanceOutFormatted;
    public $noteInExcerpt, $noteOutExcerpt;

    /**
     * Mount the component
     *
     * This method is called when the component is first initialized.
     * It sets the following properties:
     * - $this->employee
     * - $this->day
     * - $this->checkIn
     * - $this->checkOut
     * - $this->duration_string
     * - $this->duration
     * - $this->badge_color
     * - $this->distanceInFormatted
     * - $this->distanceOutFormatted
     * - $this->noteInExcerpt
     * - $this->noteOutExcerpt
     */
    public function mount()
    {
        $this->employee = $this->attendance['employee'];
        $this->day = date('d/m', strtotime($this->attendance['date']));
        $this->checkIn = $this->attendance['check_in'];
        $this->checkOut = $this->attendance['check_out'];
        $this->duration_string = $this->attendance['duration_string'];
        $this->duration = $this->attendance['duration'];
        $this->badge_color = $this->statusDuration();
        $this->distanceFormatted();
        $this->notesExcerpt();
    }

    public function notesExcerpt()
    {
        // Jika Notes lebih dari 50 karakter
        if (strlen($this->checkIn['notes']) > 50) {
            $excerptIn = substr($this->checkIn['notes'], 0, 50);
            $this->noteInExcerpt = '<p class="d-inline-block m-0 fst-italic" id="notes-in-' . $this->checkIn['id'] . '">' . $excerptIn . '</p> <a data-id="' . $this->checkIn['id'] . '" data-excerpt="' . $excerptIn . '" data-notes="' . $this->checkIn['notes'] . '" href="javascript: void(0);" class="read-more-in">Read More</a>';
        } else {
            $this->noteInExcerpt = '<p class="fst-italic">' . $this->checkIn['notes'] . '</p>';
        }

        if ($this->checkOut != null) {
            // Jika Notes lebih dari 50 karakter
            if (strlen($this->checkOut['notes']) > 50) {
                $excerptOut = substr($this->checkOut['notes'], 0, 50);
                $this->noteOutExcerpt = '<p class="d-inline-block m-0 fst-italic" id="notes-out-' . $this->checkOut['id'] . '">' . $excerptOut . '</p> <a data-id="' . $this->checkOut['id'] . '" data-excerpt="' . $excerptOut . '" data-notes="' . $this->checkOut['notes'] . '" href="javascript: void(0);" class="read-more-out">Read More</a>';
            } else {
                $this->noteOutExcerpt = '<p class="fst-italic">' . $this->checkOut['notes'] . '</p>';
            }
        }
    }

    public function distanceFormatted()
    {
        if ($this->checkIn['distance'] != null) {
            if ($this->checkIn['distance'] < 1) {
                $this->distanceInFormatted = '<span class="text-success">' . $this->checkIn['distance'] . ' Km</span>';
            } elseif ($this->checkIn['distance'] >= 1) {
                $this->distanceInFormatted = '<span class="text-warning">' . $this->checkIn['distance'] . ' Km</span>';
            } else {
                $this->distanceInFormatted = '<span class="text-danger">' . $this->checkIn['distance'] . ' Km</span>';
            }
        } else {
            $this->distanceInFormatted = '<span class="text-secondary">Tidak ada</span>';
        }

        if ($this->checkOut != null) {
            if ($this->checkOut['distance'] != null) {
                if ($this->checkOut['distance'] < 1) {
                    $this->distanceOutFormatted = '<span class="text-success">' . $this->checkOut['distance'] . ' Km</span>';
                } elseif ($this->checkOut['distance'] >= 1) {
                    $this->distanceOutFormatted = '<span class="text-warning">' . $this->checkOut['distance'] . ' Km</span>';
                } else {
                    $this->distanceOutFormatted = '<span class="text-danger">' . $this->checkOut['distance'] . ' Km</span>';
                }
            } else {
                $this->distanceOutFormatted = '<span class="text-secondary">Tidak ada</span>';
            }
        }
    }

    public function statusDuration()
    {
        if ($this->duration < 8.00) {
            return 'badge-soft-danger';
        } else {
            return 'badge-soft-success';
        }
    }

    public function render()
    {
        return view('livewire.attendance.attendance-item');
    }
}
