<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cronjob extends MY_Controller
{
    public function index()
    {
        ini_set('max_execution_time', 300); //5 minutes
        $this->theme_view = 'blank';
        $this->load->helper(['dompdf', 'file']);
        $timestamp = time();
        $core_settings = Setting::first();
        $date = date('Y-m-d');
        $this->load->library('parser');

        /* Check if cronjob option is enabled */
        if ($core_settings->cronjob != '1' && time() > ($core_settings->last_cronjob + 0)) {
            log_message('error', '[cronjob] Cronjob link has been called but cronjob option is not enabled in settings.');
            show_error('Cronjob link has been called but cronjob option is not enabled!', 403);
            return false;
        }

        // Log cronjob execution time
        $core_settings->last_cronjob = time();
        $core_settings->save();

        // Run auto Backup if enabled and if last backup is older then 7 days
        if ($core_settings->autobackup == '1' && time() > ($core_settings->last_autobackup + 7 * 24 * 60 * 60)) {
            $this->load->dbutil();

            $version = str_replace('.', '-', $core_settings->version);
            $prefs = ['format' => 'zip', 'filename' => 'Database-auto-full-backup_' . $version . '_' . date('Y-m-d_H-i')];

            $backup = &$this->dbutil->backup($prefs);

            if (!write_file('./files/backup/Database-auto-full-backup_' . $version . '_' . date('Y-m-d_H-i') . '.zip', $backup)) {
                log_message('error', '[cronjob] Error while creating auto database backup!');
            } else {
                $core_settings->last_autobackup = time();
                $core_settings->save();
                log_message('error', '[cronjob] Auto backup has been created.');
            }
        }

        redirect('cronjob');
    }

}
