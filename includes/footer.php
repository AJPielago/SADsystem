</div> <!-- Close container -->

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; <?php echo date("Y"); ?> Green Bin: Smart Waste Management using Collection Request System. All rights reserved.</p>
</footer>

<!-- Floating Feedback Button -->
<button id="feedbackBtn" class="btn btn-primary btn-floating" data-toggle="modal" data-target="#feedbackModal">
    <i class="fas fa-comment-dots"></i>
</button>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Success/Error Messages -->
                <div id="feedbackAlert" class="alert d-none"></div>

                <form id="feedbackForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

                    <div class="form-group">
                        <label for="feedbackText">Your Feedback</label>
                        <textarea class="form-control" id="feedbackText" name="feedback" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}
.container {
    flex: 1;
}
footer {
    background-color: #343a40; 
    color: white;
    text-align: center;
    padding: 15px 0;
}
.btn-floating {
    position: fixed;
    bottom: 90px;
    right: 20px;
    z-index: 1000;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- Include jQuery & Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $("#feedbackForm").submit(function(event) {
        event.preventDefault(); // Prevent form reload

        $.ajax({
    type: "POST",
    url: "/SADsystem/user/submit_feedback.php",
    data: $(this).serialize(),
    dataType: "json",
    success: function(response) {
        console.log("Server Response:", response); // Debugging log

        let alertBox = $("#feedbackAlert");
        alertBox.removeClass("d-none alert-danger alert-success")
                .addClass(response.success ? "alert-success" : "alert-danger")
                .text(response.message);
        if (response.success) {
            $("#feedbackForm")[0].reset();
            setTimeout(function() {
                $("#feedbackModal").modal("hide");
            }, 2000);
        }
    },
    error: function(xhr, status, error) {
        console.log("AJAX Error:", xhr.responseText); // Log full error details
        $("#feedbackAlert").removeClass("d-none").addClass("alert-danger")
                           .text("An unexpected error occurred.");
    }
        });

    });
});
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</html>
