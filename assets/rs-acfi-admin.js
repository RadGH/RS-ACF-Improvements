document.addEventListener('DOMContentLoaded', function() {

	const init = function() {
		setup_field_group_handles();
	};

	const setup_field_group_handles = function() {
		let handles = get_field_group_handles();

		// Loop through each handle and locate the group, then add a button to edit the field group
		handles.forEach(function(handle) {
			let group_id = handle.getAttribute('data-post-id');
			let h2 = handle.previousElementSibling;
			if ( ! h2 ) return;

			let a = document.createElement('a');

			a.classList.add('rs-field-group-handle-link');
			a.setAttribute('href', 'post.php?post='+ group_id +'&action=edit');
			a.setAttribute('title', 'Edit field group');
			a.setAttribute('target', '_blank');
			a.innerHTML = '<span class="dashicons dashicons-admin-generic"></span>';

			h2.appendChild(a);
		});
	};

	const get_field_group_handles = function() {
		return document.querySelectorAll('.rs-field-group-handle');
	};

	init();
});