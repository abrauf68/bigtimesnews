<?php

namespace Database\Seeders;

use App\Models\AiBlogSetting;
use App\Models\CompanySetting;
use App\Models\EmailSetting;
use App\Models\OtherSetting;
use App\Models\RecaptchaSetting;
use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::create([
            'company_name' => 'Big Times News',
        ]);

        RecaptchaSetting::create([
            'google_recaptcha_type' => 'no_captcha',
        ]);

        SystemSetting::create([
            'max_upload_size' => '2048',
            'currency_symbol' => '$',
            'currency_symbol_position' => 'prefix',
            'footer_text' => 'All Copyrights Reserved',
        ]);

        EmailSetting::create([
            'mail_driver' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => '2525',
            'mail_username' => '725adb089beee5',
            'mail_password' => 'b63984536f3df4',
            'mail_encryption' => 'tls',
            'mail_from_address' => 'admin@example.com',
            'mail_from_name' => 'Admin',
            'is_enabled' => '1',
        ]);

        AiBlogSetting::create([
            'is_enabled' => false,
            'daily_post_limit' => 3,
            'auto_publish' => false,
            'run_time' => '03:00:00',
            'trends_provider' => 'google_trends',
            'trend_country' => 'US',
            'claude_writer_model' => 'claude-sonnet-5',
            'claude_qa_model' => 'claude-haiku-4-5-20251001',
            'notify_admin' => true,
        ]);
    }
}
