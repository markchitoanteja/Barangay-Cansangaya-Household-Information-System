<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content gov-modal">
            <div class="modal-header gov-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('public/assets/img/logo.png') ?>" class="gov-modal-logo">
                    <div>
                        <h5 class="modal-title mb-0">USER ACCOUNT</h5>
                        <small class="gov-modal-subtitle">Barangay Cansangaya Household Information System</small>
                    </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body gov-modal-body">
                    <div class="gov-section">
                        <div class="gov-section__label">Account Information</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" placeholder="Full Name">
                                    <label><i class="fa-regular fa-user me-1"></i> Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control gov-input" placeholder="Username">
                                    <label><i class="fa-solid fa-at me-1"></i> Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input">
                                        <option value="STAFF">STAFF</option>
                                        <option value="ADMIN">ADMIN</option>
                                    </select>
                                    <label><i class="fa-solid fa-id-badge me-1"></i> User Role</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select gov-input">
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="DISABLED">DISABLED</option>
                                    </select>
                                    <label><i class="fa-solid fa-toggle-on me-1"></i> Account Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gov-section">
                        <div class="gov-section__label">Password</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control gov-input gov-input--password" id="user_password" placeholder="Password">
                                    <label><i class="fa-solid fa-lock me-1"></i> Password</label>
                                    <button type="button" class="btn btn-sm password-toggle toggle-password" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control gov-input gov-input--password" id="user_confirm_password" placeholder="Confirm Password">
                                    <label><i class="fa-solid fa-lock me-1"></i> Confirm Password</label>
                                    <button type="button" class="btn btn-sm password-toggle toggle-password" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gov-modal-footer">
                    <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    <button class="btn gov-btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>