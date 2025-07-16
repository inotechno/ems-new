<?php

namespace App\Livewire\FinancialRequest;

use App\Jobs\SendEmailJob;
use App\Models\Helper;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Livewire\BaseComponent;
use App\Models\FinancialRequest;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class FinancialRequestForm extends BaseComponent
{
    use LivewireAlert, WithFileUploads;

    public $mode = 'Create';
    public $financial_request;
    public $employee_id, $financial_type_id, $title, $amount, $notes, $receipt_image_path, $receipt_image_url, $image, $uid;
    public $employees;
    public $previewImage = 'https://undergroundgym.cz/wp-content/themes/gymat/assets/img/noimage_1210X584.jpg';

    public $recipients;
    public $employee;
    public $financial_types;

    public function mount($id = null)
    {
        $this->employees = Employee::with('user')->whereNot('user_id', $this->authUser->id)->get();

        $this->financial_types = Helper::where('code', 'financial_request_type')->get();
        $this->employee = $this->authUser->employee;
        $this->employee_id = $this->employee->id;
        if ($id) {
            $this->mode = 'Edit';
            $this->financial_request = FinancialRequest::find($id);
            $this->employee = $this->financial_request->employee;
            $this->financial_type_id = $this->financial_request->financial_type_id;
            $this->title = $this->financial_request->title;
            $this->amount = $this->financial_request->amount;
            $this->notes = $this->financial_request->notes;
            $this->receipt_image_path = $this->financial_request->receipt_image_path;
            $this->receipt_image_url = $this->financial_request->receipt_image_url;
            $this->recipients = $this->financial_request->recipients->pluck('employee_id')->toArray();

            $this->dispatch('set-default-form', param: 'recipients', value: $this->recipients);
            $this->dispatch('contentChanged', $this->notes);
        } else {
            $this->mode = 'Create';
            $this->employee = null;
            $this->financial_type_id = null;
            $this->title = null;
            $this->amount = null;
            $this->notes = null;
            $this->receipt_image_path = null;
            $this->receipt_image_url = null;
        }
    }

    // public function updatedImage()
    // {
    //     dd($this->image->temporaryUrl());
    // }

    #[On('change-input-form')]
    public function changeInputForm($param, $value)
    {
        $this->$param = $value;
        // dd($this->recipients);
    }

    public function save()
    {
        try {
            $this->validate([
                'employee_id' => 'required',
                'financial_type_id' => 'required',
                'title' => 'required',
                'amount' => 'required|numeric|gt:0',
                'recipients' => 'required',
            ]);

            if ($this->mode == 'Create') {
                $this->store();
            } else {
                $this->update();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function store()
    {
        $this->uid = (string) Str::uuid();
        $imagePath = null;
        $imageUrl = null;

        if ($this->image) {
            // Generate nama file random menggunakan UUID
            $imageName = $this->uid . '.' . $this->image->getClientOriginalExtension();

            // Store image in GCS using Laravel Storage
            $disk = Storage::disk('gcs');
            $imagePath = $disk->putFileAs('images', $this->image, $imageName);

            // Get the full public URL of the uploaded image
            $imageUrl = $disk->url($imagePath);
        }

        $financial_request = FinancialRequest::create([
            'employee_id' => $this->employee_id,
            'financial_type_id' => $this->financial_type_id,
            'title' => $this->title,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'receipt_image_path' => $imagePath,
            'receipt_image_url' => $imageUrl,
        ]);

        // Buat recipients menggunakan relasi yang ada
        $financial_request->recipients()->createMany(
            collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
        );

        // Akses relasi employee setelah AbsentRequest berhasil disimpan
        $employee = $financial_request->employee;

        // Akses relasi recipients setelah AbsentRequest berhasil disimpan
        $recipients = $financial_request->recipients;

        // Kirim email ke recipients
        foreach ($recipients as $recipient) {
            createNotification(
                $recipient->employee->user->id,
                $this->authUser->name . ' make Financial Request',
                $this->authUser->name . 'make-financial-request',
                'Financial Request',
                $this->authUser->name . ' telah membuat pengajuan keuangan dengan jumlah Rp' . number_format($financial_request->amount, 0, ',', '.') . ' dengan judul ' . $financial_request->title,
                route('financial-request.detail', $financial_request->id)
            );

            SendEmailJob::dispatch($recipient->employee->user, 'recipient-financial-request', ['financial_request' => $financial_request], $employee->user);
        }

        // Kirim email menggunakan job
        SendEmailJob::dispatch($employee->user, 'sender-financial-request', ['financial_request' => $financial_request]);

        $this->alert('success', 'Financial request created successfully');

        createNotification(
            $this->authUser->id,
            'You have Created Financial Request',
            'you-have-create-financial-request',
            'Financial Request',
            'Anda telah membuat pengajuan keuangan dengan jumlah Rp' . number_format($financial_request->amount, 0, ',', '.') . ' dengan judul ' . $financial_request->title,
            route('financial-request.detail', $financial_request->id)
        );

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('create')
            ->log("{$this->authUser->name} telah membuat Financial Request");

        return redirect()->route('financial-request.index');
    }

    public function update()
    {
        $this->uid = (string) Str::uuid();
        $imagePath = $this->receipt_image_path;
        $imageUrl = $this->receipt_image_url;

        if ($this->image) {
            // Generate nama file random menggunakan UUID
            $imageName = $this->uid . '.' . $this->image->getClientOriginalExtension();

            // Store image in GCS using Laravel Storage
            $disk = Storage::disk('gcs');
            $imagePath = $disk->putFileAs('images', $this->image, $imageName);

            // Get the full public URL of the uploaded image
            $imageUrl = $disk->url($imagePath);
        }

        try {
            $this->financial_request->update([
                'employee_id' => $this->employee_id,
                'financial_type_id' => $this->financial_type_id,
                'title' => $this->title,
                'amount' => $this->amount,
                'notes' => $this->notes,
                'receipt_image_path' => $imagePath,
                'receipt_image_url' => $imageUrl,
            ]);

            $this->financial_request->recipients()->delete();
            $this->financial_request->recipients()->createMany(
                collect($this->recipients)->map(fn($recipient) => ['employee_id' => $recipient])->toArray()
            );

            $this->alert('success', 'Financial request updated successfully');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah Financial Request");

            return redirect()->route('financial-request.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.financial-request.financial-request-form')->layout('layouts.app', ['title' => 'financial Request ' . $this->mode]);
    }
}
