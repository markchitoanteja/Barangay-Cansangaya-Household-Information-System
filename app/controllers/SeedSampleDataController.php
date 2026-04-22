<?php

class SeedSampleDataController extends Controller
{
    public function seed_sample_data()
    {
        $sample_data_seeder_model = $this->model('Sample_Data_Seeder_Model');
        $success = $sample_data_seeder_model->seedSampleData();

        if ($success) {
            flash('flash_notif', [
                'title' => 'Seeding Successful',
                'text' => 'Sample data has been successfully seeded.',
                'icon' => 'success',
            ]);

            return json([
                'success' => true,
                'message' => 'Sample data seeded successfully.',
            ]);
        } else {
            flash('flash_notif', [
                'title' => 'Seeding Failed',
                'text' => 'An error occurred while seeding sample data.',
                'icon' => 'error',
            ]);

            return json([
                'success' => false,
                'message' => 'Failed to seed sample data.',
            ]);
        }
    }
}
