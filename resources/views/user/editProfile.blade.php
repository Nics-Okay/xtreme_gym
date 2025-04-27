<div class="image-container">
    <p>Profile Picture</p>

    <form method="POST" action="{{ route('profileNew.updateImage') }}" enctype="multipart/form-data">
        @csrf
        <input 
            type="file" 
            name="profile_image" 
            accept="image/*" 
            style="display: none;" 
            id="profile-image-upload" 
            onchange="previewSelectedImage(event)">
        <button type="button" onclick="document.getElementById('profile-image-upload').click()">Upload New Image</button>
        <button type="submit">Save</button>
    </form>

    <script>
        function previewSelectedImage(event) {
            const file = event.target.files[0]; // Get the selected file
            const preview = document.getElementById('profile-image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Update the `src` of the image with the selected file's data URL
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        }
    </script>
</div>