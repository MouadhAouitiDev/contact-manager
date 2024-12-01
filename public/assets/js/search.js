    $(document).(function () {
        $('#contactForm').on('submit', function (e) {
            // Show loading indicator
            $('#loading').show();

            // Disable submit button to prevent multiple submissions
            $(this).find('button[type="submit"]').prop('disabled', true);
        });

        $('#contactsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json"
            }
        });
    });
   