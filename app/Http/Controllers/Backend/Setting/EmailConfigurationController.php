<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Models\EmailConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class EmailConfigurationController extends Controller
{
    public function index()
    {
        Gate::authorize('email-configuration');
        return view('backend.pages.setting.email_configuration');
    }

    public function setting_submit(Request $request)
    {
        Gate::authorize('email-configuration');
        $request->validate([
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_enctyption' => 'required',
            'mail_form_address' => 'required',
        ]);
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_mailer'],
            ['value' => $request->mail_mailer],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_host'],
            ['value' => $request->mail_host],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_port'],
            ['value' => $request->mail_port],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_username'],
            ['value' => $request->mail_username],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_password'],
            ['value' => $request->mail_password],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_enctyption'],
            ['value' => $request->mail_enctyption],
        );
        EmailConfiguration::updateOrCreate(
            ['name' => 'mail_form_address'],
            ['value' => $request->mail_form_address],
        );
        $this->setEnvValue('MAIL_MAILER', $request->mail_mailer);
        $this->setEnvValue('MAIL_HOST', $request->mail_host);
        $this->setEnvValue('MAIL_PORT', $request->mail_port);
        $this->setEnvValue('MAIL_USERNAME', $request->mail_username);
        $this->setEnvValue('MAIL_PASSWORD', $request->mail_password);
        $this->setEnvValue('MAIL_ENCRYPTION', $request->mail_enctyption);
        $this->setEnvValue('MAIL_FROM_ADDRESS', $request->mail_form_address);

        return redirect()->back()->with('success', 'Email configuration has been completed.');
    }

    protected function setEnvValue(string $key, string $value)
    {
        $path = app()->environmentFilePath();
        $env = file_get_contents($path);

        $old_value = env($key);

        if (!str_contains($env, $key . '=')) {
            $env .= sprintf("%s=%s\n", $key, $value);
        } else if ($old_value) {
            $env = str_replace(sprintf('%s=%s', $key, $old_value), sprintf('%s=%s', $key, $value), $env);
        } else {
            $env = str_replace(sprintf('%s=', $key), sprintf('%s=%s', $key, $value), $env);
        }

        file_put_contents($path, $env);
    }

}
