<?php

class SystemInformationController extends Controller
{
    private function current_date(): string
    {
        return date('Y-m-d H:i:s');
    }

    public function update_system_info()
    {
        $id = input('id');
        $barangay_name = input('barangay_name');

        $response = [
            'success' => true,
            'message' => 'System information updated successfully.',
        ];

        // Handle file upload if present
        if (has_file('official_logo')) {

            $upload = upload_file('official_logo', 'public/assets/img/', [
                'allowed_types' => ['image/jpeg', 'image/png', 'image/webp'],
                'max_size' => 2 * 1024 * 1024, // 2MB
            ]);

            if (!$upload['status']) {
                return json([
                    'success' => false,
                    'message' => $upload['error'],
                ]);
            }

            $official_logo = $upload['filename'];
        } else {
            $official_logo = null;
        }

        $system_information_model = $this->model('System_Information_Model');

        $data = [
            'barangay_name' => $barangay_name,
            'updated_at' => $this->current_date(),
        ];

        if ($official_logo) {
            $data['official_logo'] = $official_logo;
        }

        $system_information_model->MOD_UPDATE_SYSTEM_INFORMATION($id, $data);

        flash('flash_notif', [
            'title' => 'System Updated',
            'text' => 'System information has been successfully updated.',
            'icon' => 'success',
        ]);

        return json($response);
    }
}
