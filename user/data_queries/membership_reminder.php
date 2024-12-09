<?php

// Get the current date
$current_date = date('Y-m-d');

// Initialize the flag to show modal
$expire_modal = false;

// Ensure session variables are set
if (isset($_SESSION['expiration_membership'], $_SESSION['users_account_id'])) {
    // Get the expiration date
    $expiration_date = $_SESSION['expiration_membership'];


        // Set the flag to show the modal
    if ($current_date >= $expiration_date) {
        $expire_modal = true;
    }
} else {
    // Handle missing session variables
    error_log("Expiration membership date or user account ID is missing in the session.");
    echo "Session data is incomplete. Please log in again.";
    exit();
}
?>
<!-- Expired Membership Modal -->
<div class="modal fade tw-bg-[#bababa]" id="expiredModal" tabindex="-1" aria-labelledby="expiredModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-black text-white">
            <div class="modal-header">
                <h1 class="modal-title tw-text-red-600 fw-bold tw-text-xl" id="expiredModalLabel">
                    Expired Membership
                </h1>
            </div>
            <div class="modal-body">
                <p>Please proceed to the FitnessBoss counter!</p>
                <p>Your account ID: <?php echo htmlspecialchars($_SESSION['users_account_id']); ?></p>
            </div>

            <div class="modal-footer text-center">
                <a href="../index.php" class="tw-text-white tw-rounded mt-3 py-2 tw-transition tw-duration-300 ease-in-out tw-bg-transparent hover:tw-bg-[#00FFAE] tw-w-full tw-text-sm tw-border-solid tw-border-2 hover:tw-text-black hover:tw-border-[#00FFAE]" >Sign now</a>
            </div>
        </div>
    </div>
</div>

<?php if ($expire_modal): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var expiredModal = new bootstrap.Modal(document.getElementById('expiredModal'), {
                backdrop: 'static',
                keyboard: false
            });
            expiredModal.show();
        });
    </script>
<?php endif; ?>
