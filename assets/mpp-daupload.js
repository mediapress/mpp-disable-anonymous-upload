jQuery(document).ready(function ($) {

	if (_mppData == undefined) {
		return;
	}

	/**
	 * Checks if anonymous posting is on.
	 *
	 * @returns {boolean}
	 */
	function is_anonymous() {
		return $.cookie('bp-post-as') === 'anonymous';
	}

	// Set callback for restriction.
	mpp.activity_uploader.isRestricted = check_if_anonymous_enabled;

	/**
	 * Callback for checking and restricting upload if anonymous posting is enabled.
	 *
	 * @param uploader
	 * @param file
	 * @returns {boolean}
	 */
	function check_if_anonymous_enabled(uploader, file) {
		// clear any error we had earlier.
		$('#message').remove();

		if (!is_anonymous()) {
			return false; // no restriction.
		}
		// remove file from queue.
		uploader.removeFile(file);
		uploader.refresh();
		// remove the feedback that we added.
		this.removeFileFeedback(file);
		// notify error message.
		mpp.notify("Anonymous media upload is not supported.", 1);

		return true; // yes, this should be restricted.
	}

	// On click of the upload button, check if anonymous is selected and prevent upload.
	$('#whats-new-form').on('click', '#mpp-activity-upload-buttons a', function () {
		if (!is_anonymous()) {
			return true; // do not stop event propagation.
		}

		// since we are forcing the propagation, check if the form is checked.
		mpp.notify("Anonymous media upload is not supported.", 1);
		return false;
	});

});