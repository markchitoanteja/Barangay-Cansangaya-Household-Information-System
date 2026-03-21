<?php

class UpdateController extends Controller
{
    public function run()
    {
        $user = session_get('user');

        $response = [
            'success' => false,
            'message' => 'Update failed.'
        ];

        // 🔒 Restrict to ADMIN
        if (empty($user) || $user['role'] !== 'ADMIN') {
            $response['message'] = 'Unauthorized access.';
            return json($response);
        }

        // Execute git pull
        $output = shell_exec('git pull origin main 2>&1');

        if ($output) {
            write_log('SYSTEM_UPDATE', 'system', $user['id'], 'System updated via button');

            $response['success'] = true;
            $response['message'] = 'System updated successfully.';
            $response['output'] = $output;

            // Updated flash message for system update
            flash('flash_notif', [
                'title' => 'System Update Successful',
                'text' => 'The system has been successfully updated.',
                'icon' => 'success',
            ]);
        } else {
            write_log('SYSTEM_UPDATE_FAILED', 'system', $user['id'], 'Update failed or no changes');
            $response['message'] = 'No updates found or update failed.';
        }

        return json($response);
    }

    public function check()
    {
        $user = session_get('user');

        if (empty($user) || $user['role'] !== 'ADMIN') {
            return json(['success' => false]);
        }

        // Fetch remote changes without merging
        shell_exec('git fetch origin main 2>&1');

        $output = shell_exec('git rev-list HEAD...origin/main --count');

        $count = (int)$output;

        return json([
            'success' => true,
            'count' => $count
        ]);
    }
}
