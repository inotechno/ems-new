<?php

namespace Database\Seeders;

use App\Models\CategoryEmailTemplate;
use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // New Account
        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'new-account')->first()->id,
            'slug' => 'new-account-email',
            'name' => 'New Account Email',
            'subject' => 'Akun Baru Telah Dibuat',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Selamat datang di <strong>TPM Group</strong>! Berikut adalah informasi akun Anda: </p><ul><li><strong>URL:</strong ><a href="https://ems.tpm-facility.com" target="_blank" style="color: #1a73e8" >https://ems.tpm-facility.com</a ></li><li><strong>Email:</strong>{{ $recipient->email}}</li><li><strong>Username:</strong>{{ $recipient->username}}</li><li><strong>Password:</strong>{{ $recipient->password_string}}</li></ul><p><em>(Ganti password setelah login pertama)</em></p><p>Jika ada masalah, hubungi tim IT kami di <a href="mailto:email-support@perusahaan.com" style="color: #1a73e8" >email-support@perusahaan.com</a >atau <strong>[nomor-telepon]</strong>. </p><p>Salam hangat,<br />Tim IT <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        // Absent Request
        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'recipient-absent-request')->first()->id,
            'slug' => 'recipient-absent-request-email',
            'name' => 'Recipient Absent Request Email',
            'subject' => 'Pengajuan Tidak Hadir Baru dari {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Anda menerima pengajuan tidak hadir baru dari <strong>{{ $sender->name}}</strong>. Berikut detailnya: </p><ul><li><strong>Nama Karyawan:</strong>{{ $sender->name}}</li><li><strong>Tanggal Absen:</strong>{{ $absent_request->start_date->format("d-m-Y")}} s/d{{ $absent_request->end_date->format("d-m-Y")}} </li><li><strong>Catatan:</strong>{{ $absent_request->notes}}</li></ul><p>Silakan proses pengajuan ini sesuai prosedur. Jika ada pertanyaan, hubungi karyawan melalui email: <a href="mailto:{{ $sender->email}}" style="color: #1a73e8" >{{ $sender->email}}</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>',
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'sender-absent-request')->first()->id,
            'slug' => 'sender-absent-request-email',
            'name' => 'Sender Absent Request Email',
            'subject' => 'Pengajuan Tidak Hadir Anda Telah Masuk',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan tidak hadir Anda dengan tanggal <strong >{{ $absent_request->start_date->format("d-m-Y")}} s/d{{ $absent_request->end_date->format("d-m-Y")}}</strong >telah masuk, silahkan tunggu approval penerima. Berikut detail pengajuan Anda: </p><ul><li><strong>Catatan:</strong>{{ $absent_request->notes}}</li></ul><p>Jika ada pertanyaan atau perubahan, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'approved-absent-request')->first()->id,
            'slug' => 'approved-absent-request-email',
            'name' => 'Approved Absent Request Email',
            'subject' => 'Pengajuan Tidak Hadir Anda Telah Disetujui oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan tidak hadir Anda dengan tanggal <strong >{{ $absent_request->start_date->format("d-m-Y")}} s/d{{ $absent_request->end_date->format("d-m-Y")}}</strong >telah <strong>disetujui</strong>oleh{{ $sender->name}}. Berikut detail pengajuan Anda: </p><ul><li><strong>Catatan:</strong>{{ $absent_request->notes}}</li></ul><p>Jika ada pertanyaan atau perubahan, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'rejected-absent-request')->first()->id,
            'slug' => 'rejected-absent-request-email',
            'name' => 'Rejected Absent Request Email',
            'subject' => 'Pengajuan Tidak Hadir Anda Ditolak oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan tidak hadir Anda dengan tanggal <strong >{{ $absent_request->start_date->format("d-m-Y")}} s/d{{ $absent_request->end_date->format("d-m-Y")}}</strong >telah <strong>ditolak</strong>oleh{{ $sender->name}}. Berikut detail pengajuan Anda: </p><ul><li><strong>Catatan:</strong>{{ $absent_request->notes}}</li></ul><p>Jika ada pertanyaan atau perubahan, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        // Leave Request
        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'recipient-leave-request')->first()->id,
            'slug' => 'recipient-leave-request-email',
            'name' => 'Recipient Leave Request Email',
            'subject' => 'Pengajuan Cuti Baru dari {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Anda menerima pengajuan cuti baru dari <strong>{{ $sender->name}}</strong>. Berikut detailnya: </p><ul><li><strong>Nama Karyawan:</strong>{{ $sender->name}}</li><li><strong>Tanggal Mulai:</strong>{{ $leave_request->start_date->format("d-m-Y")}} </li><li><strong>Tanggal Selesai:</strong>{{ $leave_request->end_date->format("d-m-Y")}} </li><li><strong>Jumlah Hari:</strong>{{ $leave_request->total_days}}</li><li><strong>Catatan:</strong>{{ $leave_request->notes}}</li></ul><p>Silakan proses pengajuan ini sesuai prosedur. Jika ada pertanyaan, hubungi pengaju melalui email: <a href="mailto:{{ $sender->email}}" style="color: #1a73e8" >{{ $sender->email}}</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'sender-leave-request')->first()->id,
            'slug' => 'sender-leave-request-email',
            'name' => 'Sender Leave Request Email',
            'subject' => 'Pengajuan Cuti Anda Telah Masuk',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan cuti Anda dari tanggal <strong>{{ $leave_request->start_date->format("d-m-Y")}}</strong>sampai <strong>{{ $leave_request->end_date->format("d-m-Y")}}</strong>telah diterima. Berikut detailnya: </p><ul><li><strong>Jumlah Hari:</strong>{{ $leave_request->total_days}}</li><li><strong>Catatan:</strong>{{ $leave_request->notes}}</li></ul><p>Jika ada perubahan atau pertanyaan, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'approved-leave-request')->first()->id,
            'slug' => 'approved-leave-request-email',
            'name' => 'Approved Leave Request Email',
            'subject' => 'Pengajuan Cuti Anda Telah Disetujui oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan cuti Anda dari tanggal <strong>{{ $leave_request->start_date->format("d-m-Y")}}</strong>sampai <strong>{{ $leave_request->end_date->format("d-m-Y")}}</strong>telah <strong>disetujui</strong>. Berikut detailnya: </p><ul><li><strong>Jumlah Hari:</strong>{{ $leave_request->total_days}}</li><li><strong>Catatan:</strong>{{ $leave_request->notes}}</li><li><strong>Oleh:</strong>{{ $sender->name}}</li></ul><p>Jika ada pertanyaan lebih lanjut, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'rejected-leave-request')->first()->id,
            'slug' => 'rejected-leave-request-email',
            'name' => 'Rejected Leave Request Email',
            'subject' => 'Pengajuan Cuti Anda Ditolak oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan cuti Anda dari tanggal <strong>{{ $leave_request->start_date->format("d-m-Y")}}</strong>sampai <strong>{{ $leave_request->end_date->format("d-m-Y")}}</strong>telah <strong>ditolak</strong>. Berikut detailnya: </p><ul><li><strong>Jumlah Hari:</strong>{{ $leave_request->total_days}}</li><li><strong>Catatan:</strong>{{ $leave_request->notes}}</li><li><strong>Oleh:</strong>{{ $sender->name}}</li></ul><p>Untuk mengajukan ulang atau memberikan klarifikasi, silakan hubungi tim HR melalui email: <a href="mailto:hr@perusahaan.com" style="color: #1a73e8" >hr@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim HR <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        // Financial Request
        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'recipient-financial-request')->first()->id,
            'slug' => 'recipient-financial-request-email',
            'name' => 'Recipient Financial Request Email',
            'subject' => 'Pengajuan Keuangan Baru dari {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Anda menerima pengajuan keuangan baru dari <strong>{{ $sender->name}}</strong>. Berikut detailnya: </p><ul><li><strong>Nama Karyawan:</strong>{{ $sender->name}}</li><li><strong>Jumlah Pengajuan:</strong>Rp{{ number_format($financial_request->amount, 0, ", ", " . ")}} </li><li><strong>Catatan:</strong>{{ $financial_request->notes}}</li></ul><p>Silakan proses pengajuan ini sesuai prosedur. Jika ada pertanyaan, hubungi pengaju melalui email: <a href="mailto:{{ $sender->email}}" style="color: #1a73e8" >{{ $sender->email}}</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim Keuangan <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'sender-financial-request')->first()->id,
            'slug' => 'sender-financial-request-email',
            'name' => 'Sender Financial Request Email',
            'subject' => 'Pengajuan Keuangan Anda Telah Masuk',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan keuangan Anda dengan jumlah <strong >Rp{{ number_format($financial_request->amount, 0, ", ", " . ")}}</strong >telah masuk. Berikut detailnya: </p><ul><li><strong>Catatan:</strong>{{ $financial_request->notes}}</li></ul><p>Jika ada perubahan atau pertanyaan, silakan hubungi tim Keuangan melalui email: <a href="mailto:keuangan@perusahaan.com" style="color: #1a73e8" >keuangan@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim Keuangan <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc"><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'approved-financial-request')->first()->id,
            'slug' => 'approved-financial-request-email',
            'name' => 'Approved Financial Request Email',
            'subject' => 'Pengajuan Keuangan Anda Telah Disetujui oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan keuangan Anda dengan jumlah <strong >Rp{{ number_format($financial_request->amount, 0, ", ", " . ")}}</strong >telah <strong>disetujui</strong>oleh{{ $sender->name}}. Berikut detailnya: </p><ul><li><strong>Catatan:</strong>{{ $financial_request->notes}}</li></ul><p>Jika ada perubahan atau pertanyaan, silakan hubungi tim Keuangan melalui email: <a href="mailto:keuangan@perusahaan.com" style="color: #1a73e8" >keuangan@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim Keuangan <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);

        EmailTemplate::create([
            'category_id' => CategoryEmailTemplate::where('slug', 'rejected-financial-request')->first()->id,
            'slug' => 'rejected-financial-request-email',
            'name' => 'Rejected Financial Request Email',
            'subject' => 'Pengajuan Keuangan Anda Ditolak oleh {{ $sender->name }}',
            'body' => '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333"><p>Hai <strong>{{ $recipient->name}}</strong>,</p><p>Pengajuan keuangan Anda dengan jumlah <strong >Rp{{ number_format($financial_request->amount, 0, ", ", " . ")}}</strong >telah <strong>ditolak</strong>oleh{{ $sender->name}}. Berikut detailnya: </p><ul><li><strong>Catatan:</strong>{{ $financial_request->notes}}</li></ul><p>Jika ada perubahan atau pertanyaan, silakan hubungi tim Keuangan melalui email: <a href="mailto:keuangan@perusahaan.com" style="color: #1a73e8" >keuangan@perusahaan.com</a >. </p><p>Terima kasih.</p><p>Salam hangat,<br />Tim Keuangan <strong>TPM Group</strong></p><hr style="border-top: 1px solid #ccc" /><p><small style="font-style: italic" >* Email ini dibuat secara otomatis, tidak perlu direspon</small ></p></div>'
        ]);
    }
}
