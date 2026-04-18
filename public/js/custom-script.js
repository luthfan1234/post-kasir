$(function () {
    // Initialize SummerNote
    $(".summerNote").summernote({
        height: 200,
    });

    //Initialize Select2 Elements
    $(".select2").select2();

    // --- Modern Loading State Handler (AJAX Only) ---
    const startLoading = () => {
        $("#global-loader").addClass('active');
    };

    const stopLoading = () => {
        $("#global-loader").removeClass('active');
    };

    // Global AJAX Loading (DataTables fetching data, etc.)
    $(document).ajaxStart(startLoading).ajaxStop(stopLoading);

    // --- Global SweetAlert2 Interceptor for native confirm() ---
    document.addEventListener('click', function(e) {
        // Find if this click targets an element with an inline confirm()
        let target = e.target.closest('[onclick*="confirm"]');
        if (target) {
            e.preventDefault();
            e.stopPropagation(); // Stop the native onclick from firing!

            // Parse the message from the inline onclick attribute
            let onclickAttr = target.getAttribute('onclick');
            let match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
            let msg = match ? match[1] : "Are you sure you want to proceed?";

            // Show Premium SaaS Modal
            Swal.fire({
                title: 'Confirmation',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0ea5e9', // Sky Blue
                cancelButtonColor: '#ef4444', // Danger Red
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel',
                reverseButtons: true, // SaaS standard: Cancel on left, primary on right
                customClass: {
                    popup: 'border-radius-xl',
                    confirmButton: 'btn btn-primary ml-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false // Let our Bootstrap/modern-theme CSS handle button styles
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the onclick to prevent infinite loop
                    target.removeAttribute('onclick');
                    
                    // Trigger the action
                    if (target.type === 'submit' && target.form) {
                        target.form.submit();
                    } else if (target.tagName.toLowerCase() === 'a' && target.href) {
                        window.location.href = target.href;
                    } else {
                        target.click();
                    }
                }
            });
        }
    }, true); // true = Use Capturing Phase!
});

function previewThumbnail(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var thumbnailPreview =
                input.parentNode.querySelector(".thumbnail-preview");
            if (thumbnailPreview) {
                thumbnailPreview.src = e.target.result;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}
